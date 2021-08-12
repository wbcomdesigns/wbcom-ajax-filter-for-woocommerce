<?php
/**
 * The template for price range fields.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

if ( empty( $filters ) || ( ! empty( $filters ) && 'price_range' === $filters['type'] ) ) {
	?>
<div class="wb-ajax-filter-toggle-content-row wb-price-range-toggle">
	<label><?php esc_html_e( 'Customize price ranges', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-custom-field-wrapper">
		<button class="wb-ajax-filter-add-price-range button-primary"><?php esc_html_e( 'Add range', 'wb-ajax-filter' ); ?></button>
		<div class="wb-ajax-filter-ranges-wrapper ui-sortable" data-index="0"></div>
	</div>
</div>
<?php } ?>
