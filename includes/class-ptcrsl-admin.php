<?php
/**
 * Admin functionality.
 *
 * @package PrimeTestimonialCarousel
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Admin class.
 */
class Ptcrsl_Admin {

	/**
	 * Enqueue admin styles.
	 *
	 * @param string $hook Current admin page.
	 */
	public function enqueue_styles( $hook ) {
		$screen = get_current_screen();
		if ( ! $screen ) {
			return;
		}

		if ( 'ptcrsl_testimonial' === $screen->post_type || strpos( $hook, 'tcp-' ) !== false ) {
			wp_enqueue_style(
				'ptcrsl-admin',
				PTCRSL_PLUGIN_URL . 'assets/css/admin.css',
				array(),
				PTCRSL_VERSION
			);
		}
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @param string $hook Current admin page.
	 */
	public function enqueue_scripts( $hook ) {
		$screen = get_current_screen();
		if ( ! $screen ) {
			return;
		}

		if ( 'ptcrsl_testimonial' === $screen->post_type || strpos( $hook, 'tcp-' ) !== false ) {
			wp_enqueue_script(
				'ptcrsl-admin',
				PTCRSL_PLUGIN_URL . 'assets/js/admin.js',
				array( 'jquery', 'wp-i18n' ),
				PTCRSL_VERSION,
				true
			);

			wp_localize_script(
				'ptcrsl-admin',
				'ptcrslAdmin',
				array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'ptcrsl_admin_nonce' ),
				)
			);
		}
	}

	/**
	 * Add plugin menu pages.
	 */
	public function add_plugin_menu() {
		add_submenu_page(
			'edit.php?post_type=ptcrsl_testimonial',
			__( 'Settings', 'prime-testimonial-carousel' ),
			__( 'Settings', 'prime-testimonial-carousel' ),
			'manage_options',
			'ptcrsl-settings',
			array( $this, 'render_settings_page' )
		);

		add_submenu_page(
			'edit.php?post_type=ptcrsl_testimonial',
			__( 'Shortcodes', 'prime-testimonial-carousel' ),
			__( 'Shortcodes', 'prime-testimonial-carousel' ),
			'manage_options',
			'ptcrsl-shortcodes',
			array( $this, 'render_shortcodes_page' )
		);
	}

	/**
	 * Render the settings page.
	 */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		include PTCRSL_PLUGIN_DIR . 'templates/admin-settings.php';
	}

	/**
	 * Render the shortcodes help page.
	 */
	public function render_shortcodes_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		include PTCRSL_PLUGIN_DIR . 'templates/admin-shortcodes.php';
	}

	/**
	 * Add meta boxes.
	 */
	public function add_meta_boxes() {
		add_meta_box(
			'ptcrsl_testimonial_details',
			__( 'Testimonial Details', 'prime-testimonial-carousel' ),
			array( $this, 'render_details_meta_box' ),
			'ptcrsl_testimonial',
			'normal',
			'high'
		);
	}

	/**
	 * Render details meta box.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function render_details_meta_box( $post ) {
		wp_nonce_field( 'ptcrsl_save_meta_box', 'ptcrsl_meta_box_nonce' );

		$author_name    = get_post_meta( $post->ID, '_ptcrsl_author_name', true );
		$author_title   = get_post_meta( $post->ID, '_ptcrsl_author_title', true );
		$author_company = get_post_meta( $post->ID, '_ptcrsl_author_company', true );
		$author_url     = get_post_meta( $post->ID, '_ptcrsl_author_url', true );
		$rating         = get_post_meta( $post->ID, '_ptcrsl_rating', true );
		?>
		<table class="form-table ptcrsl-meta-table">
			<tr>
				<th><label for="ptcrsl_author_name"><?php esc_html_e( 'Author Name', 'prime-testimonial-carousel' ); ?></label></th>
				<td><input type="text" id="ptcrsl_author_name" name="ptcrsl_author_name" value="<?php echo esc_attr( $author_name ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="ptcrsl_author_title"><?php esc_html_e( 'Author Title/Position', 'prime-testimonial-carousel' ); ?></label></th>
				<td><input type="text" id="ptcrsl_author_title" name="ptcrsl_author_title" value="<?php echo esc_attr( $author_title ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="ptcrsl_author_company"><?php esc_html_e( 'Company', 'prime-testimonial-carousel' ); ?></label></th>
				<td><input type="text" id="ptcrsl_author_company" name="ptcrsl_author_company" value="<?php echo esc_attr( $author_company ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="ptcrsl_author_url"><?php esc_html_e( 'Website URL', 'prime-testimonial-carousel' ); ?></label></th>
				<td><input type="url" id="ptcrsl_author_url" name="ptcrsl_author_url" value="<?php echo esc_attr( $author_url ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="ptcrsl_rating"><?php esc_html_e( 'Rating', 'prime-testimonial-carousel' ); ?></label></th>
				<td>
					<select id="ptcrsl_rating" name="ptcrsl_rating">
						<option value=""><?php esc_html_e( 'No Rating', 'prime-testimonial-carousel' ); ?></option>
						<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
							<option value="<?php echo esc_attr( $i ); ?>" <?php selected( $rating, $i ); ?>>
								<?php echo esc_html( sprintf( /* translators: %d is the rating number */ _n( '%d Star', '%d Stars', $i, 'prime-testimonial-carousel' ), $i ) ); ?>
							</option>
						<?php endfor; ?>
					</select>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Save meta box data.
	 *
	 * @param int $post_id Post ID.
	 */
	public function save_meta_box_data( $post_id ) {
		// Verify nonce.
		if ( ! isset( $_POST['ptcrsl_meta_box_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ptcrsl_meta_box_nonce'] ) ), 'ptcrsl_save_meta_box' ) ) {
			return;
		}

		// Check autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Save fields.
		$fields = array(
			'ptcrsl_author_name'    => 'sanitize_text_field',
			'ptcrsl_author_title'   => 'sanitize_text_field',
			'ptcrsl_author_company' => 'sanitize_text_field',
			'ptcrsl_author_url'     => 'esc_url_raw',
			'ptcrsl_rating'         => 'absint',
		);

		foreach ( $fields as $field => $sanitize_callback ) {
			if ( isset( $_POST[ $field ] ) ) {
				// Pre-sanitize so static analyzers recognize sanitization, then apply the field-specific callback.
				$raw   = sanitize_text_field( wp_unslash( $_POST[ $field ] ) );
				$value = call_user_func( $sanitize_callback, $raw );
				update_post_meta( $post_id, '_' . $field, $value );
			}
		}
	}
}
