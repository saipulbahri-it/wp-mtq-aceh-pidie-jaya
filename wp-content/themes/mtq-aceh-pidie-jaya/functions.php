<?php

/**
 * MTQ Aceh Pidie Jaya functions and definitions
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

// Define theme version
if (! defined('_S_VERSION')) {
	define('_S_VERSION', '1.0.0');
}

// Include additional theme files
require get_template_directory() . '/inc/block-patterns.php';
require get_template_directory() . '/inc/translation.php';
require get_template_directory() . '/inc/widgets.php';
require get_template_directory() . '/inc/shortcodes.php';
require get_template_directory() . '/inc/cabang-lomba.php';
require get_template_directory() . '/inc/social-analytics-dashboard.php';
require get_template_directory() . '/inc/countdown-admin.php';
require get_template_directory() . '/inc/youtube-live-admin.php';
require get_template_directory() . '/inc/youtube-live-display.php';
require get_template_directory() . '/inc/menus.php';

// Include gallery system files
require get_template_directory() . '/inc/gallery-post-type.php';
require get_template_directory() . '/inc/gallery-shortcodes.php';

// Initialize gallery system
function mtq_init_gallery_system() {
    // Initialize gallery post type
    new MTQ_Gallery_Post_Type();
    new MTQ_Gallery_Shortcodes();
    
    // Check if we need to flush permalinks
    $permalinks_flushed = get_option('mtq_gallery_permalinks_flushed');
    $theme_version = get_option('mtq_theme_version', '1.0.0');
    
    // Force flush if:
    // 1. Never flushed before
    // 2. Theme version changed
    // 3. Gallery post type not working (emergency check)
    if ($permalinks_flushed !== 'yes' || 
        $theme_version !== '1.1.0' || 
        !get_post_type_archive_link('mtq_gallery')) {
        
        flush_rewrite_rules(true);
        update_option('mtq_gallery_permalinks_flushed', 'yes');
        update_option('mtq_theme_version', '1.1.0');
        
        // Log the flush for debugging
        if (WP_DEBUG) {
            error_log('MTQ Gallery: Permalinks flushed at ' . current_time('mysql'));
        }
    }
}
add_action('init', 'mtq_init_gallery_system', 5); // Earlier priority to ensure registration

// Debug gallery admin checks removed (legacy)

// Flush permalinks on theme activation
function mtq_theme_activation() {
    // Force permalink flush on theme activation
    delete_option('mtq_gallery_permalinks_flushed');
    delete_option('mtq_theme_version');
    flush_rewrite_rules(true);
    
    // Set flag to flush again on next init
    update_option('mtq_gallery_needs_flush', 'yes');
}
add_action('after_switch_theme', 'mtq_theme_activation');

// Emergency permalink flush check
function mtq_emergency_permalink_check() {
    // Only run this on admin pages to avoid performance issues
    if (!is_admin()) {
        return;
    }
    
    if (get_option('mtq_gallery_needs_flush') === 'yes') {
        flush_rewrite_rules(true);
        delete_option('mtq_gallery_needs_flush');
        update_option('mtq_gallery_permalinks_flushed', 'yes');
    }
}
add_action('admin_init', 'mtq_emergency_permalink_check');

// Admin notice untuk gallery setup
function mtq_gallery_admin_notice() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Check if gallery post type is registered
    if (!post_type_exists('mtq_gallery')) {
        ?>
		<div class="notice notice-error is-dismissible">
			<p><strong>❌ MTQ Gallery System Error:</strong> 
			Gallery post type tidak terdaftar! Periksa file theme atau hubungi developer.
			</p>
		</div>
        <?php
    } elseif (!get_option('mtq_gallery_permalinks_flushed')) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>⚠️ MTQ Gallery System:</strong> 
            Jika mengalami masalah "Halaman Galeri Tidak Ditemukan", 
            silakan pergi ke <a href="<?php echo admin_url('options-permalink.php'); ?>">Settings → Permalinks</a> 
            dan klik "Save Changes" untuk refresh permalink structure.
            </p>
        </div>
        <?php
    } else {
        // Gallery working fine, show success notice only if requested
        if (isset($_GET['gallery_debug']) && $_GET['gallery_debug'] === 'success') {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>✅ MTQ Gallery System:</strong> 
                Gallery berhasil terdaftar dan siap digunakan! 
                <a href="<?php echo admin_url('post-new.php?post_type=mtq_gallery'); ?>">Buat Gallery Baru</a>
                </p>
            </div>
            <?php
        }
    }
}
add_action('admin_notices', 'mtq_gallery_admin_notice');

if (! function_exists('mtq_aceh_pidie_jaya_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mtq_aceh_pidie_jaya_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain('mtq-aceh-pidie-jaya', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary', 'mtq-aceh-pidie-jaya'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'mtq_aceh_pidie_jaya_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'mtq_aceh_pidie_jaya_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mtq_aceh_pidie_jaya_content_width()
{
	$GLOBALS['content_width'] = apply_filters('mtq_aceh_pidie_jaya_content_width', 640);
}
add_action('after_setup_theme', 'mtq_aceh_pidie_jaya_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mtq_aceh_pidie_jaya_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'mtq-aceh-pidie-jaya'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'mtq-aceh-pidie-jaya'),
			'before_widget' => '<section id="%1$s" class="widget %2$s rounded-xl bg-white ring-1 ring-slate-200/60 shadow-sm overflow-hidden"><div class="p-5">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h2 class="widget-title text-base font-semibold text-slate-800 mb-3 flex items-center gap-2"><span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-600"></span>',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'mtq_aceh_pidie_jaya_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function mtq_aceh_pidie_jaya_scripts() {

   // Always enqueue theme style.css
   wp_enqueue_style('mtq-aceh-pidie-jaya-style', get_stylesheet_uri(), array(), _S_VERSION);
   wp_style_add_data('mtq-aceh-pidie-jaya-style', 'rtl', 'replace');

   // Enqueue Google Fonts
   wp_enqueue_style('mtq-aceh-pidie-jaya-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap', array(), null);

   // Enqueue built Tailwind CSS if exists
   $dist_css = get_template_directory() . '/dist/app.css';
   if (file_exists($dist_css)) {
	   wp_enqueue_style('mtq-aceh-pidie-jaya-app', get_template_directory_uri() . '/dist/app.css', array(), filemtime($dist_css));
   }

   // Enqueue social sharing CSS
   wp_enqueue_style('mtq-social-sharing-css', get_template_directory_uri() . '/assets/css/social-sharing.css', array(), _S_VERSION);

   // Enqueue sticky header styles
   wp_enqueue_style('mtq-sticky-header-css', get_template_directory_uri() . '/assets/css/sticky-header.css', array(), _S_VERSION);
   
   // Enqueue countdown enhanced styles
   wp_enqueue_style('mtq-countdown-enhanced-css', get_template_directory_uri() . '/assets/css/countdown-enhanced.css', array(), _S_VERSION);
   
   // Countdown display styles for show/hide functionality
   wp_enqueue_style('mtq-countdown-display-css', get_template_directory_uri() . '/assets/css/countdown-display.css', array(), _S_VERSION);
   
   // Enqueue main JavaScript
	wp_enqueue_script('mtq-aceh-pidie-jaya-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	// Enqueue main JavaScript (UI interactions)
	wp_enqueue_script('mtq-aceh-pidie-jaya-main-js', get_template_directory_uri() . '/assets/js/index.js', array(), _S_VERSION, true);
	
	// Enqueue arena-specific JavaScript for arena page only
	if (is_page_template('page-arena-dan-lokasi.php') || is_page('arena-dan-lokasi') || is_page('arena-dan-lokasi-mtq')) {
		wp_enqueue_script('mtq-aceh-pidie-jaya-arena-js', get_template_directory_uri() . '/assets/js/arena.js', array(), _S_VERSION, true);
	}
	
    // Enqueue gallery JavaScript site-wide so any gallery markup works (CPT, blocks, or templates)
    wp_enqueue_script('mtq-aceh-pidie-jaya-gallery-js', get_template_directory_uri() . '/assets/js/gallery.js', array(), _S_VERSION, true);
	
	// Countdown with dynamic configuration
	wp_enqueue_script('mtq-aceh-pidie-jaya-countdown', get_template_directory_uri() . '/assets/js/countdown.js', array(), _S_VERSION, true);
	
	// Localize countdown configuration for JavaScript
	wp_localize_script('mtq-aceh-pidie-jaya-countdown', 'mtqCountdownConfig', array(
		'targetDate' => get_option('mtq_event_date', '2025-11-01T07:00:00'),
		'eventTitle' => get_option('mtq_event_title', 'MTQ Aceh XXXVII Pidie Jaya 2025'),
		'eventLocation' => get_option('mtq_event_location', 'Kabupaten Pidie Jaya, Aceh'),
		'status' => get_option('mtq_countdown_status', 'active'),
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('mtq_countdown_nonce')
	));
	
	// Enqueue sticky header JavaScript
	wp_enqueue_script('mtq-sticky-header-js', get_template_directory_uri() . '/assets/js/sticky-header.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'mtq_aceh_pidie_jaya_scripts');

/**
 * Add countdown display classes to body
 */
