<?php
/**
 * Uninstall handler.
 *
 * Fired when the plugin is deleted from the WordPress admin.
 *
 * @package PrimeTestimonialCarousel
 */

// If uninstall not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete plugin options.
delete_option( 'ptcrsl_settings' );
delete_option( 'ptcrsl_version' );

// Optionally delete all testimonial posts and metadata.
// We only do this if the site owner has opted in.
$ptcrsl_settings = get_option( 'ptcrsl_settings', array() );
if ( isset( $ptcrsl_settings['delete_data_on_uninstall'] ) && '1' === $ptcrsl_settings['delete_data_on_uninstall'] ) {
	$ptcrsl_testimonials = get_posts(
		array(
			'post_type'      => 'ptcrsl_testimonial',
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'fields'         => 'ids',
		)
	);

	foreach ( $ptcrsl_testimonials as $ptcrsl_testimonial_id ) {
		wp_delete_post( $ptcrsl_testimonial_id, true );
	}

	// Remove taxonomy terms.
	$ptcrsl_terms = get_terms(
		array(
			'taxonomy'   => 'ptcrsl_testimonial_group',
			'hide_empty' => false,
		)
	);

	if ( ! is_wp_error( $ptcrsl_terms ) ) {
		foreach ( $ptcrsl_terms as $ptcrsl_term ) {
			wp_delete_term( $ptcrsl_term->term_id, 'ptcrsl_testimonial_group' );
		}
	}
}
