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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ratings                        = array( '1', '2', '3', '4', '5' );
$clear_style                    = 'display:none;';
$toggle_enabled                 = ( isset( $filters['show_toggle'] ) && 'yes' === $filters['show_toggle'] ) ? true : false;
$toggle_class                   = ( $toggle_enabled ) ? 'wb-ajax-accordian' : '';
$toggle_style                   = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'display:none' : '';
$toggle_icon                    = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'dashicons-arrow-down-alt2' : 'dashicons-arrow-up-alt2';
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
?>
<div class="wb-ajax-filter-container-single wb-ajax-filter-review" id="filter_<?php echo esc_attr( $preset_id . '_' . $filter_count ); ?>" data-filter-type="<?php echo esc_attr( $filters['type'] ); ?>" data-filter-id="<?php echo esc_attr( $filter_count ); ?>" role="region" aria-label="Review Filter">
	<a href="javascript:void(0)" class="wb-ajax-filter-toggle <?php echo esc_attr( $toggle_class ); ?>" role="button">
		<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
		<?php if ( $toggle_enabled ) : ?>
		<span class="dashicons <?php echo esc_attr( $toggle_icon ); ?>" aria-hidden="true"></span>
		<?php endif; ?>
	</a>
	<div class="wb-ajax-panel" style="<?php echo ( $toggle_enabled && 'closed' === $toggle_style ) ? 'display:none' : ''; ?>" id="review-filter-panel">
		<?php if ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) && 'yes' === $wb_ajax_filter_general_options['show_clear_filter'] ) { ?>
		<a href="javascript:void(0)" class="wb-ajax-clear-single-filter" data-filter="rating_filter" style="<?php echo ( ! isset( $_GET['rating_filter'] ) ) ? esc_attr( $clear_style ) : ''; //phpcs:ignore?>" role="button" aria-label="Clear Review Filter"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?></a>
		<?php } ?>
		<div class="filter-content">
			<div class="wb-ajax-filter filter-review">
				<select class="wb-ajax-filter-selectible" data-filter="rating_filter">
					<option value=""><?php esc_html_e( 'Select Ratings', 'wb-ajax-filter' ); ?></option>
				<?php
				if ( ! empty( $ratings ) && is_array( $ratings ) ) {
					foreach ( $ratings as $val ) {
						?>
						<option value="<?php echo esc_attr( $val ); ?>" <?php echo ( isset( $params['rating_filter'] ) && $val === $params['rating_filter'] ) ? 'selected' : ''; ?>>
							<?php printf( 'Rated %1$s out of 5', esc_html( $val ) ); ?>
						</option>
						<?php
					}//end foreach
				} else {
					?>
					<option value=""><?php esc_html_e( 'No Ratings yet.', 'wb-ajax-filter' ); ?></option>
					<?php
				}
				?>
				</select>
			</div>
		</div>
	</div>
</div>

<!-- Skip link at top of the page -->
<a href="#review-filter-panel" class="skip-link screen-reader-text"><?php esc_html_e( 'Skip to review filter', 'wb-ajax-filter' ); ?></a>