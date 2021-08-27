<?php
/**
 * The template for filter by sale/stock.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/filters
 */

?>
<div class="wb-ajax-filter filter-stock-sale">
	<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
	<div class="filter-content">
		<div class="wb-ajax-filter filter-stock-sale">
			<?php if ( isset( $filters['show_stock_filter'] ) && 'yes' === $filters['show_stock_filter'] ) { ?>
				<input type="checkbox" value="1" class="wb-ajax-filter-selectible" data-filter="instock_filter" <?php echo ( isset( $params['instock_filter'] ) && '1' === $params['instock_filter'] ) ? 'checked' : ''; ?>>
				<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'In Stock', 'wb-ajax-filter' ); ?></span><br>
			<?php } ?>
			<?php if ( isset( $filters['show_sale_filter'] ) && 'yes' === $filters['show_sale_filter'] ) { ?>
				<input type="checkbox" value="1" class="wb-ajax-filter-selectible" data-filter="onsale_filter" <?php echo ( isset( $params['onsale_filter'] ) && '1' === $params['onsale_filter'] ) ? 'checked' : ''; ?>>
				<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'On Sale', 'wb-ajax-filter' ); ?></span>
			<?php } ?>
		</div>
	</div>
</div>
