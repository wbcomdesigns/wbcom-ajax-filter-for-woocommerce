<?php
/**
 * The template for preset filter single.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

/**
 * Variable available in this template
 *
 * @var $filters
 * @var $key
 * @var $filter
 * @var $preset_id
 * @var $filter_count
 * @var $_REQUEST
 */

$params = ( isset( $_SERVER['QUERY_STRING'] ) ) ? sanitize_text_field( wp_unslash( $_SERVER['QUERY_STRING'] ) ) : '';
$params = str_replace( 'wb=list', 'wb=update&wb_index=' . $key, $params );
?>
<div id="filter_<?php echo esc_attr( $filter_count ); ?>" class="wb-ajax-filter-toggle-row initialized" data-item_key="0" data-filter_id="<?php echo esc_attr( $filter['filter_id'] ); ?>" style="">
	<a href="<?php echo esc_url( site_url() ); ?>/wp-admin/admin.php?<?php echo esc_attr( $params ); ?>">
		<div class="wb-ajax-filter-toggle-title ui-sortable-handle">
			<span class="dashicons dashicons-arrow-right-alt2"></span>
			<h3 class="title"><?php echo esc_html( $filter['filter_title'] ); ?></h3>
			<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
				<div class="wb-ajax-filter-onoff-container ">
					<input type="checkbox" id="filters_<?php echo esc_attr( $filter_count ); ?>_enabled" class="on_off" name="filters[<?php echo esc_attr( $filter_count ); ?>][enabled]" value="yes" <?php echo ( isset( $filter['enabled'] ) && 'yes' === $filter['enabled'] ) ? 'checked' : ''; ?>>
				</div>
			</div>
			<span class="wb-show-on-hover wb-delete-single-filter dashicons dashicons-trash"></span>
			<span class="wb-show-on-hover wb-clone-single-filter dashicons dashicons-admin-page"></span>
		</div>
	</a>
</div>
