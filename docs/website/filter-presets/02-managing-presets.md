# Managing Presets

Once created, presets can be enabled, disabled, duplicated, or deleted.

## Enable / Disable

- In **Your Filters**, toggle the **Enabled** switch for each preset.
- Only enabled presets render on the frontend (via shortcode, block, or automatic placement).

## Duplicate

- Click **Duplicate** to create a copy of an existing preset.
- The duplicate is disabled by default; rename and adjust as needed.

## Delete

- Click **Delete** to permanently remove a preset.
- Deletion cannot be undone.

## Bulk Actions

On the **Stored Data** tab, you can:

- Select multiple presets with checkboxes.
- Choose **Enable**, **Disable**, or **Delete** from the bulk actions dropdown.
- Click **Apply** to execute.

## REST API

For programmatic management, use the REST API:

- `GET /wb-ajax-filter/v1/presets` – list all presets.
- `POST /wb-ajax-filter/v1/presets/<id>` – update a preset (enable/disable, rename).
- `DELETE /wb-ajax-filter/v1/presets/<id>` – delete a preset.

All endpoints require `manage_woocommerce` capability.

## Next Steps

- [Storing Data](03-storing-data.md) – export and moderate stored presets.
- [REST API Endpoints](../rest-api/02-endpoints.md) – detailed API reference.
