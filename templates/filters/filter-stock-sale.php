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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$clear_style                    = 'display:none;';
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
$toggle_enabled                 = ( isset( $filters['show_toggle'] ) && 'yes' === $filters['show_toggle'] ) ? true : false;
$toggle_class                   = ( $toggle_enabled ) ? 'wb-ajax-accordian' : '';
$toggle_style                   = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'display:none' : '';
$toggle_open                    = ! ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] );
?>
<div class="wb-ajax-filter-container-single filter-stock-sale" role="region" aria-label="Stock Sale Filter">
	<a href="javascript:void(0)" class="wb-ajax-filter-toggle <?php echo esc_attr( $toggle_class ); ?><?php echo ( $toggle_enabled && $toggle_open ) ? ' wb-ajax-open' : ''; ?>" role="button"<?php echo $toggle_enabled ? ' aria-expanded="' . esc_attr( $toggle_open ? 'true' : 'false' ) . '"' : ''; ?>>
		<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
		<?php if ( $toggle_enabled ) : ?>
			<?php wb_ajax_filter_icon( 'chevron-down', 'wb-ajax-toggle-icon' ); ?>
		<?php endif; ?>
	</a>
	<div class="wb-ajax-panel" style="<?php echo ( $toggle_enabled && 'closed' === $filters['toggle_style'] ) ? 'display:none' : ''; ?>" id="stock-sale-filter-panel">
		<?php if ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) && 'yes' === $wb_ajax_filter_general_options['show_clear_filter'] ) { ?>
		<a href="javascript:void(0)" class="wb-ajax-clear-single-filter" data-filter="onsale_filter,instock_filter" style="<?php echo ( isset( $_GET['instock_filter'] ) || isset( $_GET['onsale_filter'] ) ) ? '' : esc_attr( $clear_style ); //phpcs:ignore?>" role="button" aria-label="Clear Stock Sale Filter"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?></a>
		<?php } ?>
		<div class="filter-content">
			<div class="wb-ajax-filter filter-stock-sale">
				<?php if ( isset( $filters['show_stock_filter'] ) && 'yes' === $filters['show_stock_filter'] ) { ?>
					<input type="checkbox" value="1" class="wb-ajax-filter-selectible" data-filter="instock_filter" <?php echo ( isset( $params['instock_filter'] ) && '1' === $params['instock_filter'] ) ? 'checked' : ''; ?>>
					<span class="wb-ajax-filter-option-text <?php echo ( isset( $params['instock_filter'] ) && '1' === $params['instock_filter'] ) ? 'filter-active' : ''; ?>"><?php esc_html_e( 'In Stock', 'wb-ajax-filter' ); ?></span><br>
				<?php } ?>
				<?php if ( isset( $filters['show_sale_filter'] ) && 'yes' === $filters['show_sale_filter'] ) { ?>
					<input type="checkbox" value="1" class="wb-ajax-filter-selectible" data-filter="onsale_filter" <?php echo ( isset( $params['onsale_filter'] ) && '1' === $params['onsale_filter'] ) ? 'checked' : ''; ?>>
					<span class="wb-ajax-filter-option-text <?php echo ( isset( $params['onsale_filter'] ) && '1' === $params['onsale_filter'] ) ? 'filter-active' : ''; ?>"><?php esc_html_e( 'On Sale', 'wb-ajax-filter' ); ?></span>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<!-- Skip link at top of the page -->
<a href="#stock-sale-filter-panel" class="skip-link screen-reader-text"><?php esc_html_e( 'Skip to stock sale filter', 'wb-ajax-filter' ); ?></a>