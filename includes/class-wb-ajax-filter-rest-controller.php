<?php
/**
 * REST controller for stored filter presets.
 *
 * The same records the Stored Data admin screen lists, exposed at
 * wb-ajax-filter/v1/presets for headless storefronts, mobile apps and
 * external integrations. Reads and writes both require a real capability
 * (manage_woocommerce) - the permission callback fails closed and is never
 * __return_true.
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
 * REST routes over Wb_Ajax_Filter_Presets.
 *
 * @since 1.2.2
 */
class Wb_Ajax_Filter_REST_Controller extends WP_REST_Controller {

	/**
	 * Set namespace and base.
	 */
	public function __construct() {
		$this->namespace = 'wb-ajax-filter/v1';
		$this->rest_base = 'presets';
	}

	/**
	 * Register the routes.
	 *
	 * @since 1.2.2
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base . '/(?P<id>[\d]+)',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'                => array(
						'id' => array(
							'description' => __( 'Preset ID.', 'wb-ajax-filter' ),
							'type'        => 'integer',
						),
					),
				),
				array(
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'update_item' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'                => array(
						'enabled' => array(
							'description' => __( 'Whether the preset renders to shoppers.', 'wb-ajax-filter' ),
							'type'        => 'boolean',
						),
						'title'   => array(
							'description'       => __( 'Preset title.', 'wb-ajax-filter' ),
							'type'              => 'string',
							'sanitize_callback' => 'sanitize_text_field',
						),
					),
				),
				array(
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'delete_item' ),
					'permission_callback' => array( $this, 'permissions_check' ),
				),
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);
	}

	/**
	 * Only store managers may read or moderate presets. Preset configuration
	 * names custom field keys and taxonomy structure, so it is store
	 * management data, not public catalogue data.
	 *
	 * @since  1.2.2
	 * @return true|WP_Error
	 */
	public function permissions_check() {
		if ( current_user_can( 'manage_woocommerce' ) ) {
			return true;
		}

		return new WP_Error(
			'rest_forbidden',
			__( 'You are not allowed to access filter presets.', 'wb-ajax-filter' ),
			array( 'status' => rest_authorization_required_code() )
		);
	}

	/**
	 * Resolve the id parameter to a preset post, or 404.
	 *
	 * @param  WP_REST_Request $request Request.
	 * @return WP_Post|WP_Error
	 */
	private function get_preset_or_error( $request ) {
		$post = get_post( absint( $request['id'] ) );

		if ( ! $post instanceof WP_Post || Wb_Ajax_Filter_Presets::POST_TYPE !== $post->post_type || 'publish' !== $post->post_status ) {
			return new WP_Error(
				'rest_preset_not_found',
				__( 'Filter preset not found.', 'wb-ajax-filter' ),
				array( 'status' => 404 )
			);
		}

		return $post;
	}

	/**
	 * GET /presets - a paginated page of records with total headers.
	 *
	 * @since  1.2.2
	 * @param  WP_REST_Request $request Request.
	 * @return WP_REST_Response
	 */
	public function get_items( $request ) {
		$query = Wb_Ajax_Filter_Presets::query(
			array(
				'page'     => $request['page'],
				'per_page' => $request['per_page'],
				'search'   => $request['search'],
				'status'   => $request['status'],
				'orderby'  => $request['orderby'],
				'order'    => $request['order'],
			)
		);

		$with_config = rest_sanitize_boolean( $request['with_config'] );

		$records = array();
		foreach ( $query->posts as $post ) {
			$record = Wb_Ajax_Filter_Presets::to_record( $post, $with_config );
			if ( null !== $record ) {
				$records[] = $record;
			}
		}

		$response = rest_ensure_response( $records );
		$response->header( 'X-WP-Total', (int) $query->found_posts );
		$response->header( 'X-WP-TotalPages', (int) $query->max_num_pages );

		return $response;
	}

	/**
	 * GET /presets/<id> - one record with its full field configuration.
	 *
	 * @since  1.2.2
	 * @param  WP_REST_Request $request Request.
	 * @return WP_REST_Response|WP_Error
	 */
	public function get_item( $request ) {
		$post = $this->get_preset_or_error( $request );
		if ( is_wp_error( $post ) ) {
			return $post;
		}

		return rest_ensure_response( Wb_Ajax_Filter_Presets::to_record( $post, true ) );
	}

	/**
	 * POST/PUT/PATCH /presets/<id> - moderate a record (enabled flag, title).
	 *
	 * @since  1.2.2
	 * @param  WP_REST_Request $request Request.
	 * @return WP_REST_Response|WP_Error
	 */
	public function update_item( $request ) {
		$post = $this->get_preset_or_error( $request );
		if ( is_wp_error( $post ) ) {
			return $post;
		}

		if ( null !== $request['enabled'] ) {
			Wb_Ajax_Filter_Presets::set_enabled( $post->ID, rest_sanitize_boolean( $request['enabled'] ) );
		}

		$title = trim( (string) $request['title'] );
		if ( '' !== $title && $title !== $post->post_title ) {
			$updated = wp_update_post(
				array(
					'ID'         => $post->ID,
					'post_title' => $title,
				),
				true
			);
			if ( is_wp_error( $updated ) ) {
				$updated->add_data( array( 'status' => 500 ) );
				return $updated;
			}
		}

		return rest_ensure_response( Wb_Ajax_Filter_Presets::to_record( $post->ID, true ) );
	}

