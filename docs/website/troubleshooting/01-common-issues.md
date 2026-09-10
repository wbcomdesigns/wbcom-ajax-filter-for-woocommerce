# Common Issues

## Filters Not Showing on Shop Page

Possible causes:

1. **WooCommerce is not active** - the plugin self-deactivates without it.
2. **No enabled preset** - open **WB Plugins → Ajax Filter → Your Filters** and make sure at least one preset shows as enabled.
3. **Block theme** - block themes may not fire `woocommerce_before_shop_loop`, so auto-render produces nothing. Use the **Ajax Product Filters** block or the `[wb_ajax_filters]` shortcode instead.

## Filters Not Updating via AJAX

Possible causes:

1. **"Display results" is set to "On page reload"** - open **WB Plugins → Ajax Filter → Advanced → Filtering behaviour** and choose **Without page reload**.
2. **A JavaScript error or failed request** - open your browser console (F12) and check the Console and Network tabs.
3. **Plugin conflict** - temporarily deactivate other plugins (or switch to a default theme) to isolate the clash.

## Search Box Not Appearing

The product search box is **not part of a preset** - it renders from the product-search settings, and only on the shop page, product category pages, and product tag pages. It never appears on other pages, even when a preset, block, or shortcode is placed there.

1. **Search is off** - open **WB Plugins → Ajax Filter → Advanced → Product search** and enable search.
2. **Wrong page type** - place the filters on the shop page or a category/tag archive for the search box to show.

## Shortcode Not Rendering

`[wb_ajax_filters]` renders every published, enabled preset - no preset lets the shortcode output nothing.

1. **No presets at all** - create one in **Your Filters**.
2. **Preset disabled** - the preset's toggle is off in **Your Filters** or **Stored Data**.
3. **Using `slug="..."`** - make sure the slug (not the title) matches the preset's post slug.

## Filters Rendering in the Wrong Order

The shortcode renders presets **newest first** (creation date, newest at the top). There is no ordering control - to re-shuffle output, use one combined preset rather than separate `slug` shortcodes, or place the block with **All enabled presets** on the page with the presets you want.

## REST API Returns 401/403

1. **Not authenticated** (401) - send credentials. Use an Application Password; the plugin has no dedicated JWT support.
2. **Authenticated but lacking `manage_woocommerce`** (403) - the account must be a store manager or administrator. There is no read-only mode; every route requires the capability.

## Related Pages

- [Debugging](02-debugging.md) - systematically isolate the cause.
- [Troubleshooting](../faq/01-general.md) - common questions.