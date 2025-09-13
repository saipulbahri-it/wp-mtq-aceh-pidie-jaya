<?php
// Register navigation menus
add_action('after_setup_theme', function() {
	register_nav_menus([
		'top-header-menu' => __('Top Header Menu', 'mtq-aceh-pidie-jaya'),
	]);
});

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

// Debug function to check gallery registration
function mtq_debug_gallery_registration() {
    if (is_admin() && current_user_can('manage_options')) {
        if (!post_type_exists('mtq_gallery')) {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error"><p><strong>MTQ Gallery:</strong> Post type tidak terdaftar! Check theme files.</p></div>';
            });
        } else {
            // Gallery registered successfully
            if (isset($_GET['debug_gallery'])) {
                add_action('admin_notices', function() {
                    echo '<div class="notice notice-success"><p><strong>MTQ Gallery:</strong> Post type berhasil terdaftar!</p></div>';
                });
            }
        }
    }
}
add_action('admin_init', 'mtq_debug_gallery_registration');

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
            <a href="<?php echo admin_url('admin.php?page=debug_gallery'); ?>">Debug Gallery</a>
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
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
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

/**
 * Force HTTPS for all URLs
 */
function mtq_force_https_urls() {
	if (!is_ssl() && !is_admin()) {
		if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
			$_SERVER['HTTPS'] = 'on';
		}
	}
}
add_action('init', 'mtq_force_https_urls');

/**
 * Replace HTTP with HTTPS in content
 */
function mtq_replace_http_with_https($content) {
	$content = str_replace('http://mtq.pidiejayakab.go.id', 'https://mtq.pidiejayakab.go.id', $content);
	return $content;
}
add_filter('the_content', 'mtq_replace_http_with_https');
add_filter('widget_text', 'mtq_replace_http_with_https');

/**
 * Secure headers for better security
 */
function mtq_add_security_headers() {
	if (!headers_sent()) {
		header('X-Frame-Options: SAMEORIGIN');
		header('X-XSS-Protection: 1; mode=block');
		header('X-Content-Type-Options: nosniff');
		header('Referrer-Policy: strict-origin-when-cross-origin');
		
		if (is_ssl()) {
			header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
		}
	}
}
add_action('send_headers', 'mtq_add_security_headers');

/**
 * Reading time shortcode
 */
function mtq_reading_time_shortcode($atts) {
	global $post;
	
	if (!$post) {
		return '5';
	}
	
	$content = get_post_field('post_content', $post->ID);
	$word_count = str_word_count(strip_tags($content));
	$reading_time = ceil($word_count / 200); // Average reading speed 200 words per minute
	
	return max(1, $reading_time); // Minimum 1 minute
}
add_shortcode('reading_time', 'mtq_reading_time_shortcode');

/**
 * Estimated reading time function
 */
function mtq_get_reading_time($post_id = null) {
	if (!$post_id) {
		global $post;
		$post_id = $post->ID;
	}
	
	$content = get_post_field('post_content', $post_id);
	$word_count = str_word_count(strip_tags($content));
	$reading_time = ceil($word_count / 200);
	
	return max(1, $reading_time);
}

/**
 * Breadcrumbs Helper Functions
 */

// Enable breadcrumbs on specific post types
function mtq_enable_breadcrumbs_for_post_type($post_type) {
	$allowed_post_types = ['post', 'page', 'product', 'event'];
	return in_array($post_type, $allowed_post_types);
}

