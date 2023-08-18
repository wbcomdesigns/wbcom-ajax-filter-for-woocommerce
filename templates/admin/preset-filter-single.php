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
<div id="filter_<?php echo esc_attr( $filter_count ); ?>" class="wb-ajax-filter-toggle-row initialized" data-item_key="<?php echo esc_attr( $key ); ?>" data-preset="<?php echo ( isset( $_REQUEST['preset'] ) ) ? esc_attr( wp_unslash( $_REQUEST['preset'] ) ) : ''; //phpcs:ignore?>" data-filter_id="<?php echo esc_attr( $filter['filter_id'] ); ?>" style="">
	<div class="wb-ajax-filter-toggle-title ui-sortable-handle" style="overflow:hidden;">
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<a href="<?php echo esc_url( site_url() ); ?>/wp-admin/admin.php?<?php echo esc_attr( $params ); ?>">
			<h3 class="title"><?php echo esc_html( $filter['filter_title'] ); ?></h3>
		</a>
		<div class="wb-ajax-filter-icon-button">
			<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
				<div class="wb-ajax-filter-onoff-container ">
					<input type="checkbox" id="filters_<?php echo esc_attr( $filter_count ); ?>_enabled" class="on_off" name="filter_enabled" value="yes" <?php echo ( isset( $filter['filter_enabled'] ) && 'yes' === $filter['filter_enabled'] ) ? 'checked' : ''; ?> data-preset="<?php echo ( isset( $_REQUEST['preset'] ) ) ? esc_attr( wp_unslash( $_REQUEST['preset'] ) ) : ''; //phpcs:ignore?>" data-filter_id="<?php echo esc_attr( $filter['filter_id'] ); ?>">
				</div>
			</div>
			<span class="wb-show-on-hover wb-delete-single-filter dashicons dashicons-trash" data-preset="<?php echo ( isset( $_REQUEST['preset'] ) ) ? esc_attr( wp_unslash( $_REQUEST['preset'] ) ) : ''; //phpcs:ignore?>" data-filter_id="<?php echo esc_attr( $filter['filter_id'] ); ?>"></span>
			<span class="wb-show-on-hover wb-clone-single-filter dashicons dashicons-admin-page" data-preset="<?php echo ( isset( $_REQUEST['preset'] ) ) ? esc_attr( wp_unslash( $_REQUEST['preset'] ) ) : ''; //phpcs:ignore?>" data-filter_id="<?php echo esc_attr( $filter['filter_id'] ); ?>"></span>
		</div>
	</div>
</div>
