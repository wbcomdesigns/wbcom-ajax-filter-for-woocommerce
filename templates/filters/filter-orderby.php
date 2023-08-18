<?php
/**
 * The template for filter by order.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/filters
 */

$sort                           = array(
	'popularity' => 'Sort by popularity',
	'rating'     => 'Sort by average rating',
	'date'       => 'Sort by latest',
	'price'      => 'Sort by price: low to high',
	'price-desc' => 'Sort by price: high to low',
);
$clear_style                    = 'display:none';
$toggle_enabled                 = ( isset( $filters['show_toggle'] ) && 'yes' === $filters['show_toggle'] ) ? true : false;
$toggle_class                   = ( $toggle_enabled ) ? 'wb-ajax-accordian' : '';
$toggle_style                   = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'display:none' : '';
$toggle_icon                    = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'dashicons-arrow-down-alt2' : 'dashicons-arrow-up-alt2';
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
?>
<div class="wb-ajax-filter-container-single filter-orderby">
	<a href="javascript:void(0)" class="wb-ajax-filter-toggle <?php echo esc_attr( $toggle_class ); ?>">
		<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
		<?php if ( $toggle_enabled ) : ?>
		<span class="dashicons <?php echo esc_attr( $toggle_icon ); ?>"></span>
		<?php endif; ?>
	</a>
	<?php if ( isset( $filters['order_options'] ) && count( $filters['order_options'] ) > 0 ) : ?>
	<div class="wb-ajax-panel" style="<?php echo ( $toggle_enabled && 'closed' === $filters['toggle_style'] ) ? 'display:none' : ''; ?>">
		<?php if ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) && 'yes' === $wb_ajax_filter_general_options['show_clear_filter'] ) { ?>
		<a href="javascript:void(0)" class="wb-ajax-clear-single-filter" data-filter="orderby" style="<?php echo ( ! isset( $_GET['orderby'] ) ) ? esc_attr( $clear_style ) : ''; //phpcs:ignore?>"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?></a>
		<?php } ?>
		<div class="filter-content">
			<div class="wb-ajax-filter filter-orderby">
				<select name="filters[orderby]" class="wb-ajax-filter-selectible" data-filter="orderby">
					<option value=""><?php esc_html_e( 'Default Sorting', 'wb-ajax-filter' ); ?></option>
					<?php
					foreach ( $filters['order_options'] as $opt ) {
						?>
						<option value="<?php echo esc_attr( $opt ); ?>" <?php echo ( isset( $params['orderby'] ) && $opt === $params['orderby'] ) ? 'selected' : ''; ?>><?php echo esc_html( $sort[ $opt ] ); ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
