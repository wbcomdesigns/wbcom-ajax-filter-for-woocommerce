# Block

The **Ajax Product Filters** block places filter presets in block themes, the Site Editor, and any block-enabled area. Use it where the classic WooCommerce archive hooks never fire - block themes, custom templates, or anywhere you want the filter controls outside the default position.

## Adding the Block

1. Edit a page, post, or template in the Block Editor.
2. Click the **+** inserter and search for "Ajax Product Filters".
3. Select the block (under the **WooCommerce** category).

## Choosing a Preset

In the block sidebar, pick a preset from the **Preset** dropdown:

- **All enabled presets** (default) - renders every enabled preset.
- **A specific preset** - renders just that preset's fields.

Presets are listed alphabetically. Disabled presets are skipped on the frontend even when chosen here.

## How It Works

- The block renders server-side through the same code path as the shortcode (`Wb_Ajax_Filter_Public::filter_preset_shortcode_callback`), so the output is identical to the shortcode and the automatic archive placement.
- In the editor you see a live preview of the selected preset's filters.
- Styles and scripts are enqueued by the block's render callback, so the block works in Site Editor template areas where the standard asset hooks may not fire.

## Compatibility

- Works in block themes, the Site Editor, and classic themes with block support.
- **Classic themes:** on the shop and taxonomy archives, filters also render automatically (see [Auto Render](03-auto-render.md)). You can remove the automatic output and use the block instead.

## Notes

- With no preset selected, the block behaves like the bare `[wb_ajax_filters]` shortcode.
- The product search box only appears when the block sits on the shop page or a category/tag archive, matching the shortcode's behaviour.

## Related Pages

- [Shortcode](01-shortcode.md) - the shortcode equivalent.
- [Auto Render](03-auto-render.md) - automatic placement on archive pages.