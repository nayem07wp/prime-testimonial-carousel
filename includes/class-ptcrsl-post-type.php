<?php
/**
 * Custom post type registration.
 *
 * @package PrimeTestimonialCarousel
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Post type class.
 */
class Ptcrsl_Post_Type {

	/**
	 * Register custom post type.
	 */
	public function register() {
		$labels = array(
			'name'                  => _x( 'Testimonials', 'Post Type General Name', 'prime-testimonial-carousel' ),
			'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'prime-testimonial-carousel' ),
			'menu_name'             => __( 'Testimonials', 'prime-testimonial-carousel' ),
			'name_admin_bar'        => __( 'Testimonial', 'prime-testimonial-carousel' ),
			'add_new'               => __( 'Add New', 'prime-testimonial-carousel' ),
			'add_new_item'          => __( 'Add New Testimonial', 'prime-testimonial-carousel' ),
			'new_item'              => __( 'New Testimonial', 'prime-testimonial-carousel' ),
			'edit_item'             => __( 'Edit Testimonial', 'prime-testimonial-carousel' ),
			'view_item'             => __( 'View Testimonial', 'prime-testimonial-carousel' ),
			'all_items'             => __( 'All Testimonials', 'prime-testimonial-carousel' ),
			'search_items'          => __( 'Search Testimonials', 'prime-testimonial-carousel' ),
			'not_found'             => __( 'No testimonials found.', 'prime-testimonial-carousel' ),
			'not_found_in_trash'    => __( 'No testimonials found in Trash.', 'prime-testimonial-carousel' ),
			'featured_image'        => __( 'Author Photo', 'prime-testimonial-carousel' ),
			'set_featured_image'    => __( 'Set author photo', 'prime-testimonial-carousel' ),
			'remove_featured_image' => __( 'Remove author photo', 'prime-testimonial-carousel' ),
			'use_featured_image'    => __( 'Use as author photo', 'prime-testimonial-carousel' ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'query_var'           => false,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'hierarchical'        => false,
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-format-quote',
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
		);

		register_post_type( 'ptcrsl_testimonial', $args );

		// Register taxonomy for grouping testimonials.
		$tax_labels = array(
			'name'          => _x( 'Groups', 'taxonomy general name', 'prime-testimonial-carousel' ),
			'singular_name' => _x( 'Group', 'taxonomy singular name', 'prime-testimonial-carousel' ),
			'search_items'  => __( 'Search Groups', 'prime-testimonial-carousel' ),
			'all_items'     => __( 'All Groups', 'prime-testimonial-carousel' ),
			'edit_item'     => __( 'Edit Group', 'prime-testimonial-carousel' ),
			'update_item'   => __( 'Update Group', 'prime-testimonial-carousel' ),
			'add_new_item'  => __( 'Add New Group', 'prime-testimonial-carousel' ),
			'new_item_name' => __( 'New Group Name', 'prime-testimonial-carousel' ),
			'menu_name'     => __( 'Groups', 'prime-testimonial-carousel' ),
		);

		register_taxonomy(
			'ptcrsl_testimonial_group',
			array( 'ptcrsl_testimonial' ),
			array(
				'hierarchical'      => true,
				'labels'            => $tax_labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'query_var'         => true,
				'rewrite'           => false,
			)
		);
	}

	/**
	 * Custom admin columns.
	 *
	 * @param array $columns Existing columns.
	 * @return array Modified columns.
	 */
	public function custom_columns( $columns ) {
		$new_columns = array();
		foreach ( $columns as $key => $value ) {
			if ( 'title' === $key ) {
				$new_columns['ptcrsl_photo']  = __( 'Photo', 'prime-testimonial-carousel' );
				$new_columns[ $key ]       = $value;
				$new_columns['ptcrsl_rating'] = __( 'Rating', 'prime-testimonial-carousel' );
			} else {
				$new_columns[ $key ] = $value;
			}
		}
		return $new_columns;
	}

	/**
	 * Content for custom columns.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 */
	public function custom_column_content( $column, $post_id ) {
		switch ( $column ) {
			case 'ptcrsl_photo':
				if ( has_post_thumbnail( $post_id ) ) {
					echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
				} else {
					echo '—';
				}
				break;
			case 'ptcrsl_rating':
				$rating = get_post_meta( $post_id, '_ptcrsl_rating', true );
				if ( $rating ) {
					echo esc_html( $rating ) . ' / 5';
				} else {
					echo '—';
				}
				break;
		}
	}
}
