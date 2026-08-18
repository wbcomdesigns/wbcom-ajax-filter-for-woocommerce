<?php
/**
 * Preset data access - the one owner of every stored-preset query and record shape.
 *
 * Three consumers read through this seam: the Stored Data admin screen
 * (WP_List_Table), the REST controller, and the export download. Keeping the
 * query builder and the record serializer here means pagination rules, the
 * enabled/disabled definition and the exported shape cannot drift apart.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.2.2
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Query, serialize and moderate stored filter presets.
 *
 * @since 1.2.2
 */
class Wb_Ajax_Filter_Presets {

	/**
	 * Post type holding the stored records.
	 */
	const POST_TYPE = 'wb_filter_preset';

	/**
	 * Meta key holding the whole field configuration array.
	 */
	const META_CONFIG = '_wb_filter';

	/**
	 * Meta key holding the enabled flag ('yes' when live).
	 *
	 * Presets created before the toggle is ever used have NO row for this key,
	 * so "disabled" must always be modelled as NOT EXISTS OR != 'yes'.
	 */
	const META_ENABLED = 'preset_enabled';

	/**
	 * Hard ceiling on rows per page, shared by the admin table and REST.
	 */
	const MAX_PER_PAGE = 100;

	/**
	 * Normalize untrusted list arguments into bounded WP_Query arguments.
	 *
	 * Every list of presets in the plugin goes through this: pagination is
	 * mandatory (no -1 escape hatch), per_page is capped, and orderby is
	 * whitelisted so request input can never reach the query raw.
	 *
	 * @since  1.2.2
	 * @param  array $args {
	 *     Optional. Raw arguments, e.g. straight from a request.
	 *
	 *     @type int    $page     Page number, 1-based. Default 1.
	 *     @type int    $per_page Rows per page, 1..MAX_PER_PAGE. Default 20.
	 *     @type string $search   Title search string. Default ''.
	 *     @type string $status   'enabled', 'disabled' or 'all'. Default 'all'.
	 *     @type string $orderby  'title', 'date' or 'id'. Default 'title'.
	 *     @type string $order    'asc' or 'desc'. Default 'asc'.
	 *     @type array  $include  Restrict to these post IDs. Default none.
	 * }
	 * @return array Arguments safe to hand to WP_Query.
	 */
	public static function normalize_args( $args = array() ) {
		$page     = isset( $args['page'] ) ? max( 1, absint( $args['page'] ) ) : 1;
		$per_page = isset( $args['per_page'] ) ? absint( $args['per_page'] ) : 20;
		$per_page = min( max( 1, $per_page ), self::MAX_PER_PAGE );

		$orderby_map = array(
			'title' => 'title',
			'date'  => 'date',
			'id'    => 'ID',
		);
		$orderby     = isset( $args['orderby'] ) && isset( $orderby_map[ strtolower( $args['orderby'] ) ] )
			? $orderby_map[ strtolower( $args['orderby'] ) ]
			: 'title';
		$order       = ( isset( $args['order'] ) && 'desc' === strtolower( $args['order'] ) ) ? 'DESC' : 'ASC';

		$query_args = array(
			'post_type'              => self::POST_TYPE,
			'post_status'            => 'publish',
			'posts_per_page'         => $per_page,
			'paged'                  => $page,
			'orderby'                => $orderby,
			'order'                  => $order,
			'update_post_term_cache' => false,
			'no_found_rows'          => false,
		);

		if ( ! empty( $args['search'] ) ) {
			$query_args['s'] = sanitize_text_field( $args['search'] );
		}

		if ( ! empty( $args['include'] ) && is_array( $args['include'] ) ) {
			$query_args['post__in'] = array_map( 'absint', $args['include'] );
		}

		$status = isset( $args['status'] ) ? strtolower( (string) $args['status'] ) : 'all';
		if ( 'enabled' === $status ) {
			$query_args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- Bounded preset list; presets number in the dozens.
				array(
					'key'   => self::META_ENABLED,
					'value' => 'yes',
				),
			);
		} elseif ( 'disabled' === $status ) {
			$query_args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- Bounded preset list; presets number in the dozens.
				'relation' => 'OR',
				array(
					'key'     => self::META_ENABLED,
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => self::META_ENABLED,
					'value'   => 'yes',
					'compare' => '!=',
				),
			);
		}

		return $query_args;
	}

	/**
	 * Run a bounded preset query.
	 *
	 * @since  1.2.2
	 * @param  array $args Raw arguments; see normalize_args().
	 * @return WP_Query
	 */
	public static function query( $args = array() ) {
		return new WP_Query( self::normalize_args( $args ) );
	}

	/**
	 * Row counts per status, for the list-table views and REST totals.
	 *
	 * All = wp_count_posts() (a cached COUNT(*)); enabled = one LIMIT 1 query's
	 * found_posts; disabled is derived - never a third scan.
	 *
	 * @since  1.2.2
	 * @return array { @type int $all @type int $enabled @type int $disabled }
	 */
	public static function count_by_status() {
		$counts = wp_count_posts( self::POST_TYPE );
		$all    = isset( $counts->publish ) ? (int) $counts->publish : 0;

		$enabled_query = self::query(
			array(
				'status'   => 'enabled',
				'per_page' => 1,
			)
		);
		$enabled       = (int) $enabled_query->found_posts;

		return array(
			'all'      => $all,
			'enabled'  => $enabled,
			'disabled' => max( 0, $all - $enabled ),
		);
	}

	/**
	 * Serialize one preset post into the record shape shared by the admin
	 * screen, the REST API and exports.
	 *
	 * @since  1.2.2
	 * @param  WP_Post|int $post        Preset post or ID.
	 * @param  bool        $with_config Include the full field configuration.
	 * @return array|null Record, or null when the ID is not a preset.
	 */
	public static function to_record( $post, $with_config = false ) {
		$post = get_post( $post );
		if ( ! $post instanceof WP_Post || self::POST_TYPE !== $post->post_type ) {
			return null;
		}

		$fields = get_post_meta( $post->ID, self::META_CONFIG, true );
		$fields = is_array( $fields ) ? $fields : array();

		$fields_enabled = 0;
		foreach ( $fields as $field ) {
			if ( ! isset( $field['filter_enabled'] ) || 'yes' === $field['filter_enabled'] ) {
				++$fields_enabled;
			}
		}

		$record = array(
			'id'             => $post->ID,
			'title'          => $post->post_title,
			'enabled'        => ( 'yes' === get_post_meta( $post->ID, self::META_ENABLED, true ) ),
			'fields_total'   => count( $fields ),
			'fields_enabled' => $fields_enabled,
			'created'        => mysql_to_rfc3339( $post->post_date_gmt ),
			'modified'       => mysql_to_rfc3339( $post->post_modified_gmt ),
		);

		if ( $with_config ) {
			$record['config'] = $fields;
		}

		return $record;
	}

	/**
	 * Flip a preset's enabled flag. The moderation seam shared by the Stored
	 * Data screen and the REST controller.
	 *
	 * @since  1.2.2
	 * @param  int  $preset_id Preset post ID.
	 * @param  bool $enabled   Whether the preset should render to shoppers.
	 * @return bool False when the ID is not a preset.
	 */
	public static function set_enabled( $preset_id, $enabled ) {
		if ( self::POST_TYPE !== get_post_type( $preset_id ) ) {
			return false;
		}
		update_post_meta( absint( $preset_id ), self::META_ENABLED, $enabled ? 'yes' : 'no' );

		return true;
	}

	/**
	 * Delete a preset. Permanent, matching the preset builder's behaviour
	 * (the CPT registers no trash UI to restore from).
	 *
	 * @since  1.2.2
	 * @param  int $preset_id Preset post ID.
	 * @return bool False when the ID is not a preset or the delete failed.
	 */
	public static function delete( $preset_id ) {
		if ( self::POST_TYPE !== get_post_type( $preset_id ) ) {
			return false;
		}

		return (bool) wp_delete_post( absint( $preset_id ), true );
	}

	/**
	 * Build the export payload for a set of presets (or every preset).
	 *
	 * Full-store exports also carry the plugin's option groups, so one file
	 * attached to a support ticket reproduces the whole configuration.
	 *
	 * @since  1.2.2
	 * @param  int[]|null $ids Preset IDs to export, or null for all.
	 * @return array
	 */
	public static function export_payload( $ids = null ) {
		$args = array(
			'per_page' => self::MAX_PER_PAGE,
			'orderby'  => 'id',
		);

		if ( is_array( $ids ) ) {
			$args['include'] = $ids;
		}

		$records = array();
		$page    = 1;
		do {
			$args['page'] = $page;
			$query        = self::query( $args );
			foreach ( $query->posts as $post ) {
				$record = self::to_record( $post, true );
				if ( null !== $record ) {
					$records[] = $record;
				}
			}
			++$page;
		} while ( $page <= (int) $query->max_num_pages );

		$payload = array(
			'plugin'       => 'wb-ajax-filter',
			'version'      => defined( 'WB_AJAX_FILTER_VERSION' ) ? WB_AJAX_FILTER_VERSION : '',
			'generated_at' => gmdate( 'c' ),
			'presets'      => $records,
		);

		// A full export doubles as a support/config snapshot.
		if ( null === $ids ) {
			$payload['settings'] = array(
				'general'        => get_option( 'wb_ajax_filter_admin_general_options', array() ),
				'customization'  => get_option( 'wb_ajax_filter_admin_customization_options', array() ),
				'search'         => get_option( 'wb_ajax_filter_search_settings', array() ),
				'search_content' => get_option( 'wb_ajax_filter_search_content_settings', array() ),
			);
		}

		return $payload;
	}

	/**
	 * Flatten records into CSV rows (header row first).
	 *
	 * @since  1.2.2
	 * @param  array $records Records from to_record().
	 * @return array[] Rows of scalar cells.
	 */
	public static function to_csv_rows( $records ) {
		$rows = array(
			array( 'id', 'title', 'enabled', 'fields_enabled', 'fields_total', 'created', 'modified' ),
		);

		foreach ( $records as $record ) {
			$rows[] = array(
				$record['id'],
				$record['title'],
				$record['enabled'] ? 'yes' : 'no',
				$record['fields_enabled'],
				$record['fields_total'],
				$record['created'],
				$record['modified'],
			);
		}

		return $rows;
	}
}
