# Managing Presets

Once a preset exists, you can enable or disable it, duplicate it, rename it, or delete it. Only enabled presets render on the frontend.

## Enable / Disable a Preset

- In **WB Plugins → Ajax Filter → Your Filters**, use the **Enabled** switch on each preset row.
- Only presets that are enabled appear on the shop, category, and tag archives, and render through the shortcode or block.

## Duplicate a Preset

Click the duplicate icon on a preset row to create an exact copy of the preset's fields and settings. The copy is titled "Your Preset Copy 1" (the number increments for each further copy), starts **disabled**, and carries a `parent_preset` marker pointing at the original. Rename and adjust the copy as needed; the original is untouched.

## Rename a Preset

Click the pencil icon on a preset row to edit the title inline. Renaming does not change the preset's slug; the shortcode's `slug="..."` attribute keeps working.

## Delete a Preset

Click the trash icon (in **Your Filters**) to move a preset to the WordPress **Trash**. You can restore it from there if you delete it by mistake. Deleting via the **Stored Data** tab removes the preset permanently - there is no Trash recovery from that path.

## Bulk Actions

On the **Stored Data** tab you can manage several presets at once:

1. Select presets with the checkboxes.
2. Choose **Enable**, **Disable**, or **Delete** from the bulk actions dropdown.
3. Click **Apply**.

## Programmatic Management

For headless workflows you can also manage presets through the REST API:

```
GET    /wp-json/wb-ajax-filter/v1/presets      List presets
GET    /wp-json/wb-ajax-filter/v1/presets/<id>  Fetch one preset with its full config
POST   /wp-json/wb-ajax-filter/v1/presets/<id>  Enable/disable or rename a preset
DELETE /wp-json/wb-ajax-filter/v1/presets/<id>  Delete a preset
```

Every endpoint requires a user with the `manage_woocommerce` capability. See the [REST API reference](../rest-api/02-endpoints.md) for full details.

## Related Pages

- [Creating Presets](01-creating-presets.md) - build and configure filter fields.
- [Stored Data](03-storing-data.md) - browse, moderate, and export presets in bulk.