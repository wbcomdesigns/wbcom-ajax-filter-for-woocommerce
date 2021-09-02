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
$wb_ajax_filter_admin_custom    = get_option( 'wb_ajax_filter_admin_customization_options' );
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
$reset_html                     = '<a class="wb-ajax-reset-all-filters">Reset filters</a>';
$reset_button                   = ( isset( $wb_ajax_filter_general_options['show_reset'] ) && 'yes' === $wb_ajax_filter_general_options['show_reset'] ) ? $reset_html : '';
$base_url                       = ( isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http' ) . '://';
$base_url                      .= isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
$base_url                      .= isset( $_SERVER['REDIRECT_URL'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REDIRECT_URL'] ) ) : '';
?>
<div class="wb-ajax-search-container">
	<form method="GET">
		<?php
		if ( isset( $wb_ajax_filter_admin_custom['filters_title'] ) && '' !== $wb_ajax_filter_admin_custom['filters_title'] ) {
			?>
			<h3 class="wb-ajax-preset-filter-title" style="display:block;"><?php echo esc_html( $wb_ajax_filter_admin_custom['filters_title'] ); ?></h3>
			<?php
		}
		$custom_template = get_stylesheet_directory() . '/wb-ajax-filter/search-form.php';
		if ( file_exists( $custom_template ) ) {
			include $custom_template;
		} else {
			require_once WB_AJAX_FILTER_TEMPLATE_PATH . 'public/search-form.php';
		}
		?>
	</form>
</div>
<div class="wb-ajax-filters-container no-title" id="preset_<?php echo esc_attr( $preset_id ); ?>" data-preset-id="<?php echo esc_attr( $preset_id ); ?>">
	<form method="POST">
		<input type="hidden" id="wb_load_result_with_ajax" name="load_results_with_ajax" value="<?php echo ( isset( $wb_ajax_filter_general_options['ajax_filters'] ) ) ? esc_attr( $wb_ajax_filter_general_options['ajax_filters'] ) : ''; ?>">
		<input type="hidden" id="wb_scroll_top_after_load_result" name="scroll_top_after_load_results" value="<?php echo ( isset( $wb_ajax_filter_general_options['scroll_top'] ) ) ? esc_attr( $wb_ajax_filter_general_options['scroll_top'] ) : ''; ?>">
		<?php if ( isset( $wb_ajax_filter_general_options['show_active_labels'] ) && 'yes' === $wb_ajax_filter_general_options['show_active_labels'] ) { ?>
		<div class="wb-ajax-active-filters-container">
			<?php
			if ( count( $params ) > 0 ) {
				$exclude_filters = array( 'orderby', 's', 'post_type', 'onsale_filter', 'instock_filter', 'min_price', 'max_price', 'rating_filter' );
				foreach ( $params as $key => $param ) {
					if ( in_array( $key, $exclude_filters, true ) ) {
						continue;
					}
					?>
					<div class="wb-ajax-active-filters-container-single">
						<span class="wb-ajax-filter-single-keyword"><?php echo esc_html( $param ); ?></span>
						<span class="wb-ajax-filter-clear-single" data-filter="<?php echo esc_attr( $key ); ?>" data-filter-value="<?php echo esc_attr( $param ); ?>"><span class="dashicons dashicons-no-alt"></span></span>
					</div>
					<?php
				}
			}
			?>
		</div>
		<?php } ?>
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
			$custom_template = get_stylesheet_directory() . '/wb-ajax-filter/filter-' . $filters['type'] . '.php';
			if ( file_exists( $custom_template ) ) {
				include $custom_template;
			} else {
				require WB_AJAX_FILTER_TEMPLATE_PATH . 'filters/filter-' . $filters['type'] . '.php';
			}
			$filter_count++;
		}
		if ( isset( $wb_ajax_filter_general_options['reset_button_position'] ) && ( 'after_filters' === $wb_ajax_filter_general_options['reset_button_position'] || 'before_products' === $wb_ajax_filter_general_options['reset_button_position'] ) ) {
			?>
			<a class="wb-ajax-reset-all-filters"><?php esc_html_e( 'Reset filters', 'wb-ajax-filter' ); ?></a>
			<?php
		}
		if ( isset( $wb_ajax_filter_general_options['instant_filters'] ) && 'no' === $wb_ajax_filter_general_options['instant_filters'] ) {
			?>
			<a class="wb-ajax-apply-all-filters"><?php esc_html_e( 'Apply filters', 'wb-ajax-filter' ); ?></a>
			<?php
		}
		?>
	</form>
</div>


