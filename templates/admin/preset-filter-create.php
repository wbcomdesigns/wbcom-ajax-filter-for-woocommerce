<?php
/**
 * The template for preset filter create form.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

$filters      = array();
$preset_title = '';
if ( isset( $_REQUEST['action'] ) && 'edit' === $_REQUEST['action'] ) {
	$preset_id = ( isset( $_REQUEST['preset'] ) && '' !== $_REQUEST['preset'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['preset'] ) ) : false;
	if ( $preset_id ) {
		$hide         = 'display:none;';
		$preset       = get_post( $preset_id );
		$preset_title = $preset->post_title;
		$filters      = get_post_meta( $preset_id, '_wb_filter', true );
	}
}
?>
<div class="wb-ajax-filter-create-preset-section">
	<div class="wb-ajax-filter-create-preset-section-content">
		<span class="view-all-presets">
			<a href="<?php echo esc_url( site_url() ); ?>/wp-admin/admin.php?page=wb-ajax-filter-integration-settings&tab=wb-ajax-filter-presets">
				<?php esc_html_e( '< Back to presets list', 'wb-ajax-filter' ); ?>
			</a>
		</span>
		<?php if ( '' === $preset_title ) : ?>
			<h2><?php esc_html_e( 'Add new filter preset', 'wb-ajax-filter' ); ?></h2>
		<?php endif; ?>
		<table>
			<tbody>
				<tr>
					<th><?php esc_html_e( 'Preset name', 'wb-ajax-filter' ); ?></th>
					<td><div class="yith-plugin-fw-field-wrapper yith-plugin-fw-text-field-wrapper">
							<input type="text" name="wb_ajax_filter_preset_title" value="<?php echo esc_attr( $preset_title ); ?>">
						</div>
						<span class="description" style="<?php echo esc_attr( $hide ); ?>">
							<?php esc_html_e( 'Enter a name to identify this filter preset', 'wb-ajax-filter' ); ?>
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="preset-filters-wrapper">
			<h4><?php esc_html_e( 'Filters of this preset', 'wb-ajax-filter' ); ?></h4>
			<div class="preset-filters ui-sortable">
				<div>
					<p>
						<?php
						if ( empty( $filters ) ) {
							?>
							<span class="strong">
								<?php esc_html_e( 'You don\'t have any filter yet.', 'wb-ajax-filter' ); ?>
							</span>
							<span><?php esc_html_e( 'But don\'t worry, here you can create your first one!', 'wb-ajax-filter' ); ?></span>
							<?php
						} else {
							$filter_count = 0;
							foreach ( $filters as $key => $filter ) {
								include 'preset-filter-single.php';
							}
						}
						?>
						<a class="wb-ajax-filter-add-button button-primary wb-add-new-filter" href="#">
							<?php esc_html_e( 'Add a new filter', 'wb-ajax-filter' ); ?>
						</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
