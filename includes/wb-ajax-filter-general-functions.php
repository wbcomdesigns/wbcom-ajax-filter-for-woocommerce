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

if ( ! function_exists( 'wb_ajax_filter_get_template' ) ) {

	/**
	 * Load a frontend template, letting the active theme override it.
	 *
	 * Resolution order:
	 * 1. Legacy flat override kept for themes that copied files before 1.2.2:
	 *    yourtheme/wb-ajax-filter/<legacy name>.php (e.g. filter-tax.php,
	 *    search-form.php - the flat names the old inline checks looked for).
	 * 2. wc_get_template(), so themes override at a path mirroring the plugin
	 *    tree: yourtheme/wb-ajax-filter/<template name> (e.g.
	 *    yourtheme/wb-ajax-filter/filters/filter-tax.php). This also makes the
	 *    templates visible to WooCommerce's template debug/system-status tools
	 *    and the woocommerce_locate_template filter.
	 * 3. The plugin's own templates/ directory.
	 *
	 * @param string $template_name Template path relative to templates/ (e.g. 'filters/filter-tax.php').
	 * @param array  $args          Variables to expose to the template.
	 * @param string $legacy_name   Optional pre-1.2.2 flat filename to honor from yourtheme/wb-ajax-filter/.
	 *
	 * @return void
	 */
	function wb_ajax_filter_get_template( $template_name, $args = array(), $legacy_name = '' ) {

		if ( '' !== $legacy_name ) {
			$legacy_template = get_stylesheet_directory() . '/wb-ajax-filter/' . $legacy_name;
			if ( file_exists( $legacy_template ) ) {
				if ( ! empty( $args ) && is_array( $args ) ) {
					extract( $args ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- template scope, mirrors wc_get_template().
				}
				include $legacy_template;
				return;
			}
		}

		if ( function_exists( 'wc_get_template' ) ) {
			wc_get_template( $template_name, $args, 'wb-ajax-filter/', WB_AJAX_FILTER_TEMPLATE_PATH );
			return;
		}

		// WooCommerce is a hard dependency, so this branch only runs if a template
		// is rendered before WooCommerce loads (or in isolated tooling).
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- template scope, mirrors wc_get_template().
		}
		include WB_AJAX_FILTER_TEMPLATE_PATH . $template_name;
	}
}

if ( ! function_exists( 'wb_ajax_filter_get_icon' ) ) {

	/**
	 * Return an inline SVG icon (Lucide set) for plugin UI.
	 *
	 * Inline SVG instead of Dashicons on purpose: WordPress does not enqueue the
	 * Dashicons font for logged-out visitors, so font icons render as blank
	 * squares for real shoppers. SVGs paint with currentColor, need no font, and
	 * flip correctly under RTL where directional (handled in CSS via rotation).
	 *
	 * @param string $icon        Icon key (chevron-down, chevron-up, chevron-right, arrow-left, x, rotate-ccw, plus, pencil, copy, trash).
	 * @param string $extra_class Additional classes for the svg element.
	 * @param int    $size        Rendered size in px (width and height).
	 *
	 * @return string SVG markup, or '' for an unknown key.
	 */
	function wb_ajax_filter_get_icon( $icon, $extra_class = '', $size = 16 ) {

		$paths = array(
			'chevron-down'  => '<path d="m6 9 6 6 6-6"/>',
			'chevron-up'    => '<path d="m18 15-6-6-6 6"/>',
			'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
			'arrow-left'    => '<path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>',
			'x'             => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
			'rotate-ccw'    => '<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/>',
			'plus'          => '<path d="M5 12h14"/><path d="M12 5v14"/>',
			'pencil'        => '<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>',
			'copy'          => '<rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>',
			'trash'         => '<path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/>',
		);

		if ( ! isset( $paths[ $icon ] ) ) {
			return '';
		}

		return sprintf(
			'<svg class="wb-icon wb-icon--%1$s%2$s" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="%3$d" height="%3$d" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%4$s</svg>',
			esc_attr( $icon ),
			'' !== $extra_class ? ' ' . esc_attr( $extra_class ) : '',
			(int) $size,
			$paths[ $icon ]
		);
	}
}

if ( ! function_exists( 'wb_ajax_filter_icon' ) ) {

	/**
	 * Echo an inline SVG icon. Template-facing wrapper around wb_ajax_filter_get_icon().
	 *
	 * @param string $icon        Icon key.
	 * @param string $extra_class Additional classes for the svg element.
	 * @param int    $size        Rendered size in px.
	 *
	 * @return void
	 */
	function wb_ajax_filter_icon( $icon, $extra_class = '', $size = 16 ) {
		echo wb_ajax_filter_get_icon( $icon, $extra_class, $size ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG assembled from a fixed internal map, classes escaped inside.
	}
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
