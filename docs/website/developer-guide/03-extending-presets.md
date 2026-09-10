# Extending Presets

You can add custom filter types to presets using the plugin’s filter hooks.

## Adding a Custom Filter Type

1. **Register a new filter type** by hooking into `wb_ajax_filter_get_preset_filters`.
2. **Render the filter** by adding a template in your theme (or using the plugin’s template system).
3. **Handle the filtering** by hooking into `woocommerce_product_query` to modify the product query.

## Example

```php
// Add a custom filter to every preset.
add_filter( 'wb_ajax_filter_get_preset_filters', function( $filters, $preset_id ) {
    $filters[] = array(
        'type' => 'custom_field',
        'key'  => '_my_custom_field',
        'label' => 'My Custom Field',
    );
    return $filters;
}, 10, 2 );

// Modify the product query based on the custom field.
add_action( 'woocommerce_product_query', function( $q ) {
    if ( ! is_admin() && isset( $_GET['my_custom_field'] ) ) {
        $q->set( 'meta_key', '_my_custom_field' );
        $q->set( 'meta_value', sanitize_text_field( $_GET['my_custom_field'] ) );
    }
} );
```

## Template Rendering

The plugin looks for a template file matching the filter type in `templates/filters/`. To render your custom filter:

1. Create a file named `filter-custom_field.php` in `templates/filters/`.
2. Copy it to `yourtheme/wb-ajax-filter/filters/` for customization.

## Notes

- Custom filter types are not saved in the preset builder UI; they must be added via code.
- Ensure your filter type is compatible with AJAX filtering (if enabled).

## Next Steps

- [Hooks and Filters](01-hooks-filters.md) – reference of available hooks.
- [Template Overrides](02-template-overrides.md) – override plugin templates.