// Get breadcrumb schema markup for SEO
function mtq_get_breadcrumb_schema() {
	if (is_front_page()) {
		return '';
	}
	
	$breadcrumbs = [];
	$position = 1;
	
	// Home
	$breadcrumbs[] = [
		'@type' => 'ListItem',
		'position' => $position++,
		'name' => get_bloginfo('name'),
		'item' => home_url('/')
	];
	
	if (is_single() && get_post_type() == 'post') {
		// Blog page
		$blog_page_id = get_option('page_for_posts');
		if ($blog_page_id) {
			$breadcrumbs[] = [
				'@type' => 'ListItem',
				'position' => $position++,
				'name' => get_the_title($blog_page_id),
				'item' => get_permalink($blog_page_id)
			];
		}
		
		// Category
		$categories = get_the_category();
		if ($categories) {
			$breadcrumbs[] = [
				'@type' => 'ListItem',
				'position' => $position++,
				'name' => $categories[0]->name,
				'item' => get_category_link($categories[0]->term_id)
			];
		}
		
		// Current post
		$breadcrumbs[] = [
			'@type' => 'ListItem',
			'position' => $position++,
			'name' => get_the_title()
		];
	}
	
	$schema = [
		'@context' => 'https://schema.org',
		'@type' => 'BreadcrumbList',
		'itemListElement' => $breadcrumbs
	];
	
	return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
}

// Add breadcrumb schema to head
function mtq_add_breadcrumb_schema() {
	if (!is_front_page()) {
		echo mtq_get_breadcrumb_schema();
	}
}
add_action('wp_head', 'mtq_add_breadcrumb_schema');

/**
 * Related Posts Helper Functions
 */

// Cache related posts for better performance
function mtq_get_cached_related_posts($post_id, $limit = 6) {
	$cache_key = "mtq_related_posts_{$post_id}_{$limit}";
	$cached_posts = wp_cache_get($cache_key, 'mtq_related_posts');
	
	if ($cached_posts !== false) {
		return $cached_posts;
	}
	
	$related_posts = mtq_get_related_posts($post_id, $limit);
	
	// Cache for 1 hour
	wp_cache_set($cache_key, $related_posts, 'mtq_related_posts', HOUR_IN_SECONDS);
	
	return $related_posts;
}

// Clear related posts cache when posts are updated
function mtq_clear_related_posts_cache($post_id) {
	// Clear cache for this post and related posts
	wp_cache_delete("mtq_related_posts_{$post_id}_6", 'mtq_related_posts');
	
	// Get categories and tags to clear cache for related posts
	$categories = wp_get_post_categories($post_id);
	$tags = wp_get_post_tags($post_id);
	
	if (!empty($categories) || !empty($tags)) {
		// Clear cache for posts in same categories/tags
		$args = [
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => 50,
			'fields' => 'ids'
		];
		
		if (!empty($categories)) {
			$args['category__in'] = $categories;
		}
		
		if (!empty($tags)) {
			$args['tag__in'] = wp_list_pluck($tags, 'term_id');
		}
		
		$related_post_ids = get_posts($args);
		
		foreach ($related_post_ids as $id) {
			wp_cache_delete("mtq_related_posts_{$id}_6", 'mtq_related_posts');
		}
	}
}

add_action('save_post', 'mtq_clear_related_posts_cache');
add_action('delete_post', 'mtq_clear_related_posts_cache');

// Enhanced algorithm with content similarity
function mtq_calculate_content_similarity($post_id_1, $post_id_2) {
	$post_1 = get_post($post_id_1);
	$post_2 = get_post($post_id_2);
	
	if (!$post_1 || !$post_2) {
		return 0;
	}
	
	// Extract keywords from titles
	$title_1_words = array_map('strtolower', explode(' ', $post_1->post_title));
	$title_2_words = array_map('strtolower', explode(' ', $post_2->post_title));
	
	// Remove common words (stopwords)
	$stopwords = ['dan', 'atau', 'yang', 'di', 'ke', 'dari', 'untuk', 'pada', 'dengan', 'dalam', 'adalah', 'ini', 'itu', 'akan', 'telah', 'sudah', 'dapat', 'bisa'];
	$title_1_words = array_diff($title_1_words, $stopwords);
	$title_2_words = array_diff($title_2_words, $stopwords);
	
	// Calculate intersection
	$common_words = array_intersect($title_1_words, $title_2_words);
	
	if (empty($title_1_words) || empty($title_2_words)) {
		return 0;
	}
	
	// Jaccard similarity coefficient
	$union_size = count(array_unique(array_merge($title_1_words, $title_2_words)));
	$intersection_size = count($common_words);
	
	return $union_size > 0 ? $intersection_size / $union_size : 0;
}

