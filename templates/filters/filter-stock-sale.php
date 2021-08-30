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

$clear_style                    = 'display:none;';
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
?>
<div class="wb-ajax-filter-container-single filter-stock-sale">
	<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
	<?php if ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) && 'yes' === $wb_ajax_filter_general_options['show_clear_filter'] ) { ?>
	<a class="wb-ajax-clear-single-filter" data-filter="onsale_filter,instock_filter" style="<?php echo ( isset( $_GET['instock_filter'] ) || isset( $_GET['onsale_filter'] ) ) ? '' : esc_attr( $clear_style ); ?>"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?></a>
	<?php } ?>
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
