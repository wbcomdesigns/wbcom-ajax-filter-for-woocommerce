# REST API Endpoints

All routes live under `wb-ajax-filter/v1` and require the `manage_woocommerce` capability. Pagination totals are returned in the `X-WP-Total` and `X-WP-TotalPages` response headers.

## List Presets

```
GET /wp-json/wb-ajax-filter/v1/presets
```

### Parameters

| Parameter | Type | Default | Allowed | Description |
|-----------|------|---------|---------|-------------|
| `page` | int | 1 | >= 1 | Page number. |
| `per_page` | int | 10 | 1 - 100 | Records per page. Values above 100 are rejected. |
| `search` | string | (empty) | any | Only presets whose title matches. |
| `status` | string | `all` | `all`, `enabled`, `disabled` | Filter by enabled state. |
| `orderby` | string | `title` | `title`, `date`, `id` | Sort field. |
| `order` | string | `asc` | `asc`, `desc` | Sort direction. |
| `with_config` | boolean | `false` | true / false | Include each preset's full `config` in the response. |

### Response

A JSON array of preset records. Each record includes `id`, `title`, `enabled`, `fields_total`, `fields_enabled`, `created`, and `modified`. The full field configuration is included only when `with_config=true`.

## Get a Single Preset

```
GET /wp-json/wb-ajax-filter/v1/presets/<id>
```

Returns one preset record, always including its full `config` field.

## Update a Preset

```
POST /wp-json/wb-ajax-filter/v1/presets/<id>
```

Also accepts `PUT` and `PATCH`. Use it to enable or disable a preset and rename it:

| Field | Type | Description |
|-------|------|-------------|
| `enabled` | boolean | `true` renders the preset to shoppers; `false` hides it. |
| `title` | string | New title for the preset. |

Only these two fields are editable through the API. Omitting a field leaves it unchanged. Returns the updated record including its full config.

## Delete a Preset

```
DELETE /wp-json/wb-ajax-filter/v1/presets/<id>
```

Permanently deletes the preset and its saved field configuration. This matches the **Stored Data** tab's delete action and cannot be undone - there is no Trash. Returns:

```json
{
  "deleted": true,
  "previous": {
    "id": 12,
    "title": "Clothing Archive",
    "...": "..."
  }
}
```

## Errors

| Status | Meaning |
|--------|---------|
| `400` | A parameter is invalid (for example, `per_page` above 100). |
| `401` | Not authenticated. |
| `403` | Authenticated but the user lacks `manage_woocommerce`. |
| `404` | The preset does not exist (or is not a published preset). |
| `500` | The update or delete could not be completed. |

## Related Pages

- [Overview](01-overview.md) - base URL and response format.
- [Authentication](03-authentication.md) - authenticating with application passwords.