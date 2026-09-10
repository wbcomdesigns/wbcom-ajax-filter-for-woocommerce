# Storing Data

The **Stored Data** tab provides a browsable, exportable list of every preset the plugin stores.

## Access Stored Data

Go to **WB Plugins → Ajax Filter for WooCommerce → Stored Data**.

## What You See

- **Paginated table** – each row is a preset.
- **Status views** – filter by All, Enabled, or Disabled.
- **Title search** – find presets by name.
- **Sortable columns** – sort by title or date.

## Bulk Moderation

Select one or more presets and choose a bulk action:

- **Enable** – activate selected presets.
- **Disable** – deactivate selected presets.
- **Delete** – permanently remove selected presets (cannot be undone).

Bulk actions are processed securely on `admin_init` with nonce verification and capability checks.

## Export

Export all presets (including their configuration and the four option groups) as:

- **JSON** – a full snapshot for support or migration.
- **CSV** – for spreadsheet analysis.

Click the **Export JSON** or **Export CSV** button at the top of the table.

## REST API

For programmatic access, use the REST API endpoints:

- `GET /wb-ajax-filter/v1/presets` – list presets with pagination.
- `GET /wb-ajax-filter/v1/presets/<id>` – retrieve a single preset with its full configuration.

All endpoints require `manage_woocommerce` capability.

## Next Steps

- [Managing Presets](02-managing-presets.md) – enable, disable, duplicate, or delete presets.
- [REST API Endpoints](../rest-api/02-endpoints.md) – detailed API reference.