	/**
	 * DELETE /presets/<id> - permanent, matching the admin surfaces.
	 *
	 * @since  1.2.2
	 * @param  WP_REST_Request $request Request.
	 * @return WP_REST_Response|WP_Error
	 */
	public function delete_item( $request ) {
		$post = $this->get_preset_or_error( $request );
		if ( is_wp_error( $post ) ) {
			return $post;
		}

		$record = Wb_Ajax_Filter_Presets::to_record( $post, true );

		if ( ! Wb_Ajax_Filter_Presets::delete( $post->ID ) ) {
			return new WP_Error(
				'rest_cannot_delete',
				__( 'The filter preset could not be deleted.', 'wb-ajax-filter' ),
				array( 'status' => 500 )
			);
		}

		return rest_ensure_response(
			array(
				'deleted'  => true,
				'previous' => $record,
			)
		);
	}

	/**
	 * Collection query parameters. Bounds mirror the shared preset seam:
	 * per_page tops out at Wb_Ajax_Filter_Presets::MAX_PER_PAGE.
	 *
	 * @since  1.2.2
	 * @return array
	 */
	public function get_collection_params() {
		return array(
			'page'        => array(
				'description'       => __( 'Page of the collection.', 'wb-ajax-filter' ),
				'type'              => 'integer',
				'default'           => 1,
				'minimum'           => 1,
				'sanitize_callback' => 'absint',
			),
			'per_page'    => array(
				'description'       => __( 'Records per page.', 'wb-ajax-filter' ),
				'type'              => 'integer',
				'default'           => 10,
				'minimum'           => 1,
				'maximum'           => Wb_Ajax_Filter_Presets::MAX_PER_PAGE,
				'sanitize_callback' => 'absint',
			),
			'search'      => array(
				'description'       => __( 'Restrict to presets whose title matches.', 'wb-ajax-filter' ),
				'type'              => 'string',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'status'      => array(
				'description' => __( 'Restrict by enabled state.', 'wb-ajax-filter' ),
				'type'        => 'string',
				'default'     => 'all',
				'enum'        => array( 'all', 'enabled', 'disabled' ),
			),
			'orderby'     => array(
				'description' => __( 'Sort field.', 'wb-ajax-filter' ),
				'type'        => 'string',
				'default'     => 'title',
				'enum'        => array( 'title', 'date', 'id' ),
			),
			'order'       => array(
				'description' => __( 'Sort direction.', 'wb-ajax-filter' ),
				'type'        => 'string',
				'default'     => 'asc',
				'enum'        => array( 'asc', 'desc' ),
			),
			'with_config' => array(
				'description' => __( 'Include each preset\'s full field configuration in list responses.', 'wb-ajax-filter' ),
				'type'        => 'boolean',
				'default'     => false,
			),
		);
	}

	/**
	 * The record schema, matching Wb_Ajax_Filter_Presets::to_record().
	 *
	 * @since  1.2.2
	 * @return array
	 */
	public function get_item_schema() {
		if ( $this->schema ) {
			return $this->add_additional_fields_schema( $this->schema );
		}

		$this->schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'wb_filter_preset',
			'type'       => 'object',
			'properties' => array(
				'id'             => array(
					'description' => __( 'Preset ID.', 'wb-ajax-filter' ),
					'type'        => 'integer',
					'readonly'    => true,
				),
				'title'          => array(
					'description' => __( 'Preset title.', 'wb-ajax-filter' ),
					'type'        => 'string',
				),
				'enabled'        => array(
					'description' => __( 'Whether the preset renders to shoppers.', 'wb-ajax-filter' ),
					'type'        => 'boolean',
				),
				'fields_total'   => array(
					'description' => __( 'Filter fields configured on the preset.', 'wb-ajax-filter' ),
					'type'        => 'integer',
					'readonly'    => true,
				),
				'fields_enabled' => array(
					'description' => __( 'Filter fields currently switched on.', 'wb-ajax-filter' ),
					'type'        => 'integer',
					'readonly'    => true,
				),
				'created'        => array(
					'description' => __( 'Creation time (RFC3339, UTC).', 'wb-ajax-filter' ),
					'type'        => 'string',
					'format'      => 'date-time',
					'readonly'    => true,
				),
				'modified'       => array(
					'description' => __( 'Last modification time (RFC3339, UTC).', 'wb-ajax-filter' ),
					'type'        => 'string',
					'format'      => 'date-time',
					'readonly'    => true,
				),
				'config'         => array(
					'description' => __( 'The full field configuration stored in _wb_filter.', 'wb-ajax-filter' ),
					'type'        => 'array',
					'readonly'    => true,
				),
			),
		);

		return $this->add_additional_fields_schema( $this->schema );
	}
}
