# Ajax Filter for WooCommerce (wbcom-ajax-filter-for-woocommerce)

## Plugin Identity
- **Plugin Name:** Wbcom Designs - Ajax Filter For WooCommerce
- **Main File:** `wb-ajax-filter.php`
- **Text Domain:** `wb-ajax-filter`
- **Version:** 1.2.0
- **Author:** Wbcom Designs
- **License:** GPL-2.0+
- **Requires WordPress:** 4.0+
- **Requires WooCommerce:** yes (hard dependency, self-deactivates)
- **Pro Version:** none (single tier, EDD-licensed)
- **Basecamp:** https://3.basecamp.com/5798509/projects/42374786

## Names & Identity

Every surface this product is known by. When these drift, a site owner reports a bug under one name and support searches for another.

| Surface | Value |
|---|---|
| Plugin Name (what the site owner sees) | `Wbcom Designs - Ajax Filter For WooCommerce` |
| Install slug (`wp-content/plugins/`) | `wbcom-ajax-filter-for-woocommerce` |
| Git repo | `wbcom-ajax-filter-for-woocommerce` |
| Text domain | `wb-ajax-filter` |
| readme.txt title | `Wbcom Designs - Ajax filter for WooCommerce` |
| Basecamp board | `Ajax filter for WooCommerce` (42374786) |
| Basecamp URL | https://3.basecamp.com/5798509/projects/42374786 |

## Current Task List

Ordered by how many store owners are affected, not by how interesting the code is.
Derived from a code audit on 2026-08-08 that verified every open Basecamp card against this branch.
**Work happens on this branch (`1.2.2`).**

### 1. Security - release blocker
- [ ] **Any logged-in customer can trash any post on the site.** Two gaps combine: the nonce guard is skipped when the nonce is simply omitted (`if ( isset($_POST['nonce']) && ! wp_verify_nonce(...) ) {exit} else {work}`), and there is **no capability check anywhere** (`current_user_can` = 0 outside the EDD updater, `check_ajax_referer` = 0). Worked example: `delete_filter_preset_wb_callback()` at `admin/class-wb-ajax-filter-admin.php:395-407` passes `$_POST['preset']` to `wp_delete_post()` with no post-type assertion.
- [ ] **Fix as ONE shared `verify_admin_request()` gate** every callback enters through - fail-closed `check_ajax_referer()`, `manage_woocommerce`, post-type assertion. The bypassable pattern repeats at ~15 sites; patching them individually recreates the hole on the next handler.
- [ ] Do **not** apply the `FILTER_SANITIZE_STRING` line from the old "Code enhancements" card - deprecated in PHP 8.1.

### 2. Feature dead for most shoppers
- [ ] **Search autocomplete does nothing when logged out.** `get_ajax_search_autocomplete_title_wb` is registered `wp_ajax_` only; the plugin registers zero `wp_ajax_nopriv_` handlers. The owner tests it as admin, it works, and real shoppers get nothing. Register it for nopriv with its own public nonce - not the admin one.

### 3. Big-site (2,000+ products)
- [ ] `admin/class-wb-ajax-filter-admin.php:607-615` - `posts_per_page => -1` then `get_post_meta()` per product in a foreach. N+1, and reachable by any logged-in user via the nonce bypass = trivial DoS.
- [ ] `templates/filters/filter-tax.php:15,57` - two unbounded `get_terms()` per taxonomy filter per page load; `:15`'s result is never even used.
- [ ] `public/class-wb-ajax-filter-public.php:403-411` - unindexable `LIKE '%...%'` over `post_content`, cached only in non-persistent object cache.

### Notes
`templates/` (34 files) is a public contract - fix inside files, never rename paths. `_wb_filter` post meta has no schema version; add a stamp + read-time normalizer (S) rather than migrating to a custom table.

### What this plugin should have and does not (7 of 16)

**Store owner expects:**

- [ ] **Gutenberg block** - Block themes often never fire the classic WooCommerce hooks this plugin renders through, so the owner sees nothing and has no way to place it by hand.
- [ ] **Theme-overridable templates** - The owner cannot restyle output without editing plugin files, which an update overwrites.
- [ ] **Admin screen for stored data** - Anything the plugin stores, the owner must be able to see, moderate and export from wp-admin. Otherwise support means phpMyAdmin.

**Developer extending it expects:**

