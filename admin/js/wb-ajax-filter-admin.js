(function ($) {
	'use strict';

	/**
	 * All of the code for admin-facing JavaScript source
	 * resides in this file.
	 */

	jQuery(document).ready(function ($) {
		// get url fields
		var url_string = window.location.href
		var urlHost = location.protocol + '//' + location.host + location.pathname;
		let urlAdmin = new URL(url_string);
		let params = new URLSearchParams(urlAdmin.search);

		// Remove field from url
		function removeField(param) {
			return params.delete(param)
		}

		// Check url for filter
		function checkFieldValues(param) {
			return params.has(param)
		}

		// Set parameters in url
		function setFieldValue(param, value) {
			if (checkFieldValues(param)) {
				removeField(param);
			}
			params.set(param, value);
		}

		// Preset single filters sort
		if (jQuery(".wb-ajax-filters-single-container .wb-ajax-filter-toggle-row").length > 1) {
			jQuery(".wb-ajax-filters-single-container").sortable({
				scrollSpeed: 1,
				scrollSensitivity: 1,
				update: function (event, ui) {
					let elem = ui.item[0];
					let elemMovedIndex = elem.getAttribute("data-item_key");
					jQuery('.wb-ajax-filters-single-container').find('.wb-ajax-filter-toggle-row').each(function (index, elm) {
						let oldIndex = jQuery(this).data('item_key');
						let preset = jQuery(this).data('preset');
						if (elemMovedIndex == oldIndex && preset != "") {
							let newIndex = index;
							let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
							jQuery.ajax({
								url: wbcom_plugin_installer_params.ajax_url,
								type: 'post',
								data: { action: 'sortable_single_filters_wb', 'nonce': nonce, 'preset': preset, 'old_index': oldIndex, 'new_index': newIndex },
								success: function (response) {
									location.reload();
								}
							});
						}
					});
				}
			});
		}
		
		
		jQuery(".wb-ajax-color-picker").wpColorPicker();
		var url_string = window.location.href
		var url = new URL( url_string );
		var urlAction = url.searchParams.get( "action" );
		var urlSubAction = url.searchParams.get( "wb" );
		var urlTab = url.searchParams.get( "tab" ) ? url.searchParams.get( "tab" ) : false;
		if (urlTab && urlTab === 'wb-ajax-filter-customization' ) {
			searchOutputTab();
		}
		if (urlTab && urlTab === 'wb-ajax-filter-search') {
			jQuery('#wb_ajax_check_custom_field_option').select2({
				ajax: {
					url: wbcom_plugin_installer_params.ajax_url,
					dataType: 'json',
					delay: 250,
					data: function (params) {
						return {
							q: params.term,
							action: 'check_custom_field_exists_wb',
							nonce: wbcom_plugin_installer_params.wbcom_ajax_nonce,
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
		}

		// Check if user is on edit filter page
		if ( 'edit' === urlAction && 'update' === urlSubAction ){

			// Initialize select2
			initializeSelect2();

			// Get all pre selected values
			let terms = jQuery( '#wb_ajax_filter_select2_terms' ).data( 'selected_terms' );
			let orderBy = jQuery( '.wb-filter-type-orderby' ).data( 'selected_orders' );
			if( terms !== '' ){
				terms.forEach(function ( elem ) {
					var option = new Option( elem.text, elem.id, true, true );
					// Add all preselected values and mark as selected.
					jQuery( '#wb_ajax_filter_select2_terms' ).append( option );
				});
				jQuery( '#wb_ajax_filter_select2_terms' ).trigger( 'change' );
			}
			if ( orderBy !== '' ) {
				jQuery( '.wb-filter-type-orderby' ).val( orderBy );
				jQuery( '.wb-filter-type-orderby' ).trigger( 'change' );
			}
		}

		function searchOutputTab () {
			jQuery( '#wb_upload_gif' ).on( 'click', function( e ) {
				e.preventDefault();
				var frame;
				if ( frame ) {
					frame.open();
					return;
				}
				// Create new Media upload window
				frame = wp.media({
					title: 'Select or Upload Media',
					button: {
						text: 'Use this media'
					},
					library: {
						type: 'image/gif' // Display only gif file in library.
					},
					uploader: {
						type: 'image/gif' // Allow only gif file in upload.
					},
					multiple: false
				});

				frame.on( 'select', function () {
					var attachment = frame.state().get( 'selection' ).first().toJSON();
					if ( attachment.type === 'image' && attachment.subtype === 'gif' ){
						jQuery( '.gif-container' ).html( '<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>' );
						jQuery( 'input[name="wb_ajax_filter_admin_customization_options[loader_attachment_id]"]' ).val( attachment.id );
						jQuery( 'input[name="wb_ajax_filter_admin_customization_options[loader_url]"]' ).val( attachment.url );
					}
				});
				frame.open();
			});
			jQuery( '#wb_reset_upload_gif' ).on( 'click', function( e ){
				e.preventDefault();
				jQuery( this ).parent().siblings( '.gif-container' ).html( '' );
				jQuery( 'input[name="wb_ajax_filter_admin_customization_options[loader_attachment_id]"]' ).val( '' );
				jQuery( 'input[name="wb_ajax_filter_admin_customization_options[loader_url]"]' ).val( '' );
			});
			jQuery('input[name="wb_ajax_filter_admin_customization_options[ajax_loader_style]"]').on('change', function(){
				if( jQuery(this).val() == 'custom' ){
					jQuery(this).closest('tr').next('tr').show();
				} else {
					jQuery(this).closest('tr').next('tr').hide();
					jQuery('#wb_reset_upload_gif').trigger('click');
				}
			});
		}

		// Show/hide fields according to filter for values
		function hideToggleElements( showClass ) {
			jQuery( '.wb-ajax-filter-toggle-content-row' ).each( function () {
				if ( !jQuery( this ).hasClass( 'wb-show-style-toggle' ) ) {
					jQuery( this ).show();
				}
			});
			jQuery( '.wb-ajax-filter-toggle-content-row' ).each( function () {
				if ( !jQuery( this ).hasClass( 'wb-all-toggle' ) && !jQuery( this ).hasClass( 'wb-' + showClass + '-toggle' ) && !jQuery( this ).hasClass( 'wb-show-style-toggle' ) ) {
					jQuery( this ).hide();
				}
			});
			jQuery( '.wb-input' ).each( function () {
				if ( !jQuery( this ).hasClass( 'wb-filter-type-' + showClass ) ) {
					let tag = jQuery( this ).prop( "tagName" ).toLowerCase();
					let type = jQuery( this ).attr( "type" );
					if ( 'select' === tag ) {
						jQuery( this ).val( '' );
					} else {
						if ( 'checkbox' === type || 'radio' === type ) {
							jQuery( this ).attr( 'checked', false );
						} else {
							jQuery( this ).val( '' );
						}
					}
				}
			});
		}

		// Initializes select2 on selected element.
		function initializeSelect2(){
			jQuery( '.wb-filter-type-orderby' ).select2();
			jQuery( '#wb_ajax_filter_select2_terms' ).select2({
				ajax: {
					url: wbcom_plugin_installer_params.ajax_url,
					dataType: 'json',
					delay: 250,
					data: function ( params ) {
						return {
							q: params.term,
							action: 'select2_get_terms_wb',
							nonce: wbcom_plugin_installer_params.wbcom_ajax_nonce,
							cat: jQuery( 'select[name="filters[taxonomy]"]' ).val()
						};
					},
					processResults: function ( data ) {
						var options = [];
						if ( jQuery( 'select[name="filters[taxonomy]"]' ).val() === '' ){
							alert( 'Please select taxonomy' );
						}
						if ( data ) {
							$.each( data, function ( index, text ) {
								options.push( { id: text[0], text: text[1] } );
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

			jQuery( '#wb_ajax_filter_select2_terms' ).on( 'select2:select', function ( e ) {
				var data = e.params.data;
				let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'customize_term_text_wb', 'nonce': nonce, 'id': data.id, 'text': data.text },
					success: function ( response ) {
						jQuery( '.wb-tax-toggle' ).find( '.terms-wrapper' ).append( JSON.parse( response ) );
					}
				});
			});

			jQuery( '#wb_ajax_filter_select2_terms' ).on( 'select2:unselect', function ( e ) {
				var data = e.params.data;
				jQuery( '.terms-wrapper #wb_term_' + data.id ).remove();
			});
		}

		function afterAjaxResponse() {
			// Multiple select for terms with AJAX search
			initializeSelect2();

			// Enable taxonomy fields on form load.
			hideToggleElements( 'tax' );

			// Show/hide toggle style on form load.
			if ( jQuery('input[name="filters[show_toggle]"]' ).is( ':checked' ) ) {
				jQuery( '.wb-show-style-toggle' ).show();
			} else {
				jQuery( '.wb-show-style-toggle' ).hide();
			}
		}

		function afterFormSubmit() {
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			var queryString = jQuery( '#filter-preset-create' ).serializeArray();
			jQuery.ajax({
				url: wbcom_plugin_installer_params.ajax_url,
				type: 'post',
				data: { action: 'create_filter_preset_wb', 'nonce': nonce, 'form_data': queryString },
				success: function ( response ) {
					if ( 'filter_created' === response ) {
						window.location.search ='page=wc-ajax-filter-settings&tab=wb-ajax-filter-presets';
					}
					if ('filter_edited' === response) {
						setFieldValue('wb', 'list');
						location.search = params.toString();
					}
				}
			});
		}

		// Change form fields according to the selected filter for value.
		jQuery( '.wb-ajax-filter-modal-content' ).on( 'change', 'select[name="filters[type]"]', function () {
			let filterFor = jQuery( this ).val();
			if ( filterFor.indexOf('_') > -1 ) {
				filterFor = filterFor.replace( "_", "-" );
			}
			hideToggleElements( filterFor );
		});

		jQuery('input[name="wb_ajax_filter_admin_general_options[show_reset]"]').on('change', function () {
			if (jQuery(this).is(':checked')) {
				jQuery(this).closest('tr').next('tr').show();
			} else {
				jQuery(this).closest('tr').next('tr').hide();
			}
		});

		jQuery('input[name="filters[multiple]"]').on('change', function () {
			if ( jQuery( this ).is( ':checked' ) ) {
				jQuery( this ).closest( '.wb-ajax-filter-toggle-content-row' ).next( '.wb-ajax-filter-toggle-content-row' ).show();
			} else {
				jQuery( this ).closest( '.wb-ajax-filter-toggle-content-row' ).next( '.wb-ajax-filter-toggle-content-row' ).hide();
			}
		});

		jQuery( '.wb-ajax-filter-modal-content' ).on( 'change', '.wb-filter-type-price-range-unlimited', function () {
			if ( jQuery( this ).is( ':checked' ) ) {
				jQuery( this ).closest( '.unlimited' ).next( 'p' ).hide();
				jQuery( this ).closest( '.unlimited' ).next( 'p' ).find( '.wb-input' ).val( '' );
			} else {
				jQuery( this ).closest( '.unlimited' ).next( 'p' ).show();
			}
		});

		// Check if the Filter preset title already exists
		jQuery( 'input[name="wb_ajax_filter_preset_title"]' ).keyup( function () {
			let postTitle = jQuery( this ).val();
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			if ( postTitle !== '' || postTitle !== undefined ) {
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'check_filter_preset_title_wb', 'nonce': nonce, 'title': postTitle },
					success: function ( response ) {
						if ( 'exists' === response ) {
							alert( 'Name already exists.' );
							jQuery( 'input[name="wb_ajax_filter_preset_title"]' ).val('');
						}
					}
				});
			}
		});

		// Remove add price range field
		jQuery( '.wb-ajax-filter-modal-content' ).on( 'click', '.wb-ajax-filter-range-remove', function ( e ) {
			e.preventDefault();
			jQuery( this ).parent().remove();
			jQuery( '.wb-ajax-filter-range-box' ).each( function () {
				jQuery( this ).find( '.unlimited' ).hide();
			});
			let newCount = jQuery( '.wb-ajax-filter-ranges-wrapper' ).children().length;
			jQuery( '.wb-ajax-filter-ranges-wrapper' ).attr( 'data-index', newCount );
			jQuery( '.wb-ajax-filter-range-box' ).each( function ( index, element ) {
				if ( newCount === index + 1 ) {
					jQuery( this ).find( '.unlimited' ).show();
				}
			});
		});

		// Add price range field
		jQuery( '.wb-ajax-filter-modal-content' ).on( 'click', '.wb-ajax-filter-add-price-range', function ( e ) {
			e.preventDefault();
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			var count = jQuery( ".wb-ajax-filter-ranges-wrapper" ).children().length;
			jQuery.ajax({
				url: wbcom_plugin_installer_params.ajax_url,
				type: 'post',
				data: { action: 'add_price_range_field_wb', 'nonce': nonce, 'count': count },
				success: function ( response ) {
					jQuery( '.wb-ajax-filter-ranges-wrapper' ).append( JSON.parse( response ) );
					let newCount = jQuery( '.wb-ajax-filter-ranges-wrapper' ).children().length;
					jQuery( '.wb-ajax-filter-ranges-wrapper' ).attr( 'data-index', newCount );
					jQuery( '.wb-ajax-filter-range-box' ).each( function () {
						jQuery( this ).find( '.unlimited' ).hide();
						jQuery(this).find('.unlimited').find('.wb-filter-type-price-range-unlimited').prop('checked', false);
						jQuery( this ).find( '.max' ).show();
					});
					jQuery( '.wb-ajax-filter-range-box' ).each( function ( index, element ) {
						if ( newCount === index + 1 ) {
							jQuery( this ).find( '.unlimited' ).show();
						}
					});
				}
			});
		});

		// Click to copy shortcode to clipboard
		jQuery( '.text-to-copy' ).click(function () {
			jQuery( this ).select();
			document.execCommand( 'copy' );
			jQuery( this ).siblings( '.wb-shortcode-copy' ).css( {
				'opacity': 1
			});
			setTimeout( function () {
				jQuery( '.wb-shortcode-copy' ).css( {
					'opacity': 0
				});
			}, 1000);
		});

		// Show/hide toggle style on change.
		jQuery( '.wb-ajax-filter-modal-content' ).on( 'change', 'input[name="filters[show_toggle]"]', function () {
			if ( jQuery( this ).is( ':checked' ) ) {
				jQuery( '.wb-show-style-toggle' ).show();
			} else {
				jQuery( '.wb-show-style-toggle' ).hide();
			}
		});

		// Show/hide choose terms on change.
		jQuery('.wb-ajax-filter-modal-content').on('change', 'select[name="filters[taxonomy]"]', function () {
			if ( jQuery(this).val() != '' ) {
				jQuery(this).closest('.wb-ajax-filter-toggle-content-row').next('.wb-tax-toggle').show(250);
			} else {
				jQuery(this).closest('.wb-ajax-filter-toggle-content-row').next('.wb-tax-toggle').hide(250);
			}
		});

		jQuery('.wb-ajax-filter-modal-content').on('change', 'select[name="filters[filter_design]"]', function () {
			if (jQuery(this).val() == 'radio') {
				jQuery('.wb-ajax-filter-multiselect').hide();
				jQuery('input[name="filters[multiple]"]').prop( 'checked', false );
			} else {
				jQuery('.wb-ajax-filter-multiselect').show();
			}
		});

		// Enable/Disable filter preset
		jQuery( '.preset-active-status' ).on( 'change', function () {
			let preset = jQuery( this ).parent().data( 'preset' );
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			let enabled = 'no';
			if ( jQuery( this ).is( ':checked' ) ) {
				enabled = 'yes';
			}
			jQuery.ajax({
				url: wbcom_plugin_installer_params.ajax_url,
				type: 'post',
				data: { action: 'enable_disable_filter_preset_wb', 'nonce': nonce, 'preset': preset, 'enabled': enabled },
				success: function ( response ) {

				}
			});
		});

		// Create a duplicate of the preset
		jQuery( 'a.wb-copy-filter-preset' ).on( 'click', function () {
			var copy = confirm( "Do you want to create duplicate of this preset?" );
			if ( copy == true ) {
				let preset = jQuery( this ).data( 'preset' );
				let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'duplicate_filter_preset_wb', 'nonce': nonce, 'preset': preset },
					success: function ( response ) {
						if ( 'copy_created' == response ) {
							location.reload();
						}
					}
				});
			}
		});

		// Delete a filter preset
		jQuery( 'a.wb-delete-filter-preset' ).on( 'click', function () {
			var del = confirm( "Are you sure you want to delete this preset?" );
			if ( del == true ) {
				let preset = jQuery( this ).data( 'preset' );
				let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'delete_filter_preset_wb', 'nonce': nonce, 'preset': preset },
					success: function ( response ) {
						if ( 'preset_deleted' == response ) {
							location.reload();
						}
					}
				});
			}
		});

		// Create a duplicate of the preset
		jQuery( 'span.wb-clone-single-filter' ).on( 'click', function () {
			var copy = confirm( "Do you want to create duplicate of this filter?" );
			if ( copy == true ) {
				let preset = jQuery( this ).data( 'preset' );
				let filter_id = jQuery( this ).data( 'filter_id' );
				let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'duplicate_single_filter_wb', 'nonce': nonce, 'filter_id': filter_id, 'preset': preset },
					success: function ( response ) {
						if ( 'copy_created' == response ) {
							location.reload();
						}
					}
				});
			}
		});

		// Delete a filter preset
		jQuery( 'span.wb-delete-single-filter' ).on( 'click', function () {
			var del = confirm( "Are you sure you want to delete this filter?" );
			if ( del == true ) {
				let preset = jQuery( this ).data( 'preset' );
				let filter_id = jQuery( this ).data( 'filter_id' );
				let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'delete_single_filter_wb', 'nonce': nonce, 'filter_id': filter_id, 'preset': preset },
					success: function ( response ) {
						if ( 'preset_deleted' == response ) {
							location.reload();
						}
					}
				});
			}
		});

		// Enable/Disable filter preset
		jQuery( 'input[name="filter_enabled"]' ).on( 'change', function () {
			let preset = jQuery( this ).data( 'preset' );
			let filter_id = jQuery( this ).data( 'filter_id' );
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			let enabled = 'no';
			if ( jQuery( this ).is( ':checked' ) ) {
				enabled = 'yes';
			}
			jQuery.ajax({
				url: wbcom_plugin_installer_params.ajax_url,
				type: 'post',
				data: { action: 'enable_disable_single_filter_wb', 'nonce': nonce, 'preset': preset, 'filter_id': filter_id, 'enabled': enabled },
				success: function ( response ) {
					location.reload();
				}
			});
		});

		//

		jQuery( '.wb-ajax-filter-save-title-button' ).on( 'click', function ( e ) {
			e.preventDefault();
			var title = jQuery( this ).prev( 'input' ).val();
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			let preset = ( jQuery( this ).data( 'preset' ) !== '' ) ? jQuery( this ).data( 'preset' ) : '';
			if (title !== '' || title !== undefined ){
				jQuery.ajax({
					url: wbcom_plugin_installer_params.ajax_url,
					type: 'post',
					data: { action: 'edit_preset_post_title_wb', 'nonce': nonce, 'title': title, 'preset': preset },
					success: function ( response ) {
						location.reload();
					}
				});
			}
		});

		// Load create filter modal template
		jQuery( '.wb-ajax-filter-add-button' ).on( 'click', function (e) {
			e.preventDefault();
			var title = jQuery( 'input[name="wb_ajax_filter_preset_title"]' ).val();
			if ( title == '' || title == undefined ) {
				alert('Please enter name for preset');
				return false;
			}
			let nonce = wbcom_plugin_installer_params.wbcom_ajax_nonce;
			let preset = ( jQuery( this ).data( 'preset' ) !== '' ) ? jQuery( this ).data( 'preset' ) : '';
			jQuery.ajax({
				url: wbcom_plugin_installer_params.ajax_url,
				type: 'post',
				data: { action: 'load_create_filter_template_wb', 'nonce': nonce, 'title': title, 'preset': preset },
				success: function ( response ) {
					jQuery( '.wb-ajax-filter-modal-content' ).html( JSON.parse( response ) );
					jQuery( '.wb-ajax-filter-modal-container' ).css({
						'opacity': 1,
						'z-index': 999
					});
					afterAjaxResponse();
				}
			});
		});

		// Close create filter modal template
		jQuery( '.wb-ajax-filter-modal-body' ).on( 'click', '.wb-ajax-filter-close-modal', function () {
			jQuery( '.wb-ajax-filter-modal-container' ).css({
				'opacity': 0,
				'z-index': -199
			});
		});

		// Save new filter preset on create page
		jQuery( '.wb-ajax-filter-modal-content' ).on( 'click', '#wb-ajax-filer-create-filter-save', function ( e ) {
			e.preventDefault();
			if (jQuery('select[name="filters[type]"]').val() == 'tax' ){
				if (jQuery('select[name="filters[taxonomy]"]').val() == '' || jQuery('select[name="filters[taxonomy]"]').val() == undefined ){
					alert('Please select a valid taxonomy');
					return false;
				}
				if (jQuery('#wb_ajax_filter_select2_terms').val() == '' || jQuery('#wb_ajax_filter_select2_terms').val() == undefined) {
					alert('Please select terms');
					return false;
				}
			}
			jQuery( '#filter-preset-create' ).trigger( 'submit' );
		});

		// Create new filter preset after
		jQuery( '.wb-ajax-filter-modal-content' ).on( 'submit', '#filter-preset-create', function ( e ) {
			e.preventDefault();
			afterFormSubmit();
		});

		jQuery('.wb-ajax-filter-modal-content').on('change', '.wb-filter-type-price-range-min', function(e) {
			var minPriceEntered     =  $(this).val();
			var highestProductPrice =  $(this).attr( 'data-highest-price' );

			if( parseInt( minPriceEntered ) > parseInt( highestProductPrice) ) {
				$(this).prev().prev().text('Entered min price is greater than the highest price on this store.');
				$(this).prev().prev().show();
				$(this).val(null);
				$(this).closest('.wb-filter-type-price-range-max').val(null);
				
			} else{
				$(this).prev().prev().hide();
			}
		});

		jQuery('.wb-ajax-filter-modal-content').on('change', '.wb-filter-type-price-range-max', function (e) {
			var maxPriceEntered = $(this).val();
			var minPriceEntered = $(this).parent().prev().prev().children('input').val();
			
			if (parseInt(minPriceEntered) > parseInt(maxPriceEntered)) {
				$(this).parent().prev().prev().children('span').text('Max price cannot be smaller than Min price.');
				$(this).parent().prev().prev().children('span').show();
				$(this).val(null);
				$(this).$(this).parent().prev().prev().children('input').val(null);
			} else {
				$(this).parent().prev().prev().children('span').hide();
			}	
		});

		jQuery( 'input[name="wb_ajax_filter_search_settings[enable_search]"]' ).on('click', function(e){
			let isChecked = $(this).is(':checked');
			if( true == isChecked ) {
				$('.wb_ajax_search_options').show();
			}else {
				$('.wb_ajax_search_options').hide();
			}
		});
	});

})(jQuery);
