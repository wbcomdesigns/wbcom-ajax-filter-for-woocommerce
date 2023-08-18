<?php
/**
 * The template for filter by review.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/filters
 */

$args = array(
	'status'      => 'approve',
	'post_status' => 'publish',
	'post_type'   => 'product',
);

$commnts = get_comments( $args );
$ratings = array();
foreach ( $commnts as $commnt ) {
	$rating = get_comment_meta( $commnt->comment_ID, 'rating', true );
	if ( ! in_array( $rating, $ratings, true ) ) {
		$ratings[] = $rating;
	}
}
sort( $ratings );
$clear_style                    = 'display:none;';
$toggle_enabled                 = ( isset( $filters['show_toggle'] ) && 'yes' === $filters['show_toggle'] ) ? true : false;
$toggle_class                   = ( $toggle_enabled ) ? 'wb-ajax-accordian' : '';
$toggle_style                   = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'display:none' : '';
$toggle_icon                    = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'dashicons-arrow-down-alt2' : 'dashicons-arrow-up-alt2';
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
?>
<div class="wb-ajax-filter-container-single wb-ajax-filter-review" id="filter_<?php echo esc_attr( $preset_id . '_' . $filter_count ); ?>" data-filter-type="<?php echo esc_attr( $filters['type'] ); ?>" data-filter-id="<?php echo esc_attr( $filter_count ); ?>" >
	<a href="javascript:void(0)" class="wb-ajax-filter-toggle <?php echo esc_attr( $toggle_class ); ?>">
		<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
		<?php if ( $toggle_enabled ) : ?>
		<span class="dashicons <?php echo esc_attr( $toggle_icon ); ?>"></span>
		<?php endif; ?>
	</a>
	<div class="wb-ajax-panel" style="<?php echo ( $toggle_enabled && 'closed' === $filters['toggle_style'] ) ? 'display:none' : ''; ?>">
		<?php if ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) && 'yes' === $wb_ajax_filter_general_options['show_clear_filter'] ) { ?>
		<a href="javascript:void(0)" class="wb-ajax-clear-single-filter" data-filter="rating_filter" style="<?php echo ( ! isset( $_GET['rating_filter'] ) ) ? esc_attr( $clear_style ) : ''; //phpcs:ignore?>"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?></a>
		<?php } ?>
		<div class="filter-content">
			<div class="wb-ajax-filter filter-review">
				<select class="wb-ajax-filter-selectible" data-filter="rating_filter">
					<option value=""><?php esc_html_e( 'Any rating', 'wb-ajax-filter' ); ?></option>
				<?php
				foreach ( $ratings as $val ) {
					?>
					<option value="<?php echo esc_attr( $val ); ?>" <?php echo ( isset( $params['rating_filter'] ) && $val === $params['rating_filter'] ) ? 'selected' : ''; ?>>
					<?php printf( 'Rated %1$s out of 5', esc_html( $val ) ); ?>
				</option>
				<?php } ?>
				</select>
			</div>
		</div>
	</div>
</div>
