# Theme Overrides

You can override any plugin template file by copying it into your theme. Plugin updates will not overwrite your customizations.

## How to Override

1. Find the template file you want to override in the plugin’s `templates/` directory.
2. Copy the file (keeping the same relative path) into your theme under `wb-ajax-filter/`.
3. Edit the copied file.

## Example

To override the taxonomy filter template:

- Plugin path: `templates/filters/filter-tax.php`
- Theme path: `yourtheme/wb-ajax-filter/filters/filter-tax.php`

To override the search form:

- Plugin path: `templates/public/search-form.php`
- Theme path: `yourtheme/wb-ajax-filter/public/search-form.php`

## Template Loading

The plugin loads templates through `wc_get_template`, which checks your theme first. If a matching file exists in your theme, it is used; otherwise, the plugin’s default is loaded.

## Backward Compatibility

Flat‑path copies made before version 1.2.2 (e.g., `yourtheme/wb-ajax-filter/filter-tax.php`) still work. The plugin checks both the new nested path and the legacy flat path.

## Notes

- If you override `filters/filter-tax/items/checkbox.php` or `radio.php`, also copy `term-children.php` alongside them.
- Template files are the plugin’s public contract; renaming or restructuring them is a breaking change.

## Next Steps

- [Developer Guide](../developer-guide/02-template-overrides.md) – detailed template structure.
- [Shortcode](01-shortcode.md) – place filters via shortcode.
