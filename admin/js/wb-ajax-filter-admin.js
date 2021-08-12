(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function ($){
		// Show/hide fields according to filter for values
		function hideToggleElements(showClass){
			jQuery('.wb-ajax-filter-toggle-content-row').each(function () {
				if (!jQuery(this).hasClass('wb-show-style-toggle')) {
					jQuery(this).show();
				}
			});
			jQuery('.wb-ajax-filter-toggle-content-row').each(function(){
				if (!jQuery(this).hasClass('wb-all-toggle') && !jQuery(this).hasClass('wb-' + showClass + '-toggle') && !jQuery(this).hasClass('wb-show-style-toggle')) {
					jQuery(this).hide();
				}
			});
		}

		function afterAjaxResponse(){
			// multiple select with AJAX search
			$('#wb_ajax_filter_select2_terms').select2({
				ajax: {
					url: wbcom_plugin_installer_params.ajax_url,
					dataType: 'json',
					delay: 250,
					data: function (params) {
						return {
							q: params.term,
							action: 'select2_get_terms_wb',
							nonce: wbcom_plugin_installer_params.wbcom_ajax_nonce,
							cat: $('select[name="filters[taxonomy]"]').val()
						};
					},
					processResults: function (data) {
						var options = [];
						if (data) {
							$.each(data, function (index, text) {
								options.push({ id: text[0], text: text[1] });
							});
						}
						return {
							results: options
						};
					},
					cache: true
				},
				minimumInputLength: 1
			});

			// Enable taxonomy fields on form load.
			hideToggleElements('tax'); 

			// Show/hide toggle style on form load.
			if (jQuery('input[name="filters[show_toggle]"]').is(':checked')) {
				jQuery('.wb-show-style-toggle').show();
			} else {
				jQuery('.wb-show-style-toggle').hide();
			}
			
		} // End after AJAX response

		function afterFormSubmit(method) {
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			var queryString = jQuery('#filter-preset-create').serializeArray();
			jQuery.ajax({
				url: wbcom_plugin_installer_params.ajax_url,
				type: 'post',
				data: { action: 'create_filter_preset_wb', 'nonce': nonce, 'form_data': queryString, 'method': method },
				success: function (response) {
					if ('filter_created' === response) {
						location.reload();
					}
				}
			});
		} // End after Form submit

		// Change form fields according to the selected filter for value.
		jQuery('.wb-ajax-filter-modal-content').on('change', 'select[name="filters[type]"]', function () {
			let filterFor = jQuery(this).val();
			if (filterFor.indexOf('_') > -1) {
				filterFor = filterFor.replace("_", "-");
			}
			hideToggleElements(filterFor);
		});

		// Check if the Filter preset title already exists
		jQuery('input[name="wb_ajax_filter_preset_title"]').keyup(function () {
			let postTitle = jQuery(this).val();
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			if (postTitle !== '' || postTitle !== undefined ){
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'check_filter_preset_title_wb', 'nonce': nonce, 'title': postTitle },
					success: function (response) {
						if ( 'exists' === response ) {
							alert('Filter title already exists.');
							jQuery('input[name="wb_ajax_filter_preset_title"]').val('');
						}
					}
				});
			}
		});

		// Remove add price range field
		jQuery('.wb-ajax-filter-modal-content').on('click', '.wb-ajax-filter-range-remove', function () {
			jQuery(this).parent().remove();
			jQuery('.wb-ajax-filter-range-box').each(function () {
				jQuery(this).find('.unlimited').hide();
			});
			let newCount = jQuery('.wb-ajax-filter-ranges-wrapper').children().length;
			$('.wb-ajax-filter-ranges-wrapper').attr('data-index', newCount);
			jQuery('.wb-ajax-filter-range-box').each(function (index, element) {
				if (newCount === index + 1) {
					jQuery(this).find('.unlimited').show();
				}
			});
		});

		// Add price range field
		jQuery('.wb-ajax-filter-add-price-range').on('click', function (e) {
			e.preventDefault();
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			var count = $(".wb-ajax-filter-ranges-wrapper").children().length;
			jQuery.ajax({
				url: wbcom_plugin_installer_params.ajax_url,
				type: 'post',
				data: { action: 'add_price_range_field_wb', 'nonce': nonce, 'count': count },
				success: function (response) {
					jQuery('.wb-ajax-filter-ranges-wrapper').append(JSON.parse(response));
					let newCount = jQuery('.wb-ajax-filter-ranges-wrapper').children().length;
					$('.wb-ajax-filter-ranges-wrapper').attr('data-index', newCount);
					jQuery('.wb-ajax-filter-range-box').each(function () {
						jQuery(this).find('.unlimited').hide();
					});
					jQuery('.wb-ajax-filter-range-box').each(function (index, element) {
						if (newCount === index + 1) {
							jQuery(this).find('.unlimited').show();
						}
					});
				}
			});
		});

		// Click to copy shortcode to clipboard
		jQuery('.text-to-copy').click(function () {
			jQuery(this).select();
			document.execCommand("copy");
			alert('Short copied to clipboard');
		});

		// Create a duplicate of the preset
		jQuery('a.wb-copy-filter-preset').on('click', function(){
			var copy = confirm("Do you want to create a copy of this preset?");
			if ( copy == true ) {
				let preset = jQuery(this).data('preset');
				let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'duplicate_filter_preset_wb', 'nonce': nonce, 'preset': preset },
					success: function (response) {
						if ( 'copy_created' == response ) {
							location.reload();
						}
					}
				});
			}
		});

		// Show/hide toggle style on change.
		jQuery('.wb-ajax-filter-modal-content').on('change', 'input[name="filters[show_toggle]"]', function () {
			if (jQuery(this).is(':checked')) {
				jQuery('.wb-show-style-toggle').show();
			} else {
				jQuery('.wb-show-style-toggle').hide();
			}
		});

		// Enable/Disable filter preset
		jQuery('.preset-active-status').on( 'change', function(){
			let preset = jQuery(this).parent().data('preset');
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			if( jQuery(this).is(':checked') ){
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'enable_disable_filter_preset_wb', 'nonce': nonce, 'preset': preset, 'enabled': 'yes' },
					success: function (response) {
						
					}
				});
			} else {
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'enable_disable_filter_preset_wb', 'nonce': nonce, 'preset': preset, 'enabled': 'no' },
					success: function (response) {
						
					}
				});
			}
		});

		// Delete a filter preset
		jQuery('a.wb-delete-filter-preset').on('click', function () {
			var copy = confirm("Are you sure you want to delete this preset?");
			if (copy == true) {
				let preset = jQuery(this).data('preset');
				let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'delete_filter_preset_wb', 'nonce': nonce, 'preset': preset },
					success: function (response) {
						if ('preset_deleted' == response) {
							location.reload();
						}
					}
				});
			}
		});

		// Load create filter modal template
		jQuery('.wb-ajax-filter-add-button').on('click', function(e){
			e.preventDefault();
			var title = jQuery('input[name="wb_ajax_filter_preset_title"]').val();
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			jQuery.ajax({
				url: wbcom_plugin_installer_params.ajax_url,
				type : 'post',
				data: { action: 'load_create_filter_template_wb', 'nonce': nonce, 'title': title },
				success: function (response) {
					jQuery('.wb-ajax-filter-modal-content').html( JSON.parse( response ) );
					jQuery('.wb-ajax-filter-modal-container').css({
						'opacity' : 1,
						'z-index' : 999999
					});
					afterAjaxResponse();
				}
   			});
		});

		// Close create filter modal template
		jQuery('.wb-ajax-filter-modal-body').on('click', '.wb-ajax-filter-close-modal', function(){
			jQuery('.wb-ajax-filter-modal-container').css({
				'opacity': 0,
				'z-index': -199
			});
		});

		// Save new filter preset on create page
		jQuery('.wb-ajax-filter-modal-content').on('click', '#wb-ajax-filer-create-filter-save', function (e) {
			e.preventDefault();
			jQuery('#filter-preset-create').trigger('submit');
		});

		// Create new filter preset aftre
		jQuery('.wb-ajax-filter-modal-content').on('submit', '#filter-preset-create', function (e) {
			e.preventDefault();
			afterFormSubmit('add');
		});

	});

})( jQuery );
