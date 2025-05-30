<?php
/**
 * The admin General setting tab template.
 *
 * @link       support@wbcom.com
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/* admin setting on dashboard */
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
?>
<div class="wbcom-tab-content">
<div class="wbcom-admin-title-section">
		<h3 class="wp-heading-inline"><?php esc_html_e( 'General Settings', 'wb-ajax-filter' ); ?></h3>
	</div>
	<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">
	<form method="post" action="options.php">
		<?php
		settings_fields( 'wb_ajax_filter_admin_general_options' );
		do_settings_sections( 'wb_ajax_filter_admin_general_options' );
		?>
		<?php do_action( 'wb_ajax_filter_before_admin_general_settings', $wb_ajax_filter_general_options ); ?>
		
		<div class="form-table">
		
		<div class="wbcom-settings-section-wrap">
			<div class="wbcom-settings-section-options-heading">
					
						<label>
							<?php esc_html_e( 'Filter View', 'wb-ajax-filter' ); ?>
						</label>

							<p class="description"><?php esc_html_e( 'Choose to apply filters in real time using AJAX or whether to show a button to apply all filters.', 'wb-ajax-filter' ); ?></p>

					   </div>
					   <div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_general_options[instant_filters]" type="radio" value="yes" <?php ( isset( $wb_ajax_filter_general_options['instant_filters'] ) ) ? checked( $wb_ajax_filter_general_options['instant_filters'], 'yes' ) : ''; ?>>
							<span class="description"><?php esc_html_e( 'Instant result', 'wb-ajax-filter' ); ?></span>
						</label>  <br>
						
						<label>
							<input name="wb_ajax_filter_admin_general_options[instant_filters]" type="radio" value="no" <?php ( isset( $wb_ajax_filter_general_options['instant_filters'] ) ) ? checked( $wb_ajax_filter_general_options['instant_filters'], 'no' ) : ''; ?>>
							<span class="description"><?php esc_html_e( 'By clicking "Apply filters" button', 'wb-ajax-filter' ); ?></span>
						</label><br>
					  </div>
				</div>
				<div class="wbcom-settings-section-wrap">
					<div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Display Results', 'wb-ajax-filter' ); ?>
						</label>

							<p class="description"><?php esc_html_e( 'Choose whether to render search results on page reload or without page reload.', 'wb-ajax-filter' ); ?></p>

					</div>
					<div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_general_options[ajax_filters]" type="radio" value="yes" <?php ( isset( $wb_ajax_filter_general_options['ajax_filters'] ) ) ? checked( $wb_ajax_filter_general_options['ajax_filters'], 'yes' ) : ''; ?>>
							<span class="description"><?php esc_html_e( 'Without Page Reload', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_admin_general_options[ajax_filters]" type="radio" value="no" <?php ( isset( $wb_ajax_filter_general_options['ajax_filters'] ) ) ? checked( $wb_ajax_filter_general_options['ajax_filters'], 'no' ) : ''; ?>>
							<span class="description"><?php esc_html_e( 'On Page Reload', 'wb-ajax-filter' ); ?></span>
						</label><br>
					  </div>
					</div>
					<div class="wbcom-settings-section-wrap">
					  <div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Hide empty terms', 'wb-ajax-filter' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Enable to hide empty terms from filters section', 'wb-ajax-filter' ); ?></p>
			   
					</div>
					<div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_general_options[hide_empty_terms]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_general_options['hide_empty_terms'] ) ) ? checked( $wb_ajax_filter_general_options['hide_empty_terms'], 'yes' ) : ''; ?>>
						</label><br>
					</div>
				   </div>
				   <div class="wbcom-settings-section-wrap">
					  <div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Hide out of stock products', 'wb-ajax-filter' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Enable to hide "out of stock" products from the results.', 'wb-ajax-filter' ); ?></p>

					   </div>
					   <div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_general_options[hide_out_of_stock]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_general_options['hide_out_of_stock'] ) ) ? checked( $wb_ajax_filter_general_options['hide_out_of_stock'], 'yes' ) : ''; ?>>
						</label><br>
						</div>
				 </div>
				 <div class="wbcom-settings-section-wrap">
					  <div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Show reset button', 'wb-ajax-filter' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Enable to show the "Reset filter" button to allow the user to cancel the filter selection in one click', 'wb-ajax-filter' ); ?></p>

						</div>
						<div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_general_options[show_reset]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_general_options['show_reset'] ) ) ? checked( $wb_ajax_filter_general_options['show_reset'], 'yes' ) : ''; ?>>
						</label><br>
					</div>
					</div>

					
				<div style="<?php echo ( isset( $wb_ajax_filter_general_options['show_reset'] ) && 'yes' === $wb_ajax_filter_general_options['show_reset'] ) ? '' : 'display:none;'; ?>">
				<div class="wbcom-settings-section-wrap">
					  <div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Reset button position', 'wb-ajax-filter' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Choose the default position for reset button', 'wb-ajax-filter' ); ?></p>
					 
					  </div>
					  <div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_general_options[reset_button_position]" type="radio" value="before_filters" <?php ( isset( $wb_ajax_filter_general_options['reset_button_position'] ) ) ? checked( $wb_ajax_filter_general_options['reset_button_position'], 'before_filters' ) : ''; ?>>
							<span class="description"><?php esc_html_e( 'Before filters', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_admin_general_options[reset_button_position]" type="radio" value="after_filters" <?php ( isset( $wb_ajax_filter_general_options['reset_button_position'] ) ) ? checked( $wb_ajax_filter_general_options['reset_button_position'], 'after_filters' ) : ''; ?>>
							<span class="description"><?php esc_html_e( 'After filters', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_admin_general_options[reset_button_position]" type="radio" value="before_products" <?php ( isset( $wb_ajax_filter_general_options['reset_button_position'] ) ) ? checked( $wb_ajax_filter_general_options['reset_button_position'], 'before_products' ) : ''; ?>>
							<span class="description"><?php esc_html_e( 'Above products list', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</div>
				</div>
				</div>
				<div class="wbcom-settings-section-wrap">
					  <div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Show "Clear" above each filter', 'wb-ajax-filter' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Enable to show the "Clear" link above each filter of the preset', 'wb-ajax-filter' ); ?></p>

					</div>
					<div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_general_options[show_clear_filter]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) ) ? checked( $wb_ajax_filter_general_options['show_clear_filter'], 'yes' ) : ''; ?>>
						</label><br>
					</div>
				</div>
				<div class="wbcom-settings-section-wrap">
					  <div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Show active filters as labels', 'wb-ajax-filter' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Enable to show the active filters as labels. Labels show the current filters selection, and can be used to remove any active filter.', 'wb-ajax-filter' ); ?></p>

					</div>
					<div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_general_options[show_active_labels]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_general_options['show_active_labels'] ) ) ? checked( $wb_ajax_filter_general_options['show_active_labels'], 'yes' ) : ''; ?>>
						</label><br>
					 </div>
					 </div>
					 <div class="wbcom-settings-section-wrap">
					  <div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Scroll top after filtering', 'wb-ajax-filter' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Enable this option if you want to scroll to top after filtering.', 'wb-ajax-filter' ); ?></p>

					</div>
					<div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_general_options[scroll_top]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_general_options['scroll_top'] ) ) ? checked( $wb_ajax_filter_general_options['scroll_top'], 'yes' ) : ''; ?>>
						</label><br>				
					   </div>
					</div>
	
		<?php do_action( 'wb_ajax_filter_after_admin_general_settings', $wb_ajax_filter_general_options ); ?>
		<?php submit_button(); ?>
	</form>
</div>
</div>
