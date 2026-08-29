<?php
/**
 * The template for the "Your Filters" landing - the preset builder entry point.
 *
 * The full, paginated list of presets lives on the Stored Data tab
 * (Wb_Ajax_Filter_Presets_List_Table), which also links each row into this
 * builder for editing. This screen therefore only offers the "create" entry
 * and a pointer to that list, rather than maintaining a second copy of it.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

defined( 'ABSPATH' ) || exit;

$wb_create_url = add_query_arg(
	array( 'action' => 'create' ),
	Wbcom_Settings_Page::tab_url( Wb_Ajax_Filter_Admin::PAGE_SLUG, 'wb-ajax-filter-presets' )
);
$wb_manage_url = Wbcom_Settings_Page::tab_url( Wb_Ajax_Filter_Admin::PAGE_SLUG, 'stored-data' );
?>
<?php
Wbcom_Settings_Page::card_open(
	__( 'Filter presets', 'wb-ajax-filter' ),
	__( 'A preset is a reusable set of filters. Create one here, then place it with its shortcode or enable it to show on shop and archive pages.', 'wb-ajax-filter' )
);
?>
<div class="wb-ajax-filter-preset-actions">
	<a href="<?php echo esc_url( $wb_create_url ); ?>" class="wbcom-btn wbcom-btn--primary">
		<?php wb_ajax_filter_icon( 'plus', 'wb-ajax-add-preset-icon', 16 ); ?>
		<?php esc_html_e( 'Add preset', 'wb-ajax-filter' ); ?>
	</a>
	<a href="<?php echo esc_url( $wb_manage_url ); ?>" class="wbcom-btn">
		<?php esc_html_e( 'Manage saved presets', 'wb-ajax-filter' ); ?>
	</a>
</div>
<p class="description">
	<?php esc_html_e( 'Edit, enable, disable, duplicate, delete and export existing presets on the Stored Data tab.', 'wb-ajax-filter' ); ?>
</p>
<?php
Wbcom_Settings_Page::card_close();
