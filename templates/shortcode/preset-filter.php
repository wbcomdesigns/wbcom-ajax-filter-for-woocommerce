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

defined( 'ABSPATH' ) || exit;

/**
 * Variables available for this template
 *
 * @var $preset_id string
 * @var $filters   array
 */

$base_url  = ( isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http' ) . '://';
$base_url .= isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
$base_url .= isset( $_SERVER['REDIRECT_URL'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REDIRECT_URL'] ) ) : '';
?>
<?php if ( 'yes' === $enabled ) { ?>
	<div class="wb-ajax-filters-container" id="preset_<?php echo esc_attr( $preset_id ); ?>" data-preset-id="<?php echo esc_attr( $preset_id ); ?>">
		<form method="POST">
			<input type="hidden" id="wb_load_result_with_ajax" name="load_results_with_ajax" value="<?php echo ( isset( $wb_ajax_filter_general_options['ajax_filters'] ) ) ? esc_attr( $wb_ajax_filter_general_options['ajax_filters'] ) : ''; ?>">
			<input type="hidden" id="wb_scroll_top_after_load_result" name="scroll_top_after_load_results" value="<?php echo ( isset( $wb_ajax_filter_general_options['scroll_top'] ) ) ? esc_attr( $wb_ajax_filter_general_options['scroll_top'] ) : ''; ?>">
			<?php
			$filter_count = 0;
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
				++$filter_count;
			}
			?>
		</form>
	</div>
	<?php
}


