# Authentication

All REST API endpoints require a user with the `manage_woocommerce` capability.

## WordPress Application Passwords

The simplest way to authenticate is with WordPress Application Passwords (built into WordPress 5.6+).

1. Go to **Users → Your Profile**.
2. Scroll to **Application Passwords**.
3. Enter a name (e.g., “REST API”) and click **Add New Application Password**.
4. Copy the generated password.

Use the application password in the `Authorization` header:

```
Authorization: Basic base64(username:application_password)
```

## JWT Authentication

If you use a JWT plugin (e.g., JWT Authentication for WP REST API), include the token in the `Authorization` header:

```
Authorization: Bearer your_jwt_token
```

## Cookie Authentication

For same‑origin requests (e.g., from wp‑admin), you can use nonce‑based authentication:

1. Add `_wpnonce` parameter to the request.
2. The nonce is available in the admin footer as `wpApiSettings.nonce`.

## Example cURL Request

```bash
curl -X GET \
  https://example.com/wp-json/wb-ajax-filter/v1/presets \
  -H 'Authorization: Basic base64(username:application_password)'
```

## Permissions

Only users with `manage_woocommerce` capability can:

- List, view, update, and delete presets.
- Access the Stored Data screen.

## Next Steps

- [Endpoints](02-endpoints.md) – detailed endpoint reference.
- [Overview](01-overview.md) – response format and base URL.
