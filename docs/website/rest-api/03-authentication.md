# REST API Authentication

Every route requires a user with the `manage_woocommerce` capability - the same role the **Stored Data** screen needs. The permission check fails closed: nobody can reach the preset data without this capability.

## How to Authenticate

Use a WordPress **Application Password**, which is the built-in way to authenticate programmatic REST API requests.

1. In wp-admin, go to **Users > Profile**.
2. Scroll to **Application Passwords**, give one a name (for example `storefront-sync`), and click **Add New Application Password**.
3. Copy the generated password - it is shown only once. If the section is missing, your host blocks it; see [Troubleshooting](../troubleshooting/01-common-issues.md).

### Curl

```bash
curl -u "your-username:your-application-password" \
  "https://your-site.com/wp-json/wb-ajax-filter/v1/presets"
```

### Basic auth in JavaScript

```js
const user = 'store-manager';
const pass = 'xxxx xxxx xxxx xxxx xxxx xxxx';

const res = await fetch('https://your-site.com/wp-json/wb-ajax-filter/v1/presets', {
  headers: {
    'Authorization': 'Basic ' + btoa(`${user}:${pass}`)
  }
});
```

## Error Responses

| Status | Meaning |
|--------|---------|
| `401` | No credentials sent, or the credentials are wrong. |
| `403` | Credentials are valid but the user lacks `manage_woocommerce`. |

Both return a JSON error body:

```json
{
  "code": "rest_forbidden",
  "message": "You are not allowed to access filter presets.",
  "data": { "status": 403 }
}
```

## Related Pages

- [Overview](01-overview.md) - base URL and response format.
- [Endpoints](02-endpoints.md) - every route and parameter.