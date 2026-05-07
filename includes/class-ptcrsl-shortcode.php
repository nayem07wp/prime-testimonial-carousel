<?php
/**
 * Shortcode implementation.
 *
 * @package PrimeTestimonialCarousel
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Shortcode class.
 */
class Ptcrsl_Shortcode {

	/**
	 * Render the shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string Rendered HTML.
	 */
	public function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'layout'        => 'classic',      // classic, card, modern, minimal, masonry, grid.
				'count'         => 10,
				'columns'       => 3,              // 1, 2, 3, 4.
				'group'         => '',             // Taxonomy slug filter.
				'autoplay'      => 'true',
				'autoplay_speed' => 5000,
				'loop'          => 'true',
				'show_dots'     => 'true',
				'show_arrows'   => 'true',
				'show_rating'   => 'true',
				'show_photo'    => 'true',
				'show_quote_icon' => 'true',
				'order'         => 'DESC',
				'orderby'       => 'date',
				'id'            => '',             // Specific testimonial IDs.
			),
			$atts,
			'prime_testimonial_carousel'
		);

		// Sanitize attributes.
		$layout         = sanitize_key( $atts['layout'] );
		$count          = absint( $atts['count'] );
		$columns        = max( 1, min( 4, absint( $atts['columns'] ) ) );
		$group          = sanitize_text_field( $atts['group'] );
		$autoplay       = filter_var( $atts['autoplay'], FILTER_VALIDATE_BOOLEAN );
		$autoplay_speed = max( 1000, absint( $atts['autoplay_speed'] ) );
		$loop           = filter_var( $atts['loop'], FILTER_VALIDATE_BOOLEAN );
		$show_dots      = filter_var( $atts['show_dots'], FILTER_VALIDATE_BOOLEAN );
		$show_arrows    = filter_var( $atts['show_arrows'], FILTER_VALIDATE_BOOLEAN );
		$show_rating    = filter_var( $atts['show_rating'], FILTER_VALIDATE_BOOLEAN );
		$show_photo     = filter_var( $atts['show_photo'], FILTER_VALIDATE_BOOLEAN );
		$show_quote     = filter_var( $atts['show_quote_icon'], FILTER_VALIDATE_BOOLEAN );

		$valid_layouts = array( 'classic', 'card', 'modern', 'minimal', 'masonry', 'grid' );
		if ( ! in_array( $layout, $valid_layouts, true ) ) {
			$layout = 'classic';
		}

		// Build query.
		$query_args = array(
			'post_type'      => 'ptcrsl_testimonial',
			'post_status'    => 'publish',
			'posts_per_page' => $count,
			'orderby'        => sanitize_key( $atts['orderby'] ),
			'order'          => 'ASC' === strtoupper( $atts['order'] ) ? 'ASC' : 'DESC',
		);

		if ( ! empty( $atts['id'] ) ) {
			$ids                    = array_map( 'absint', explode( ',', $atts['id'] ) );
			$query_args['post__in'] = $ids;
		}

		if ( ! empty( $group ) ) {
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Required for group filtering feature; users can opt out by not setting the 'group' attribute.
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'ptcrsl_testimonial_group',
					'field'    => 'slug',
					'terms'    => $group,
				),
			);
		}

		$query = new WP_Query( $query_args );

		if ( ! $query->have_posts() ) {
			return '<p class="ptcrsl-no-testimonials">' . esc_html__( 'No testimonials found.', 'prime-testimonial-carousel' ) . '</p>';
		}

		// Enqueue assets when shortcode is actually used.
		wp_enqueue_style( 'ptcrsl-public' );
		wp_enqueue_script( 'ptcrsl-public' );

		// Unique ID for this carousel instance.
		$carousel_id = 'ptcrsl-carousel-' . wp_generate_uuid4();

		$config = array(
			'autoplay'      => $autoplay,
			'autoplaySpeed' => $autoplay_speed,
			'loop'          => $loop,
			'showDots'      => $show_dots,
			'showArrows'    => $show_arrows,
			'columns'       => $columns,
			'layout'        => $layout,
		);

		ob_start();
		?>
		<div
			id="<?php echo esc_attr( $carousel_id ); ?>"
			class="ptcrsl-carousel ptcrsl-layout-<?php echo esc_attr( $layout ); ?> ptcrsl-columns-<?php echo esc_attr( $columns ); ?>"
			data-config="<?php echo esc_attr( wp_json_encode( $config ) ); ?>"
		>
			<?php if ( 'grid' === $layout || 'masonry' === $layout ) : ?>
				<div class="ptcrsl-grid-wrapper">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						$this->render_testimonial_item( $show_photo, $show_rating, $show_quote, $layout );
					endwhile;
					?>
				</div>
			<?php else : ?>
				<div class="ptcrsl-carousel-viewport">
					<div class="ptcrsl-carousel-track">
						<?php
						while ( $query->have_posts() ) :
							$query->the_post();
							$this->render_testimonial_item( $show_photo, $show_rating, $show_quote, $layout );
						endwhile;
						?>
					</div>
				</div>

				<?php if ( $show_arrows ) : ?>
					<button type="button" class="ptcrsl-arrow ptcrsl-arrow-prev" aria-label="<?php esc_attr_e( 'Previous testimonial', 'prime-testimonial-carousel' ); ?>">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M13 4L7 10L13 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
					<button type="button" class="ptcrsl-arrow ptcrsl-arrow-next" aria-label="<?php esc_attr_e( 'Next testimonial', 'prime-testimonial-carousel' ); ?>">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M7 4L13 10L7 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				<?php endif; ?>

				<?php if ( $show_dots ) : ?>
					<div class="ptcrsl-dots" role="tablist"></div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php
		wp_reset_postdata();
		return ob_get_clean();
	}

	/**
	 * Render a single testimonial item.
	 *
	 * @param bool   $show_photo  Whether to show photo.
	 * @param bool   $show_rating Whether to show rating.
	 * @param bool   $show_quote  Whether to show quote icon.
	 * @param string $layout      Layout name.
	 */
	private function render_testimonial_item( $show_photo, $show_rating, $show_quote, $layout ) {
		$post_id        = get_the_ID();
		$author_name    = get_post_meta( $post_id, '_ptcrsl_author_name', true );
		$author_title   = get_post_meta( $post_id, '_ptcrsl_author_title', true );
		$author_company = get_post_meta( $post_id, '_ptcrsl_author_company', true );
		$author_url     = get_post_meta( $post_id, '_ptcrsl_author_url', true );
		$rating         = (int) get_post_meta( $post_id, '_ptcrsl_rating', true );

		// Fallback to title if author name not set.
		if ( empty( $author_name ) ) {
			$author_name = get_the_title();
		}
		?>
		<div class="ptcrsl-item">
			<div class="ptcrsl-item-inner">
				<?php if ( $show_quote ) : ?>
					<div class="ptcrsl-quote-icon" aria-hidden="true">
						<svg width="32" height="32" viewBox="0 0 32 32" fill="currentColor"><path d="M10 8C6.5 8 4 10.5 4 14v10h10V14H8c0-2 1.5-4 4-4V8zm14 0c-3.5 0-6 2.5-6 6v10h10V14h-6c0-2 1.5-4 4-4V8z"/></svg>
					</div>
				<?php endif; ?>

				<?php if ( $show_rating && $rating > 0 ) : ?>
					<div class="ptcrsl-rating" aria-label="<?php echo esc_attr( sprintf( /* translators: %d is the rating */ __( 'Rating: %d out of 5', 'prime-testimonial-carousel' ), $rating ) ); ?>">
						<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
							<span class="ptcrsl-star <?php echo $i <= $rating ? 'ptcrsl-star-filled' : ''; ?>" aria-hidden="true">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 1l2.2 4.5 5 .7-3.6 3.5.9 5L8 12.3 3.5 14.7l.9-5L.8 6.2l5-.7L8 1z"/></svg>
							</span>
						<?php endfor; ?>
					</div>
				<?php endif; ?>

				<div class="ptcrsl-content">
					<?php the_content(); ?>
				</div>

				<div class="ptcrsl-author">
					<?php if ( $show_photo && has_post_thumbnail() ) : ?>
						<div class="ptcrsl-author-photo">
							<?php the_post_thumbnail( 'thumbnail', array( 'alt' => esc_attr( $author_name ) ) ); ?>
						</div>
					<?php endif; ?>

					<div class="ptcrsl-author-info">
						<div class="ptcrsl-author-name">
							<?php if ( $author_url ) : ?>
								<a href="<?php echo esc_url( $author_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $author_name ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $author_name ); ?>
							<?php endif; ?>
						</div>
						<?php if ( $author_title || $author_company ) : ?>
							<div class="ptcrsl-author-meta">
								<?php echo esc_html( trim( $author_title . ( $author_title && $author_company ? ', ' : '' ) . $author_company ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
