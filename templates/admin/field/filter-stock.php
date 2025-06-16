<?php
/**
 * The template for stock fields.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

$style = 'display:none;';
if ( empty( $filters ) || ( ! empty( $filters ) && isset( $filters['type'] ) && 'stock_sale' === $filters['type'] ) ) {
	$style = '';
}
?>
<div class="wb-ajax-filter-toggle-content-row wb-stock-sale-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label for="show_stock_filter"><?php esc_html_e( 'Show stock filter', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
		<div class="wb-ajax-filter-onoff-container ">
			<input id="show_stock_filter" type="checkbox" class="on_off wb-input wb-filter-type-stock-sale" name="filters[show_stock_filter]" value="yes" <?php echo ( isset( $filters['show_stock_filter'] ) && 'yes' === $filters['show_stock_filter'] ) ? 'checked' : ''; ?>>
			<span class="wb-ajax-filter-onoff" data-text-on="YES" data-text-off="NO"></span>
		</div>
	</div>
	<span class="description"><?php esc_html_e( "Enable this to show the 'In Stock' filter", 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-stock-sale-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label for="show_sale_filter"><?php esc_html_e( 'Show sale filter', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
		<div class="wb-ajax-filter-onoff-container ">
			<input id="show_sale_filter" type="checkbox" class="on_off wb-input wb-filter-type-stock-sale" name="filters[show_sale_filter]" value="yes" <?php echo ( isset( $filters['show_sale_filter'] ) && 'yes' === $filters['show_sale_filter'] ) ? 'checked' : ''; ?>>
			<span class="yith-plugin-fw-onoff" data-text-on="YES" data-text-off="NO"></span>
		</div>
	</div>
	<span class="description"><?php esc_html_e( "Enable this to show the 'On Sale' filter", 'wb-ajax-filter' ); ?></span>
	<span class="description"><?php esc_html_e( "Enable this to show the 'On Sale' filter", 'wb-ajax-filter' ); ?></span>
</div>

