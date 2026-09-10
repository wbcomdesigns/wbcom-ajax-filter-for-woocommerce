# REST API Overview

The plugin exposes its stored filter presets over the WordPress REST API for headless storefronts, mobile apps, external dashboards, and any integration that needs the same data the admin screens show.

The API is **admin-only by design**: preset configuration names custom field keys and taxonomy structure, so it is store-management data, not a public catalogue. Every route requires a user with the `manage_woocommerce` capability.

## Base URL

```
/wp-json/wb-ajax-filter/v1/
```

## What You Can Do

- List presets with pagination, search, status filtering, and sorting.
- Fetch one preset including its full field configuration.
- Enable, disable, or rename a preset.
- Delete a preset permanently.

## Response Format

Responses are plain JSON arrays or objects - no extra wrapper. Pagination totals travel in HTTP response headers, not in the body:

- `X-WP-Total` - total number of presets.
- `X-WP-TotalPages` - total pages at the current page size.

### Example record

```json
{
  "id": 12,
  "title": "Clothing Archive",
  "enabled": true,
  "fields_total": 4,
  "fields_enabled": 4,
  "created": "2026-08-01T09:12:00+00:00",
  "modified": "2026-08-14T15:40:22+00:00",
  "config": [
    {
      "filter_id": "wb_filter_66ab9...",
      "filter_title": "Category",
      "type": "tax",
      "taxonomy": "product_cat"
    }
  ]
}
```

The `config` field only appears when the request asks for it (`with_config=true`, or on a single-record fetch).

## Related Pages

- [Endpoints](02-endpoints.md) - every route, parameter, and response.
- [Authentication](03-authentication.md) - how to authenticate requests.