- [ ] **REST API** - No mobile app, headless storefront or external integration can reach this data.
- [ ] **Documented hooks/filters** - Developers extending the plugin have to read the source to find the extension points.
- [ ] **Test suite** - Nothing catches a regression before a customer does.
- [ ] **WPCS config** - Coding-standard drift is invisible until a WordPress.org review rejects it.
### Frontend, UX & code health

**The filter block costs a mobile shopper the whole first screen.** Rendered at 390px on a real store: a "Filters" heading, an empty reserved gap, a Reset button and three dropdowns - the first product image starts roughly 580px down.

- [ ] **Active-filter chip renders as a bare `1`** with a close button and no label - reads as a rendering bug, not a control.
- [ ] **"Search by Category" is clipped by its own caret** at 390px.
- [ ] **The filter block reserves vertical space with no filter applied.** Collapse behind a "Filter" toggle on mobile so products are above the fold.
- [ ] **6 native `confirm()` calls** - highest in the suite.
- [ ] **Templates: 34 files**, the largest template surface here and an explicit public contract.
- [ ] Only 1 dead-code lead - clean on that axis.

### The standard every plugin in this suite is measured against
We are not auditing against each plugin's own history - we are auditing against what a WooCommerce plugin **should** provide a store owner and a developer extending it. Scored across all 11 plugins on 2026-08-08.

| Expectation | Who needs it | Suite score |
|---|---|---|
| Gutenberg block | owner | **0 / 11** |
| Admin screen for stored data | owner | **0 / 11** |
| REST API | developer | **0 / 11** |
| Test suite | developer | **0 / 11** |
| WPCS config | developer | 2 / 11 |
| Documented hooks/filters | developer | 3 / 11 |
| Theme-overridable templates | owner | 4 / 11 |
| Shortcode fallback | owner | 5 / 11 |
| RTL stylesheet | owner | 8 / 11 |
| CSS custom properties | owner | 8 / 11 |
| Conditional asset loading | owner | 9 / 11 |
| Clean uninstall | owner | 9 / 11 |
| First-run guidance | owner | 9 / 11 |
| Translation file | owner | 10 / 11 |
| CI config | developer | 10 / 11 |
| Settings screen | owner | 11 / 11 |

**The four zeros are the real backlog.** Every plugin has a settings screen; not one has a block, an admin screen for the data it stores, a REST route, or a test. Those four gaps explain more customer complaints than the entire open bug list does.

### Portfolio floor - one mechanical pass per plugin
- [ ] **Focus rings** - `outline: none` with no `:focus-visible` replacement, **98 occurrences suite-wide**. Keyboard users cannot see where they are.
- [ ] **RTL** - raw `margin-left` / `margin-right`, **96 occurrences suite-wide**. Use `margin-inline-start/end`.
- [ ] **Icons** - **62** Dashicons references; migrate to Lucide with a map for stored values.
- [ ] **No native dialogs** - **12** `alert()`/`confirm()` calls put a raw browser dialog in front of a shopper mid-purchase.

### Ground rules
- **Dead-code lists are leads, not delete lists.** `init_form_fields()`, `get_content_html()` and `get_content_plain()` are `WC_Email` overrides invoked through the parent class - they look unreferenced to a static scan and **must not be removed**. The same applies to callbacks reached only by `add_action` string name and CSS classes built in JS.
- **Deduplicate at the seam.** Where free and Pro share an identical function body, the fix is one owner plus an extension point, never the same edit twice.
- **One concern per PR**, so a regression bisects fast.

### Ground rules for this list
- A card is a lead, not a spec. Several open cards were found to be already fixed or factually wrong about this tree - re-verify before building.
- Fix at the seam, not on the screen that reported it. Where a fix has a shared cause, the entry below says so.
- Most customers do not run our themes. Verify on a generic theme (Storefront or a block theme), not only on Reign/BuddyX.

## What It Does
Adds AJAX product filtering to WooCommerce shop and archive pages. Shoppers narrow results by attribute, category, price range, and custom fields without a page reload. Filter sets are authored in the admin as reusable **presets** (a custom post type), so one store can run different filter layouts on different pages.

## Architecture

### Pattern
WordPress Plugin Boilerplate (loader pattern). `Wb_Ajax_Filter_Loader` registers hooks; `Wb_Ajax_Filter::run()` executes. Front-end markup is template-driven - `templates/` holds 34 overridable files, which is the largest single directory in the plugin.

### Key Files