// Get trending posts (posts with high engagement)
function mtq_get_trending_posts($limit = 6, $exclude_ids = []) {
	$args = [
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => $limit,
		'post__not_in' => $exclude_ids,
		'date_query' => [
			[
				'after' => '30 days ago'
			]
		],
		'meta_query' => [
			[
				'key' => '_thumbnail_id',
				'compare' => 'EXISTS'
			]
		],
		// Order by comment count as engagement metric
		'orderby' => 'comment_count',
		'order' => 'DESC'
	];
	
	$query = new WP_Query($args);
	$posts = $query->posts;
	wp_reset_postdata();
	
	return $posts;
}

// Add related posts to RSS feeds
function mtq_add_related_posts_to_rss($content) {
	if (is_feed() && is_single()) {
		$related_posts = mtq_get_related_posts(get_the_ID(), 3);
		
		if (!empty($related_posts)) {
			$content .= '<h3>Artikel Terkait:</h3><ul>';
			
			foreach ($related_posts as $post) {
				$content .= '<li><a href="' . get_permalink($post->ID) . '">' . get_the_title($post->ID) . '</a></li>';
			}
			
			$content .= '</ul>';
		}
	}
	
	return $content;
}

add_filter('the_content_feed', 'mtq_add_related_posts_to_rss');

// Track post views for better recommendations
function mtq_track_post_views($post_id = null) {
	if (!$post_id) {
		$post_id = get_the_ID();
	}
	
	if (!$post_id || is_admin() || is_preview()) {
		return;
	}
	
	$views = (int) get_post_meta($post_id, '_mtq_post_views', true);
	$views++;
	
	update_post_meta($post_id, '_mtq_post_views', $views);
}

// Add view tracking to single posts
function mtq_add_view_tracking() {
	if (is_single() && get_post_type() == 'post') {
		mtq_track_post_views();
	}
}

add_action('wp_head', 'mtq_add_view_tracking');

// Get popular posts by views
function mtq_get_popular_posts($limit = 6, $exclude_ids = []) {
	$args = [
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => $limit,
		'post__not_in' => $exclude_ids,
		'meta_key' => '_mtq_post_views',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'meta_query' => [
			[
				'key' => '_thumbnail_id',
				'compare' => 'EXISTS'
			]
		]
	];
	
	$query = new WP_Query($args);
	$posts = $query->posts;
	wp_reset_postdata();
	
	return $posts;
}

// Include Related Posts Widget
require get_template_directory() . '/inc/class-related-posts-widget.php';

/**
 * Related Posts Shortcode
 */
