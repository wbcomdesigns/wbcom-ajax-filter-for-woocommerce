# Theme Overrides

Copy any filter template into your theme to restyle it. Theme copies survive plugin updates, so you never lose customisations.

## How to Override

1. Find the template you want to change in the plugin's `templates/` directory.
2. Copy it to your theme under the `wb-ajax-filter/` folder, keeping the same relative path.
3. Edit the copy.

### Example

Override the taxonomy filter:

- Plugin: `templates/filters/filter-tax.php`
- Theme: `yourtheme/wb-ajax-filter/filters/filter-tax.php`

Override the search form:

- Plugin: `templates/public/search-form.php`
- Theme: `yourtheme/wb-ajax-filter/public/search-form.php`

## How Loading Works

Templates load through `wc_get_template`, which checks locations in this order:

1. `yourtheme/wb-ajax-filter/<relative-path>` - the modern nested location.
2. `yourtheme/wb-ajax-filter/<filename>` - legacy flat copies from before version 1.2.2 (for example `yourtheme/wb-ajax-filter/filter-tax.php`). These still win for backwards compatibility.
3. The plugin's own `templates/<relative-path>` - the default.

## Notes

- **Taxonomy term items:** if you override `filters/filter-tax/items/checkbox.php` or `radio.php`, copy `term-children.php` into your theme alongside them - the parts depend on each other.
- Template paths are a public contract. Renaming or restructuring a template file is a breaking change for any site that has overridden it.
- A full template map lives in the [Developer Guide](../developer-guide/02-template-overrides.md).

## Related Pages

- [Developer Guide](../developer-guide/02-template-overrides.md) - the complete template structure.