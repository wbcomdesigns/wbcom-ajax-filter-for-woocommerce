# Capabilities - Wbcom Designs Ajax Filter For WooCommerce

Version 1.3.0 - functionality roll-up. Source of truth is the code under `includes/`, `admin/`, `public/` and `assets/blocks/`; the machine-readable companion is `audit/manifest.json`. Maturity status reflects what is wired and reachable in this release, not a roadmap.

## What it does

Adds real-time AJAX product filtering to a WooCommerce store. A shopper narrows the catalogue by taxonomy (category, tag, attributes), price (range inputs and slider), stock/sale status, average rating and order-by, and the product grid updates in place with no full page reload. The store owner builds one or more **presets** (a named set of filter fields) and places them on the shop through the automatic archive placement, a shortcode, or a Gutenberg block. A single preset - the "Default" - is seeded enabled on activation so the filter works with zero configuration.

## Capabilities

| Capability | What it delivers | Status |
|---|---|---|
| AJAX archive filtering | Filters render on WooCommerce shop / category / tag archives and update results without reload | Stable |
| Preset builder | Create, duplicate, delete, rename presets; drag-sort fields; per-field config | Stable |
| Taxonomy filter | Filter by category, tag and product attributes; checkbox / radio / select, child terms, per-term custom labels and counts | Stable |
| Price filter | Min/max range inputs and a price slider | Stable |
| Stock / sale filter | Restrict to in-stock and/or on-sale products | Stable |
| Rating filter | Filter by average product rating | Stable |
| Order-by filter | Shopper-facing sort control | Stable |
| Adaptive filtering | Option to restrict shown terms/products to those with matches in the current result set | Stable |
| Product search + autocomplete | Search box with autocomplete, including SKU search; works for logged-out shoppers via a public nonce-verified endpoint | Stable |
| Gutenberg block | "Ajax Product Filters" dynamic block with a preset picker, for block themes / the site editor | Stable |
| Shortcode | `[wb_ajax_filters]` (all enabled presets) / `[wb_ajax_filters slug="..."]` (one preset) | Stable |
| Stored Data screen | Admin list of saved presets: paginate, filter by status, bulk enable/disable/delete, export JSON + CSV | Stable |
| REST API | `wb-ajax-filter/v1/presets` - list/read/moderate/delete presets, capability-gated | Stable |
| Theme-overridable templates | Every render template overridable from `yourtheme/wb-ajax-filter/` via `wc_get_template` | Stable |
| Theme-following styles + dark mode | Filter components pick up the active theme through `--wb-*` custom properties | Stable |

## Admin surfaces

One admin screen on the shared Wbcom settings shell (`lib/wbcom-settings/`), slug `wc-ajax-filter-settings`, under the **WB Plugins** parent menu. Tabs:

- **Overview** - read-first dashboard: active presets, live fields, and which archives the filter renders on.
- **Your Filters** - the preset builder (create/duplicate/delete presets, add/sort/configure fields).
- **Stored Data** - `WP_List_Table` of preset records: status views, search, bulk enable/disable/delete, and JSON/CSV export (downloads served through `admin-post.php`). This is the support surface that replaces reaching for phpMyAdmin.
- **Advanced** - general, search and customization option groups.
- **License** - EDD Software Licensing activation.

## Frontend surfaces

The same renderer (`Wb_Ajax_Filter_Public::filter_preset_shortcode_callback`) backs all three placement paths:

- **Automatic archive placement** - `woocommerce_before_shop_loop` (and `woocommerce_no_products_found`) on classic themes.
- **Gutenberg block** - "Ajax Product Filters", placeable in pages and block-theme template areas where the classic WooCommerce hooks never fire.
- **Shortcode** - `[wb_ajax_filters]`.

Result filtering is applied server-side through `woocommerce_product_query` (priority 999) and `posts_search` (SKU search); the grid is refreshed over AJAX. Active selections show as human-readable chips with a reset control; below 640px the filters collapse behind a single **Filters** toggle.