function mtq_countdown_body_classes($classes) {
	// Get countdown display settings
	$show_title = get_option('mtq_show_title', true);
	$show_date = get_option('mtq_show_date', true);
	$show_location = get_option('mtq_show_location', true);
	$show_progress = get_option('mtq_show_progress', true);
	
	// Add classes based on settings
	if (!$show_title) {
		$classes[] = 'hide-countdown-title';
	}
	
	if (!$show_date) {
		$classes[] = 'hide-countdown-date';
	}
	
	if (!$show_location) {
		$classes[] = 'hide-countdown-location';
	}
	
	if (!$show_progress) {
		$classes[] = 'hide-countdown-progress';
	}
	
	return $classes;
}
add_filter('body_class', 'mtq_countdown_body_classes');

/**
 * Add admin bar compatibility for sticky header
 */
function mtq_admin_bar_compatibility() {
	// Add body class for admin bar compatibility
	if (is_admin_bar_showing()) {
		add_filter('body_class', function($classes) {
			$classes[] = 'has-admin-bar';
			return $classes;
		});
	}
}
add_action('wp_head', 'mtq_admin_bar_compatibility');

/**
 * Add inline styles for admin bar compatibility
 */
function mtq_admin_bar_inline_styles() {
	if (is_admin_bar_showing()) {
		?>
		<style type="text/css">
			/* Ensure admin bar doesn't conflict with sticky header */
			html {
				margin-top: 0 !important;
			}
			
			/* Additional admin bar fixes for mobile */
			@media screen and (max-width: 782px) {
				html.wp-toolbar {
					margin-top: 0 !important;
				}
			}
		</style>
		<?php
	}
}
add_action('wp_head', 'mtq_admin_bar_inline_styles');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/security.php';
require get_template_directory() . '/inc/reading-time.php';
require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/related-posts.php';
require get_template_directory() . '/inc/social-sharing.php';
require get_template_directory() . '/inc/ajax.php';
require get_template_directory() . '/inc/featured-post.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

