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

defined( 'ABSPATH' ) || exit;

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

$wb_presets_url = Wbcom_Settings_Page::tab_url( Wb_Ajax_Filter_Admin::PAGE_SLUG, 'wb-ajax-filter-presets' );
?>
<div class="wb-ajax-filter-create-preset-section">
	<p class="wb-ajax-filter-back-link">
		<a href="<?php echo esc_url( $wb_presets_url ); ?>" class="wbcom-btn">
			<?php wb_ajax_filter_icon( 'arrow-left', 'wb-ajax-back-icon', 16 ); ?>
			<?php esc_html_e( 'Back to presets', 'wb-ajax-filter' ); ?>
		</a>
	</p>

	<?php
	Wbcom_Settings_Page::card_open(
		'' === $preset_title ? __( 'Add new filter preset', 'wb-ajax-filter' ) : $preset_title,
		'' === $preset_title ? __( 'Enter a name to identify this filter preset.', 'wb-ajax-filter' ) : ''
	);
	?>
	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label for="wb_ajax_filter_preset_title"><?php esc_html_e( 'Preset name', 'wb-ajax-filter' ); ?></label>
		</div>
		<div class="wbcom-field-control">
			<input class="wbcom-input" type="text" id="wb_ajax_filter_preset_title" name="wb_ajax_filter_preset_title" value="<?php echo esc_attr( $preset_title ); ?>">
			<?php
			if ( isset( $_REQUEST['preset'] ) ) { //phpcs:ignore
				$wb_ajax_preset = isset( $_REQUEST['preset'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['preset'] ) ) : ''; //phpcs:ignore
				?>
				<a class="wb-ajax-filter-save-title-button wbcom-btn wbcom-btn--primary wb-add-new-filter" href="#" data-preset="<?php echo esc_attr( $wb_ajax_preset ); ?>">
					<?php esc_html_e( 'Save', 'wb-ajax-filter' ); ?>
				</a>
			<?php } ?>
		</div>
	</div>
	<?php
	Wbcom_Settings_Page::card_close();

	Wbcom_Settings_Page::card_open( __( 'Filters of this preset', 'wb-ajax-filter' ) );
	?>
	<div class="preset-filters-wrapper">
		<div class="preset-filters ui-sortable">
			<div class="wb-ajax-filters-single-container">
				<?php
				if ( empty( $filters ) ) {
					?>
					<div class="wbcom-empty-state wbcom-preset-filters-message">
						<i data-lucide="sliders-horizontal"></i>
						<p class="wbcom-empty-state__title"><?php esc_html_e( 'No filters have been created yet.', 'wb-ajax-filter' ); ?></p>
						<p class="wbcom-empty-state__desc"><?php esc_html_e( 'Create your first filter using the button below.', 'wb-ajax-filter' ); ?></p>
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
				<p class="wb-ajax-filter-add-filter-bar">
					<a class="wb-ajax-filter-add-button wbcom-btn wbcom-btn--primary wb-add-new-filter" href="#" data-preset="<?php echo esc_attr( $wb_ajax_filter_preset ); ?>">
						<?php wb_ajax_filter_icon( 'plus', '', 16 ); ?>
						<?php esc_html_e( 'Add a new filter', 'wb-ajax-filter' ); ?>
					</a>
				</p>
			</div>
		</div>
	</div>
	<?php
	Wbcom_Settings_Page::card_close();
	?>
</div>
