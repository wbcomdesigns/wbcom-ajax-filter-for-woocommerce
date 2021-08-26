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

$prices        = get_posts( $args );
$prod          = wc_get_product( $prices[0]->ID );
$highest_price = $prod->get_price();
?>
<div class="wb-ajax-filter filter-price-slider">
	<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
	<div class="filter-content">
		<div class="wb-ajax-filter filter-price-slider">
			<div class="wb-ajax-filter-slidecontainer" style="width: 30%;">
				<input type="text" class="js-range-slider" name="my_range" value=""
					data-type="double"
					data-min="0"
					data-max="<?php echo esc_attr( $highest_price ); ?>"
					data-from="0"
					data-to="<?php echo esc_attr( $highest_price ); ?>"
					data-grid="true"
					/>
			</div>
		</div>
	</div>
</div>
