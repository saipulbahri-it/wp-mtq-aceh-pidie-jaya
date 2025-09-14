<?php
// Footer Related Links Customizer
add_action('customize_register', function ($wp_customize) {
	$wp_customize->add_section('footer_related_links', [
		'title' => __('Footer: Link Terkait', 'mtq-aceh-pidie-jaya'),
		'priority' => 80,
	]);

	for ($i = 1; $i <= 4; $i++) {
		// Default values
		$default_labels = [
			1 => __('Pemerintah Aceh', 'mtq-aceh-pidie-jaya'),
			2 => __('Pemerintah Pidie Jaya', 'mtq-aceh-pidie-jaya'),
			3 => __('Kementerian Agama RI', 'mtq-aceh-pidie-jaya'),
			4 => __('MTQ Nasional', 'mtq-aceh-pidie-jaya'),
		];
		$default_urls = [
			1 => 'https://acehprov.go.id',
			2 => 'https://pidiejayakab.go.id',
			3 => 'https://kemenag.go.id',
			4 => 'https://lptqnasional.com',
		];

		$wp_customize->add_setting("footer_related_link_label_$i", [
			'default' => $default_labels[$i],
			'sanitize_callback' => 'sanitize_text_field',
		]);
		$wp_customize->add_setting("footer_related_link_url_$i", [
			'default' => $default_urls[$i],
			'sanitize_callback' => 'esc_url_raw',
		]);
		$wp_customize->add_control("footer_related_link_label_$i", [
			'label' => __('Label Link Terkait #', 'mtq-aceh-pidie-jaya') . $i,
			'section' => 'footer_related_links',
			'type' => 'text',
		]);
		$wp_customize->add_control("footer_related_link_url_$i", [
			'label' => __('URL Link Terkait #', 'mtq-aceh-pidie-jaya') . $i,
			'section' => 'footer_related_links',
			'type' => 'url',
		]);
	}
});
?>
<?php
/**
 * MTQ Aceh Pidie Jaya Theme Customizer
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mtq_aceh_pidie_jaya_customize_register($wp_customize) {
	// Transport settings
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

	// Location Map Section
	$wp_customize->add_section(
		'mtq_location_section',
		array(
			'title'       => __('Peta Lokasi', 'mtq-aceh-pidie-jaya'),
			'priority'    => 115,
			'description' => __('Pengaturan peta dan lokasi event MTQ', 'mtq-aceh-pidie-jaya'),
		)
	);

	// Map Embed URL
	$default_map_url = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4852.693491674251!2d96.24198147580853!3d5.230074394747693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3040b100162f57eb%3A0xf5697ff0a3aa42fe!2sGEDUNG%20MTQ%20PIDIE%20JAYA!5e1!3m2!1sid!2sid!4v1757497686875!5m2!1sid!2sid';

	$wp_customize->add_setting(
		'location_map_url',
		array(
			'default'           => $default_map_url,
			'sanitize_callback' => function ($url) use ($default_map_url) {
				$cleaned_url = esc_url_raw($url);
				return !empty($cleaned_url) ? $cleaned_url : $default_map_url;
			},
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'location_map_url',
		array(
			'label'       => __('URL Google Maps', 'mtq-aceh-pidie-jaya'),
			'description' => __('Masukkan URL embed Google Maps (https://www.google.com/maps/embed?...)', 'mtq-aceh-pidie-jaya'),
			'section'     => 'mtq_location_section',
			'type'        => 'url',
		)
	);

	// Map Height
	$wp_customize->add_setting(
		'location_map_height',
		array(
			'default'           => '400',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'location_map_height',
		array(
			'label'       => __('Tinggi Peta (px)', 'mtq-aceh-pidie-jaya'),
			'description' => __('Atur tinggi peta dalam pixel', 'mtq-aceh-pidie-jaya'),
			'section'     => 'mtq_location_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 200,
				'max'  => 800,
				'step' => 10,
			),
		)
	);

	// Location Title
	$wp_customize->add_setting(
		'location_title',
		array(
			'default'           => __('Lokasi Penyelenggaraan MTQ XXXVII Aceh', 'mtq-aceh-pidie-jaya'),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'location_title',
		array(
			'label'    => __('Judul Lokasi', 'mtq-aceh-pidie-jaya'),
			'section'  => 'mtq_location_section',
			'type'     => 'text',
		)
	);

	// Location Description
	$wp_customize->add_setting(
		'location_description',
		array(
			'default'           => __('MTQ XXXVII Aceh akan diselenggarakan di Kompleks Perkantoran Bupati Pidie Jaya, yang berlokasi di Jalan Banda Aceh-Medan KM. 156.5, Kecamatan Meureudu, Kabupaten Pidie Jaya.', 'mtq-aceh-pidie-jaya'),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'location_description',
		array(
			'label'    => __('Deskripsi Lokasi', 'mtq-aceh-pidie-jaya'),
			'section'  => 'mtq_location_section',
			'type'     => 'textarea',
		)
	);

	// Footer Section
	$wp_customize->add_section(
		'mtq_footer_section',
		array(
			'title'       => __('Footer', 'mtq-aceh-pidie-jaya'),
			'priority'    => 120,
			'description' => __('Pengaturan footer website', 'mtq-aceh-pidie-jaya'),
		)
	);

	// Footer Logo
	$wp_customize->add_setting(
		'footer_logo',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'footer_logo',
			array(
				'label'    => __('Logo Footer', 'mtq-aceh-pidie-jaya'),
				'section'  => 'mtq_footer_section',
				'settings' => 'footer_logo',
			)
		)
	);

	// Footer Text
	$wp_customize->add_setting(
		'footer_text',
		array(
			'default'           => __('© 2025 MTQ Aceh XXXVII Pidie Jaya. All rights reserved.', 'mtq-aceh-pidie-jaya'),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'footer_text',
		array(
			'label'    => __('Teks Footer', 'mtq-aceh-pidie-jaya'),
			'section'  => 'mtq_footer_section',
			'type'     => 'textarea',
		)
	);

	// Footer Address
	$wp_customize->add_setting(
		'footer_address',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'footer_address',
		array(
			'label'    => __('Alamat', 'mtq-aceh-pidie-jaya'),
			'section'  => 'mtq_footer_section',
			'type'     => 'textarea',
		)
	);

	// Footer Email
	$wp_customize->add_setting(
		'footer_email',
		array(
			'default'           => 'info@mtq.pidiejayakab.go.id',
			'sanitize_callback' => 'sanitize_email',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'footer_email',
		array(
			'label'    => __('Email', 'mtq-aceh-pidie-jaya'),
			'section'  => 'mtq_footer_section',
			'type'     => 'email',
		)
	);

	// Footer Phone
	$wp_customize->add_setting(
		'footer_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'mtq_aceh_pidie_jaya_sanitize_phone',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'footer_phone',
		array(
			'label'    => __('Nomor Telepon', 'mtq-aceh-pidie-jaya'),
			'section'  => 'mtq_footer_section',
			'type'     => 'text',
		)
	);

	// Social Media Links
	$social_platforms = array(
		'facebook'  => __('Facebook URL', 'mtq-aceh-pidie-jaya'),
		'instagram' => __('Instagram URL', 'mtq-aceh-pidie-jaya'),
		'youtube'   => __('YouTube URL', 'mtq-aceh-pidie-jaya'),
		'twitter'   => __('Twitter URL', 'mtq-aceh-pidie-jaya'),
	);

	foreach ($social_platforms as $platform => $label) {
		$wp_customize->add_setting(
			'footer_social_' . $platform,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'footer_social_' . $platform,
			array(
				'label'    => $label,
				'section'  => 'mtq_footer_section',
				'type'     => 'url',
			)
		);
	}

	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'mtq_aceh_pidie_jaya_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'mtq_aceh_pidie_jaya_customize_partial_blogdescription',
			)
		);
	}
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function mtq_aceh_pidie_jaya_customize_partial_blogname() {
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function mtq_aceh_pidie_jaya_customize_partial_blogdescription() {
	bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @return void
 */
function mtq_aceh_pidie_jaya_customize_preview_js() {
	wp_enqueue_script(
		'mtq-aceh-pidie-jaya-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array('customize-preview'),
		_S_VERSION,
		true
	);
}

/**
 * Sanitize phone number.
 *
 * @param string $phone Phone number to sanitize.
 * @return string Sanitized phone number.
 */
function mtq_aceh_pidie_jaya_sanitize_phone($phone) {
	return preg_replace('/[^\d+]/', '', $phone);
}

// Register customizer settings.
add_action('customize_register', 'mtq_aceh_pidie_jaya_customize_register');

// Enqueue preview JS.
add_action('customize_preview_init', 'mtq_aceh_pidie_jaya_customize_preview_js');
