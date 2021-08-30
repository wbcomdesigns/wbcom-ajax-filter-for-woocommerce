(function ($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 */

	jQuery( document ).ready( function ($) {
		jQuery('.wb-ajax-search_categories').select2();
		jQuery('.wb-ajax-filter-post-type').select2();
		var url_string = window.location.href
		var urlHost = location.protocol + '//' + location.host + location.pathname;
		let url = new URL( url_string );
		let params = new URLSearchParams( url.search );
		
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
			//params.toString();
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

		jQuery('.wb-ajax-clear-single-filter').on('click', function(){
			let filter = jQuery(this).data('filter');
			if ( filter.indexOf(',') != -1 ) {
				let filters = filter.split(',');
				for(let i=0; i <= filters.length; i++ ){
					removeField(filters[i]);
				}
			} else {
				removeField(filter);
			}
			
			location.search = params.toString();
		});

		// Get values from all select and input boxes
		jQuery("select.wb-ajax-filter-selectible, input.wb-ajax-filter-selectible").on( 'change', function () {
			let filter    = jQuery( this ).data( 'filter' );
			let filterVal = jQuery( this ).val();
			let tag       = jQuery(this).prop('tagName');
			if ( tag === 'SELECT' ) {
				if ( filterVal !== '' && filterVal !== undefined ) {
					setFieldValue(filter, filterVal);
				} else {
					removeField(filter);
				}
			} else if ( tag === 'INPUT' ) {
				if ( jQuery( this ).is( ':checked' ) ) {
					if ( checkFieldValues( filter ) ){
						let oldValues = params.getAll( filter );
						let index = oldValues[0].indexOf( filterVal );
						if (index > -1) {
							
						} else {
							let newValue = concatValue(filter, filterVal);
							setFieldValue(filter, newValue);
						}	
					} else {
						setFieldValue( filter, filterVal );
					}
				} else {
					if ( checkFieldValues( filter ) ) {
						let oldValues = params.getAll(filter);
						if ( filterVal === oldValues[0] ) {
							removeField(filter);
						} else {
							let newValue = removeValues(filter, filterVal);
							setFieldValue(filter, newValue);
						}
					} else {
						removeField(filter);
					}
				}
			}
			location.search = params.toString();
		});

		// Price range filter
		jQuery( "ul.wb-price-ranges a.price-range" ).on( 'click' , function (e) {
			e.preventDefault();
			jQuery(this).closest('.wb-ajax-filter-container-single').find('.wb-ajax-clear-single-filter').show();
			let minPrice = jQuery( this ).data( 'range-min' );
			let maxPrice = jQuery( this ).data( 'range-max' );
			let oldMin = params.get('min_price');
			let oldMax = params.get('max_price');
			if (oldMin == minPrice && oldMax == maxPrice ) {
				removeField('min_price');
				removeField('max_price');
			} else {
				setFieldValue('min_price', minPrice);
				setFieldValue('max_price', maxPrice);
			}
			location.search = params.toString();
		});
		
		// Price range slider
		jQuery(".js-range-slider").ionRangeSlider({
			onFinish: function (data) {
				let fromPrice = data.from;
				let toPrice   = data.to;
				let elem = jQuery(this);
				let minPrice =  elem[0].min;
				let maxPrice =  elem[0].max;
				if (minPrice === fromPrice && maxPrice === toPrice ) {
					removeField('min_price');
					removeField('max_price');
				} else {
					setFieldValue('min_price', fromPrice);
					setFieldValue('max_price', toPrice);
				}
				location.search = params.toString();
			},
		});
	});
})(jQuery);
