<?php
/**
 * The template for filter by price slider.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/filters
 */

$args = array(
	'posts_per_page' => 1,
	'post_type'      => 'product',
	'orderby'        => 'meta_value_num',
	'meta_key'       => '_price',
	'order'          => 'desc',
);

$prices                         = get_posts( $args );
$prod                           = wc_get_product( $prices[0]->ID );
$highest_price                  = $prod->get_price();
$clear_style                    = 'display:none;';
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
?>
<div class="wb-ajax-filter-container-single filter-price-slider">
	<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
	<?php if ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) && 'yes' === $wb_ajax_filter_general_options['show_clear_filter'] ) { ?>
	<a href="javascript:void(0)" class="wb-ajax-clear-single-filter" data-filter="min_price,max_price" style="<?php echo ( ! isset( $_GET['min_price'] ) ) ? esc_attr( $clear_style ) : ''; ?>"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?></a>
	<?php } ?>
	<div class="filter-content">
		<div class="wb-ajax-filter filter-price-slider">
			<div class="wb-ajax-filter-slidecontainer">
				<input type="text" class="js-range-slider" name="my_range" value=""
					data-type="double"
					data-min="0"
					data-max="<?php echo esc_attr( $highest_price ); ?>"
					data-from="<?php echo ( isset( $params['min_price'] ) ) ? esc_attr( $params['min_price'] ) : '0'; ?>"
					data-to="<?php echo ( isset( $params['max_price'] ) ) ? esc_attr( $params['max_price'] ) : esc_attr( $highest_price ); ?>"
					data-grid="true"
					data-skin="square"
					data-prefix="$"
				/>
			</div>
		</div>
	</div>
</div>