function mtq_related_posts_shortcode($atts) {
	$atts = shortcode_atts([
		'count' => 3,
		'post_id' => get_the_ID(),
		'style' => 'grid', // grid, list, compact
		'show_excerpt' => 'true',
		'show_date' => 'true',
		'show_author' => 'false'
	], $atts, 'mtq_related_posts');
	
	$post_id = (int) $atts['post_id'];
	$count = (int) $atts['count'];
	
	if (!$post_id) {
		return '';
	}
	
	$related_posts = mtq_get_related_posts($post_id, $count);
	
	if (empty($related_posts)) {
		return '';
	}
	
	ob_start();
	?>
	
	<div class="mtq-related-posts-shortcode mtq-style-<?php echo esc_attr($atts['style']); ?>">
		<?php if ($atts['style'] === 'grid') : ?>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
		<?php elseif ($atts['style'] === 'list') : ?>
			<div class="space-y-4">
		<?php else : ?>
			<div class="space-y-2">
		<?php endif; ?>
		
		<?php foreach ($related_posts as $post) : 
			setup_postdata($post); ?>
			
			<article class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
				<?php if ($atts['style'] !== 'compact') : ?>
					<div class="aspect-video overflow-hidden">
						<a href="<?php the_permalink(); ?>">
							<?php if (has_post_thumbnail()) : ?>
								<?php the_post_thumbnail('medium', [
									'class' => 'w-full h-full object-cover hover:scale-105 transition-transform',
									'alt' => get_the_title()
								]); ?>
							<?php else : ?>
								<div class="w-full h-full bg-gray-100 flex items-center justify-center">
									<svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
									</svg>
								</div>
							<?php endif; ?>
						</a>
					</div>
				<?php endif; ?>
				
				<div class="p-4">
					<h3 class="<?php echo ($atts['style'] === 'compact') ? 'text-sm' : 'text-lg'; ?> font-semibold text-gray-900 mb-2">
						<a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
							<?php the_title(); ?>
						</a>
					</h3>
					
					<?php if ($atts['show_excerpt'] === 'true' && $atts['style'] !== 'compact') : ?>
						<p class="text-gray-600 text-sm mb-2">
							<?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
						</p>
					<?php endif; ?>
					
					<?php if ($atts['show_date'] === 'true' || $atts['show_author'] === 'true') : ?>
						<div class="text-xs text-gray-500 flex items-center gap-2">
							<?php if ($atts['show_date'] === 'true') : ?>
								<time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
									<?php echo get_the_date(); ?>
								</time>
							<?php endif; ?>
							
							<?php if ($atts['show_author'] === 'true') : ?>
								<?php if ($atts['show_date'] === 'true') : ?>
									<span>•</span>
								<?php endif; ?>
								<span><?php echo esc_html(get_the_author()); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</article>
			
		<?php endforeach; ?>
		<?php wp_reset_postdata(); ?>
		
		</div>
	</div>
	
	<?php
	return ob_get_clean();
}
add_shortcode('mtq_related_posts', 'mtq_related_posts_shortcode');

// Categories and tags setup completed - function removed

/**
 * =========================================
 * SECURITY FUNCTIONS
 * =========================================
 */

/**
 * Log security events
 */
function mtq_log_security_event($event, $details = array()) {
    if (WP_DEBUG_LOG) {
        $log_entry = array(
            'timestamp' => current_time('mysql'),
            'event' => $event,
            'details' => $details,
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '',
        );
        error_log('[MTQ SECURITY] ' . json_encode($log_entry));
    }
}

/**
 * =========================================
 * SOCIAL SHARING ANALYTICS FUNCTIONALITY
 * =========================================
 */

/**
 * Track social sharing analytics via AJAX
 */
