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
