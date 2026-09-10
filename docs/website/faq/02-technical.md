# Technical FAQ

## What shortcode does the plugin provide?

`[wb_ajax_filters]` renders every published, enabled preset, newest first. Use `[wb_ajax_filters slug="your-preset-slug"]` to render one specific preset. Disabled presets are never rendered, even when their slug is given.

## What block does the plugin provide?

The **Ajax Product Filters** block (`wb-ajax-filter/filters`). In the block sidebar choose **All enabled presets** or a specific one. It renders through the same code path as the shortcode, so output is identical.

## Is there a REST API?

Yes. Everything is under `/wp-json/wb-ajax-filter/v1/presets`. List presets with `GET`, fetch one with `GET /presets/<id>`, enable/disable or rename with `POST/PUT/PATCH /presets/<id>`, and delete with `DELETE /presets/<id>`. Every route requires the `manage_woocommerce` capability - there is no public read path. See [REST API](../rest-api/01-overview.md).

## Can I add custom filter types?

Code-only, but yes. Inject a field array through the `wb_ajax_filter_get_preset_filters` filter, render it from a `filter-<type>.php` template in your theme, and handle the query parameter on `woocommerce_product_query`. See [Extending Presets](../developer-guide/03-extending-presets.md).

## How do I disable automatic rendering on archives?

The automatic hooks are registered as an object method, so plain `remove_action( ..., 'add_wb_ajax_filters', 10 )` will not work. Use the matching instance snippet in [Auto Render](../frontend-display/03-auto-render.md), then place the block or shortcode manually.

## Where are the plugin's options stored?

In `wp_options`:

- `wb_ajax_filter_admin_general_options` - filtering behaviour
- `wb_ajax_filter_admin_customization_options` - appearance
- `wb_ajax_filter_search_settings` - product search
- `wb_ajax_filter_search_content_settings` - search scope

Presets are posts of the `wb_filter_preset` custom post type, with `_wb_filter` (field configuration) and `preset_enabled` post meta.

## How do I export and import presets?

Open **WB Plugins → Ajax Filter → Stored Data** and use **Export JSON** or **Export CSV**. The full JSON export carries every preset's configuration plus the plugin's option groups, so one file is a complete support snapshot. There is no import button - restored configurations are applied by support.

## Next Steps

- [Hooks and Filters](../developer-guide/01-hooks-filters.md)
- [REST API Endpoints](../rest-api/02-endpoints.md)