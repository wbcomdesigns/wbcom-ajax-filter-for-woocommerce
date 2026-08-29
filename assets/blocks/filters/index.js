/**
 * Editor script for the wb-ajax-filter/filters block.
 *
 * Plain JavaScript on the wp.* globals - no JSX, no build step. Attributes and
 * supports come from block.json (registered server-side); this file only
 * supplies the edit UI. The frontend markup is server-rendered.
 */
( function ( wp ) {
	'use strict';

	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	var registerBlockType = wp.blocks.registerBlockType;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var useBlockProps = wp.blockEditor.useBlockProps;
	var PanelBody = wp.components.PanelBody;
	var SelectControl = wp.components.SelectControl;
	var Disabled = wp.components.Disabled;
	var ServerSideRender = wp.serverSideRender;

	// Localized by Wb_Ajax_Filter_Blocks::localize_editor_presets().
	var presetChoices =
		( window.wbAjaxFilterBlock && window.wbAjaxFilterBlock.presets ) || [
			{ label: __( 'All enabled presets', 'wb-ajax-filter' ), value: '' },
		];

	registerBlockType( 'wb-ajax-filter/filters', {
		edit: function ( props ) {
			var blockProps = useBlockProps();

			return el(
				'div',
				blockProps,
				el(
					InspectorControls,
					{},
					el(
						PanelBody,
						{ title: __( 'Filter preset', 'wb-ajax-filter' ) },
						el( SelectControl, {
							label: __( 'Preset', 'wb-ajax-filter' ),
							value: props.attributes.preset,
							options: presetChoices,
							onChange: function ( value ) {
								props.setAttributes( { preset: value } );
							},
							help: __(
								'Which saved filter preset this block renders. "All enabled presets" shows every preset that is switched on.',
								'wb-ajax-filter'
							),
						} )
					)
				),
				el(
					Disabled,
					{},
					el( ServerSideRender, {
						block: 'wb-ajax-filter/filters',
						attributes: props.attributes,
					} )
				)
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp );
