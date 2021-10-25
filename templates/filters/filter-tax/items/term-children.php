<?php
/**
 * The template for term children for taxonomy filter.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/filters
 */
$list_child_style = ( 'collapsed' === $heirarchy ) ? 'display:none;' : '';
foreach ( $filters['terms'] as $child ) {
	if ( in_array( $child->id, $terms_added, true ) ) {
		continue;
	}
	$child_term_data = get_term( $child->id, $filters['taxonomy'] );
	if ( (int) $parent_id !== (int) $child_term_data->parent || 0 === (int) $child_term_data->parent ) {
		continue;
	}
	$ch_disabled      = ( 0 === $child_term_data->count ) ? 'disabled' : '';
	$child_item_class = ( 'no' === $heirarchy ) ? 'wb-ajax-level-0' : 'wb-ajax-level-1';
	if ( ( $hide_term && '' === $ch_disabled ) || ( ! $hide_term && '' === $ch_disabled ) || ( ! $hide_term && 'disabled' === $ch_disabled ) ) {
		?>
	<li class="filter-item <?php echo esc_attr( $filter_design ); ?> <?php echo esc_attr( $child_item_class ); ?>" data-child-of="<?php echo esc_attr( $term_data->slug ); ?>" style="<?php echo esc_attr( $list_child_style ); ?>">
		<label>
			<input type="<?php echo esc_attr( $filter_design ); ?>" name="<?php echo esc_attr( $filter_taxonomy ); ?>" class="wb-ajax-filter-selectible" value="<?php echo esc_attr( $child_term_data->slug ); ?>" data-filter="<?php echo esc_attr( $filter_taxonomy ); ?>" <?php echo esc_attr( $checked ); ?> <?php echo esc_attr( $ch_disabled ); ?>>
			<a href="<?php echo esc_attr( $base_url ); ?>?wb_ajax=1&<?php echo esc_attr( $filter_taxonomy . '=' . $child_term_data->slug ); ?>" class="wb-term-label wb-tooltip-added <?php echo ( 'checked' === $checked ) ? 'filter-active' : ''; ?> <?php echo esc_attr( $ch_disabled ); ?>" data-title="<?php echo esc_attr( $child_term_data->name ); ?>"><?php echo ( isset( $filters['terms_text'] ) && array_key_exists( 'label', $filters['terms_text'][ $child->id ] ) ) ? esc_html( $filters['terms_text'][ $child->id ]['label'] ) : esc_html( $child_term_data->name ); ?>
			<?php if ( isset( $filters['show_count'] ) && 'yes' === $filters['show_count'] ) : ?>
				<small class="item-count">(<?php echo esc_html( $child_term_data->count ); ?>)</small>
			<?php endif; ?>
			<span class="wb-ajax-filter-tooltip-text"><?php echo ( isset( $filters['terms_text'] ) && array_key_exists( 'tooltip', $filters['terms_text'][ $child->id ] ) ) ? esc_html( $filters['terms_text'][ $child->id ]['tooltip'] ) : esc_html( $child_term_data->name ); ?></span>
		</a>
		</label>
	</li>
		<?php
		$terms_added[] = $child->id;
	}
}
