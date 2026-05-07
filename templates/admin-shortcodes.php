<?php
/**
 * Shortcode documentation page.
 *
 * @package PrimeTestimonialCarousel
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<div class="wrap ptcrsl-settings-wrapper">
	<h1><?php esc_html_e( 'Shortcode Usage', 'prime-testimonial-carousel' ); ?></h1>

	<p><?php esc_html_e( 'Use the following shortcode to display testimonials anywhere on your site. Click any example to copy it.', 'prime-testimonial-carousel' ); ?></p>

	<div class="ptcrsl-shortcode-box">
		<h3><?php esc_html_e( 'Basic Usage', 'prime-testimonial-carousel' ); ?></h3>
		<code>[prime_testimonial_carousel]</code>
	</div>

	<div class="ptcrsl-shortcode-box">
		<h3><?php esc_html_e( 'Classic Carousel - 3 columns', 'prime-testimonial-carousel' ); ?></h3>
		<code>[prime_testimonial_carousel layout="classic" columns="3" count="6"]</code>
	</div>

	<div class="ptcrsl-shortcode-box">
		<h3><?php esc_html_e( 'Modern Card Layout', 'prime-testimonial-carousel' ); ?></h3>
		<code>[prime_testimonial_carousel layout="modern" columns="2" autoplay="true"]</code>
	</div>

	<div class="ptcrsl-shortcode-box">
		<h3><?php esc_html_e( 'Masonry Grid (non-carousel)', 'prime-testimonial-carousel' ); ?></h3>
		<code>[prime_testimonial_carousel layout="masonry" count="9"]</code>
	</div>

	<div class="ptcrsl-shortcode-box">
		<h3><?php esc_html_e( 'Filtered by Group', 'prime-testimonial-carousel' ); ?></h3>
		<code>[prime_testimonial_carousel group="homepage" layout="card"]</code>
	</div>

	<h2><?php esc_html_e( 'All Parameters', 'prime-testimonial-carousel' ); ?></h2>

	<table class="ptcrsl-param-table">
		<thead>
			<tr>
				<th><?php esc_html_e( 'Parameter', 'prime-testimonial-carousel' ); ?></th>
				<th><?php esc_html_e( 'Default', 'prime-testimonial-carousel' ); ?></th>
				<th><?php esc_html_e( 'Description', 'prime-testimonial-carousel' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr><td><code>layout</code></td><td><code>classic</code></td><td><?php esc_html_e( 'Options: classic, card, modern, minimal, masonry, grid', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>count</code></td><td><code>10</code></td><td><?php esc_html_e( 'Number of testimonials to display', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>columns</code></td><td><code>3</code></td><td><?php esc_html_e( 'Columns on desktop (1-4)', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>group</code></td><td>—</td><td><?php esc_html_e( 'Filter by testimonial group slug', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>autoplay</code></td><td><code>true</code></td><td><?php esc_html_e( 'Auto-advance the carousel', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>autoplay_speed</code></td><td><code>5000</code></td><td><?php esc_html_e( 'Speed in milliseconds', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>loop</code></td><td><code>true</code></td><td><?php esc_html_e( 'Loop back to the start', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>show_dots</code></td><td><code>true</code></td><td><?php esc_html_e( 'Show navigation dots', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>show_arrows</code></td><td><code>true</code></td><td><?php esc_html_e( 'Show prev/next arrows', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>show_rating</code></td><td><code>true</code></td><td><?php esc_html_e( 'Show star ratings', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>show_photo</code></td><td><code>true</code></td><td><?php esc_html_e( 'Show author photos', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>show_quote_icon</code></td><td><code>true</code></td><td><?php esc_html_e( 'Show decorative quote icon', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>order</code></td><td><code>DESC</code></td><td><?php esc_html_e( 'Sort direction (ASC or DESC)', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>orderby</code></td><td><code>date</code></td><td><?php esc_html_e( 'Options: date, title, menu_order, rand', 'prime-testimonial-carousel' ); ?></td></tr>
			<tr><td><code>id</code></td><td>—</td><td><?php esc_html_e( 'Comma-separated post IDs to include specific testimonials', 'prime-testimonial-carousel' ); ?></td></tr>
		</tbody>
	</table>
</div>
