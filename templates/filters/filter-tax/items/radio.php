<div class="wb-ajax-filter filter-tax" id="filter_59_0" data-filter-type="tax" data-filter-id="0" data-taxonomy="product_cat" data-multiple="no" data-relation="and">
    <h4 class="filter-title"><?php esc_html( $filters['filter_title'] ); ?></h4>
    <div class="filter-content">	
        <ul class="filter-items filter-radio  level-0">
            <?php foreach ( $filter['terms'] as $tm ) {
                $term = get_term( $tm->id, $filters['taxonomy'] );
                ?>
            <li class="filter-item radio  level-0">
                <label>
                    <input type="radio" name="filter[<?php echo esc_html( $_REQUEST['preset'] ); ?>][<?php echo esc_html( $term_count ); ?>]" value="<?php echo esc_html( $term->slug ); ?>">
                    <a href="<?php echo site_url(); ?>?wb_ajax=1&product_cat    =<?php echo esc_html( $term->slug ); ?>" class="term-label tooltip-added" data-title="<?php echo esc_html( $term->name ); ?>"><?php echo esc_html( $term->name ); ?></a>
                </label>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>