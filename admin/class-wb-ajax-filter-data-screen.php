<?php
/**
 * Controller for the Stored Data screen - moderation actions and exports.
 *
 * State changes run on admin_init (before any output, so the request can
 * redirect back clean), and file downloads go through admin-post.php (the
 * server-rendered download seam - no admin-ajax). Rendering itself lives in
 * admin/partials/tab-data.php on the shared settings shell.
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

/**
 * Handles Stored Data screen actions.
 *
 * @since 1.2.2
 */
class Wb_Ajax_Filter_Data_Screen {

	/**
	 * Nonce action for enable/disable/delete requests.
	 */
	const NONCE_ACTION = 'wb_ajax_filter_data_action';

	/**
	 * Nonce action for export downloads.
	 */
	const NONCE_EXPORT = 'wb_ajax_filter_export';

	/**
	 * Whether the current request targets the Stored Data tab.
	 *
	 * @return bool
	 */
	private function is_data_screen_request() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Routing only; actions verify their own nonce.
		$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
		$tab  = isset( $_REQUEST['tab'] ) ? sanitize_key( wp_unslash( $_REQUEST['tab'] ) ) : '';
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		return Wb_Ajax_Filter_Admin::PAGE_SLUG === $page && 'stored-data' === $tab;
	}

	/**
	 * Preset IDs named by the request (bulk checkboxes or a single link).
	 *
	 * @return int[]
	 */
	private function requested_preset_ids() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Callers verify the nonce first.
		if ( isset( $_REQUEST['presets'] ) && is_array( $_REQUEST['presets'] ) ) {
			$ids = array_map( 'absint', wp_unslash( $_REQUEST['presets'] ) );
		} elseif ( isset( $_REQUEST['preset'] ) ) {
			$ids = array( absint( wp_unslash( $_REQUEST['preset'] ) ) );
		} else {
			$ids = array();
		}
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		return array_filter( $ids );
	}

	/**
	 * Process enable/disable/delete requests, then redirect back clean.
	 *
	 * Runs on admin_init so it always precedes output. Row links carry
	 * wb_data_action; the list table's bulk form submits action/action2.
	 * Fail-closed: nonce first, capability second, per-ID post-type assert
	 * inside the shared preset seam third.
	 *
	 * @since 1.2.2
	 */
	public function handle_actions() {
		if ( ! is_admin() || wp_doing_ajax() || ! $this->is_data_screen_request() ) {
			return;
		}

		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Verified below before any write.
		$action = isset( $_REQUEST['wb_data_action'] ) ? sanitize_key( wp_unslash( $_REQUEST['wb_data_action'] ) ) : '';
		if ( '' === $action && isset( $_REQUEST['action'] ) && '-1' !== $_REQUEST['action'] ) {
			$action = sanitize_key( wp_unslash( $_REQUEST['action'] ) );
		}
		if ( '' === $action && isset( $_REQUEST['action2'] ) && '-1' !== $_REQUEST['action2'] ) {
			$action = sanitize_key( wp_unslash( $_REQUEST['action2'] ) );
		}
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		if ( ! in_array( $action, array( 'enable', 'disable', 'delete', 'export-json' ), true ) ) {
			return;
		}

		check_admin_referer( self::NONCE_ACTION );

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_die( esc_html__( 'You are not allowed to manage filter presets.', 'wb-ajax-filter' ), 403 );
		}

		$ids = $this->requested_preset_ids();

		// The bulk-action route to a download: re-enter the export path with
		// the selected IDs so the file goes out before any admin output.
		if ( 'export-json' === $action ) {
			if ( ! empty( $ids ) ) {
				$this->send_export( 'json', $ids );
			}
			$this->redirect_back( 'none', 0 );
		}

		$done = 0;
		foreach ( $ids as $id ) {
			switch ( $action ) {
				case 'enable':
					$done += Wb_Ajax_Filter_Presets::set_enabled( $id, true ) ? 1 : 0;
					break;
				case 'disable':
					$done += Wb_Ajax_Filter_Presets::set_enabled( $id, false ) ? 1 : 0;
					break;
				case 'delete':
					$done += Wb_Ajax_Filter_Presets::delete( $id ) ? 1 : 0;
					break;
			}
		}

		$this->redirect_back( $action, $done );
	}

	/**
	 * Redirect back to the Stored Data tab with a result message.
	 *
	 * @param string $action What ran.
	 * @param int    $count  Rows affected.
	 */
	private function redirect_back( $action, $count ) {
		$url = add_query_arg(
			array(
				'page' => Wb_Ajax_Filter_Admin::PAGE_SLUG,
				'tab'  => 'stored-data',
			),
			admin_url( 'admin.php' )
		);

		if ( 'none' !== $action ) {
			$url = add_query_arg(
				array(
					'wb_data_done'  => $action,
					'wb_data_count' => absint( $count ),
				),
				$url
			);
		}

		wp_safe_redirect( $url );
		exit;
	}

	/**
	 * Serve an export download from admin-post.php.
	 *
	 * URL: admin-post.php?action=wb_ajax_filter_export&format=json|csv
	 *      [&presets=<id>|presets[]=<id>...] - no presets param exports all.
	 *
	 * @since 1.2.2
	 */
	public function handle_export() {
		check_admin_referer( self::NONCE_EXPORT );

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_die( esc_html__( 'You are not allowed to export filter presets.', 'wb-ajax-filter' ), 403 );
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- check_admin_referer() above.
		$format = isset( $_REQUEST['format'] ) && 'csv' === $_REQUEST['format'] ? 'csv' : 'json';
		$ids    = $this->requested_preset_ids();

		$this->send_export( $format, empty( $ids ) ? null : $ids );
	}

	/**
	 * Emit the export file and exit.
	 *
	 * @param string     $format 'json' or 'csv'.
	 * @param int[]|null $ids    Preset IDs, or null for the full store.
	 */
	private function send_export( $format, $ids ) {
		$payload  = Wb_Ajax_Filter_Presets::export_payload( $ids );
		$filename = 'wb-ajax-filter-presets-' . gmdate( 'Ymd-His' ) . '.' . $format;

		nocache_headers();
		header( 'Content-Disposition: attachment; filename=' . $filename );

		if ( 'csv' === $format ) {
			header( 'Content-Type: text/csv; charset=utf-8' );
			// phpcs:disable WordPress.WP.AlternativeFunctions -- Streaming a download to php://output, not touching the filesystem.
			$out = fopen( 'php://output', 'w' );
			foreach ( Wb_Ajax_Filter_Presets::to_csv_rows( $payload['presets'] ) as $row ) {
				// Explicit escape argument: relying on the default is deprecated in PHP 8.4.
				fputcsv( $out, $row, ',', '"', '\\' );
			}
			fclose( $out );
			// phpcs:enable WordPress.WP.AlternativeFunctions
			exit;
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo wp_json_encode( $payload, JSON_PRETTY_PRINT );
		exit;
	}

	/**
	 * The success notice for the Stored Data tab, from the redirect args.
	 *
	 * Returned (not echoed) so the partial controls placement. Empty string
	 * when the request carries no completed action.
	 *
	 * @since  1.2.2
	 * @return string
	 */
	public static function result_notice() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Message display only, set by our own redirect.
		$action = isset( $_GET['wb_data_done'] ) ? sanitize_key( wp_unslash( $_GET['wb_data_done'] ) ) : '';
		$count  = isset( $_GET['wb_data_count'] ) ? absint( wp_unslash( $_GET['wb_data_count'] ) ) : 0;
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		switch ( $action ) {
			case 'enable':
				/* translators: %s: number of presets. */
				$message = _n( '%s preset enabled.', '%s presets enabled.', $count, 'wb-ajax-filter' );
				break;
			case 'disable':
				/* translators: %s: number of presets. */
				$message = _n( '%s preset disabled.', '%s presets disabled.', $count, 'wb-ajax-filter' );
				break;
			case 'delete':
				/* translators: %s: number of presets. */
				$message = _n( '%s preset deleted.', '%s presets deleted.', $count, 'wb-ajax-filter' );
				break;
			default:
				return '';
		}

		return sprintf(
			'<div class="notice notice-success is-dismissible inline"><p>%s</p></div>',
			esc_html( sprintf( $message, number_format_i18n( $count ) ) )
		);
	}
}
