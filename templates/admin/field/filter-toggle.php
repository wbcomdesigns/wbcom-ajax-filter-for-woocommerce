<?php
/**
 * The template for filter toggle field.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="wbcom-field wbcom-field-group wb-all-toggle">
	<div class="wbcom-field-info">
		<label for="show_toggle"><?php esc_html_e( 'Show as toggle', 'wb-ajax-filter' ); ?></label>
		<p class="description"><?php esc_html_e( 'Enable this to show this filter as a toggle.', 'wb-ajax-filter' ); ?></p>
	</div>
	<div class="wbcom-field-control">
		<label class="wbcom-toggle">
			<input id="show_toggle" type="checkbox" name="filters[show_toggle]" value="yes" <?php echo ( isset( $filters['show_toggle'] ) && 'yes' === $filters['show_toggle'] ) ? 'checked' : ''; ?>>
			<span class="wbcom-toggle-slider"></span>
		</label>
	</div>
</div>
<div class="wbcom-field wbcom-field-group wb-show-style-toggle" <?php echo ( isset( $filters['show_toggle'] ) && 'yes' === $filters['show_toggle'] ) ? '' : 'style="display:none;"'; ?>>
	<div class="wbcom-field-info">
		<label><?php esc_html_e( 'Toggle style', 'wb-ajax-filter' ); ?></label>
		<p class="description"><?php esc_html_e( 'Choose if the toggle should be closed or opened by default.', 'wb-ajax-filter' ); ?></p>
	</div>
	<div class="wbcom-field-control">
		<label>
			<input id="toggle_style_closed" type="radio" name="filters[toggle_style]" value="closed" <?php echo ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'checked' : ''; ?>>
			<span class="description"><?php esc_html_e( 'Closed by default', 'wb-ajax-filter' ); ?></span>
		</label>
		<label>
			<input id="toggle_style_opened" type="radio" name="filters[toggle_style]" value="opened" <?php echo ( isset( $filters['toggle_style'] ) && 'opened' === $filters['toggle_style'] ) ? 'checked' : ''; ?>>
			<span class="description"><?php esc_html_e( 'Opened by default', 'wb-ajax-filter' ); ?></span>
		</label>
	</div>
</div>
