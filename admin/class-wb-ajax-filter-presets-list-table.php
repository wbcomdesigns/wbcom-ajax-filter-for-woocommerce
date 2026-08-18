<?php
/**
 * The Stored Data list table - every preset the plugin has stored, browsable
 * the way core lists posts: paginated, sortable, filterable, searchable.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.2.2
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table over the wb_filter_preset records.
 *
 * All querying goes through Wb_Ajax_Filter_Presets, the same seam the REST
 * controller reads, so both surfaces always agree on what a record is.
 *
 * @since 1.2.2
 */
class Wb_Ajax_Filter_Presets_List_Table extends WP_List_Table {

	/**
	 * Status counts for the views row.
	 *
	 * @var array
	 */
	private $status_counts = array();

	/**
	 * Set up the table.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'singular' => 'wb_filter_preset',
				'plural'   => 'wb_filter_presets',
				'ajax'     => false,
			)
		);
	}

	/**
	 * The base URL of the Stored Data tab, preserving nothing but page + tab.
	 *
	 * @return string
	 */
	public static function base_url() {
		return add_query_arg(
			array(
				'page' => Wb_Ajax_Filter_Admin::PAGE_SLUG,
				'tab'  => 'stored-data',
			),
			admin_url( 'admin.php' )
		);
	}

	/**
	 * Requested status view, whitelisted.
	 *
	 * @return string 'all', 'enabled' or 'disabled'.
	 */
	private function current_status() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only list filter.
		$status = isset( $_REQUEST['status'] ) ? sanitize_key( wp_unslash( $_REQUEST['status'] ) ) : 'all';

