<?php

/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses mtq_aceh_pidie_jaya_header_style()
 */
function mtq_aceh_pidie_jaya_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'mtq_aceh_pidie_jaya_custom_header_args',
			array(
				'default-image' => '',
				'default-text-color' => '000000',
				'width' => 1000,
				'height' => 250,
				'flex-height' => true,
				'wp-head-callback' => 'mtq_aceh_pidie_jaya_header_style',
			)
		)
	);
}
add_action('after_setup_theme', 'mtq_aceh_pidie_jaya_custom_header_setup');

if (! function_exists('mtq_aceh_pidie_jaya_header_style')) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see mtq_aceh_pidie_jaya_custom_header_setup().
	 */
	function mtq_aceh_pidie_jaya_header_style() {
		$header_text_color = get_header_textcolor();

		/** 
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if (get_theme_support('custom-header', 'default-text-color') === $header_text_color) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		echo '<style type="text/css">';
		
		if (!display_header_text()) {
			echo '
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}';
		} else {
			echo '
			.site-title a,
			.site-description {
				color: #' . esc_attr($header_text_color) . ';
			}';
		}
		
		echo '</style>';
	}
endif;
