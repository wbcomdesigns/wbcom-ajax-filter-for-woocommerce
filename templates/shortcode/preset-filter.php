<?php
/**
 * The template for displaying filter presets on the frontend.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template
 */

/**
 * Variables available for this template
 *
 * @var $preset_id string
 * @var $filters   array
 */

if ( isset( $_GET ) ) {
	$params     = array();
	$get_params = $_GET;
	foreach ( $get_params as $key => $param ) {
		$values = explode( ',', $param );
		if ( count( $values ) > 1 ) {
			$tmp = array();
			foreach ( $values as $val ) {
				$tmp[] = $val;
			}
			$params[ $key ] = $tmp;
		} else {
			$params[ $key ] = $param;
		}
	}
}
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
$reset_html                     = '<a class="wb-ajax-reset-all-filters">Reset filters</a>';
$reset_button                   = ( isset( $wb_ajax_filter_general_options['show_reset'] ) && 'yes' === $wb_ajax_filter_general_options['show_reset'] ) ? $reset_html : '';
?>
<div class="wb-ajax-filters no-title">
	<div class="wb-ajax-filters-container">
		<form method="GET" style="display: flex;">
			<?php
			require_once WB_AJAX_FILTER_TEMPLATE_PATH . 'public/search-form.php';
			?>
		</form>
	</div>
</div>
<div class="wb-ajax-filters no-title" id="preset_<?php echo esc_attr( $preset_id ); ?>" data-preset-id="<?php echo esc_attr( $preset_id ); ?>">
	<div class="wb-ajax-filters-container">
		<form method="POST">
			<?php
			$filter_count = 0;
			if ( isset( $wb_ajax_filter_general_options['reset_button_position'] ) && 'before_filters' === $wb_ajax_filter_general_options['reset_button_position'] ) {
				?>
				<a class="wb-ajax-reset-all-filters"><?php esc_html_e( 'Reset filters', 'wb-ajax-filter' ); ?></a>
				<?php
			}
			foreach ( $all_filters as $filters ) {
				if ( strpos( $filters['type'], '_' ) !== false ) {
					$filters['type'] = str_replace( '_', '-', $filters['type'] );
				}
				require WB_AJAX_FILTER_TEMPLATE_PATH . 'filters/filter-' . $filters['type'] . '.php';
				$filter_count++;
			}
			if ( isset( $wb_ajax_filter_general_options['reset_button_position'] ) && 'after_filters' === $wb_ajax_filter_general_options['reset_button_position'] ) {
				?>
				<a class="wb-ajax-reset-all-filters"><?php esc_html_e( 'Reset filters', 'wb-ajax-filter' ); ?></a>
				<?php
			}
			?>
		</form>
	</div>
</div>


