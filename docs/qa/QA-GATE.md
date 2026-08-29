# QA Gate - Ajax Filter For WooCommerce

Pre-release checklist for **wbcom-ajax-filter-for-woocommerce** (v1.3.0). Two layers: **[code]** items you verify in the terminal (lint, contract audit, wp-cli, DB), and **[browser]** items where you must open the page and *read the rendered result* - admin and storefront - to catch friction a passing test never shows. A `getBoundingClientRect` / DOM-node check is not a browser verification; look at the pixels.

Surfaces this gate maps to (see `CAPABILITIES.md` / `audit/manifest.json`):
- Admin tabs: Overview, Your Filters (preset builder), Stored Data, Advanced, License.
- Frontend: archive auto-render, `[wb_ajax_filters]` shortcode, "Ajax Product Filters" block.
- REST: `wb-ajax-filter/v1/presets` (public API, `manage_woocommerce`-gated).
- Store: `wb_filter_preset` CPT + `_wb_filter` / `preset_enabled` meta, via `Wb_Ajax_Filter_Presets`.

## How to run

1. Clean WP + WooCommerce install, Storefront (or a default block theme) active. `WP_DEBUG` + `WP_DEBUG_LOG` on.
2. Activate the plugin from the built zip (not the dev tree - see Phase 6). Auto-login via `?autologin=1`.
3. Seed data before Phase 2: `wp wc ...` / a generator for 1,000+ products, and duplicate presets to 1,000+ rows.
4. Walk phases top to bottom. A box ticks only with evidence - a command output or a screenshot you read. Ship when every box is ticked or the gap is a logged, accepted exception (Phase 8).

---

## Phase 1 - Code flow: boot & activation

- [ ] Activates on a clean WP + WooCommerce install with no PHP notice/warning/fatal in `debug.log`. **[code]**
- [ ] **Bootstraps exactly once** - the plugin instantiates a single `Wb_Ajax_Filter` on `plugins_loaded`, not a second time from the `admin_init` WooCommerce check. Count instances/callbacks on an admin load. **[code]** *(Fixed this week, commit b9e0d9d: the WooCommerce guard used to also run the bootstrap, giving 2 instances / 4 callbacks per admin load. `wb_ajax_filter_check_woocomerce` must now only deactivate-when-missing. Keep this front and centre.)*
- [ ] WooCommerce dependency handled once: `wb_ajax_filter_check_woocomerce` deactivates cleanly when WooCommerce is absent and shows the admin notice; no duplicate self-deactivation path. **[code]**
- [ ] Shared `wbcom-settings` shell loads the highest bundled version; activating a second Wbcom plugin that ships a different copy throws no fatal (`wbcom_settings_register` version arbitration). **[code]**
- [ ] Textdomain (`wb-ajax-filter`) loads on `plugins_loaded`/`init`, not earlier; no output before headers. **[code]**
- [ ] `wb_filter_preset` CPT registers on `init` with `public=false`, `show_in_menu=false`; the Default preset seeds once (`maybe_seed_default_preset`, latched by `wb_ajax_filter_default_preset_seeded`) and re-seed does not duplicate. **[code]**
- [ ] Deactivate -> reactivate is clean; `uninstall.php` removes only this plugin's own options/CPT data. **[code]**
- [ ] PHP lint (7.4-8.4) + PHPStan clean; WPCS clean. **[code]**

## Phase 2 - Code flow: data, contracts & scale

