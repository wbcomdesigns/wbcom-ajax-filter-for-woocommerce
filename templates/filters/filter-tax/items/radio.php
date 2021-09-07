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
		foreach ( $filters['terms'] as $tm ) {
			if ( in_array( $tm->id, $terms_added, true ) ) {
				continue;
			}
			$term_data     = get_term( $tm->id, $filters['taxonomy'] );
			$parent_exists = ( 0 !== $term_data->parent ) ? Wb_Ajax_Filter_Public::wb_ajax_check_parent_is_included( $term_data->parent, $filters['terms'] ) : false;
			if ( $parent_exists ) {
				continue;
			}
			$checked            = ( isset( $params[ $filter_taxonomy ] ) && in_array( $term_data->slug, (array) $params[ $filter_taxonomy ], true ) ) ? 'checked' : '';
			$disabled           = ( 0 === $term_data->count ) ? 'disabled' : '';
			$filter_item_class  = ( 0 === $term_data->parent || 'no' === $heirarchy ) ? 'wb-ajax-level-0' : '';
			$filter_item_class .= ( 'collapsed' === $heirarchy ) ? ' wb-ajax-heirarchy-collapsible closed' : '';
			$filter_item_class .= ( 'expanded' === $heirarchy ) ? ' wb-ajax-heirarchy-collapsible opened' : '';
			if ( ( $hide_term && '' === $disabled ) || ( ! $hide_term && '' === $disabled ) || ( ! $hide_term && 'disabled' === $disabled ) ) {
				?>
				<li class="filter-item radio <?php echo esc_attr( $filter_item_class ); ?>" data-parent="<?php echo esc_attr( $term_data->slug ); ?>">
					<label>
						<input type="radio" name="<?php echo esc_attr( $filter_taxonomy ); ?>" class="wb-ajax-filter-selectible" value="<?php echo esc_attr( $term_data->slug ); ?>" data-filter="<?php echo esc_attr( $filter_taxonomy ); ?>" <?php echo esc_attr( $checked ); ?> <?php echo esc_attr( $disabled ); ?>>
						<a href="<?php echo esc_attr( $base_url ); ?>?wb_ajax=1&<?php echo esc_attr( $filter_taxonomy . '=' . $term_data->slug ); ?>" class="wb-term-label wb-tooltip-added <?php echo ( 'checked' === $checked ) ? 'filter-active' : ''; ?> <?php echo esc_attr( $disabled ); ?>" data-title="<?php echo esc_attr( $term_data->name ); ?>"><?php echo ( isset( $filters['terms_text'] ) && array_key_exists( 'label', $filters['terms_text'][ $tm->id ] ) ) ? esc_html( $filters['terms_text'][ $tm->id ]['label'] ) : esc_html( $term_data->name ); ?>
							<span class="wb-ajax-filter-tooltip-text"><?php echo ( isset( $filters['terms_text'] ) && array_key_exists( 'tooltip', $filters['terms_text'][ $tm->id ] ) ) ? esc_html( $filters['terms_text'][ $tm->id ]['tooltip'] ) : esc_html( $term_data->name ); ?></span>
							<?php if ( isset( $filters['show_count'] ) && 'yes' === $filters['show_count'] ) : ?>
								<small class="item-count">(<?php echo esc_html( $term_data->count ); ?>)</small>
							<?php endif; ?>
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
				$terms_added[] = $tm->id;
			}
			if ( 0 === $term_data->parent && 'parents_only' !== $heirarchy ) {
				$parent_id = $tm->id;
				require 'term-children.php';
			}
		}
		?>
	</ul>
</div>