function mtq_track_social_share() {
    // Rate limiting check
    $user_ip = mtq_get_user_ip();
    $rate_limit_key = 'mtq_share_rate_limit_' . md5($user_ip);
    
    if (get_transient($rate_limit_key)) {
        wp_send_json_error('Rate limit exceeded. Please try again later.');
        return;
    }
    
    // Set rate limit (max 10 requests per minute)
    set_transient($rate_limit_key, true, 60);
    
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'mtq_social_share_nonce')) {
        mtq_log_security_event('social_share_nonce_failed', array('ip' => $user_ip));
        wp_die('Security check failed');
    }
    
    $post_id = intval($_POST['post_id']);
    $platform = sanitize_text_field($_POST['platform']);
    
    // Enhanced validation
    if (!$post_id || !$platform || !in_array($platform, ['facebook', 'twitter', 'whatsapp', 'telegram', 'email', 'copy'])) {
        wp_send_json_error('Invalid parameters');
        return;
    }
    
    // Update total shares count
    $total_shares = get_post_meta($post_id, '_social_shares_count', true);
    $total_shares = $total_shares ? intval($total_shares) + 1 : 1;
    update_post_meta($post_id, '_social_shares_count', $total_shares);
    
    // Update individual platform shares
    $platform_key = '_social_shares_' . $platform;
    $platform_shares = get_post_meta($post_id, $platform_key, true);
    $platform_shares = $platform_shares ? intval($platform_shares) + 1 : 1;
    update_post_meta($post_id, $platform_key, $platform_shares);
    
    // Store sharing activity log for analytics
    $share_log = get_post_meta($post_id, '_social_shares_log', true);
    if (!is_array($share_log)) {
        $share_log = array();
    }
    
    $share_log[] = array(
        'platform' => $platform,
        'timestamp' => current_time('timestamp'),
        'user_ip' => mtq_get_user_ip(),
        'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 255) : '',
        'referrer' => isset($_SERVER['HTTP_REFERER']) ? esc_url_raw($_SERVER['HTTP_REFERER']) : ''
    );
    
    // Keep only last 100 entries to prevent database bloat
    if (count($share_log) > 100) {
        $share_log = array_slice($share_log, -100);
    }
    
    update_post_meta($post_id, '_social_shares_log', $share_log);
    
    // Update daily sharing statistics
    $today = date('Y-m-d');
    $daily_stats_key = '_daily_social_shares_' . $today;
    $daily_stats = get_option($daily_stats_key, array());
    
    if (!isset($daily_stats[$platform])) {
        $daily_stats[$platform] = 0;
    }
    $daily_stats[$platform]++;
    
    update_option($daily_stats_key, $daily_stats);
    
    // Clean old daily stats (keep only 30 days)
    mtq_cleanup_old_social_stats();
    
    wp_send_json_success(array(
        'total_shares' => $total_shares,
        'platform_shares' => $platform_shares,
        'message' => 'Share tracked successfully'
    ));
}
add_action('wp_ajax_mtq_track_social_share', 'mtq_track_social_share');
add_action('wp_ajax_nopriv_mtq_track_social_share', 'mtq_track_social_share');

/**
 * Get user IP address for analytics
 */
function mtq_get_user_ip() {
    if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
        return sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return sanitize_text_field(trim($ips[0]));
    } elseif (isset($_SERVER['HTTP_X_FORWARDED']) && !empty($_SERVER['HTTP_X_FORWARDED'])) {
        return sanitize_text_field($_SERVER['HTTP_X_FORWARDED']);
    } elseif (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && !empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        return sanitize_text_field($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']);
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR']) && !empty($_SERVER['HTTP_FORWARDED_FOR'])) {
        return sanitize_text_field($_SERVER['HTTP_FORWARDED_FOR']);
    } elseif (isset($_SERVER['HTTP_FORWARDED']) && !empty($_SERVER['HTTP_FORWARDED'])) {
        return sanitize_text_field($_SERVER['HTTP_FORWARDED']);
    } elseif (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
        return sanitize_text_field($_SERVER['REMOTE_ADDR']);
    }
    return '0.0.0.0';
}

/**
 * Clean up old social sharing statistics
 */