- [ ] Contract audit clean: no orphan meta/option keys, no read-never-written, no consumed-never-fired hooks. Confirm `_wb_filter` and `preset_enabled` are both written and read (`Wb_Ajax_Filter_Presets` is the only writer). **[code]**
- [ ] The preset store is reachable **three ways**: frontend (shortcode/block/archive), admin (Your Filters + Stored Data), and REST (`/presets`). No half-wired surface. **[code]**
- [ ] Every preset list runs through `Wb_Ajax_Filter_Presets::normalize_args`: mandatory `LIMIT`/`OFFSET`, `per_page` capped at `MAX_PER_PAGE` (100), whitelisted `orderby`, totals via `wp_count_posts()` - no unbounded `SELECT *`, no `count()` over a full fetch. **[code]**
- [ ] Seed **1,000+ presets**: the Stored Data list still loads under ~2s, paginates, and status views (all/enabled/disabled) + search + sort work. Overview caps at 100 and flags truncation while showing the true total. **[code]** **[browser]**
- [ ] Seed **1,000+ products**: archive filtering (taxonomy/price/stock/rating) stays fast; result filtering narrows WooCommerce's own paginated `woocommerce_product_query` rather than fetching all products; custom-field autocomplete uses one indexed query, not a catalogue scan. **[code]** **[browser]**
- [ ] Nonce + capability on **every** write: all admin AJAX callbacks call `check_ajax_referer('ajax-nonce','nonce')` and a `manage_woocommerce` gate; Stored Data actions verify `check_admin_referer` + cap; export verifies its own nonce + cap; every REST route uses the fail-closed `permissions_check` (`manage_woocommerce`, never `__return_true`). **[code]**
- [ ] Public search autocomplete (`get_ajax_search_autocomplete_title_wb`, registered nopriv) is read-only and nonce-verified - the one intentionally-public endpoint mutates nothing. **[code]**
- [ ] Settings persist: save each Advanced option group -> reload -> values retained. No key the UI writes that nothing reads. **[code]** **[browser]**

## Phase 3 - Browser: admin presentation

- [ ] Settings screen renders on the shared shell; **each of the five tabs** (Overview, Your Filters, Stored Data, Advanced, License) switches and *paints* - not merely present in the DOM. The shell renders every tab's section and switches client-side, so **look** that the target section is actually visible after a switch. **[browser]**
- [ ] **Overview** shows real numbers: active-preset count, live-field count, and the archives the filter renders on - matching `get_overview_stats`. Edit links jump to the right preset in Your Filters. **[browser]**
- [ ] **Your Filters** preset builder works after a client-side tab switch: the footer modal loads on any tab (not gated to `tab=wb-ajax-filter-presets`); create / duplicate / rename / delete a preset; add, drag-sort and configure fields; the in-page dialog (not native `confirm()`) handles delete. **[browser]**
- [ ] **Stored Data** renders the `WP_List_Table`: rows, status views, search box, bulk enable/disable/delete, and per-row actions. The "N presets enabled/disabled/deleted" success notice shows in the tab after the redirect. Empty and single-row states both read correctly. **[browser]**
- [ ] **Export** actually downloads: JSON and CSV, both full-store and a bulk-selected subset, come down as attachments with sane filenames (via `admin-post.php`, not a blank page). **[browser]**
- [ ] No console errors on any admin tab; admin assets (select2, color-picker, admin JS) enqueue once, no 404s, no double-enqueue. **[browser]**
- [ ] License tab renders and the EDD activation field is reachable; help/docs links resolve to the live docs URL, not localhost or a stale slug. **[browser]**

## Phase 4 - Browser: frontend presentation

