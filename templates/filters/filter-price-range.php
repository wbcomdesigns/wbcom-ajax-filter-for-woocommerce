<?php
/**
 * The template for filter by price range.
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
<div class="wb-ajax-filter filter-price-range">
	<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
	<div class="filter-content">
		<div class="wb-ajax-filter filter-price-range">
			<ul class="wb-price-ranges">
				<?php
				foreach ( $filters['price_ranges'] as $range ) {
					if ( isset( $range['max'] ) && $highest_price >= $range['min'] ) {
						if ( isset( $range['max'] ) ) {
							?>
						<li><a href="#" role="button" data-range-min="<?php echo esc_attr( $range['min'] ); ?>" data-range-max="<?php echo esc_attr( $range['max'] ); ?>" class="price-range">
								<span class="woocommerce-Price-amount amount">
									<span class="woocommerce-Price-currencySymbol"></span><?php echo esc_html( $range['min'] ); ?></span> - <span class="woocommerce-Price-amount amount">
									<span class="woocommerce-Price-currencySymbol"></span><?php echo esc_html( $range['max'] ); ?></span>
						</a></li>
						<?php } else { ?>
							<li><a href="#" role="button" data-range-min="<?php echo esc_attr( $range['min'] ); ?>" class="price-range">
								<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span>
								<?php echo esc_html( $range['min'] ); ?></span> <?php esc_html_e( '& above', 'wb-ajax-filter' ); ?>
							</a></li>
						<?php } ?>
							<?php
					}
				}
				?>
			</ul>
		</div>
	</div>
</div>
