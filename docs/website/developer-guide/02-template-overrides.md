# Template Overrides

All frontend markup renders through `wc_get_template`, so any template can be overridden by copying it into your theme. Theme copies survive plugin updates.

## How Loading Works

Templates resolve in this order:

1. `yourtheme/wb-ajax-filter/<relative-path>` - the modern nested location.
2. `yourtheme/wb-ajax-filter/<filename>` - legacy flat copies from before version 1.2.2 (for example `yourtheme/wb-ajax-filter/filter-tax.php`). Still supported for backwards compatibility.
3. The plugin's own `templates/<relative-path>` - the default.

## Directory Structure

```
templates/
├── shortcode/
│   └── preset-filter.php          Frontend preset renderer
├── public/
│   └── search-form.php            Product search box
├── filters/
│   ├── filter-tax.php             Taxonomy filter
│   ├── filter-price-slider.php    Price slider filter
│   ├── filter-price-range.php     Price range filter
│   ├── filter-stock-sale.php      In stock / on sale filter
│   ├── filter-review.php          Review filter
│   ├── filter-orderby.php         Order by filter
│   ├── global/
│   │   ├── active-filters.php     Active filter chips
│   │   ├── apply-filters.php      Apply button (instant filters off)
│   │   └── reset-filters.php      Reset button
│   └── filter-tax/
│       └── items/
│           ├── checkbox.php       Taxonomy term item: checkbox
│           ├── radio.php          Taxonomy term item: radio
│           ├── select.php         Taxonomy term item: select
│           └── term-children.php  Child terms + item-count badge
└── admin/                          Preset builder (admin; not theme-overridable)
    └── field/...                   One partial per builder option
```

## Example Override

Restyle the taxonomy filter:

1. Copy `templates/filters/filter-tax.php` to `yourtheme/wb-ajax-filter/filters/filter-tax.php`.
2. Edit the copy.

## Notes

- **Child terms:** if you override `filters/filter-tax/items/checkbox.php` or `radio.php`, also copy `term-children.php` into your theme alongside them - the same file writes the child-term tree back into the parent's accumulator.
- **The `admin/` folder is not theme-overridable** - it renders the preset builder in wp-admin, which ships with the plugin.
- Template paths are a public contract. Renaming or restructuring a file is a breaking change for every site that has overridden it.
- Plugin updates never overwrite theme copies.

## Related Pages

- [Hooks and Filters](01-hooks-filters.md) - change behaviour without touching templates.
- [Extending Presets](03-extending-presets.md) - render a custom filter type from your own template.