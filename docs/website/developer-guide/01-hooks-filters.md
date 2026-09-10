# Hooks and Filters

The plugin exposes action and filter hooks at every layer: the preset builder form, the settings tabs, the frontend render, and the product query.

## Action Hooks

### Preset Builder (admin form)

| Hook | Args | Fires |
|------|------|-------|
| `wb_ajax_filter_before_filter_fields` | `$filters` | Before the field list renders. |
| `wb_ajax_filter_fields` | `$filters` | Once per field while the field rows render - this is where a preset gets its filters. |
| `wb_ajax_filter_after_filter_fields` | `$filters` | After the last field row. |

### Settings Tabs (admin)

| Hook | Args | Fires |
|------|------|-------|
| `wb_ajax_filter_settings_tab_content` | `$tab_id` | Renders one tab's body. |
| `wb_ajax_filter_before_admin_general_settings` | `$wb_general` | Before the filtering-behaviour form. |
| `wb_ajax_filter_after_admin_general_settings` | `$wb_general` | After it. |
| `wb_ajax_filter_before_admin_search_settings` | `$wb_search` | Before the product-search form. |
| `wb_ajax_filter_before_admin_search_option_settings` | `$wb_search_scope` | Before the search-scope options. |
| `wb_ajax_filter_after_admin_search_option_settings` | `$wb_search_scope` | After them. |
| `wb_ajax_filter_after_admin_search_settings` | `$wb_search` | After the product-search form. |
| `wb_ajax_filter_before_admin_customization_settings` | `$wb_customization` | Before the appearance form. |
| `wb_ajax_filter_after_admin_customization_settings` | `$wb_customization` | After it. |

### Frontend

| Hook | Args | Fires |
|------|------|-------|
| `wb_ajax_filter_before_content` | none | At the top of the filters container, before the title. |
| `wb_ajax_filter_after_content` | none | At the bottom of the filters container, after the last preset. |

## Filter Hooks

| Hook | Args | Purpose |
|------|------|---------|
| `wb_ajax_filter_get_preset_filters` | `$filters`, `$preset_id` | Change the filter fields a preset renders. Add new field arrays, remove existing ones, or re-order. |
| `wb_ajax_filter_restrict_products` | `$matched_products` | Restrict the products the search autocomplete returns. |
| `wb_ajax_filter_restrict_terms` | `$results`, `$taxonomy` | Restrict which taxonomy terms show as filter options in the preset builder. |
| `wb_ajax_filter_custom_field_search_limit` | `$limit` (default 30) | Change how many custom-field matches the search returns. |
| `wb_ajax_filter_settings_nav_groups` | `$groups` | Declare or modify the admin settings navigation. |

## Example

Add a badge next to a taxonomy filter's title on the frontend:

```php
add_filter( 'wb_ajax_filter_get_preset_filters', function ( $filters, $preset_id ) {
    foreach ( $filters as &$filter ) {
        if ( 'tax' === $filter['type'] && 'product_cat' === $filter['taxonomy'] ) {
            $filter['filter_title'] = $filter['filter_title'] . ' (categories)';
        }
    }
    return $filters;
}, 10, 2 );
```

## Related Pages

- [Template Overrides](02-template-overrides.md) - restyle output without hooks.
- [Extending Presets](03-extending-presets.md) - add a custom filter type end to end.