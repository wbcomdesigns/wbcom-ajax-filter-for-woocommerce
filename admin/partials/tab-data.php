<?php
/**
 * Stored Data tab - everything the plugin stores, browsable and exportable.
 *
 * The table itself is Wb_Ajax_Filter_Presets_List_Table; enable/disable/delete
 * requests are processed on admin_init by Wb_Ajax_Filter_Data_Screen (so they
 * run before output and redirect back clean), and downloads go through
 * admin-post.php. This partial only lays the pieces out.
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin/partials
 * @since      1.2.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( __DIR__ ) . 'class-wb-ajax-filter-presets-list-table.php';

$wb_data_table = new Wb_Ajax_Filter_Presets_List_Table();
$wb_data_table->prepare_items();

$wb_export_all_json = wp_nonce_url(
	add_query_arg(
		array(
			'action' => 'wb_ajax_filter_export',
			'format' => 'json',
		),
		admin_url( 'admin-post.php' )
	),
	Wb_Ajax_Filter_Data_Screen::NONCE_EXPORT
);
$wb_export_all_csv  = wp_nonce_url(
	add_query_arg(
		array(
			'action' => 'wb_ajax_filter_export',
			'format' => 'csv',
		),
		admin_url( 'admin-post.php' )
	),
	Wb_Ajax_Filter_Data_Screen::NONCE_EXPORT
);

?>
<div class="wb-ajax-filter-data-screen">

	<?php
	Wbcom_Settings_Page::card_open(
		__( 'Stored presets', 'wb-ajax-filter' ),
		__( 'Every filter preset stored on your site. Enable, disable, delete or export them here; a JSON export carries the full field configuration and the plugin settings, so it can move to another site or travel with a support ticket.', 'wb-ajax-filter' )
	);

	// Result of the action that just redirected back here, if any.
	echo wp_kses_post( Wb_Ajax_Filter_Data_Screen::result_notice() );
	?>

	<p class="wb-ajax-filter-data-export-all">
		<a href="<?php echo esc_url( $wb_export_all_json ); ?>" class="wbcom-btn">
			<?php esc_html_e( 'Export all (JSON)', 'wb-ajax-filter' ); ?>
		</a>
		<a href="<?php echo esc_url( $wb_export_all_csv ); ?>" class="wbcom-btn">
			<?php esc_html_e( 'Export list (CSV)', 'wb-ajax-filter' ); ?>
		</a>
	</p>

	<form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>">
		<input type="hidden" name="page" value="<?php echo esc_attr( Wb_Ajax_Filter_Admin::PAGE_SLUG ); ?>" />
		<input type="hidden" name="tab" value="stored-data" />
		<?php wp_nonce_field( Wb_Ajax_Filter_Data_Screen::NONCE_ACTION ); ?>
		<?php $wb_data_table->views(); ?>
		<?php $wb_data_table->search_box( __( 'Search presets', 'wb-ajax-filter' ), 'wb-ajax-filter-preset' ); ?>
		<?php $wb_data_table->display(); ?>
	</form>

	<p class="description">
		<?php
		printf(
			/* translators: %s: REST route. */
			esc_html__( 'The same records are available to store managers over the REST API at %s.', 'wb-ajax-filter' ),
			'<code>/wp-json/wb-ajax-filter/v1/presets</code>'
		);
		?>
	</p>

	<?php Wbcom_Settings_Page::card_close(); ?>
</div>
