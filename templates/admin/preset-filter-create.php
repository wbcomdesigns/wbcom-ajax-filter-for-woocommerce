<div class="wb-ajax-filter-create-preset-section">
	<div class="wb-ajax-filter-create-preset-section-content">
		<span class="view-all-presets">
			<a href="<?php echo esc_url( site_url() ); ?>/wp-admin/admin.php?page=wb-ajax-filter-integration-settings&tab=wb-ajax-filter-presets">
				<?php esc_html_e( '< Back to presets list', 'wb-ajax-filter' ); ?>
			</a>
		</span>
		<h2><?php esc_html_e( 'Add new filter preset', 'wb-ajax-filter' ); ?></h2>
		<table>
			<tbody>
				<tr>
					<th><?php esc_html_e( 'Preset name', 'wb-ajax-filter' ); ?></th>
					<td><div class="yith-plugin-fw-field-wrapper yith-plugin-fw-text-field-wrapper">
							<input type="text" name="wb_ajax_filter_preset_title" value="">
						</div>
						<span class="description">
							<?php esc_html_e( 'Enter a name to identify this filter preset', 'wb-ajax-filter' ); ?>
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="preset-filters-wrapper">
			<h4>Filters of this preset</h4>
			<div class="preset-filters ui-sortable">
				<div>
					<p>
						<span class="strong">
							You don't have any filter yet.
						</span>
						<span>But don't worry, here you can create your first one!</span>
						<a class="wb-ajax-filter-add-button button-primary wb-add-new-filter" href="#">
							Add a new filter
						</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