| File | Purpose |
|------|---------|
| `wb-ajax-filter.php` | Bootstrap, dependency guard, constants |
| `includes/class-wb-ajax-filter.php` | Core class, dependency loading, hook definitions |
| `includes/class-wb-ajax-filter-loader.php` | Hook registration system |
| `includes/class-wb-ajax-filter-activator.php` | Activation (registers CPT, flushes rules) |
| `includes/class-wb-ajax-filter-deactivator.php` | Deactivation routine |
| `includes/class-wb-ajax-filter-i18n.php` | Text domain loading |
| `admin/class-wb-ajax-filter-admin.php` | Preset builder UI, settings, AJAX handlers |
| `public/class-wb-ajax-filter-public.php` | Front-end filter rendering and query handling |
| `templates/` | 34 overridable template partials (filter field types, layouts) |
| `admin/wbcom/` | Shared Wbcom admin header/nav + license UI |
| `edd-license/EDD_WB_Ajax_Filter_Plugin_Updater.php` | EDD Software Licensing updater |

Codebase: ~7,400 PHP LOC across 62 files.

## Constants

| Constant | Value |
|----------|-------|
| `WB_AJAX_FILTER_VERSION` | `'1.2.0'` |
| `WB_AJAX_FILTER` | `__FILE__` |
| `WB_AJAX_FILTER_URL` | plugin URL |
| `WB_AJAX_FILTER_PATH` | plugin path |
| `WB_AJAX_FILTER_TEMPLATE_PATH` | `/templates/` |
| `EDD_WB_AJAX_FILTER_STORE_URL` | `'https://wbcomdesigns.com/'` |
| `EDD_WB_AJAX_FILTER_ITEM_NAME` | `'Ajax Filter For WooCommerce'` |
| `EDD_WB_AJAX_FILTER_PLUGIN_LICENSE_PAGE` | `'wbcom-license-page'` |

## Custom Post Type

| CPT | Purpose |
|-----|---------|
| `wb_filter_preset` | A saved filter set. Post meta: `_wb_filter` (field config), `parent_preset`, `preset_enabled` |

## Hooks & Filters (plugin-defined)

### Filters
| Hook | Purpose |
|------|---------|
| `wb_ajax_filter_get_preset_filters` | The filter fields resolved for a preset |
| `wb_ajax_filter_restrict_products` | Restrict which products the filter query returns |
| `wb_ajax_filter_restrict_terms` | Restrict which taxonomy terms appear as options |

### Actions
Front-end: `wb_ajax_filter_after_content`, `wb_ajax_filter_after_filter_fields`

Admin settings screens expose paired before/after actions for each tab:
`wb_ajax_filter_{before,after}_admin_general_settings`, `..._admin_search_settings`,
`..._admin_search_option_settings`, `..._admin_customization_settings`

## Settings & Data

### Options (`wp_options`)
| Option | Purpose |
|--------|---------|
| `wb_ajax_filter_admin_general_options` | General settings |
| `wb_ajax_filter_admin_customization_options` | Appearance/customization settings |
| `wb_ajax_filter_search_settings` | Search behaviour |
| `wb_ajax_filter_search_content_settings` | Search content scope |
| `edd_wbcom_ajax_filter_license_key` / `_status` | EDD license state |

### AJAX actions
Preset CRUD and the filter builder are AJAX-heavy:
`create_filter_preset_wb`, `delete_filter_preset_wb`, `duplicate_filter_preset_wb`,
`check_filter_preset_title_wb`, `delete_single_filter_wb`, `add_price_range_field_wb`,
`check_custom_field_exists_wb`, `customize_term_text_wb`

## Dependencies
- **WooCommerce** - hard dependency, enforced by a runtime guard that deactivates the plugin and shows an admin notice.

## Development Notes
- **Templates are the public contract.** 34 files under `templates/` can be overridden by themes. Renaming or restructuring one is a breaking change for any site that copied it - treat template paths as API.
- **Presets are posts, so they scale like posts.** A store with many presets, or a preset with many terms, hits term-count and query cost quickly. Any list/query added here needs pagination and an index check before shipping (portfolio big-site rule).
- **Every AJAX action needs a nonce check and a capability check.** Preset CRUD is admin-only; the front-end filter action is public. Do not share one nonce across both surfaces.
- The `_wb_filter` post meta holds the whole field config as structured data. Changing its shape requires a migration - there is no versioned schema on it today.
