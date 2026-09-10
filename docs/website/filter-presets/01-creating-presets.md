# Creating Presets

A **preset** is a saved set of filter fields that appear on your shop pages. Each preset can have different fields and settings.

## Access the Preset Builder

1. Go to **WB Plugins → Ajax Filter for WooCommerce → Your Filters**.
2. Click **Add New** to create a new preset.

## Configure the Preset

### Name

Give your preset a descriptive name (e.g., “Shop Sidebar”, “Category Filter”).

### Add Filter Fields

Click **Add Filter** to insert a new field. Choose from:

- **Taxonomy** – product categories, tags, or attributes.
- **Price Range** – slider or input fields for min/max price.
- **Price Slider** – a visual slider for price filtering.
- **Stock Status** – filter by in-stock, out-of-stock, or on-backorder.
- **Rating** – filter by product rating (e.g., 4 stars and up).
- **Order By** – sort by price, popularity, rating, etc.
- **Custom Field** – filter by a product custom field.

### Configure Each Field

Each field type has its own settings:

- **Label** – heading shown above the field.
- **Type** – display style (checkbox, radio, select, slider, etc.).
- **Taxonomy** (for taxonomy fields) – which taxonomy to display.
- **Show count** – display the number of products matching each term.
- **Show search** – add a search box inside the field.
- **Adoptive filtering** – dynamically hide terms that would return zero results.

### Reorder Fields

Drag and drop fields to change their order.

## Save the Preset

Click **Save Preset**. The preset is stored as a custom post type (`wb_filter_preset`) and can be enabled or disabled.

## Next Steps

- [Managing Presets](02-managing-presets.md) – enable, disable, duplicate, or delete presets.
- [Storing Data](03-storing-data.md) – export and moderate stored presets.
