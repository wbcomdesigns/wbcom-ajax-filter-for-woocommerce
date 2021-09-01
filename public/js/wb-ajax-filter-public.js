(function ($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 */

	jQuery( document ).ready( function ($) {

		// Check if 'Apply Filters' button exists
		var applyFiltersButton = false;
		if (jQuery('.wb-ajax-apply-all-filters').length ){
			var applyFiltersButton = true;
		}

		// Enable select2 js
		jQuery('.wb-ajax-search_categories').select2();
		jQuery('.wb-ajax-filter-post-type').select2();
		jQuery('select.wb-ajax-filter-selectible').select2();

		// Enable select2 autocomplete js
		jQuery('#wb_ajax_search_input').select2({
			ajax: {
				url: wbcom_plugin_installer_params.ajax_url,
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						q: params.term,
						action: 'get_ajax_search_autocomplete_title_wb',
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

		// get url fields
		var url_string = window.location.href
		var urlHost = location.protocol + '//' + location.host + location.pathname;
		let url = new URL( url_string );
		let params = new URLSearchParams( url.search );
		
		// Refresh products with filters
		function refreshShopPageTemplate (urlTo) {
			$.ajax({
				url: urlTo,
				success: function (result) {
					const responseDom = document.createElement('html'),
					$response = $(responseDom);
					responseDom.innerHTML = result;
					$('body').replaceWith($response.find('body'));
					$('html,body').animate({ scrollTop: $('.site-header-wrapper').offset().top }, 'slow');
				}
			});
		}

		// Remove field from url
		function removeField ( param ) {
			return params.delete( param )
		}

		// Check url for filter
		function checkFieldValues( param ) {
			return params.has( param )
		}

		// Set parameters in url
		function setFieldValue( param, value ) {
			if ( checkFieldValues( param ) ) {
				removeField( param );
			}
			params.set( param, value );
		}

		// Add values to param
		function concatValue( filter, newValue ) {
			let oldValue = params.getAll(filter);
			oldValue.push( newValue );
			let values = oldValue.join();
			return values;
		}

		// Remove values from param
		function removeValues( filter, removeValue ) {
			let oldValue = params.getAll( filter );
			let oldArr = oldValue[0].split(",");
			let index = oldArr.indexOf( removeValue );
			if ( index > -1 ) {
				oldArr.splice( index, 1 );
			}
			let values = oldArr.join();
			return values;
		}

		jQuery('.wb-tooltip-added').on('mouseover', function(){
			jQuery(this).find('span').css({
				'opacity': 1
			});
		});

		jQuery('.wb-tooltip-added').on('mouseleave', function () {
			jQuery(this).find('span').css({
				'opacity': 0
			})
		});

		// Submit Ajax search
		jQuery('.wb-search-submit-container').on('click', function(e) {
			e.preventDefault();
			history.pushState({}, null, urlHost + '?' + params.toString());
			refreshShopPageTemplate(urlHost + '?' + params.toString());
			
		});

		jQuery('.wb-ajax-filter-ajaxsearchform-select select').on('change', function(){
			let filter = jQuery(this).attr('name');
			let filterValue = jQuery(this).val();
			if ( filterValue == '' ){
				removeField(filter);
			} else {
				setFieldValue(filter, filterValue);
			}
		});

		// Apply filters
		jQuery('.wb-ajax-apply-all-filters').on('click', function( e ){
			e.preventDefault();
			refreshShopPageTemplate( urlHost + '?' + params.toString() );
		});

		jQuery('a.wb-term-label').on('click', function(e){
			e.preventDefault();
			let type = jQuery(this).prev('input').attr('type');
			if (jQuery(this).prev('input').is(':checked') ){
				if (type === 'checkbox') {
					jQuery(this).prev('input').prop('checked', false);
					jQuery(this).prev('input').trigger("change");
				}
			} else {
				jQuery(this).prev('input').prop('checked', true);
				jQuery(this).prev('input').trigger("change");
			}
		});

		// Clear single filter
		jQuery('.wb-ajax-clear-single-filter').on('click', function(){
			let filter = jQuery(this).data('filter');
			if ( filter.indexOf(',') != -1 ) {
				let filters = filter.split(',');
				for( let i=0; i <= filters.length; i++ ){
					removeField( filters[i] );
				}
			} else {
				removeField(filter);
			}
			history.pushState( {}, null, urlHost + '?' + params.toString() );
			refreshShopPageTemplate( urlHost + '?' + params.toString() );
		});

		// Reset filters
		jQuery('.wb-ajax-reset-all-filters').on( 'click', function () {
			var hash;
			var hashes = window.location.href.slice( window.location.href.indexOf('?') + 1 ).split('&');
			for (var i = 0; i < hashes.length; i++) {
				hash = hashes[i].split('=');
				removeField( hash[0] );
			}
			history.pushState( {}, null, urlHost );
			refreshShopPageTemplate( urlHost );
		});

		// Get values from all select and input boxes
		jQuery("select.wb-ajax-filter-selectible, input.wb-ajax-filter-selectible").on( 'change', function () {
			let filter    = jQuery( this ).data( 'filter' );
			let filterVal = jQuery( this ).val();
			let tag       = jQuery( this ).prop( 'tagName' );
			let type       = jQuery(this).attr('type');
			if ( tag === 'SELECT' ) {
				if ( filterVal !== '' && filterVal !== undefined ) {
					setFieldValue( filter, filterVal );
				} else {
					removeField( filter );
				}
			} else if ( tag === 'INPUT' ) {
				if ( jQuery( this ).is( ':checked' ) ) {
					if ( checkFieldValues( filter ) && type === 'checkbox'){
						let oldValues = params.getAll( filter );
						let index = oldValues[0].indexOf( filterVal );
						if (index > -1) {
							
						} else {
							let newValue = concatValue( filter, filterVal );
							setFieldValue( filter, newValue );
						}	
					} else {
						setFieldValue( filter, filterVal );
					}
				} else {
					if ( checkFieldValues( filter ) ) {
						let oldValues = params.getAll( filter );
						if ( filterVal === oldValues[0] ) {
							removeField( filter );
						} else {
							let newValue = removeValues( filter, filterVal );
							setFieldValue( filter, newValue );
						}
					} else {
						removeField(filter);
					}
				}
			}
			history.pushState( {}, null, urlHost + '?' + params.toString() );
			if ( !applyFiltersButton ) {
				refreshShopPageTemplate( urlHost + '?' + params.toString() );
			}
		});

		// Price range filter
		jQuery( "ul.wb-price-ranges a.price-range" ).on( 'click', function ( e ) {
			e.preventDefault();
			jQuery(this).closest('.wb-ajax-filter-container-single').find('.wb-ajax-clear-single-filter').show();
			let minPrice = jQuery( this ).data( 'range-min' );
			let maxPrice = jQuery( this ).data( 'range-max' );
			let oldMin = params.get('min_price');
			let oldMax = params.get('max_price');
			if ( oldMin == minPrice && oldMax == maxPrice ) {
				removeField('min_price');
				removeField('max_price');
			} else {
				setFieldValue( 'min_price', minPrice );
				setFieldValue( 'max_price', maxPrice );
			}
			history.pushState( {}, null, urlHost + '?' + params.toString() );
			if (!applyFiltersButton) {
				refreshShopPageTemplate( urlHost + '?' + params.toString() );
			}
		});
		
		// Price range slider
		jQuery(".js-range-slider").ionRangeSlider({
			onFinish: function ( data ) {
				let fromPrice = data.from;
				let toPrice   = data.to;
				let elem = jQuery(this);
				let minPrice =  elem[0].min;
				let maxPrice =  elem[0].max;
				if ( minPrice === fromPrice && maxPrice === toPrice ) {
					removeField( 'min_price' );
					removeField( 'max_price' );
				} else {
					setFieldValue( 'min_price', fromPrice );
					setFieldValue( 'max_price', toPrice );
				}
				history.pushState( {}, null, urlHost + '?' + params.toString() );
				if ( !applyFiltersButton ) {
					refreshShopPageTemplate( urlHost + '?' + params.toString() );
				}
			},
		});
	});
})(jQuery);
