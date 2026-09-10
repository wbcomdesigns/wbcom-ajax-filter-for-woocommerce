# REST API Endpoints

All endpoints are under the `wb-ajax-filter/v1` namespace and require `manage_woocommerce` capability.

## List Presets

```
GET /wb-ajax-filter/v1/presets
```

### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `page` | integer | 1 | Page number. |
| `per_page` | integer | 10 | Items per page. Values above `100` are accepted and clamped to `100`. |
| `search` | string | – | Search preset titles. |
| `status` | string | `all` | Filter by status (`all`, `enabled`, `disabled`). |
| `orderby` | string | `title` | Sort field (`title`, `date`, `id`). |
| `order` | string | `asc` | Sort order (`asc`, `desc`). |
| `with_config` | boolean | false | Include the full `_wb_filter` config. |

### Response

Returns an array of preset objects. Totals are returned in `X-WP-Total` and `X-WP-TotalPages` headers.

## Get Single Preset

```
GET /wb-ajax-filter/v1/presets/<id>
```

Returns a single preset object, including its full `_wb_filter` config.

## Update Preset

```
POST /wb-ajax-filter/v1/presets/<id>
```

The route also accepts `PUT` and `PATCH` (registered as `EDITABLE`).

### Request Body

| Field | Type | Description |
|-------|------|-------------|
| `enabled` | boolean | Enable or disable the preset. |
| `title` | string | New title for the preset. |

Only these two fields can be modified via the API.

## Delete Preset

```
DELETE /wb-ajax-filter/v1/presets/<id>
```

Permanently deletes the preset. This action cannot be undone.

## Error Responses

- `400 Bad Request` – invalid parameters.
- `401 Unauthorized` – missing or invalid authentication.
- `403 Forbidden` – user lacks `manage_woocommerce` capability.
- `404 Not Found` – preset not found.

## Next Steps

- [Overview](01-overview.md) – authentication and response format.
- [Authentication](03-authentication.md) – how to authenticate requests.
