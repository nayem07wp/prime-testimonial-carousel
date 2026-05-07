<?php
/**
 * Gutenberg block registration.
 *
 * @package PrimeTestimonialCarousel
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Block class.
 */
class Ptcrsl_Block {

	/**
	 * Register the block.
	 */
	public function register() {
		// Register block script.
		wp_register_script(
			'ptcrsl-block-editor',
			PTCRSL_PLUGIN_URL . 'assets/js/block.js',
			array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n', 'wp-server-side-render' ),
			PTCRSL_VERSION,
			true
		);

		register_block_type(
			'ptcrsl/testimonial-carousel',
			array(
				'editor_script'   => 'ptcrsl-block-editor',
				'render_callback' => array( $this, 'render_block' ),
				'attributes'      => array(
					'layout'      => array(
						'type'    => 'string',
						'default' => 'classic',
					),
					'count'       => array(
						'type'    => 'number',
						'default' => 10,
					),
					'columns'     => array(
						'type'    => 'number',
						'default' => 3,
					),
					'autoplay'    => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showDots'    => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showArrows'  => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showRating'  => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showPhoto'   => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'group'       => array(
						'type'    => 'string',
						'default' => '',
					),
				),
			)
		);
	}

	/**
	 * Render the block on the frontend.
	 *
	 * @param array $attributes Block attributes.
	 * @return string
	 */
	public function render_block( $attributes ) {
		$shortcode = new Ptcrsl_Shortcode();

		return $shortcode->render(
			array(
				'layout'      => isset( $attributes['layout'] ) ? $attributes['layout'] : 'classic',
				'count'       => isset( $attributes['count'] ) ? $attributes['count'] : 10,
				'columns'     => isset( $attributes['columns'] ) ? $attributes['columns'] : 3,
				'autoplay'    => ! empty( $attributes['autoplay'] ) ? 'true' : 'false',
				'show_dots'   => ! empty( $attributes['showDots'] ) ? 'true' : 'false',
				'show_arrows' => ! empty( $attributes['showArrows'] ) ? 'true' : 'false',
				'show_rating' => ! empty( $attributes['showRating'] ) ? 'true' : 'false',
				'show_photo'  => ! empty( $attributes['showPhoto'] ) ? 'true' : 'false',
				'group'       => isset( $attributes['group'] ) ? $attributes['group'] : '',
			)
		);
	}
}
