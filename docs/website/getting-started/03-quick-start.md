# Quick Start

This guide gets filters running on your store in minutes.

## 1. Verify WooCommerce is Active

The plugin requires WooCommerce. If WooCommerce is not active, deactivate the plugin and install WooCommerce first.

## 2. Check the Default Preset

After activation, a **Default** preset is created and enabled. You can see it under **WB Plugins → Ajax Filter for WooCommerce → Your Filters**.

## 3. Display Filters

### Option A: Automatic Rendering (Classic Themes)

On classic themes, filters automatically appear on WooCommerce shop, category, and tag archives. No configuration needed.

### Option B: Shortcode

Place the shortcode `[wb_ajax_filters]` on any page or widget area. This renders every enabled preset.

To render a specific preset by slug:

```
[wb_ajax_filters slug="your-preset-slug"]
```

### Option C: Gutenberg Block (Block Themes)

1. Edit a page, post, or template in the Block Editor.
2. Add the **Ajax Product Filters** block (found under the WooCommerce category).
3. Choose a preset from the block sidebar.
4. Save.

## 4. Test the Filter

Visit your shop page. You should see filter fields (e.g., price slider, category dropdown). Select options and watch the product grid update instantly.

## Next Steps

- [Create additional presets](../filter-presets/01-creating-presets.md) for different pages.
- [Customize the filter appearance](../configuration/03-customization-settings.md).
- [Explore the REST API](../rest-api/01-overview.md) for headless integrations.
