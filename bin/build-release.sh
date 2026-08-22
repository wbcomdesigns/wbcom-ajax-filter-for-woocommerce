#!/usr/bin/env bash
#
# Build the customer zip for Ajax Filter for WooCommerce.
#
# Every check here runs BEFORE the archive is written, and the content
# assertions run against the ARTIFACT rather than the working tree. That
# distinction is the whole point: a sibling plugin shipped a release where every
# dev-tree gate passed and the zip was still broken, because the packaging step
# was what dropped the file. A gate that inspects the source cannot see that.
#
# Usage:
#   bash bin/build-release.sh              # build, refusing on any failed gate
#   bash bin/build-release.sh --skip-audit # skip the contract audit only

set -euo pipefail

cd "$( dirname "${BASH_SOURCE[0]}" )/.."

SLUG="wbcom-ajax-filter-for-woocommerce"
MAIN_FILE="wb-ajax-filter.php"
README="README.txt"
DIST="dist"
SKIP_AUDIT=0

for arg in "$@"; do
	case "$arg" in
		--skip-audit) SKIP_AUDIT=1 ;;
		*) echo "build-release: unknown option $arg" >&2; exit 2 ;;
	esac
done

# --- Clear the previous artifact BEFORE any gate runs. ---------------------
#
# Gates 4-6 delete the zip when the archive is wrong, so a broken artifact
# cannot be published. The gates that run BEFORE packaging had no such
# protection: they exit under `set -e` while last build's zip is still sitting
# in dist/, looking current. That is worse than a broken zip, because nothing
# about the directory says the build failed - and it is exactly how a stale
# artifact got installed during testing on a sibling plugin.
rm -rf "$DIST"

# --- Gate 1: one version, agreed everywhere. -------------------------------
#
# The readme is README.txt here, capitalised, which is what git tracks. On a
# case-insensitive filesystem the difference is invisible and on the customer's
# Linux host it is not, so the name is stated once rather than guessed.
#
# package.json is included deliberately. It is the file that drifts, because
# nothing on the PHP side reads it: at the time this script was written the
# other three said 1.3.0 and package.json still said 1.0.0.
HEADER_VERSION="$( grep -m1 -E '^\s*\*\s*Version:' "$MAIN_FILE" | sed -E 's/.*Version:[[:space:]]*//' | tr -d '[:space:]' )"
CONST_VERSION="$( grep -m1 -E "define\( *'WB_AJAX_FILTER_VERSION'" "$MAIN_FILE" | sed -E "s/.*'WB_AJAX_FILTER_VERSION' *, *'([^']*)'.*/\1/" )"
README_VERSION="$( grep -m1 -E '^Stable tag:' "$README" | sed -E 's/^Stable tag:[[:space:]]*//' | tr -d '[:space:]' )"
PKG_VERSION="$( python3 -c "import json;print(json.load(open('package.json')).get('version',''))" 2>/dev/null || echo "" )"

if [ -z "$HEADER_VERSION" ]; then
	echo "build-release: could not read Version from $MAIN_FILE" >&2
	exit 1
fi

if [ "$HEADER_VERSION" != "$CONST_VERSION" ] || [ "$HEADER_VERSION" != "$README_VERSION" ] \
	|| { [ -n "$PKG_VERSION" ] && [ "$HEADER_VERSION" != "$PKG_VERSION" ]; }; then
	echo "build-release: FAILED - versions disagree." >&2
	echo "  $MAIN_FILE header       : $HEADER_VERSION" >&2
	echo "  WB_AJAX_FILTER_VERSION  : $CONST_VERSION" >&2
	echo "  $README                 : $README_VERSION" >&2
	echo "  package.json            : ${PKG_VERSION:-<absent>}" >&2
	echo >&2
	echo "A mismatch here is what makes a site update forever: WordPress compares" >&2
	echo "the header against the store's advertised version and never settles." >&2
	exit 1
fi

VERSION="$HEADER_VERSION"
echo "build-release: version $VERSION agrees across header, constant, readme and package.json"

