# Template Overrides

The plugin’s frontend markup is built from 34 template files in the `templates/` directory. You can override any of them by copying the file into your theme.

## How Template Loading Works

The plugin uses `wc_get_template` to load templates. WordPress checks your theme first:

1. `yourtheme/wb-ajax-filter/<relative-path>` (new nested path)
2. `yourtheme/wb-ajax-filter/<filename>` (legacy flat path, for backward compatibility)
3. Plugin’s `templates/<relative-path>` (default)

## Directory Structure

```
templates/
├── filters/
│   ├── filter-tax.php
│   ├── filter-price-slider.php
│   ├── filter-price-range.php
│   ├── filter-stock-sale.php
│   ├── filter-review.php
│   ├── filter-orderby.php
│   ├── global/
│   │   ├── active-filters.php
│   │   ├── apply-filters.php
│   │   └── reset-filters.php
│   └── filter-tax/
│       └── items/
│           ├── checkbox.php
│           ├── radio.php
│           ├── select.php
│           └── term-children.php
├── shortcode/
│   └── preset-filter.php
├── public/
│   └── search-form.php
└── admin/
    └── field/
        └── *.php
```

## Example Override

To customize the taxonomy filter:

1. Copy `templates/filters/filter-tax.php` to `yourtheme/wb-ajax-filter/filters/filter-tax.php`.
2. Edit the copied file.

## Important Notes

- If you override `filters/filter-tax/items/checkbox.php` or `radio.php`, also copy `term-children.php` alongside them.
- Template files are the plugin’s public contract; renaming or restructuring them is a breaking change.
- Plugin updates will not overwrite your copies.

## Next Steps

- [Hooks and Filters](01-hooks-filters.md) – modify behavior without editing templates.
- [Extending Presets](03-extending-presets.md) – add custom filter types.