function mtq_cleanup_old_social_stats() {
    global $wpdb;
    
    // Only run cleanup occasionally (1% chance)
    if (rand(1, 100) > 1) {
        return;
    }
    
    $cutoff_date = date('Y-m-d', strtotime('-30 days'));
    
    $old_options = $wpdb->get_results($wpdb->prepare("
        SELECT option_name 
        FROM {$wpdb->options} 
        WHERE option_name LIKE '_daily_social_shares_%' 
        AND option_name < %s
    ", '_daily_social_shares_' . $cutoff_date));
    
    foreach ($old_options as $option) {
        delete_option($option->option_name);
    }
}

/**
 * Get social sharing statistics for a post
 */
function mtq_get_social_sharing_stats($post_id) {
    $stats = array(
        'total_shares' => intval(get_post_meta($post_id, '_social_shares_count', true)),
        'facebook' => intval(get_post_meta($post_id, '_social_shares_Facebook', true)),
        'twitter' => intval(get_post_meta($post_id, '_social_shares_Twitter', true)),
        'whatsapp' => intval(get_post_meta($post_id, '_social_shares_WhatsApp', true)),
        'telegram' => intval(get_post_meta($post_id, '_social_shares_Telegram', true)),
        'linkedin' => intval(get_post_meta($post_id, '_social_shares_LinkedIn', true)),
        'pinterest' => intval(get_post_meta($post_id, '_social_shares_Pinterest', true)),
        'email' => intval(get_post_meta($post_id, '_social_shares_Email', true)),
        'copy_link' => intval(get_post_meta($post_id, '_social_shares_Copy_Link', true))
    );
    
    return $stats;
}

/**
 * Get daily social sharing statistics
 */
function mtq_get_daily_social_stats($date = null) {
    if (!$date) {
        $date = date('Y-m-d');
    }
    
    $stats_key = '_daily_social_shares_' . $date;
    return get_option($stats_key, array());
}

/**
 * Get social sharing trends (last 7 days)
 */
function mtq_get_social_sharing_trends($days = 7) {
    $trends = array();
    
    for ($i = 0; $i < $days; $i++) {
        $date = date('Y-m-d', strtotime("-{$i} days"));
        $trends[$date] = mtq_get_daily_social_stats($date);
    }
    
    return array_reverse($trends, true);
}

/**
 * Add social sharing meta to post admin
 */
function mtq_add_social_sharing_meta_box() {
    add_meta_box(
        'mtq-social-sharing-stats',
        'Social Sharing Statistics',
        'mtq_social_sharing_meta_box_callback',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'mtq_add_social_sharing_meta_box');

/**
 * Display social sharing statistics in post admin
 */
function mtq_social_sharing_meta_box_callback($post) {
    $stats = mtq_get_social_sharing_stats($post->ID);
    $share_log = get_post_meta($post->ID, '_social_shares_log', true);
    
    echo '<div class="mtq-social-stats">';
    echo '<h4>Total Shares: ' . $stats['total_shares'] . '</h4>';
    
    if ($stats['total_shares'] > 0) {
        echo '<ul>';
        foreach ($stats as $platform => $count) {
            if ($platform !== 'total_shares' && $count > 0) {
                echo '<li><strong>' . ucfirst($platform) . ':</strong> ' . $count . '</li>';
            }
        }
        echo '</ul>';
        
        if (is_array($share_log) && !empty($share_log)) {
            $recent_shares = array_slice($share_log, -5);
            echo '<h4>Recent Shares:</h4>';
            echo '<ul>';
            foreach (array_reverse($recent_shares) as $share) {
                $date = date('M j, Y H:i', $share['timestamp']);
                echo '<li>' . $share['platform'] . ' - ' . $date . '</li>';
            }
            echo '</ul>';
        }
    } else {
        echo '<p>No shares yet.</p>';
    }
    echo '</div>';
    
    // Add some basic CSS
    echo '<style>
        .mtq-social-stats ul { list-style: disc; margin-left: 20px; }
        .mtq-social-stats li { margin-bottom: 5px; }
        .mtq-social-stats h4 { margin-top: 15px; margin-bottom: 10px; }
    </style>';
}

/**
 * Add social sharing widget
 */
class MTQ_Social_Sharing_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mtq_social_sharing_widget',
            'MTQ Social Sharing Widget',
            array('description' => 'Display social sharing buttons for the current post')
        );
    }
    
    public function widget($args, $instance) {
        if (!is_single()) {
            return;
        }
        
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        // Include the social sharing template part
        get_template_part('template-parts/social-sharing');
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : 'Bagikan Artikel';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * Register social sharing widget
 */
function mtq_register_social_sharing_widget() {
    register_widget('MTQ_Social_Sharing_Widget');
}
add_action('widgets_init', 'mtq_register_social_sharing_widget');

/**
 * Social sharing shortcode
 */
function mtq_social_sharing_shortcode($atts) {
    $atts = shortcode_atts(array(
        'style' => 'default',
        'show_counters' => 'true',
        'platforms' => 'facebook,twitter,whatsapp,telegram,linkedin,email,copy'
    ), $atts);
    
    if (!is_single() && !is_page()) {
        return '';
    }
    
    ob_start();
    get_template_part('template-parts/social-sharing');
    return ob_get_clean();
}
add_shortcode('mtq_social_sharing', 'mtq_social_sharing_shortcode');

/**
 * Add Open Graph meta tags for better social sharing
 */
function mtq_add_opengraph_meta() {
    if (is_single() || is_page()) {
        global $post;
        
        $title = get_the_title();
        $description = get_the_excerpt() ?: wp_trim_words(strip_tags($post->post_content), 20);
        $url = get_permalink();
        $image = get_the_post_thumbnail_url($post->ID, 'large');
        $site_name = get_bloginfo('name');
        
        echo "\n<!-- Open Graph Meta Tags by MTQ Theme -->\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
        
        if ($image) {
            echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
            echo '<meta property="og:image:width" content="1200">' . "\n";
            echo '<meta property="og:image:height" content="630">' . "\n";
        }
        
        // Twitter Cards
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
        if ($image) {
            echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
        }
        
        // Additional meta tags
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        echo '<!-- End Open Graph Meta Tags -->' . "\n\n";
    }
}
add_action('wp_head', 'mtq_add_opengraph_meta');

/**
 * Enhanced post view tracking for analytics (extends existing function)
 */
add_action('wp_head', function() {
    if (is_single() && !current_user_can('edit_posts')) {
        $post_id = get_the_ID();
        if ($post_id) {
            // Use existing function but also add alternative key for social sharing compatibility
            mtq_track_post_views($post_id);
            
            // Add alternative count key for social sharing display
            $count_key = '_post_views_count';
            $count = get_post_meta($post_id, $count_key, true);
            if ($count == '') {
                $count = get_post_meta($post_id, '_mtq_post_views', true) ?: 1;
            } else {
                $count++;
            }
            update_post_meta($post_id, $count_key, $count);
        }
    }
});

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

/**
 * AJAX handler for tracking post views
 */
function mtq_ajax_track_post_view() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'track_post_view')) {
        wp_die('Security check failed');
    }
    
    $post_id = intval($_POST['post_id']);
    
    if ($post_id && get_post($post_id)) {
        // Get current view count
        $views = get_post_meta($post_id, 'post_views_count', true);
        $views = $views ? intval($views) : 0;
        
        // Increment view count
        $views++;
        
        // Update view count
        update_post_meta($post_id, 'post_views_count', $views);
        
        // Also track in the existing system
        if (function_exists('mtq_track_post_views')) {
            mtq_track_post_views($post_id);
        }
        
        wp_send_json_success(array('views' => $views));
    } else {
        wp_send_json_error('Invalid post ID');
    }
}

