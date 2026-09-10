# Debugging

Work down this list in order. Most filter issues come from one of the first three steps.

## 1. Enable WordPress Debug Mode

Add these lines to `wp-config.php`:

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
```

PHP notices, warnings, and fatal errors are written to `wp-content/debug.log`. Leave `WP_DEBUG_DISPLAY` off on a live store - you do not want raw PHP errors in front of shoppers.

## 2. Check the Log

Look at the tail of `wp-content/debug.log`. Filter-related messages mention the plugin's text domain, `wb-ajax-filter`, or its class names. Every fatal error logs the file and line that caused it.

## 3. Check the Browser Console

1. Open developer tools (F12).
2. Console tab - look for JavaScript errors and failed network requests.
3. Network tab - filter by `wb-ajax` to see the AJAX filter calls; a red row means the request failed.

## 4. Test a Clean Setup

- **Deactivate other plugins** - filter conflicts first. Keep only Ajax Filter and WooCommerce, then re-enable the rest one by one.
- **Switch to a default theme** - a theme that does not fire `woocommerce_before_shop_loop` (typically a block theme) will not auto-render filters; place them with the block or shortcode instead.
- **Clear caches** - page cache, object cache, and CDN. A stale cache looks exactly like "my filters do not work".

## 5. Confirm WooCommerce Is Active

The plugin self-deactivates if WooCommerce is not active - you would already have seen the banner, but a half-started restructure can leave the plugin inactive with old cache still serving.

## 6. Test the REST API Isolating

Hit the endpoint directly to separate the API from the frontend:

```bash
curl -u "storemanager:xxxx xxxx xxxx xxxx xxxx xxxx" \
  "https://your-site.com/wp-json/wb-ajax-filter/v1/presets?per_page=5"
```

A `401`/`403` means the credentials or role are the problem. An empty array with `200` and `X-WP-Total: 0` means there are simply no presets (see [Common Issues](01-common-issues.md)).

## Related Pages

- [Common Issues](01-common-issues.md) - the usual fixes for each symptom.