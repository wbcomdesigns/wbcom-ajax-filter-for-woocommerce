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

if ( empty( $filters ) || ( ! empty( $filters ) && 'stock_sale' === $filters['type'] ) ) {
	?>
<div class="wb-ajax-filter-toggle-content-row wb-stock-sale-toggle">
	<label><?php esc_html_e( 'Show stock filter', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
		<div class="wb-ajax-filter-onoff-container ">
			<input type="checkbox" class="on_off" name="filters[show_stock_filter]" value="yes" <?php echo ( isset( $filters['show_stock_filter'] ) && 'yes' === $filters['show_stock_filter'] ) ? 'checked' : ''; ?>>
			<span class="wb-ajax-filter-onoff" data-text-on="YES" data-text-off="NO"></span>
		</div>
	</div>
	<span class="description"><?php esc_html_e( 'Enable if you want to show "In Stock" filter', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-stock-sale-toggle">
	<label><?php esc_html_e( 'Show sale filter', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
		<div class="wb-ajax-filter-onoff-container ">
			<input type="checkbox" class="on_off" name="filters[show_sale_filter]" value="yes" <?php echo ( isset( $filters['show_sale_filter'] ) && 'yes' === $filters['show_sale_filter'] ) ? 'checked' : ''; ?>>
			<span class="yith-plugin-fw-onoff" data-text-on="YES" data-text-off="NO"></span>
		</div>
	</div>
	<span class="description"><?php esc_html_e( 'Enable if you want to show "On Sale" filter', 'wb-ajax-filter' ); ?></span>
</div>
<?php } ?>
