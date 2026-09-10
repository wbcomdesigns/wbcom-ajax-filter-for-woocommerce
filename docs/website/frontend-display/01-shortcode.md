# Shortcode

The `[wb_ajax_filters]` shortcode renders filter presets on any page, post, or widget area.

## Basic Usage

```
[wb_ajax_filters]
```

This renders **every enabled preset** in the order they were created.

## Specify a Preset

To render a single preset by its slug:

```
[wb_ajax_filters slug="your-preset-slug"]
```

The slug is the preset’s post slug (visible in the preset editor URL).

## Attributes

| Attribute | Required | Default | Description |
|-----------|----------|---------|-------------|
| `slug` | No | (all enabled presets) | The slug of a specific preset to render. |

## Examples

Render all enabled presets:

```
[wb_ajax_filters]
```

Render only the “shop-sidebar” preset:

```
[wb_ajax_filters slug="shop-sidebar"]
```

## Where to Place

- **Pages/Posts** – insert the shortcode in the content editor.
- **Widgets** – add a Shortcode widget and paste the shortcode.
- **Templates** – use `do_shortcode('[wb_ajax_filters]')` in theme templates.

## Notes

- The shortcode output is identical to the block and the automatic archive placement.
- If no presets are enabled, the shortcode renders nothing.

## Next Steps

- [Block](02-block.md) – place filters in block themes.
- [Auto Render](03-auto-render.md) – automatic placement on WooCommerce archives.