// moved to inc/security.php

// moved to inc/reading-time.php

// moved to inc/breadcrumbs.php

// moved to inc/related-posts.php

// Include Related Posts Widget
require get_template_directory() . '/inc/class-related-posts-widget.php';

/**
 * Related Posts Shortcode
 */
// moved to inc/related-posts.php (shortcode)

// Categories and tags setup completed - function removed

// moved to inc/security.php

// moved to inc/social-sharing.php

/**
 * =========================================
 * END SOCIAL SHARING FUNCTIONALITY
 * =========================================
 */

/**
 * =========================================
 * YOUTUBE LIVE INITIALIZATION
 * =========================================
 */

// Initialize YouTube Live classes
function mtq_init_youtube_live() {
    if (class_exists('MTQ_YouTube_Live_Admin')) {
        new MTQ_YouTube_Live_Admin();
    }
    if (class_exists('MTQ_YouTube_Live_Display')) {
        new MTQ_YouTube_Live_Display();
    }
}
add_action('init', 'mtq_init_youtube_live');

/**
 * =========================================
 * END YOUTUBE LIVE INITIALIZATION
 * =========================================
 */

// moved to inc/ajax.php (mtq_ajax_track_post_view)

// moved to inc/ajax.php (mtq_ajax_load_more_posts)

// moved to inc/featured-post.php

// moved to inc/ajax.php (mtq_ajax_load_more_category)

// moved to inc/ajax.php (mtq_ajax_load_more_news_page)