# --- Gate 2: PHP must parse. -----------------------------------------------
#
# Report REAL parse errors and nothing else.
#
# A `php -l` run inherits whatever php.ini the developer's environment points
# at, and a mismatched one is noisy on stderr - a Local WP PHPRC whose opcache
# and Xdebug builds do not match the CLI binary prints a paragraph of loader
# warnings per file. That is not a parse error, but it buries the output and a
# gate nobody can read is a gate that stops being trusted.
#
# Errors are collected instead: php -l says "No syntax errors detected" for a
# healthy file, so anything else on stdout is a genuine failure, and the exit
# status is checked per file rather than inferred from the noise.
LINT_ERRORS=0
while IFS= read -r -d '' phpfile; do
	if ! out="$( php -l "$phpfile" 2>/dev/null )"; then
		echo "build-release: PARSE ERROR in $phpfile" >&2
		printf '%s\n' "$out" | grep -v 'No syntax errors' >&2 || true
		LINT_ERRORS=1
	fi
done < <( find . -name '*.php' -not -path './node_modules/*' -not -path './dist/*' -not -path './.git/*' -print0 )

if [ "$LINT_ERRORS" -ne 0 ]; then
	echo "build-release: FAILED - PHP does not parse." >&2
	exit 1
fi
echo "build-release: PHP lint clean"

# --- Gate 3: cross-surface contracts. --------------------------------------
#
# Catches the class of bug where one surface writes key A and another reads key
# B, so everything "works" and nothing connects. Disjoint from lint and from
# any browser pass, and it runs in about a second.
AUDIT="$HOME/.claude/skills/wp-contract-audit/scripts/contract-audit.php"

if [ "$SKIP_AUDIT" -eq 1 ]; then
	echo "build-release: contract audit SKIPPED (--skip-audit)"
elif [ ! -f "$AUDIT" ]; then
	echo "build-release: contract audit script not found, skipping" >&2
else
	php "$AUDIT" . > /dev/null
	echo "build-release: contract audit clean"
fi

# --- Gate 3b: coding standards. --------------------------------------------
#
# Skipped rather than failed when phpcs is not installed, because a missing dev
# tool should not block a release build.
PHPCS_BIN=""
for candidate in "vendor/bin/phpcs" "$HOME/.composer/vendor/bin/phpcs" "$( command -v phpcs || true )"; do
	if [ -x "$candidate" ]; then PHPCS_BIN="$candidate"; break; fi
done

if [ -n "$PHPCS_BIN" ] && [ -f "phpcs.xml.dist" ]; then
	# Show the summary WHEN IT FAILS. Piping to /dev/null and letting set -e
	# abort means the build dies with no reason printed - the operator sees an
	# exit code and has to re-run phpcs by hand to find out what broke.
	# Errors block, warnings are advisory - the portfolio standard. Without
	# ignore_warnings_on_exit phpcs returns 1 for warnings alone, which would
	# make the gate refuse to build over things nobody has agreed are faults.
	# The warnings are still printed; they just do not stop the release.
	if ! phpcs_out="$( "$PHPCS_BIN" -q --report=summary --runtime-set ignore_warnings_on_exit 1 2>&1 )"; then
		echo "build-release: FAILED - coding standards." >&2
		printf '%s\n' "$phpcs_out" | tail -20 >&2
		exit 1
	fi
	echo "build-release: WPCS clean"
else
	echo "build-release: phpcs or ruleset missing, coding-standard gate SKIPPED" >&2
fi

# --- Gate 3c: unit tests, when the plugin has them. ------------------------
#
# Absent for now, and deliberately not faked. A hollow suite that asserts
# nothing is worse than no suite, because the build then reports a gate that
# is not protecting anything.
if [ -f "tests/run-tests.php" ]; then
	php tests/run-tests.php > /dev/null
	echo "build-release: unit tests pass"
else
	echo "build-release: no test suite yet, gate SKIPPED" >&2
fi

# --- Stage, honouring .distignore. -----------------------------------------
STAGE="$DIST/$SLUG"
mkdir -p "$STAGE"

