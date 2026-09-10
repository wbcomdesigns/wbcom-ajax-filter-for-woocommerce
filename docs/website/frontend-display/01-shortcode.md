# Shortcode

The `[wb_ajax_filters]` shortcode renders filter presets on any page, post, or widget area. It works on classic themes, block themes, and anywhere shortcodes are allowed.

## Basic Usage

```
[wb_ajax_filters]
```

This renders every **enabled** preset. Enabled presets appear newest-first; disabled presets are skipped.

## Render a Single Preset

```
[wb_ajax_filters slug="your-preset-slug"]
```

The `slug` attribute targets one preset by its post slug. A slug-only render still checks the preset's enabled state - a disabled preset renders nothing.

## Attributes

| Attribute | Default | Description |
|-----------|---------|-------------|
| `slug` | (all enabled presets) | The slug of a specific preset to render. |

## Examples

Render all enabled presets:

```
[wb_ajax_filters]
```

Render only the "shop-sidebar" preset:

```
[wb_ajax_filters slug="shop-sidebar"]
```

## Where to Place

- **Pages and posts** - insert the shortcode in the content editor.
- **Widget areas** - use a Shortcode widget and paste the shortcode.
- **Theme templates** - call `do_shortcode( '[wb_ajax_filters]' )` from a template file.

## Notes

- The output is identical to the block and the automatic archive placement.
- If no presets are enabled, the block area renders nothing - not even a heading or reset button.
- The product search box shows only on the shop page and category and tag archives, even when the shortcode is placed on an ordinary page. This is deliberate: the search results grid only exists on those archive pages.

## Related Pages

- [Block](02-block.md) - place filters in block themes.
- [Auto Render](03-auto-render.md) - automatic placement on WooCommerce archives.