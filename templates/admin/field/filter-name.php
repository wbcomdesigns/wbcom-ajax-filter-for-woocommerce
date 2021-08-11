<?php
/**
 * The template for filter name field.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

if ( ! isset( $_REQUEST['preset'] ) ) {
	$name = ( isset( $_POST['title'] ) && '' !== $_POST['title'] ) ? esc_html( wp_unslash( $_POST['title'] ) ) : 'New filter';// phpcs:ignore
} else {
	$preset = get_post( $_REQUEST['preset'] );
	$name   = $preset->post_title;
}

echo '<pre>';
print_r( $filters );
echo '</pre>';
?>
<input type="hidden" name="filters[preset_id]" value="<?php echo ( isset( $_REQUEST['preset'] ) ) ? esc_html( wp_unslash( $_REQUEST['preset'] ) ) : ''; ?>">
<div class="wb-ajax-filter-toggle-content-row">
	<label><?php esc_html_e( 'Filter name', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-text-field-wrapper">
		<input type="text" name="filters[title]" value="<?php echo esc_html( $name ); ?>">
	</div>
	<span class="description"><?php esc_html_e( 'Enter a name to identify this filter', 'wb-ajax-filter' ); ?></span>
</div>
