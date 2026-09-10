# Debugging

## Enable WordPress Debug Mode

Add these lines to your `wp-config.php`:

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
```

Errors will be logged to `wp-content/debug.log`.

## Check the Debug Log

Look for errors related to `wb-ajax-filter` in `wp-content/debug.log`.

## Browser Console

1. Open your browser’s developer tools (F12).
2. Go to the **Console** tab.
3. Look for JavaScript errors or failed network requests.

## Common Debug Steps

1. **Disable other plugins** – test for conflicts.
2. **Switch to a default theme** – rule out theme issues.
3. **Clear caches** – page cache, object cache, CDN.
4. **Verify WooCommerce is active** – the plugin deactivates itself without WooCommerce.

## REST API Debugging

Use a tool like Postman or cURL to test API endpoints directly:

```bash
curl -X GET \
  https://example.com/wp-json/wb-ajax-filter/v1/presets \
  -H 'Authorization: Basic base64(username:application_password)'
```

Check the response status and message.

## Next Steps

- [Common Issues](01-common-issues.md) – solutions to frequent problems.
