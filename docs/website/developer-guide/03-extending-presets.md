# Extending Presets

A preset is a list of filter-field arrays saved in `_wb_filter` post meta. Every field array has `type` plus type-specific keys, and the frontend renders the field through a matching `filter-<type>.php` template. A custom type needs four pieces: a field array, a render template, a URL parameter the field submits, and query code that reads it.

## The Mechanism

A field's `type` maps straight to a template name under `templates/filters/` - the renderer replaces `_` with `-` first (so type `stock_sale` loads `filter-stock-sale.php`):

| Type | Template |
|------|----------|
| `tax` | `filter-tax.php` |
| `orderby` | `filter-orderby.php` |
| `price_range` | `filter-price-range.php` |
| `price_slider` | `filter-price-slider.php` |
| `review` | `filter-review.php` |
| `stock_sale` | `filter-stock-sale.php` |

A custom `type => 'brand'` renders through `yourtheme/wb-ajax-filter/filters/filter-brand.php`.

## Step 1 - Add the Field

Inject a field array into every preset (or a specific one, keyed by `$preset_id`):

```php
add_filter( 'wb_ajax_filter_get_preset_filters', function ( $filters, $preset_id ) {
    $filters[] = array(
        'filter_id'    => uniqid( 'wb_filter_' ),
        'filter_title' => 'Brand',
        'type'         => 'brand',
    );
    return $filters;
}, 10, 2 );
```

A field array supports the keys the builder writes: `filter_id`, `filter_title`, `type`, `filter_enabled`, plus type-specific keys. The builder's field options map 1:1 to these keys.

## Step 2 - Render the Field

Create `yourtheme/wb-ajax-filter/filters/filter-brand.php`. The field config arrives as `$filters`, alongside `$preset_id`, `$filter_count`, `$params` (the current `$_GET`), `$base_url`, and `$wb_ajax_filter_general_options` - the same variables the built-in templates use.

Built-in fields submit through `data-filter` (the URL parameter name) plus `.wb-ajax-filter-selectible` controls; their `value` becomes the parameter value. Give the same attributes to your field so the AJAX script picks it up:

```php
<div class="wb-ajax-filter-single">
    <h4><?php echo esc_html( $filters['filter_title'] ); ?></h4>
    <label>
        <input type="checkbox" class="wb-ajax-filter-selectible" name="brand_alfa"
               value="alfa-romeo" data-filter="brand"
               <?php echo ! empty( $params['brand'] ) && in_array( 'alfa-romeo', (array) $params['brand'], true ) ? 'checked' : ''; ?>>
        Alfa Romeo
    </label>
</div>
```

A checked box makes the AJAX script add `brand=alfa-romeo` to the shop URL before products load.

## Step 3 - Handle the Query

Read your parameter on `woocommerce_product_query` (the plugin filters at priority 999) and append to its existing clauses:

```php
add_action( 'woocommerce_product_query', function ( $q ) {
    if ( is_admin() || empty( $_GET['brand'] ) ) {
        return;
    }
    $brand = sanitize_text_field( wp_unslash( $_GET['brand'] ) );
    $meta_query = $q->get( 'meta_query' ) ? $q->get( 'meta_query' ) : array();
    $meta_query[] = array(
        'key'     => '_brand',
        'value'   => $brand,
        'compare' => '=',
    );
    $q->set( 'meta_query', $meta_query );
} );
```

Use `meta_<key>` as the parameter name to reuse the plugin's built-in custom-field matching instead - it runs at the same point and needs no query code of your own.

## Notes

- Custom types are not available in the preset builder dropdown - they are code-only. The builder renders known types through its `admin/field/` templates; an unknown type has no builder form, so it can only be added, edited, enabled, and deleted through `wb_ajax_filter_get_preset_filters` code.
- `filter_enabled` is a builder-side flag only (it marks the field in the Stored Data count); the frontend renders every field in the preset. There is no on/off column this doc can promise for code-only fields beyond your own template conditionals.
- Validate and escape every parameter exactly as shown - it is unsanitized input heading for an SQL-shaped query clause.

## Related Pages

- [Hooks and Filters](01-hooks-filters.md) - the filter that injects fields.
- [Template Overrides](02-template-overrides.md) - where your render template lives.
- [Filter Presets](../filter-presets/01-creating-presets.md) - the builder and field options.