		return in_array( $status, array( 'enabled', 'disabled' ), true ) ? $status : 'all';
	}

	/**
	 * Columns.
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'cb'      => '<input type="checkbox" />',
			'title'   => __( 'Preset', 'wb-ajax-filter' ),
			'status'  => __( 'Status', 'wb-ajax-filter' ),
			'fields'  => __( 'Filter fields', 'wb-ajax-filter' ),
			'created' => __( 'Created', 'wb-ajax-filter' ),
		);
	}

	/**
	 * Sortable columns.
	 *
	 * @return array
	 */
	protected function get_sortable_columns() {
		return array(
			'title'   => array( 'title', false ),
			'created' => array( 'date', false ),
		);
	}

	/**
	 * Status views (All / Enabled / Disabled) with true counts.
	 *
	 * @return array
	 */
	protected function get_views() {
		$current = $this->current_status();
		$views   = array();

		$labels = array(
			'all'      => __( 'All', 'wb-ajax-filter' ),
			'enabled'  => __( 'Enabled', 'wb-ajax-filter' ),
			'disabled' => __( 'Disabled', 'wb-ajax-filter' ),
		);

		foreach ( $labels as $status => $label ) {
			$url = ( 'all' === $status ) ? self::base_url() : add_query_arg( 'status', $status, self::base_url() );

			$views[ $status ] = sprintf(
				'<a href="%1$s"%2$s>%3$s <span class="count">(%4$s)</span></a>',
				esc_url( $url ),
				$current === $status ? ' class="current" aria-current="page"' : '',
				esc_html( $label ),
				esc_html( number_format_i18n( isset( $this->status_counts[ $status ] ) ? $this->status_counts[ $status ] : 0 ) )
			);
		}

		return $views;
	}

	/**
	 * Bulk actions. Delete is deliberately bulk-only: selecting rows and
	 * applying is a two-step act, so no native confirm() dialog is needed
	 * for a permanent delete.
	 *
	 * @return array
	 */
	protected function get_bulk_actions() {
		return array(
			'enable'      => __( 'Enable', 'wb-ajax-filter' ),
			'disable'     => __( 'Disable', 'wb-ajax-filter' ),
			'export-json' => __( 'Export (JSON)', 'wb-ajax-filter' ),
			'delete'      => __( 'Delete permanently', 'wb-ajax-filter' ),
		);
	}

	/**
	 * Checkbox cell.
	 *
	 * @param array $item Record.
	 * @return string
	 */
	protected function column_cb( $item ) {
		return sprintf(
			'<label class="screen-reader-text" for="preset-%1$d">%2$s</label><input type="checkbox" name="presets[]" id="preset-%1$d" value="%1$d" />',
			absint( $item['id'] ),
			/* translators: %s: preset title. */
			esc_html( sprintf( __( 'Select %s', 'wb-ajax-filter' ), $item['title'] ) )
		);
	}

	/**
	 * Title cell with the row actions.
	 *
	 * @param array $item Record.
	 * @return string
	 */
	protected function column_title( $item ) {
		$edit_url = add_query_arg(
			array(
				'page'   => Wb_Ajax_Filter_Admin::PAGE_SLUG,
				'tab'    => 'wb-ajax-filter-presets',
				'action' => 'edit',
				'wb'     => 'list',
				'preset' => absint( $item['id'] ),
			),
			admin_url( 'admin.php' )
		);

		$toggle_action = $item['enabled'] ? 'disable' : 'enable';
		$toggle_url    = wp_nonce_url(
			add_query_arg(
				array(
					'wb_data_action' => $toggle_action,
					'preset'         => absint( $item['id'] ),
				),
				self::base_url()
			),
			'wb_ajax_filter_data_action'
		);

		$export_url = wp_nonce_url(
			add_query_arg(
				array(
					'action'  => 'wb_ajax_filter_export',
					'format'  => 'json',
					'presets' => absint( $item['id'] ),
				),
				admin_url( 'admin-post.php' )
			),
			'wb_ajax_filter_export'
		);

		$actions = array(
			'edit'         => sprintf( '<a href="%s">%s</a>', esc_url( $edit_url ), esc_html__( 'Edit', 'wb-ajax-filter' ) ),
			$toggle_action => sprintf(
				'<a href="%s">%s</a>',
				esc_url( $toggle_url ),
				$item['enabled'] ? esc_html__( 'Disable', 'wb-ajax-filter' ) : esc_html__( 'Enable', 'wb-ajax-filter' )
			),
			'export'       => sprintf( '<a href="%s">%s</a>', esc_url( $export_url ), esc_html__( 'Export (JSON)', 'wb-ajax-filter' ) ),
		);

		return sprintf(
			'<strong><a class="row-title" href="%1$s">%2$s</a></strong>%3$s',
			esc_url( $edit_url ),
			esc_html( $item['title'] ),
			$this->row_actions( $actions )
		);
	}

	/**
	 * Status cell.
	 *
	 * @param array $item Record.
	 * @return string
	 */
	protected function column_status( $item ) {
		// Same badge vocabulary the shared settings shell styles for the Overview tab.
		if ( $item['enabled'] ) {
			return '<span class="wbcom-badge wbcom-badge--success">' . esc_html__( 'Enabled', 'wb-ajax-filter' ) . '</span>';
		}

		return '<span class="wbcom-badge">' . esc_html__( 'Disabled', 'wb-ajax-filter' ) . '</span>';
	}

	/**
	 * Fields cell - how many of the preset's fields shoppers actually see.
	 *
	 * @param array $item Record.
	 * @return string
	 */
	protected function column_fields( $item ) {
		return esc_html(
			sprintf(
				/* translators: 1: enabled field count, 2: total field count. */
				__( '%1$s of %2$s enabled', 'wb-ajax-filter' ),
				number_format_i18n( $item['fields_enabled'] ),
				number_format_i18n( $item['fields_total'] )
			)
		);
	}

	/**
	 * Created cell.
	 *
	 * @param array $item Record.
	 * @return string
	 */
	protected function column_created( $item ) {
		$timestamp = strtotime( $item['created'] );
		if ( ! $timestamp ) {
			return '&#8212;';
		}

		return esc_html( date_i18n( get_option( 'date_format' ), $timestamp ) );
	}

	/**
	 * Empty-state copy.
	 */
	public function no_items() {
		if ( 'all' === $this->current_status() && ! $this->get_search_term() ) {
			esc_html_e( 'No filter presets stored yet. Create one under Your Filters.', 'wb-ajax-filter' );
			return;
		}

		esc_html_e( 'No presets match this filter.', 'wb-ajax-filter' );
	}

	/**
	 * Requested search term.
	 *
	 * @return string
	 */
	private function get_search_term() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only list search.
		return isset( $_REQUEST['s'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) : '';
	}

	/**
	 * Query the page of records through the shared preset seam.
	 */
	public function prepare_items() {
		$per_page = 20;

		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Read-only list state.
		$orderby = isset( $_REQUEST['orderby'] ) ? sanitize_key( wp_unslash( $_REQUEST['orderby'] ) ) : 'title';
		$order   = isset( $_REQUEST['order'] ) ? sanitize_key( wp_unslash( $_REQUEST['order'] ) ) : 'asc';
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		$this->status_counts = Wb_Ajax_Filter_Presets::count_by_status();

		$query = Wb_Ajax_Filter_Presets::query(
			array(
				'page'     => $this->get_pagenum(),
				'per_page' => $per_page,
				'search'   => $this->get_search_term(),
				'status'   => $this->current_status(),
				'orderby'  => $orderby,
				'order'    => $order,
			)
		);

		$items = array();
		foreach ( $query->posts as $post ) {
			$record = Wb_Ajax_Filter_Presets::to_record( $post );
			if ( null !== $record ) {
				$items[] = $record;
			}
		}

		$this->items = $items;

		$this->set_pagination_args(
			array(
				'total_items' => (int) $query->found_posts,
				'per_page'    => $per_page,
				'total_pages' => (int) $query->max_num_pages,
			)
		);

		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns(), 'title' );
	}
}
