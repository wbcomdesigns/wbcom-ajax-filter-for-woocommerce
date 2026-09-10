# Common Issues

## Filters Not Showing on Shop Page

**Possible Causes:**

1. **WooCommerce not active** – the plugin requires WooCommerce.
2. **No enabled presets** – check **WB Plugins → Ajax Filter for WooCommerce → Your Filters** and ensure at least one preset is enabled.
3. **Theme compatibility** – block themes may not fire `woocommerce_before_shop_loop`. Use the block or shortcode instead.

**Solution:**

- Activate WooCommerce.
- Enable a preset.
- Use the Ajax Product Filters block or `[wb_ajax_filters]` shortcode.

## Filters Not Updating via AJAX

**Possible Causes:**

1. **AJAX disabled** – in **General Settings**, set “Display results” to “Without page reload”.
2. **JavaScript error** – open browser console and look for errors.
3. **Plugin conflict** – disable other plugins to test.

**Solution:**

- Enable AJAX in General Settings.
- Check console for errors.
- Deactivate conflicting plugins.

## Search Field Not Appearing

**Possible Causes:**

1. **Search disabled** – in **Search Settings**, toggle “Enable search” on.
2. **Preset doesn’t include search** – ensure the preset has a search field added.
3. **Wrong page type** – the search box only renders on the shop page, product category, and product tag archives. It does not appear when the block or shortcode is placed on an ordinary page, regardless of settings.

**Solution:**

- Enable search in Search Settings.
- Edit the preset and add a search field.
- Place the block/shortcode on the shop page, a product category page, or a product tag page for the search box to appear.

## Shortcode Not Rendering

**Possible Causes:**

1. **Invalid slug** – check the preset slug in the preset editor.
2. **Preset disabled** – ensure the preset is enabled.

**Solution:**

- Use the correct slug.
- Enable the preset.

## REST API Returns 401/403

**Possible Causes:**

1. **Insufficient permissions** – user lacks `manage_woocommerce` capability.
2. **Authentication missing** – provide valid credentials.

**Solution:**

- Use an admin account with `manage_woocommerce` capability.
- Authenticate with application passwords or JWT.

## Next Steps

- [Debugging](02-debugging.md) – enable debug mode and logs.
