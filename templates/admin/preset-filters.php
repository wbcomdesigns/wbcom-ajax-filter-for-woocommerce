<?php
/**
 * The template for displaying filter presets list in admin section.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="wb-ajax-filter-list-table-section">
	<div class="wbcom-admin-title-section">
		<h3><?php esc_html_e( 'Filter Presets', 'wb-ajax-filter' ); ?></h3>
	</div>
	<div class="wbcom-admin-option-wrap">
	<div class="wb-ajax-filter-list-table-section-content">		
		<div class="wb-ajax-filter-add-preset-button">
			<a href="<?php echo esc_url( site_url() ); ?>/wp-admin/admin.php?action=create&<?php echo ( isset( $_SERVER['QUERY_STRING'] ) ) ? esc_attr( sanitize_text_field( wp_unslash( $_SERVER['QUERY_STRING'] ) ) ) : ''; ?>" class="page-title-action">
				<?php wb_ajax_filter_icon( 'plus', 'wb-ajax-add-preset-icon', 14 ); ?><?php esc_html_e( 'Add Preset', 'wb-ajax-filter' ); ?>
			</a>
		</div>
	</div>
	<div class="wb-ajax-filter-list-table-content">
		<table class="wb-ajax-filter-table wp-list-table widefat fixed striped table-view-list affiliates">
			<thead>
				<tr>
					<th scope="col"><?php esc_html_e( 'Preset Name', 'wb-ajax-filter' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Shortcode', 'wb-ajax-filter' ); ?></th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( ! empty( $all_presets ) ) { ?>
					<?php foreach ( $all_presets as $preset ) { ?>
						<?php $enabled = get_post_meta( $preset->ID, 'preset_enabled', true ); ?>
					<tr>
						<td data-colname="Preset name"><?php echo esc_html( $preset->post_title ); ?></td>
						<td data-colname="Shortcode">
							<input class="text-to-copy" type="text" readonly="" value="[wb_ajax_filters slug='<?php echo esc_html( $preset->post_name ); ?>']">
							<br><span class="wb-shortcode-copy"><?php esc_html_e( 'Shortcode copied to clipboard.', 'wb-ajax-filter' ); ?></span>
						</td>
						<td data-colname="Action">
							<?php
							$wb_ajax_query_string = isset( $_SERVER['QUERY_STRING'] ) ? sanitize_text_field( wp_unslash( $_SERVER['QUERY_STRING'] ) ) : '';
							?>
							<a href="<?php echo esc_url( site_url() ); ?>/wp-admin/admin.php?action=edit&wb=list&<?php echo esc_attr( $wb_ajax_query_string ); ?>&preset=<?php echo esc_html( $preset->ID ); ?>" class="wb-edit-filter-preset" aria-label="<?php esc_attr_e( 'Edit preset', 'wb-ajax-filter' ); ?>">
								<?php wb_ajax_filter_icon( 'pencil', '', 18 ); ?>
							</a>
							<button type="button" class="wb-copy-filter-preset wb-ajax-icon-button" data-preset="<?php echo esc_attr( $preset->ID ); ?>" aria-label="<?php esc_attr_e( 'Duplicate preset', 'wb-ajax-filter' ); ?>"><?php wb_ajax_filter_icon( 'copy', '', 18 ); ?></button>
							<button type="button" class="wb-delete-filter-preset wb-ajax-icon-button" data-preset="<?php echo esc_attr( $preset->ID ); ?>" aria-label="<?php esc_attr_e( 'Delete preset', 'wb-ajax-filter' ); ?>"><?php wb_ajax_filter_icon( 'trash', '', 18 ); ?></button>
							<div class="wb-ajax-filter-onoff-container" data-preset="<?php echo esc_html( $preset->ID ); ?>">
								<input type="checkbox" class="preset-active-status" value="yes" <?php echo ( 'yes' === $enabled ) ? 'checked' : ''; ?>>
							</div>
						</td>
					</tr>
					<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="3"><?php esc_html_e( 'No presets found.', 'wb-ajax-filter' ); ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>