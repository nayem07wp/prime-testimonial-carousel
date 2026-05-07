<?php
/**
 * Fired during plugin activation.
 *
 * @package PrimeTestimonialCarousel
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin activator class.
 */
class Ptcrsl_Activator {

	/**
	 * Activate the plugin.
	 */
	public static function activate() {
		// Register post type so rewrite rules work.
		require_once PTCRSL_PLUGIN_DIR . 'includes/class-ptcrsl-post-type.php';
		$post_type = new Ptcrsl_Post_Type();
		$post_type->register();

		// Flush rewrite rules.
		flush_rewrite_rules();

		// Set default options.
		$default_options = array(
			'primary_color'   => '#0073aa',
			'secondary_color' => '#23282d',
			'text_color'      => '#333333',
			'bg_color'        => '#ffffff',
			'border_radius'   => '8',
			'enable_lazyload' => '1',
		);

		if ( false === get_option( 'ptcrsl_settings' ) ) {
			add_option( 'ptcrsl_settings', $default_options );
		}

		// Store plugin version.
		update_option( 'ptcrsl_version', PTCRSL_VERSION );
	}
}