EXCLUDES=()
while IFS= read -r line; do
	[ -z "$line" ] && continue
	case "$line" in \#*) continue ;; esac
	EXCLUDES+=( --exclude "$line" )
done < .distignore

rsync -a "${EXCLUDES[@]}" --exclude "/$DIST" ./ "$STAGE/"

ZIP="$DIST/$SLUG-$VERSION.zip"
( cd "$DIST" && zip -qr "$SLUG-$VERSION.zip" "$SLUG" )

# List the archive ONCE. `unzip | grep -q` per file is quietly broken under
# pipefail: grep exits on first match, unzip takes SIGPIPE, and the pipeline
# reports failure for a file that is present.
ZIP_CONTENTS="$( unzip -Z1 "$ZIP" )"

# --- Gate 4: the ARTIFACT must contain what the plugin needs to run. -------
#
# Named files, not directories. A directory-level check passes while the one
# file inside it that the plugin guards on is missing - which is exactly how a
# sibling plugin shipped a zip with its licensing SDK sources stripped by an
# unanchored glob, breaking updates on every fresh install.
REQUIRED_FILES=(
	"$SLUG/$MAIN_FILE"
	"$SLUG/$README"
	"$SLUG/uninstall.php"
	"$SLUG/edd-license/edd-plugin-license.php"
	"$SLUG/edd-license/EDD_WB_Ajax_Filter_Plugin_Updater.php"
	"$SLUG/lib/wbcom-settings/loader.php"
)
MISSING=0

for f in "${REQUIRED_FILES[@]}"; do
	if ! printf '%s\n' "$ZIP_CONTENTS" | grep -qxF "$f"; then
		echo "build-release: MISSING FROM ZIP: $f" >&2
		MISSING=1
	fi
done

# The minified and RTL stylesheets are committed rather than built here, so the
# only way they go missing is an exclude rule eating them. Asserted by shape
# rather than by name, since the set grows as components are added.
for pattern in "min/" "rtl/"; do
	count="$( printf '%s\n' "$ZIP_CONTENTS" | grep -c "$pattern" || true )"
	if [ "$count" -eq 0 ]; then
		echo "build-release: NO $pattern ASSETS IN ZIP - an exclude rule is eating them" >&2
		MISSING=1
	fi
done

# --- Gate 5: the ARTIFACT must not contain dev files. ----------------------
LEAKED=0
while IFS= read -r leak; do
	echo "build-release: DEV FILE IN ZIP: $leak" >&2
	LEAKED=1
done < <( printf '%s\n' "$ZIP_CONTENTS" \
	| grep -E "/(node_modules|\.git|bin|dist|plan|docs|tests)/|/(package\.json|gruntfile\.js|\.distignore|phpcs\.xml\.dist)$" \
	|| true )

# --- Gate 6: no internal markdown in the ARTIFACT. -------------------------
#
# The wildcard in .distignore is what excludes these; this gate is what stops
# the wildcard being quietly weakened later. Checked on the archive, because
# the working tree is not what customers receive.
STRAY_MD=0
while IFS= read -r mdfile; do
	echo "build-release: INTERNAL DOC IN ZIP: $mdfile" >&2
	STRAY_MD=1
done < <( printf '%s\n' "$ZIP_CONTENTS" | grep -iE '\.md$' || true )

if [ "$MISSING" -ne 0 ] || [ "$LEAKED" -ne 0 ] || [ "$STRAY_MD" -ne 0 ]; then
	echo >&2
	echo "build-release: FAILED - the archive is wrong. Deleting it so a broken" >&2
	echo "zip cannot be published by mistake." >&2
	rm -f "$ZIP"
	exit 1
fi

rm -rf "$STAGE"

SIZE="$( du -h "$ZIP" | cut -f1 | tr -d '[:space:]' )"
COUNT="$( printf '%s\n' "$ZIP_CONTENTS" | wc -l | tr -d '[:space:]' )"
echo "build-release: OK - $ZIP ($SIZE), $COUNT files"
