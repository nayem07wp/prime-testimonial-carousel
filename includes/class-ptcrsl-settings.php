<?php
/**
 * Settings API registration.
 *
 * @package PrimeTestimonialCarousel
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Settings class.
 */
class Ptcrsl_Settings {

	/**
	 * Register settings.
	 */
	public function register_settings() {
		register_setting(
			'ptcrsl_settings_group',
			'ptcrsl_settings',
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize' ),
				'default'           => array(),
			)
		);
	}

	/**
	 * Sanitize settings input.
	 *
	 * @param array $input Raw input.
	 * @return array Sanitized values.
	 */
	public function sanitize( $input ) {
		$output = array();

		if ( isset( $input['primary_color'] ) ) {
			$output['primary_color'] = sanitize_hex_color( $input['primary_color'] );
		}
		if ( isset( $input['secondary_color'] ) ) {
			$output['secondary_color'] = sanitize_hex_color( $input['secondary_color'] );
		}
		if ( isset( $input['text_color'] ) ) {
			$output['text_color'] = sanitize_hex_color( $input['text_color'] );
		}
		if ( isset( $input['bg_color'] ) ) {
			$output['bg_color'] = sanitize_hex_color( $input['bg_color'] );
		}
		if ( isset( $input['border_radius'] ) ) {
			$output['border_radius'] = absint( $input['border_radius'] );
		}
		$output['enable_lazyload'] = isset( $input['enable_lazyload'] ) ? '1' : '0';

		return $output;
	}
}
