<?php
/**
 * MTQ Aceh Pidie Jaya Theme Customizer
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mtq_aceh_pidie_jaya_customize_register( $wp_customize ) {
	// Transport settings
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Footer Section
	$wp_customize->add_section(
		'mtq_footer_section',
		array(
			'title'       => __( 'Footer', 'mtq-aceh-pidie-jaya' ),
			'priority'    => 120,
			'description' => __( 'Pengaturan footer website', 'mtq-aceh-pidie-jaya' ),
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
				'label'    => __( 'Logo Footer', 'mtq-aceh-pidie-jaya' ),
				'section'  => 'mtq_footer_section',
				'settings' => 'footer_logo',
			)
		)
	);

	// Footer Text
	$wp_customize->add_setting(
		'footer_text',
		array(
			'default'           => __( '© 2025 MTQ Aceh XXXVII Pidie Jaya. All rights reserved.', 'mtq-aceh-pidie-jaya' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'footer_text',
		array(
			'label'    => __( 'Teks Footer', 'mtq-aceh-pidie-jaya' ),
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
			'label'    => __( 'Alamat', 'mtq-aceh-pidie-jaya' ),
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

    if ( isset( $wp_customize->selective_refresh ) ) {
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
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function mtq_aceh_pidie_jaya_customize_partial_blogdescription() {
	bloginfo( 'description' );
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
		array( 'customize-preview' ),
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
function mtq_aceh_pidie_jaya_sanitize_phone( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

// Register customizer settings.
add_action( 'customize_register', 'mtq_aceh_pidie_jaya_customize_register' );

// Enqueue preview JS.
add_action( 'customize_preview_init', 'mtq_aceh_pidie_jaya_customize_preview_js' );
