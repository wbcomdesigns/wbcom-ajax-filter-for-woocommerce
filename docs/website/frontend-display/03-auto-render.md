# Auto Render

On classic themes, the plugin automatically renders filters on WooCommerce archive pages without any configuration.

## Where Filters Appear

- **Shop page** – the main WooCommerce shop archive.
- **Category archives** – product category pages.
- **Tag archives** – product tag pages.
- **Search results** – when the search results page uses WooCommerce templates.

## How It Works

The plugin hooks into `woocommerce_before_shop_loop` and `woocommerce_no_products_found` to output the filter block. The same shortcode renderer is used, so the output matches the shortcode and block.

## Controlling Placement

If you want to disable automatic rendering and place filters manually:

1. Use the shortcode `[wb_ajax_filters]` or the Ajax Product Filters block.
2. Remove the automatic output by adding this snippet to your theme’s `functions.php`:

```php
remove_action( 'woocommerce_before_shop_loop', 'add_wb_ajax_filters', 10 );
remove_action( 'woocommerce_no_products_found', 'add_wb_ajax_filters', 10 );
```

## Notes

- Automatic rendering only works on classic themes that fire the `woocommerce_before_shop_loop` hook.
- Block themes often do not fire this hook; use the block or shortcode instead.

## Next Steps

- [Shortcode](01-shortcode.md) – place filters via shortcode.
- [Block](02-block.md) – place filters in block themes.
- [Theme Overrides](04-theme-overrides.md) – customize filter templates.
