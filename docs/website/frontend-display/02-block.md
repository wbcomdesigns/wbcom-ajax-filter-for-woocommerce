# Block

The **Ajax Product Filters** block lets you place filter presets in block themes, the Site Editor, and any block‑enabled area.

## Adding the Block

1. Edit a page, post, or template in the Block Editor.
2. Click the **+** inserter and search for “Ajax Product Filters”.
3. Select the block (found under the WooCommerce category).

## Block Settings

In the block sidebar, choose a preset from the dropdown. The block renders the selected preset’s fields.

## How It Works

- The block uses `ServerSideRender` to output the same filter markup as the shortcode.
- It shares the same PHP renderer (`Wb_Ajax_Filter_Public::filter_preset_shortcode_callback`).
- Preset data is localized for the editor via `wbAjaxFilterBlock.presets`.

## Compatibility

- Works in block themes, the Site Editor, and classic themes with block support.
- On classic themes, filters also render automatically on WooCommerce archives (see [Auto Render](03-auto-render.md)).

## Notes

- If no preset is selected, the block renders all enabled presets.
- The block’s output is identical to the shortcode and the automatic archive placement.

## Next Steps

- [Shortcode](01-shortcode.md) – place filters via shortcode.
- [Auto Render](03-auto-render.md) – automatic placement on WooCommerce archives.
