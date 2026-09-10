# REST API Overview

The plugin exposes a REST API for headless storefronts, mobile apps, and external integrations. The API provides the same preset data available in the admin Stored Data screen.

## Base URL

```
/wp-json/wb-ajax-filter/v1/
```

## Authentication

All endpoints require the `manage_woocommerce` capability. Requests must be authenticated with a user who has this capability.

## Response Format

Responses follow the standard WP REST API envelope:

```json
{
  "data": [ ... ],
  "headers": {
    "X-WP-Total": 10,
    "X-WP-TotalPages": 2
  }
}
```

## Rate Limiting

There are no built‑in rate limits, but we recommend caching responses when possible.

## Next Steps

- [Endpoints](02-endpoints.md) – detailed endpoint reference.
- [Authentication](03-authentication.md) – how to authenticate requests.
