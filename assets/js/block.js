/**
 * Prime Testimonial Carousel - Gutenberg Block
 */
( function ( blocks, element, components, editor, i18n, serverSideRender ) {
	var el = element.createElement;
	var __ = i18n.__;
	var ServerSideRender = serverSideRender;
	var InspectorControls = editor.InspectorControls;
	var PanelBody = components.PanelBody;
	var SelectControl = components.SelectControl;
	var RangeControl = components.RangeControl;
	var ToggleControl = components.ToggleControl;
	var TextControl = components.TextControl;

	blocks.registerBlockType( 'ptcrsl/testimonial-carousel', {
		title: __( 'Testimonial Carousel', 'prime-testimonial-carousel' ),
		description: __( 'Display a responsive testimonial carousel.', 'prime-testimonial-carousel' ),
		icon: 'format-quote',
		category: 'widgets',
		keywords: [
			__( 'testimonial', 'prime-testimonial-carousel' ),
			__( 'carousel', 'prime-testimonial-carousel' ),
			__( 'slider', 'prime-testimonial-carousel' )
		],
		supports: { html: false },

		edit: function ( props ) {
			var attrs = props.attributes;

			var inspector = el( InspectorControls, {},
				el( PanelBody, { title: __( 'Layout', 'prime-testimonial-carousel' ), initialOpen: true },
					el( SelectControl, {
						label: __( 'Layout Style', 'prime-testimonial-carousel' ),
						value: attrs.layout,
						options: [
							{ label: __( 'Classic', 'prime-testimonial-carousel' ), value: 'classic' },
							{ label: __( 'Card', 'prime-testimonial-carousel' ), value: 'card' },
							{ label: __( 'Modern', 'prime-testimonial-carousel' ), value: 'modern' },
							{ label: __( 'Minimal', 'prime-testimonial-carousel' ), value: 'minimal' },
							{ label: __( 'Masonry', 'prime-testimonial-carousel' ), value: 'masonry' },
							{ label: __( 'Grid', 'prime-testimonial-carousel' ), value: 'grid' }
						],
						onChange: function ( val ) { props.setAttributes( { layout: val } ); }
					} ),
					el( RangeControl, {
						label: __( 'Columns', 'prime-testimonial-carousel' ),
						value: attrs.columns,
						min: 1, max: 4,
						onChange: function ( val ) { props.setAttributes( { columns: val } ); }
					} ),
					el( RangeControl, {
						label: __( 'Number of Testimonials', 'prime-testimonial-carousel' ),
						value: attrs.count,
						min: 1, max: 50,
						onChange: function ( val ) { props.setAttributes( { count: val } ); }
					} ),
					el( TextControl, {
						label: __( 'Group Slug (optional)', 'prime-testimonial-carousel' ),
						value: attrs.group,
						onChange: function ( val ) { props.setAttributes( { group: val } ); }
					} )
				),
				el( PanelBody, { title: __( 'Behavior', 'prime-testimonial-carousel' ), initialOpen: false },
					el( ToggleControl, {
						label: __( 'Autoplay', 'prime-testimonial-carousel' ),
						checked: attrs.autoplay,
						onChange: function ( val ) { props.setAttributes( { autoplay: val } ); }
					} ),
					el( ToggleControl, {
						label: __( 'Show Arrows', 'prime-testimonial-carousel' ),
						checked: attrs.showArrows,
						onChange: function ( val ) { props.setAttributes( { showArrows: val } ); }
					} ),
					el( ToggleControl, {
						label: __( 'Show Dots', 'prime-testimonial-carousel' ),
						checked: attrs.showDots,
						onChange: function ( val ) { props.setAttributes( { showDots: val } ); }
					} )
				),
				el( PanelBody, { title: __( 'Display', 'prime-testimonial-carousel' ), initialOpen: false },
					el( ToggleControl, {
						label: __( 'Show Author Photo', 'prime-testimonial-carousel' ),
						checked: attrs.showPhoto,
						onChange: function ( val ) { props.setAttributes( { showPhoto: val } ); }
					} ),
					el( ToggleControl, {
						label: __( 'Show Rating', 'prime-testimonial-carousel' ),
						checked: attrs.showRating,
						onChange: function ( val ) { props.setAttributes( { showRating: val } ); }
					} )
				)
			);

			return [
				inspector,
				el( 'div', { className: props.className },
					el( ServerSideRender, {
						block: 'ptcrsl/testimonial-carousel',
						attributes: attrs
					} )
				)
			];
		},

		save: function () {
			return null; // Rendered server-side.
		}
	} );
} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.components,
	window.wp.blockEditor || window.wp.editor,
	window.wp.i18n,
	window.wp.serverSideRender || window.wp.components.ServerSideRender
);
