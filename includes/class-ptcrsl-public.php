<?php
/**
 * Public-facing functionality.
 *
 * @package PrimeTestimonialCarousel
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Public class.
 */
class Ptcrsl_Public {

	/**
	 * Enqueue public styles.
	 */
	public function enqueue_styles() {
		wp_register_style(
			'ptcrsl-public',
			PTCRSL_PLUGIN_URL . 'assets/css/public.css',
			array(),
			PTCRSL_VERSION
		);

		// Load dynamic CSS based on settings.
		$this->add_dynamic_styles();
	}

	/**
	 * Enqueue public scripts.
	 */
	public function enqueue_scripts() {
		wp_register_script(
			'ptcrsl-public',
			PTCRSL_PLUGIN_URL . 'assets/js/public.js',
			array(),
			PTCRSL_VERSION,
			true
		);
	}

	/**
	 * Add dynamic inline styles based on plugin settings.
	 */
	private function add_dynamic_styles() {
		$settings = get_option( 'ptcrsl_settings', array() );

		$primary   = isset( $settings['primary_color'] ) ? sanitize_hex_color( $settings['primary_color'] ) : '#0073aa';
		$secondary = isset( $settings['secondary_color'] ) ? sanitize_hex_color( $settings['secondary_color'] ) : '#23282d';
		$text      = isset( $settings['text_color'] ) ? sanitize_hex_color( $settings['text_color'] ) : '#333333';
		$bg        = isset( $settings['bg_color'] ) ? sanitize_hex_color( $settings['bg_color'] ) : '#ffffff';
		$radius    = isset( $settings['border_radius'] ) ? absint( $settings['border_radius'] ) : 8;

		$css = "
			:root {
				--ptcrsl-primary: {$primary};
				--ptcrsl-secondary: {$secondary};
				--ptcrsl-text: {$text};
				--ptcrsl-bg: {$bg};
				--ptcrsl-radius: {$radius}px;
			}
		";

		wp_add_inline_style( 'ptcrsl-public', $css );
	}
}
