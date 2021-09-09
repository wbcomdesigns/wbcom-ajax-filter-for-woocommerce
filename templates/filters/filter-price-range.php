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

global  $woocommerce;
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
$clear_style                    = 'display:none';
$toggle_enabled                 = ( isset( $filters['show_toggle'] ) && 'yes' === $filters['show_toggle'] ) ? true : false;
$toggle_class                   = ( $toggle_enabled ) ? 'wb-ajax-accordian' : '';
$toggle_style                   = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'display:none' : '';
$toggle_icon                    = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'dashicons-arrow-down-alt2' : 'dashicons-arrow-up-alt2';
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
?>
<div class="wb-ajax-filter-container-single filter-price-range">
	<a href="javascript:void(0)" class="wb-ajax-filter-toggle <?php echo esc_attr( $toggle_class ); ?>">
		<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
		<?php if ( $toggle_enabled ) : ?>
		<span class="dashicons <?php echo esc_attr( $toggle_icon ); ?>"></span>
		<?php endif; ?>
	</a>
	<div class="wb-ajax-panel" style="<?php echo ( $toggle_enabled && 'closed' === $filters['toggle_style'] ) ? 'display:none' : ''; ?>">
		<?php if ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) && 'yes' === $wb_ajax_filter_general_options['show_clear_filter'] ) { ?>
		<a href="javascript:void(0)" class="wb-ajax-clear-single-filter" data-filter="min_price,max_price" style="<?php echo ( isset( $_GET['min_price'] ) ) ? '' : esc_attr( $clear_style ); ?>"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?></a>
		<?php } ?>
		<div class="filter-content">
			<div class="wb-ajax-filter filter-price-range">
				<ul class="wb-price-ranges">
					<?php
					foreach ( $filters['price_ranges'] as $range ) {
						if ( isset( $range['min'] ) && $highest_price >= $range['min'] ) {
							if ( isset( $range['max'] ) ) {
								$active = ( isset( $_REQUEST['min_price'] ) && isset( $_REQUEST['max_price'] ) && $range['min'] === $_REQUEST['min_price'] && $range['max'] === $_REQUEST['max_price'] ) ? 'filter-active' : '';
								?>
							<li>
								<a href="#" role="button" data-range-min="<?php echo esc_attr( $range['min'] ); ?>" data-range-max="<?php echo esc_attr( $range['max'] ); ?>" class="price-range <?php echo esc_attr( $active ); ?>">
									<span class="woocommerce-Price-amount amount">
									<?php echo esc_html( get_woocommerce_currency_symbol() ); ?><?php echo esc_html( $range['min'] ); ?></span> - <span class="woocommerce-Price-amount amount">
									<?php echo esc_html( get_woocommerce_currency_symbol() ); ?><?php echo esc_html( $range['max'] ); ?></span>
								</a>
							</li>
								<?php
							} else {
									$active = ( isset( $_REQUEST['min_price'] ) && $range['min'] === $_REQUEST['min_price'] ) ? 'filter-active' : '';
								?>
								<li>
									<a href="#" role="button" data-range-min="<?php echo esc_attr( $range['min'] ); ?>" class="price-range <?php echo esc_attr( $active ); ?>">
										<span class="woocommerce-Price-amount amount"><?php echo esc_html( get_woocommerce_currency_symbol() ); ?>
										<?php echo esc_html( $range['min'] ); ?></span> <?php esc_html_e( '& above', 'wb-ajax-filter' ); ?>
									</a>
								</li>
							<?php } ?>
								<?php
						}
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
