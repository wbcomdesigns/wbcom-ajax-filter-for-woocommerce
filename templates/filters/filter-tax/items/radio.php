<?php
/**
 * The template for filter design radio.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

$hide_term     = ( isset( $wb_ajax_filter_general_options['hide_empty_terms'] ) && 'yes' === $wb_ajax_filter_general_options['hide_empty_terms'] ) ? true : false;
$heirarchy     = ( isset( $filters['hierarchical'] ) ) ? $filters['hierarchical'] : false;
$filter_design = 'radio';

?>
<div class="wb-ajax-filter filter-tax">
	<ul class="filter-items filter-radio ">
		<?php
		$hide_term   = ( isset( $filters['adoptive'] ) && 'hide' === $filters['adoptive'] ) ? true : false;
		$terms_added = array();
		foreach ( $filters['terms'] as $term ) {
			if ( in_array( $term->id, $terms_added, true ) ) {
				continue;
			}
			$term_data     = get_term( $term->id, $filters['taxonomy'] );
			$parent_exists = ( 0 !== $term_data->parent ) ? Wb_Ajax_Filter_Public::wb_ajax_check_parent_is_included( $term_data->parent, $filters['terms'] ) : false;
			if ( $parent_exists ) {
				continue;
			}
			$checked            = ( isset( $params[ $filter_taxonomy ] ) && in_array( $term_data->slug, (array) $params[ $filter_taxonomy ], true ) ) ? 'checked' : '';
			
			$filter_item_class  = ( 0 === $term_data->parent || 'no' === $heirarchy ) ? 'wb-ajax-level-0' : '';
			$filter_item_class .= ( 'collapsed' === $heirarchy ) ? ' wb-ajax-heirarchy-collapsible closed' : '';
			$filter_item_class .= ( 'expanded' === $heirarchy ) ? ' wb-ajax-heirarchy-collapsible opened' : '';

			$count_child_terms = get_taxonomy_child_terms_count( $term->id, $filters['taxonomy'] );
			$count_child_terms = $count_child_terms + $term_data->count;
			
			$disabled          = ( 0 === $count_child_terms ) ? 'disabled' : '';

			if ( ( $hide_term && '' === $disabled ) || ( ! $hide_term && '' === $disabled ) || ( ! $hide_term && 'disabled' === $disabled ) ) {
				?>
				<li class="filter-item radio <?php echo esc_attr( $filter_item_class ); ?>" data-parent="<?php echo esc_attr( $term_data->slug ); ?>">
					<label>
						<input type="radio" name="<?php echo esc_attr( $filter_taxonomy ); ?>" class="wb-ajax-filter-selectible" value="<?php echo esc_attr( $term_data->slug ); ?>" data-filter="<?php echo esc_attr( $filter_taxonomy ); ?>" <?php echo esc_attr( $checked ); ?> <?php echo esc_attr( $disabled ); ?>>
						<?php
						$wb_ajax_terms_text = isset( $filters['terms_text'] ) && array_key_exists( 'label', $filters['terms_text'][ $term->id ] ) ? $filters['terms_text'][ $term->id ]['label'] : $term_data->name;
						?>
						<a href="<?php echo esc_attr( $base_url ); ?>?wb_ajax=1&<?php echo esc_attr( $filter_taxonomy . '=' . $term_data->slug ); ?>" class="wb-term-label wb-tooltip-added <?php echo ( 'checked' === $checked ) ? 'filter-active' : ''; ?> <?php echo esc_attr( $disabled ); ?>" data-title="<?php echo esc_attr( $term_data->name ); ?>"><?php echo esc_html( $wb_ajax_terms_text ); ?>
							<?php if ( isset( $filters['show_count'] ) && 'yes' === $filters['show_count'] ) : ?>
								<small class="item-count">(<?php echo esc_html( $count_child_terms ); ?>)</small>
							<?php endif; ?>
							<?php
							$wb_filter_term_text = isset( $filters['terms_text'] ) && array_key_exists( 'tooltip', $filters['terms_text'][ $term->id ] ) ? $filters['terms_text'][ $term->id ]['tooltip'] : $term_data->name;
							?>
							<span class="wb-ajax-filter-tooltip-text"><?php echo esc_attr( $wb_filter_term_text ); ?></span>

						</a>
					</label>
					<?php if ( 'open' !== $heirarchy ) : ?>
						<?php if ( 'collapsed' === $heirarchy ) : ?>
							<span class="dashicons dashicons-arrow-right-alt2"></span>
						<?php elseif ( 'expanded' === $heirarchy ) : ?>
							<span class="dashicons dashicons-arrow-down-alt2"></span>
						<?php endif; ?>
					<?php endif; ?>
				</li>
				<?php
				$terms_added[] = $term->id;
			}
			if ( 0 === $term_data->parent && 'parents_only' !== $heirarchy ) {
				$parent_id = $term->id;
				require 'term-children.php';
			}
		}
		?>
	</ul>
</div>
