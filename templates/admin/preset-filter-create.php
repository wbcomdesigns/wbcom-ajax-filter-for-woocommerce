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
$hide         = '';
if ( isset( $_REQUEST['action'] ) && 'edit' === $_REQUEST['action'] ) { //phpcs:ignore
	$preset_id = ( isset( $_REQUEST['preset'] ) && '' !== $_REQUEST['preset'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['preset'] ) ) : false; //phpcs:ignore
	if ( $preset_id ) {
		$hide         = 'display:none;';
		$preset       = get_post( $preset_id );
		$preset_title = $preset->post_title;
		$filters      = get_post_meta( $preset_id, '_wb_filter', true );
	}
}
?>
<div class="wbcom-admin-option-wrap wb-ajax-filter-create-preset-section">
	<div class="wb-ajax-filter-create-preset-section-content">
		<span class="view-all-presets">
			<a href="<?php echo esc_url( site_url() ); ?>/wp-admin/admin.php?page=wc-ajax-filter-settings&tab=wb-ajax-filter-presets"  class="button-primary" >
				<span class="dashicons dashicons-arrow-left-alt"></span> <?php esc_html_e( ' Back to presets list', 'wb-ajax-filter' ); ?>
			</a>
		</span>
		<div class="wbcom-settings-section-wrap">		
		<?php if ( '' === $preset_title ) : ?>
			<div class="wbcom-settings-section-options-heading">
				<label><?php esc_html_e( 'Add new filter preset', 'wb-ajax-filter' ); ?></label>
				<p class="description" style="<?php echo esc_attr( $hide ); ?>">
					<?php esc_html_e( 'Enter a name to identify this filter preset.', 'wb-ajax-filter' ); ?>
				</p>
			</div>
		<?php endif; ?>
		
		<div class="wbcom-settings-section-options">
			<?php esc_html_e( 'Preset name', 'wb-ajax-filter' ); ?>
			<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-text-field-wrapper">
				<input type="text" name="wb_ajax_filter_preset_title" value="<?php echo esc_attr( $preset_title ); ?>">
				<?php
				if ( isset( $_REQUEST['preset'] ) ) { //phpcs:ignore
					$wb_ajax_preset = isset( $_REQUEST['preset'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['preset'] ) ) : ''; //phpcs:ignore
					?>
				<a class="wb-ajax-filter-save-title-button button-primary wb-add-new-filter" href="#" data-preset="<?php echo esc_attr( $wb_ajax_preset ); ?>">
					<?php esc_html_e( 'Save', 'wb-ajax-filter' ); ?>
				</a>
				<?php } ?>
			</div>
		</div>
	</div>

		<div class="preset-filters-wrapper">
			<div class="wbcom-admin-title-section">
				<h3><?php esc_html_e( 'Filters of this preset', 'wb-ajax-filter' ); ?></h3>
			</div>
			<div class="preset-filters ui-sortable">
				<div class="wb-ajax-filters-single-container">
						<?php
						if ( empty( $filters ) ) {
							?>
							<div class="wbcom-preset-filters-message">
								<strong><?php esc_html_e( 'No filters have been created yet.', 'wb-ajax-filter' ); ?></strong>
								<?php esc_html_e( 'Create your first filter using the options below.', 'wb-ajax-filter' ); ?>
							</div>
							<?php
						} else {
							$filter_count = 0;
							foreach ( $filters as $key => $filter ) {
								include 'preset-filter-single.php';
							}
						}
						?>
						<?php
						$wb_ajax_filter_preset = isset( $_REQUEST['preset'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['preset'] ) ) : ''; //phpcs:ignore
						?>
						<a class="wb-ajax-filter-add-button button-primary wb-add-new-filter" href="#" data-preset="<?php echo esc_attr( $wb_ajax_filter_preset ); ?>">
							<?php esc_html_e( 'Add a new filter', 'wb-ajax-filter' ); ?>
						</a>
				</div>
			</div>
		</div>
	</div>
</div>
