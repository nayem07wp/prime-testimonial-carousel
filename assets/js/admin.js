/**
 * Prime Testimonial Carousel - Admin Script
 */
(function ($) {
	'use strict';

	$(function () {
		// Copy shortcode to clipboard on click.
		$('.ptcrsl-shortcode-box code').on('click', function () {
			var text = $(this).text();
			if (navigator.clipboard) {
				navigator.clipboard.writeText(text);
				var $el = $(this);
				var original = $el.text();
				$el.text('Copied!');
				setTimeout(function () {
					$el.text(original);
				}, 1500);
			}
		});
	});
})(jQuery);