## REST API (deliberate public API)

`wb-ajax-filter/v1/presets` is an intentional public API for headless storefronts, mobile apps and external integrations - it exposes the **same** preset records as the Stored Data screen through the shared `Wb_Ajax_Filter_Presets` seam.

- `GET /presets` - paginated list with `X-WP-Total` / `X-WP-TotalPages`, params `page`, `per_page` (capped at 100), `search`, `status`, `orderby`, `order`, `with_config`.
- `GET /presets/{id}` - one record with its full field configuration.
- `POST|PUT|PATCH /presets/{id}` - moderate: `enabled` flag and `title`.
- `DELETE /presets/{id}` - permanent delete, matching the admin surfaces.

Every route is gated by `manage_woocommerce` through a fail-closed permission callback (never `__return_true`) - preset configuration names custom-field keys and taxonomy structure, so it is treated as store-management data, not public catalogue data.

## Data stored

- **`wb_filter_preset` CPT** (private, `show_ui` true, not in menu) - one post per preset.
  - `_wb_filter` post meta - the full array of filter-field configuration.
  - `preset_enabled` post meta - `'yes'` when the preset renders to shoppers; absent or other value means disabled.
- **Options** - `wb_ajax_filter_admin_general_options`, `wb_ajax_filter_admin_customization_options`, `wb_ajax_filter_search_settings`, `wb_ajax_filter_search_content_settings`, and the `wb_ajax_filter_default_preset_seeded` latch.

All preset reads/writes route through `Wb_Ajax_Filter_Presets`, the single data-access owner, so pagination rules, the enabled/disabled definition and the exported record shape cannot drift between the admin table, REST and export. No custom database tables; no cron.

## Extension seams

- **Filters** - `wb_ajax_filter_get_preset_filters`, `wb_ajax_filter_restrict_products`, `wb_ajax_filter_restrict_terms`, `wb_ajax_filter_custom_field_search_limit`, plus the admin-shell seams `wb_ajax_filter_settings_nav_groups` and `wb_ajax_filter_settings_tab_content`.
- **Actions** - `wb_ajax_filter_fields` / `wb_ajax_filter_before_filter_fields` / `wb_ajax_filter_after_filter_fields` (field registry), `wb_ajax_filter_before_content` / `wb_ajax_filter_after_content` (frontend wrap), and the `*_admin_*_settings` pairs around each Advanced-tab option group.
- **Templates** - copy any file from `templates/` into `yourtheme/wb-ajax-filter/` (same relative path); loaded through `wc_get_template`, so updates never overwrite overrides. Flat-path copies from before 1.2.2 still resolve.

## Big-site note

Filtering runs over the store catalogue, which is the surface that grows. Coverage in this release:

- **Preset lists are bounded end to end.** `Wb_Ajax_Filter_Presets::normalize_args` makes pagination mandatory (no `-1` escape), caps `per_page` at `MAX_PER_PAGE` (100), and whitelists `orderby`; totals come from `wp_count_posts()` (a cached `COUNT(*)`), not `count()` over a full fetch. The admin list table, REST list and export all share this seam.
- **Overview / block preset dropdown** cap their queries at 100 presets and prime the meta cache in one batched `get_posts` (no per-row meta query); the Overview flags when the list is truncated while still showing the true total.
- **Custom-field autocomplete** uses one indexed query rather than scanning the whole catalogue (commit 92e060f).
- **Result filtering** is applied inside WooCommerce's own product query (`woocommerce_product_query`), which is already paginated by the loop - the plugin narrows the existing query rather than fetching all products.

Verify at scale before release: seed a 1,000+ product catalogue and 1,000+ presets, confirm the Stored Data list paginates and stays responsive, and confirm archive filtering stays fast on a large product set (see `docs/qa/QA-GATE.md`, Phase 2).
