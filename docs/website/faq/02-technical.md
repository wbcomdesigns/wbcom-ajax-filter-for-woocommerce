# Technical FAQ

## What shortcode does the plugin provide?

`[wb_ajax_filters]` – renders every enabled preset. Use `slug="your-preset-slug"` to render a specific preset.

## What block does the plugin provide?

**Ajax Product Filters** (`wb-ajax-filter/filters`) – place in block themes and the Site Editor. Choose a preset from the block sidebar.

## Is there a REST API?

Yes. `GET /wb-ajax-filter/v1/presets` lists presets; `GET /wb-ajax-filter/v1/presets/<id>` returns a single preset. All endpoints require `manage_woocommerce` capability.

## How do I add custom filter types?

Hook into `wb_ajax_filter_get_preset_filters` to add a custom filter configuration, and `woocommerce_product_query` to modify the product query.

## How do I disable automatic rendering on archives?

Remove the action hooks:

```php
remove_action( 'woocommerce_before_shop_loop', 'add_wb_ajax_filters', 10 );
remove_action( 'woocommerce_no_products_found', 'add_wb_ajax_filters', 10 );
```

Then use the shortcode or block to place filters manually.

## Where are the plugin’s options stored?

In `wp_options`:

- `wb_ajax_filter_admin_general_options`
- `wb_ajax_filter_admin_customization_options`
- `wb_ajax_filter_search_settings`
- `wb_ajax_filter_search_content_settings`

Presets are stored as `wb_filter_preset` custom post type with `_wb_filter` and `preset_enabled` meta.

## How do I export presets?

Use the **Stored Data** tab → **Export JSON** or **Export CSV** buttons, or call the REST API `GET /wb-ajax-filter/v1/presets?with_config=true`.

## Next Steps

- [Developer Guide](../developer-guide/01-hooks-filters.md)
- [REST API Endpoints](../rest-api/02-endpoints.md)
