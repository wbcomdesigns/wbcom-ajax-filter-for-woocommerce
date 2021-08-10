<?php
/**
 * The template for displaying filter presets.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin
 */

?>
<div class="wb-ajax-filter-list-table-section">
	<div class="wb-ajax-filter-list-table-section-content">
		<h2><?php esc_html_e( 'Filter Presets', 'wb-ajax-filter' ); ?></h2>
		<a href="<?php echo esc_url( site_url() ); ?>/wp-admin/admin.php?action=create&<?php echo ( isset( $_SERVER['QUERY_STRING'] ) ) ? wp_unslash( $_SERVER['QUERY_STRING'] ) : ''; ?>" class="yith-add-button">
		<?php esc_html_e( 'Add preset', 'wb-ajax-filter' ); ?>
		</a>
	</div>
	<div class="wb-ajax-filter-list-table-content">
		<table>
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
					<tr>
						<td data-colname="Preset name"><?php echo esc_html( $preset->post_title ); ?></td>
						<td data-colname="Shortcode">
							<input class="text-to-copy" type="text" readonly="" value="[wb_ajax_filters slug=<?php echo esc_html( $preset->post_name ); ?>]">
						</td>
						<td data-colname="Action">
							<a href="<?php echo esc_url( site_url() ); ?>/wp-admin/admin.php?action=edit&<?php echo ( isset( $_SERVER['QUERY_STRING'] ) ) ? wp_unslash( $_SERVER['QUERY_STRING'] ) : ''; ?>&preset=<?php echo esc_html( $preset->ID ); ?>" class="wb-edit-filter-preset">
								<span class="dashicons dashicons-edit"></span>
							</a>
							<a class="wb-copy-filter-preset" data-preset="<?php echo esc_html( $preset->ID ); ?>"><span class="dashicons dashicons-admin-page"></span></a>
							<a class="wb-delete-filter-preset" data-preset="<?php echo esc_html( $preset->ID ); ?>"><span class="dashicons dashicons-trash"></span></a>
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