// Register AJAX handlers for both logged-in and non-logged-in users
add_action('wp_ajax_track_post_view', 'mtq_ajax_track_post_view');
add_action('wp_ajax_nopriv_track_post_view', 'mtq_ajax_track_post_view');

/**
 * AJAX handler for loading more posts
 */
function mtq_ajax_load_more_posts() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'load_more_posts')) {
        wp_die('Security check failed');
    }
    
    $page = intval($_POST['page']);
    $exclude_id = intval($_POST['exclude']);
    
    if ($page <= 0) {
        wp_send_json_error('Invalid page number');
        return;
    }
    
    // Get posts for the requested page
    $posts = get_posts([
        'numberposts' => 6,
        'post__not_in' => [$exclude_id],
        'orderby' => 'date',
        'order' => 'DESC',
        'offset' => ($page - 1) * 6
    ]);
    
    if (empty($posts)) {
        wp_send_json_success(['html' => '', 'has_more' => false]);
        return;
    }
    
    ob_start();
    
    foreach ($posts as $post) : setup_postdata($post);
    ?>
        <article class="group relative bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="relative overflow-hidden">
                <?php if (has_post_thumbnail($post->ID)) : ?>
                    <div class="aspect-video">
                        <?php echo get_the_post_thumbnail($post->ID, 'medium_large', [
                            'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300'
                        ]); ?>
                    </div>
                <?php else : ?>
                    <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <i class="fas fa-newspaper text-gray-400 text-3xl"></i>
                    </div>
                <?php endif; ?>
                
                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-50 transition-all duration-300"></div>
                
                <!-- Category Badge -->
                <?php
                $post_categories = get_the_category($post->ID);
                if (!empty($post_categories)) :
                ?>
                    <span class="absolute top-4 left-4 px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-full">
                        <?php echo esc_html($post_categories[0]->name); ?>
                    </span>
                <?php endif; ?>
                
                <!-- Content Overlay -->
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <h3 class="text-lg font-bold leading-tight mb-3 group-hover:text-orange-300 transition-colors">
                        <a href="<?php echo get_permalink($post->ID); ?>" class="line-clamp-3">
                            <?php echo get_the_title($post->ID); ?>
                        </a>
                    </h3>
                    
                    <div class="flex items-center gap-4 text-sm opacity-90">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-calendar text-orange-300"></i>
                            <time datetime="<?php echo get_the_date('c', $post->ID); ?>">
                                <?php echo get_the_date('d M Y', $post->ID); ?>
                            </time>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-eye text-orange-300"></i>
                            <span><?php echo get_post_meta($post->ID, 'post_views_count', true) ?: '0'; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    <?php
    endforeach;
    wp_reset_postdata();
    
    $html = ob_get_clean();
    
    // Check if there are more posts
    $next_posts = get_posts([
        'numberposts' => 1,
        'post__not_in' => [$exclude_id],
        'orderby' => 'date',
        'order' => 'DESC',
        'offset' => $page * 6
    ]);
    
    $has_more = !empty($next_posts);
    
    wp_send_json_success([
        'html' => $html,
        'has_more' => $has_more
    ]);
}

