# Hooks and Filters

The plugin provides several action and filter hooks for developers to extend its behavior.

## Action Hooks

### Frontend

| Hook | Location | Description |
|------|----------|-------------|
| `wb_ajax_filter_before_filter_fields` | Before the filter fields are rendered. | |
| `wb_ajax_filter_fields` | While the filter fields are rendered (one pass per field). | |
| `wb_ajax_filter_after_filter_fields` | After the filter fields are rendered. | |
| `wb_ajax_filter_before_content` | Before the product grid. | |
| `wb_ajax_filter_after_content` | After the product grid. | |

### Admin Settings

| Hook | Location | Description |
|------|----------|-------------|
| `wb_ajax_filter_before_admin_general_settings` | Before the general settings form. | |
| `wb_ajax_filter_after_admin_general_settings` | After the general settings form. | |
| `wb_ajax_filter_before_admin_search_settings` | Before the search settings form. | |
| `wb_ajax_filter_after_admin_search_settings` | After the search settings form. | |
| `wb_ajax_filter_before_admin_search_option_settings` | Before the search scope settings. | |
| `wb_ajax_filter_after_admin_search_option_settings` | After the search scope settings. | |
| `wb_ajax_filter_before_admin_customization_settings` | Before the customization settings form. | |
| `wb_ajax_filter_after_admin_customization_settings` | After the customization settings form. | |

## Filter Hooks

| Hook | Description |
|------|-------------|
| `wb_ajax_filter_get_preset_filters` | Modify the filter fields resolved for a preset. |
| `wb_ajax_filter_restrict_products` | Restrict which products the filter query returns. |
| `wb_ajax_filter_restrict_terms` | Restrict which taxonomy terms appear as options. |
| `wb_ajax_filter_custom_field_search_limit` | Adjust the limit for custom field search results. |
| `wb_ajax_filter_settings_nav_groups` | Modify the admin settings navigation tabs. |
| `wb_ajax_filter_settings_tab_content` | Replace the content of a settings tab. |

## Usage Example

```php
// Add a custom field to every preset.
add_filter( 'wb_ajax_filter_get_preset_filters', function( $filters, $preset_id ) {
    $filters[] = array(
        'type' => 'custom_field',
        'key'  => '_my_custom_field',
        'label' => 'My Custom Field',
    );
    return $filters;
}, 10, 2 );
```

## Next Steps

- [Template Overrides](02-template-overrides.md) – override plugin templates.
- [Extending Presets](03-extending-presets.md) – add custom filter types.
