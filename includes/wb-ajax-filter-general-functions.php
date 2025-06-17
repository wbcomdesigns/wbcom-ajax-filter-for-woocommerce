<?php

/**
 * Function to retrieve parent term's child term count.
 * 
 * @param int $parent_term_id Parent term id.
 * @param string $taxonomy Taxonomy.
 * 
 * @return int $total Child terms count. 
 * 
 */
if( ! function_exists( 'get_taxonomy_child_terms_count' ) ) {
    
    function get_taxonomy_child_terms_count( $parent_term_id, $taxonomy ) {
	
        if( empty( $parent_term_id ) || empty( $taxonomy ) ) {
            return 0;
        }
        
        $child_ids = get_term_children($parent_term_id, $taxonomy);

        if (is_wp_error($child_ids) || empty($child_ids)) {
            return 0;
        }

        $child_terms = get_terms(array(
            'taxonomy'   => $taxonomy,
            'include'    => $child_ids,
            'hide_empty' => false,
        ));
        
        $total = 0;

        foreach ($child_terms as $term) {
            $total += $term->count;
        }

        return $total;
    }
}