add_action('wp_ajax_load_more_posts', 'mtq_ajax_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'mtq_ajax_load_more_posts');

/**
 * Add meta box for featured post option
 */
function mtq_add_featured_post_meta_box() {
    add_meta_box(
        'mtq_featured_post',
        'Berita Utama',
        'mtq_featured_post_meta_box_callback',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'mtq_add_featured_post_meta_box');

/**
 * Meta box callback for featured post
 */
function mtq_featured_post_meta_box_callback($post) {
    wp_nonce_field('mtq_featured_post_nonce', 'mtq_featured_post_nonce');
    $featured = get_post_meta($post->ID, '_featured_post', true);
    ?>
    <label for="mtq_featured_post">
        <input type="checkbox" id="mtq_featured_post" name="mtq_featured_post" value="1" <?php checked($featured, '1'); ?> />
        Tampilkan di slider berita utama
    </label>
    <p class="description">Centang untuk menampilkan berita ini di slider headline pada halaman berita.</p>
    <?php
}

/**
 * Save featured post meta
 */
function mtq_save_featured_post_meta($post_id) {
    if (!isset($_POST['mtq_featured_post_nonce']) || !wp_verify_nonce($_POST['mtq_featured_post_nonce'], 'mtq_featured_post_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $featured = isset($_POST['mtq_featured_post']) ? '1' : '0';
    update_post_meta($post_id, '_featured_post', $featured);
}
add_action('save_post', 'mtq_save_featured_post_meta');