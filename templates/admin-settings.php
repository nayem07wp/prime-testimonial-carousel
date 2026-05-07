<?php
/**
 * Admin settings page.
 *
 * @package PrimeTestimonialCarousel
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

$ptcrsl_settings = get_option(
	'ptcrsl_settings',
	array(
		'primary_color'   => '#0073aa',
		'secondary_color' => '#23282d',
		'text_color'      => '#333333',
		'bg_color'        => '#ffffff',
		'border_radius'   => '8',
		'enable_lazyload' => '1',
	)
);
?>
<div class="wrap ptcrsl-settings-wrapper">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'ptcrsl_settings_group' ); ?>

		<h2><?php esc_html_e( 'Appearance', 'prime-testimonial-carousel' ); ?></h2>
		<table class="form-table">
			<tr>
				<th scope="row"><label for="ptcrsl_primary_color"><?php esc_html_e( 'Primary Color', 'prime-testimonial-carousel' ); ?></label></th>
				<td><input type="color" id="ptcrsl_primary_color" name="ptcrsl_settings[primary_color]" value="<?php echo esc_attr( $ptcrsl_settings['primary_color'] ); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="ptcrsl_secondary_color"><?php esc_html_e( 'Secondary Color', 'prime-testimonial-carousel' ); ?></label></th>
				<td><input type="color" id="ptcrsl_secondary_color" name="ptcrsl_settings[secondary_color]" value="<?php echo esc_attr( $ptcrsl_settings['secondary_color'] ); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="ptcrsl_text_color"><?php esc_html_e( 'Text Color', 'prime-testimonial-carousel' ); ?></label></th>
				<td><input type="color" id="ptcrsl_text_color" name="ptcrsl_settings[text_color]" value="<?php echo esc_attr( $ptcrsl_settings['text_color'] ); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="ptcrsl_bg_color"><?php esc_html_e( 'Background Color', 'prime-testimonial-carousel' ); ?></label></th>
				<td><input type="color" id="ptcrsl_bg_color" name="ptcrsl_settings[bg_color]" value="<?php echo esc_attr( $ptcrsl_settings['bg_color'] ); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="ptcrsl_border_radius"><?php esc_html_e( 'Border Radius (px)', 'prime-testimonial-carousel' ); ?></label></th>
				<td><input type="number" id="ptcrsl_border_radius" name="ptcrsl_settings[border_radius]" value="<?php echo esc_attr( $ptcrsl_settings['border_radius'] ); ?>" min="0" max="50" /></td>
			</tr>
		</table>

		<h2><?php esc_html_e( 'Performance', 'prime-testimonial-carousel' ); ?></h2>
		<table class="form-table">
			<tr>
				<th scope="row"><?php esc_html_e( 'Lazy Load Images', 'prime-testimonial-carousel' ); ?></th>
				<td>
					<label>
						<input type="checkbox" name="ptcrsl_settings[enable_lazyload]" value="1" <?php checked( '1', isset( $ptcrsl_settings['enable_lazyload'] ) ? $ptcrsl_settings['enable_lazyload'] : '' ); ?> />
						<?php esc_html_e( 'Enable lazy loading for testimonial photos', 'prime-testimonial-carousel' ); ?>
					</label>
				</td>
			</tr>
		</table>

		<?php submit_button(); ?>
	</form>
</div>
