<?php
/**
 * The template for filter design checkbox.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

$hide_term = ( isset( $wb_ajax_filter_general_options['hide_empty_terms'] ) && 'yes' === $wb_ajax_filter_general_options['hide_empty_terms'] ) ? true : false;
?>
<div class="wb-ajax-filter filter-tax">
	<ul class="filter-items filter-radio">
		<?php
		foreach ( $filters['terms'] as $tm ) {
			$term_data = get_term( $tm->id, $filters['taxonomy'] );
			$checked   = ( isset( $params[ $filter_taxonomy ] ) && in_array( $term_data->slug, (array) $params[ $filter_taxonomy ], true ) ) ? 'checked' : '';
			$disabled  = ( 0 === $term_data->count ) ? 'disabled' : '';
			if ( ( $hide_term && '' === $disabled ) || ( ! $hide_term && '' === $disabled ) || ( ! $hide_term && 'disabled' === $disabled ) ) {
				?>
			<li class="filter-item radio">
				<label>
					<input type="checkbox" name="<?php echo esc_attr( $filter_taxonomy . '_' . $tm->id ); ?>" class="wb-ajax-filter-selectible" value="<?php echo esc_attr( $term_data->slug ); ?>" data-filter="<?php echo esc_attr( $filter_taxonomy ); ?>" <?php echo esc_attr( $checked ); ?> <?php echo esc_attr( $disabled ); ?>>
					<a href="<?php echo esc_attr( $base_url ); ?>?wb_ajax=1&<?php echo esc_attr( $filter_taxonomy . '=' . $term_data->slug ); ?>" class="wb-term-label wb-tooltip-added <?php echo ( 'checked' === $checked ) ? 'filter-active' : ''; ?> <?php echo esc_attr( $disabled ); ?>" data-title="<?php echo esc_attr( $term_data->name ); ?>"><?php echo ( isset( $filters['terms_text'] ) && array_key_exists( 'label', $filters['terms_text'][ $tm->id ] ) ) ? esc_html( $filters['terms_text'][ $tm->id ]['label'] ) : esc_html( $term_data->name ); ?>
						<span class="wb-ajax-filter-tooltip-text"><?php echo ( isset( $filters['terms_text'] ) && array_key_exists( 'tooltip', $filters['terms_text'][ $tm->id ] ) ) ? esc_html( $filters['terms_text'][ $tm->id ]['tooltip'] ) : esc_html( $term_data->name ); ?></span>
					</a>
				</label>
			</li>
				<?php
			}
		}
		?>
	</ul>
</div>