- [ ] Filters render on the **shop archive** on a generic theme (Storefront + a default block theme), not only BuddyX / Reign - via the automatic `woocommerce_before_shop_loop` placement. **[browser]**
- [ ] **Applying a filter updates the product grid over AJAX with no full page reload** - taxonomy, price range + slider, stock/sale, rating, order-by each re-query and repaint the loop; the URL/state stays coherent and back/refresh does not strip the selection. **[browser]**
- [ ] The **block** ("Ajax Product Filters") placed in a block-theme template area / page renders the same filter UI as the archive, and its sidebar preset picker (`wbAjaxFilterBlock.presets`) selects a specific preset. **[browser]**
- [ ] The **`[wb_ajax_filters]` shortcode** (no attr = all enabled presets; `slug="..."` = one) renders identically to the block and the auto-render - all three share one renderer. **[browser]**
- [ ] **Active-filter chips** show human-readable labels (including WooCommerce's own `filter_` keys), and Reset clears them; below 640px the filters collapse behind a single **Filters** toggle and products stay above the fold. **[browser]**
- [ ] Search + autocomplete works **logged out** (public nonce endpoint), including SKU search; the "single search result" redirect behaves. **[browser]**
- [ ] Variable / grouped / external products filter correctly, not just simple products. **[browser]**
- [ ] No JS errors in the storefront console; no handler bound to a selector the markup never emits (dead handlers); button/link **hover, focus and visited** states are correct (themes override `<a>` buttons - check all three). No store internals (file paths, admin notices) leak to shoppers. **[browser]**

## Phase 5 - Cross-cutting: responsive, RTL, dark, a11y

- [ ] 390 / 768 / 1024 / 1280 on both admin and storefront: no horizontal body scroll; filter rows stack; the Stored Data table scrolls inside its own container. **[browser]**
- [ ] Primary shopper action (apply/reset a filter, open the mobile Filters toggle) is reachable one-thumb at 390px; tap targets >= 44px. **[browser]**
- [ ] RTL: filter layout and admin mirror; spacing uses logical properties (`margin-inline`), not `left/right`. **[browser]**
- [ ] Dark mode: filter components follow the theme through `--wb-*` custom properties - token-driven, no raw hex bleeding one theme onto the other. **[browser]**
- [ ] Keyboard-reachable: every filter control and admin control is tabbable with a visible focus ring; icon-only buttons carry `aria-label`; inline SVG icons render for logged-out shoppers; semantic `<ul>`/`<table>`/`<nav>`. **[browser]**

## Phase 6 - Packaging & release artifact

- [ ] Version agrees across the main-file header, `WB_AJAX_FILTER_VERSION`, `readme.txt`/`README.txt` stable tag, and `package.json`. **[code]**
- [ ] Built zip (via `bin/` build + `.distignore`) contains no `bin/`, `.distignore`, `node_modules/`, tests, or docs; `assets/blocks/filters/` (including `block.json` + built `index.js`) and `lib/wbcom-settings/` **are** present, asserted by named file on the artifact. **[code]**
- [ ] Bundled EDD SL SDK (`edd-license/`) is present in the zip - asserted by named file, on the artifact. **[code]**
- [ ] Pristine install from the **built zip** (fresh Docker WP + WooCommerce): activates, shop archive returns 200 with filters, REST `/presets` responds. **[code]** **[browser]**
- [ ] Changelog in WooCommerce action-prefix style (New/Improve/Fix/Security), no em-dashes, no emoji. **[code]**

## Phase 7 - Friction hunt

Judge against 10,000 store owners, not the happy path.

- [ ] **First run:** on a fresh activation with zero config, the seeded **Default** preset already renders working filters on the shop - not a blank archive until the owner hunts for a setting. Confirm the seed lands even on an update that skipped the activation hook. **[browser]**
- [ ] **Owner setup:** a non-developer can build a preset from Your Filters without the docs - field labels say what they do (category, price, rating), not the option key behind them; the preset picker in the block sidebar names presets by title. **[browser]**
- [ ] **Shopper path:** walk shop -> apply two filters -> narrow to a result -> reset. Count the clicks; no dead end, no step where applying a filter silently no-ops or leaves an empty grid with no "no products / reset" affordance (`woocommerce_no_products_found` still shows the filters). **[browser]**
- [ ] **Stored Data as support tool:** an owner sent to Stored Data can find a preset, toggle it, and export a JSON/CSV snapshot to attach to a ticket without touching phpMyAdmin. The full export doubles as a config snapshot (carries the option groups). **[browser]**
- [ ] **REST honesty:** hitting `/presets` without `manage_woocommerce` returns 401/403 (fail-closed), a bad `id` returns 404, and `per_page` over 100 is clamped, not honoured. Errors say what went wrong. **[code]** **[browser]**
- [ ] **Same-class sweep:** every friction found - is the same shape broken on another placement (block vs shortcode vs archive), theme, viewport or state the tester never opened? All three placements share one renderer, so a render bug fixed in one must be verified in the other two. Prove the sweep. **[browser]** **[code]**

## Phase 8 - Release sign-off

- [ ] Phases 1-7 complete, or each unchecked item logged as an accepted exception with a reason.
- [ ] Functionality catalog current: `audit/manifest.json` + `CAPABILITIES.md` regenerated no earlier than the newest `includes/` change. **[code]**
- [ ] Smoke-pass evidence recorded (`docs/qa/.last-smoke-pass.json`) with before/after proof for anything fixed this cycle - notably the double-bootstrap fix (Phase 1). **[code]**
