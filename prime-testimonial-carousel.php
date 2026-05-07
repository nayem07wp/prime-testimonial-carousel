<?php
/**
 * Plugin Name:       Prime Testimonial Carousel
 * Plugin URI:        https://wordpress.org/plugins/prime-testimonial-carousel/
 * Description:       A powerful, responsive testimonial carousel plugin with multiple layout options. Display beautiful customer testimonials anywhere on your site using shortcodes or Gutenberg blocks.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            nayem07
 * Author URI:        https://profiles.wordpress.org/nayem07/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       prime-testimonial-carousel
 * Domain Path:       /languages
 *
 * @package PrimeTestimonialCarousel
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin version.
 */
define( 'PTCRSL_VERSION', '1.0.0' );
define( 'PTCRSL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PTCRSL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PTCRSL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 */
function ptcrsl_activate() {
	require_once PTCRSL_PLUGIN_DIR . 'includes/class-ptcrsl-activator.php';
	Ptcrsl_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function ptcrsl_deactivate() {
	require_once PTCRSL_PLUGIN_DIR . 'includes/class-ptcrsl-deactivator.php';
	Ptcrsl_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'ptcrsl_activate' );
register_deactivation_hook( __FILE__, 'ptcrsl_deactivate' );

/**
 * The core plugin class.
 */
require PTCRSL_PLUGIN_DIR . 'includes/class-ptcrsl-plugin.php';

/**
 * Begins execution of the plugin.
 */
function ptcrsl_run() {
	$plugin = new Ptcrsl_Plugin();
	$plugin->run();
}
ptcrsl_run();
