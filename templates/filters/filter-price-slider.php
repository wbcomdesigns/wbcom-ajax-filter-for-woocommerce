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
$toggle_enabled                 = ( isset( $filters['show_toggle'] ) && 'yes' === $filters['show_toggle'] ) ? true : false;
$toggle_class                   = ( $toggle_enabled ) ? 'wb-ajax-accordian' : '';
$toggle_style                   = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'display:none' : '';
$toggle_icon                    = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'dashicons-arrow-down-alt2' : 'dashicons-arrow-up-alt2';
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
?>
<div class="wb-ajax-filter-container-single filter-price-slider" role="region" aria-label="Price Filter">
	<a href="javascript:void(0)" class="wb-ajax-filter-toggle <?php echo esc_attr( $toggle_class ); ?>" role="button">
	   
		<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
		
		<?php if ( $toggle_enabled ) : ?>
			<span class="dashicons <?php echo esc_attr( $toggle_icon ); ?>" aria-hidden="true"></span>
		<?php endif; ?>
	</a>

	<div id="price-filter-panel" class="wb-ajax-panel" style="<?php echo ( $toggle_enabled && isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'display:none' : ''; ?>" role="region" aria-labelledby="price-filter-label">
		
		<?php if ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) && 'yes' === $wb_ajax_filter_general_options['show_clear_filter'] ) { ?>
			<a href="javascript:void(0)" class="wb-ajax-clear-single-filter" data-filter="min_price,max_price" style="<?php echo ( ! isset( $_GET['min_price'] ) ) ? esc_attr( $clear_style ) : ''; ?>" role="button" aria-label="Clear price filter"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?>
			</a>
		<?php } ?>
		<div class="filter-content">
			<div class="wb-ajax-filter filter-price-slider">
				<div class="wb-ajax-filter-slidecontainer">
					<?php $wb_ajax_max_price = isset( $params['max_price'] ) ? $params['max_price'] : $highest_price; ?>
					
					<label id="price-filter-label" for="price-range" class="screen-reader-text"><?php esc_html_e( 'Select price range', 'wb-ajax-filter' ); ?></label>
					
					<input type="text" class="js-range-slider" id="price-range" name="my_range" value="" data-type="double" data-min="0" data-max="<?php echo esc_attr( $highest_price ); ?>" data-from="<?php echo ( isset( $params['min_price'] ) ) ? esc_attr( $params['min_price'] ) : '0'; ?>" data-to="<?php echo esc_attr( $wb_ajax_max_price ); ?>" data-grid="true" data-skin="square" data-prefix="$" aria-describedby="price-filter-description"/>
					<span id="price-filter-description" class="screen-reader-text">
						<?php esc_html_e( 'Use the slider to select a minimum and maximum price.', 'wb-ajax-filter' ); ?>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Skip link at top of the page -->
<a href="#price-filter-panel" class="skip-link screen-reader-text"><?php esc_html_e( 'Skip to price filter', 'wb-ajax-filter' ); ?></a>
