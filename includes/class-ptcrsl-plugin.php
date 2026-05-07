<?php
/**
 * The core plugin class.
 *
 * @package PrimeTestimonialCarousel
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Main plugin class.
 */
class Ptcrsl_Plugin {

	/**
	 * Run the plugin.
	 */
	public function run() {
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_post_type();
		$this->define_shortcode();
		$this->define_block();
	}

	/**
	 * Load required dependencies.
	 */
	private function load_dependencies() {
		require_once PTCRSL_PLUGIN_DIR . 'includes/class-ptcrsl-post-type.php';
		require_once PTCRSL_PLUGIN_DIR . 'includes/class-ptcrsl-admin.php';
		require_once PTCRSL_PLUGIN_DIR . 'includes/class-ptcrsl-public.php';
		require_once PTCRSL_PLUGIN_DIR . 'includes/class-ptcrsl-shortcode.php';
		require_once PTCRSL_PLUGIN_DIR . 'includes/class-ptcrsl-block.php';
		require_once PTCRSL_PLUGIN_DIR . 'includes/class-ptcrsl-settings.php';
	}

	/**
	 * Register admin hooks.
	 */
	private function define_admin_hooks() {
		$admin = new Ptcrsl_Admin();
		add_action( 'admin_enqueue_scripts', array( $admin, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $admin, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $admin, 'add_plugin_menu' ) );
		add_action( 'add_meta_boxes', array( $admin, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $admin, 'save_meta_box_data' ) );

		$settings = new Ptcrsl_Settings();
		add_action( 'admin_init', array( $settings, 'register_settings' ) );
	}

	/**
	 * Register public-facing hooks.
	 */
	private function define_public_hooks() {
		$public = new Ptcrsl_Public();
		add_action( 'wp_enqueue_scripts', array( $public, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $public, 'enqueue_scripts' ) );
	}

	/**
	 * Register custom post type.
	 */
	private function define_post_type() {
		$post_type = new Ptcrsl_Post_Type();
		add_action( 'init', array( $post_type, 'register' ) );
		add_filter( 'manage_ptcrsl_testimonial_posts_columns', array( $post_type, 'custom_columns' ) );
		add_action( 'manage_ptcrsl_testimonial_posts_custom_column', array( $post_type, 'custom_column_content' ), 10, 2 );
	}

	/**
	 * Register shortcode.
	 */
	private function define_shortcode() {
		$shortcode = new Ptcrsl_Shortcode();
		add_shortcode( 'prime_testimonial_carousel', array( $shortcode, 'render' ) );
	}

	/**
	 * Register Gutenberg block.
	 */
	private function define_block() {
		$block = new Ptcrsl_Block();
		add_action( 'init', array( $block, 'register' ) );
	}
}
