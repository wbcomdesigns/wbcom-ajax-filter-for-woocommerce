<?php
/**
 * The template for price slider fields.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

if ( empty( $filters ) || ( ! empty( $filters ) && 'price_slider' === $filters['type'] ) ) {
	?>
<div class="wb-ajax-filter-toggle-content-row">
	<label><?php esc_html_e( 'Slider min value', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
		<input type="number" name="filters[price_slider_min]" class="" value="0" min="0" step="0.01">
	</div>
	<span class="description"><?php esc_html_e( 'Set the minimum value for the price slider', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row">
	<label><?php esc_html_e( 'Slider max value', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-number-field-wrapper">
		<input type="number" name="filters[price_slider_max]" class="" value="100" min="0" step="0.01">
	</div>
	<span class="description"><?php esc_html_e( 'Set the maximum value for the price slider.', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row">
	<label><?php esc_html_e( 'Slider step', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-number-field-wrapper">
		<input type="number" name="filters[price_slider_step]" class="" value="0.01" min="0.01" step="0.01">
	</div>
	<span class="description"><?php esc_html_e( 'Set the value for each increment of the price slider.', 'wb-ajax-filter' ); ?></span>
</div>
<?php } ?>
