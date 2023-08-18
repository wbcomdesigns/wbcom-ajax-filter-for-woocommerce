<?php
/**
 * The template for add price ranges field.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin/field
 */

$style = 'display:none;';
if ( isset( $_POST['count'] ) ) { //phpcs:ignore
	$count = sanitize_text_field( wp_unslash( $_POST['count'] ) ); //phpcs:ignore
}

if ( isset( $range ) && isset( $range_count ) ) {

	$style = ( $range_count === $count + 1 ) ? '' : 'display:none;';
}

?>
<div id="wb_range_<?php echo esc_html( $count ); ?>" class="wb-ajax-filter-range-box" data-range_id="<?php echo esc_html( $count ); ?>">
	<a href="#" role="button" class="wb-ajax-filter-range-remove">
		<span class="dashicons dashicons-no-alt"></span>	
	</a>
	<p class="wb-ajax-filter-field-wrapper wb-ajax-filter-text-field-wrapper min">
		<label for="wb_price_ranges_<?php echo esc_html( $count ); ?>_min"><?php esc_html_e( 'Min', 'wb-ajax-filter' ); ?></label>
		<input type="number" class="wb-input wb-filter-type-price-range" name="filters[price_ranges][<?php echo esc_html( $count ); ?>][min]" id="wb_price_ranges_<?php echo esc_html( $count ); ?>_min" value="<?php echo ( isset( $range['min'] ) && '' !== $range['min'] ) ? esc_html( $range['min'] ) : ''; ?>">
	</p>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper unlimited" style="<?php echo esc_attr( $style ); ?>">
		<label for="wb_price_ranges_<?php echo esc_html( $count ); ?>_unlimited"><?php esc_html_e( 'Show "&amp; Above" in last range', 'wb-ajax-filter' ); ?></label>
		<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
			<div class="wb-ajax-filter-onoff-container ">
				<input type="checkbox" id="wb_price_ranges_<?php echo esc_html( $count ); ?>_unlimited" class="wb-ajax-filter-on_off wb-input wb-filter-type-price-range wb-filter-type-price-range-unlimited" name="filters[price_ranges][<?php echo esc_html( $count ); ?>][unlimited]" value="yes" <?php echo ( isset( $range['unlimited'] ) && 'yes' === $range['unlimited'] ) ? 'checked' : ''; ?>>
				<span class="wb-ajax-filter-onoff" data-text-on="YES" data-text-off="NO"></span>
			</div>
		</div>
	</div>
	<p class="wb-ajax-filter-field-wrapper wb-ajax-filter-text-field-wrapper max" style="<?php echo ( isset( $range['unlimited'] ) && 'yes' === $range['unlimited'] ) ? 'display:none' : ''; ?>">
		<label for="wb_price_ranges_<?php echo esc_html( $count ); ?>_max"><?php esc_html_e( 'Max', 'wb-ajax-filter' ); ?></label>
		<input type="number" name="filters[price_ranges][<?php echo esc_html( $count ); ?>][max]" id="wb_price_ranges_<?php echo esc_html( $count ); ?>_max" class="wb-input wb-filter-type-price-range" value="<?php echo ( isset( $range['max'] ) && '' !== $range['max'] ) ? esc_html( $range['max'] ) : ''; ?>">
	</p>
</div>
