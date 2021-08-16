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

?>
<div class="wb-ajax-filters no-title enhanced" id="preset_<?php echo esc_attr( $preset_id ); ?>" data-preset-id="<?php echo esc_attr( $preset_id ); ?>" data-target="">
	<div class="wb-ajax-filters-container">
		<form method="POST">
			<?php
			$filter_count = 0;
			foreach ( $all_filters as $filters ) {
				if ( strpos( $filters['type'], '_' ) !== false ) {
					$filters['type'] = str_replace( '_', '-', $filters['type'] );
				}
				include WB_AJAX_FILTER_TEMPLATE_PATH . 'filters/filter-' . $filters['type'] . '.php';
				$filter_count++;
			}
			?>
		</form>
	</div>
</div>


