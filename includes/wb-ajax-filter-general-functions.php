<?php
/**
 * General functions used across the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'get_taxonomy_child_terms_count' ) ) {

	/**
	 * Function to retrieve parent term's child term count.
	 *
	 * @param int    $parent_term_id Parent term id.
	 * @param string $taxonomy Taxonomy.
	 *
	 * @return int $total Child terms count.
	 */
	function get_taxonomy_child_terms_count( $parent_term_id, $taxonomy ) {

		if ( empty( $parent_term_id ) || empty( $taxonomy ) ) {
			return 0;
		}

		$child_ids = get_term_children( $parent_term_id, $taxonomy );

		if ( is_wp_error( $child_ids ) || empty( $child_ids ) ) {
			return 0;
		}

		$child_terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'include'    => $child_ids,
				'hide_empty' => false,
			)
		);

		$total = 0;

		foreach ( $child_terms as $term ) {
			$total += $term->count;
		}

		return $total;
	}
}

if ( ! function_exists( 'wb_ajax_filter_get_active_filter_label' ) ) {

	/**
	 * Resolve a URL filter value to a human-readable label for the active-filter chips.
	 *
	 * Taxonomy params carry term slugs from this plugin's own controls, but the same
	 * `filter_*` vocabulary is shared with WooCommerce core's layered nav, which puts
	 * term IDs in the URL - so both forms must resolve. Anything unresolvable falls
	 * back to the raw value (search text, custom-field values).
	 *
	 * @param string $filter_key URL parameter name (e.g. product_cat, filter_color).
	 * @param string $value      Raw URL parameter value (term slug or term ID).
	 *
	 * @return string Human-readable label.
	 */
	function wb_ajax_filter_get_active_filter_label( $filter_key, $value ) {

		$taxonomy = '';
		if ( 'product_cat' === $filter_key || 'product_tag' === $filter_key ) {
			$taxonomy = $filter_key;
		} elseif ( 0 === strpos( $filter_key, 'filter_' ) ) {
			$taxonomy = 'pa_' . substr( $filter_key, 7 );
		}

		if ( $taxonomy && taxonomy_exists( $taxonomy ) ) {
			$term = get_term_by( 'slug', $value, $taxonomy );
			if ( ! $term && is_numeric( $value ) ) {
				$term = get_term( (int) $value, $taxonomy );
			}
			if ( $term && ! is_wp_error( $term ) ) {
				return $term->name;
			}
		}

		return $value;
	}
}

if ( ! function_exists( 'wb_ajax_filter_get_active_chips' ) ) {

	/**
	 * Flatten the request params into the list of active-filter chips.
	 *
	 * Single source of truth for which params count as user-facing filters: the
	 * active-filters template renders from this, and the mobile toggle button
	 * shows count( this ).
	 *
	 * @param array $params Request parameters (already exploded on commas).
	 *
	 * @return array[] Each chip: array( 'filter' => key, 'value' => raw value, 'label' => display label ).
	 */
	function wb_ajax_filter_get_active_chips( $params ) {

		$chips           = array();
		$exclude_filters = array( 'preset', 'orderby', 'post_type', 'onsale_filter', 'instock_filter', 'min_price', 'max_price', 'rating_filter' );

		if ( empty( $params ) || ! is_array( $params ) ) {
			return $chips;
		}

		foreach ( $params as $key => $param ) {
			if ( empty( $param ) || in_array( $key, $exclude_filters, true ) ) {
				continue;
			}
			foreach ( (array) $param as $pm ) {
				if ( empty( $pm ) ) {
					continue;
				}
				$chips[] = array(
					'filter' => $key,
					'value'  => $pm,
					'label'  => wb_ajax_filter_get_active_filter_label( $key, $pm ),
				);
			}
		}

		return $chips;
	}
}
