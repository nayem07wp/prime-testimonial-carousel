<?php
/**
 * Fired during plugin deactivation.
 *
 * @package PrimeTestimonialCarousel
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin deactivator class.
 */
class Ptcrsl_Deactivator {

	/**
	 * Deactivate the plugin.
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}
}
