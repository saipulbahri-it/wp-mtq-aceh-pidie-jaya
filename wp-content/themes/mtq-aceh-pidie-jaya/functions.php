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

   // Enqueue built Tailwind CSS if exists, otherwise fallback to prototype CSS
   $dist_css = get_template_directory() . '/dist/app.css';
   if (file_exists($dist_css)) {
	   wp_enqueue_style('mtq-aceh-pidie-jaya-app', get_template_directory_uri() . '/dist/app.css', array(), filemtime($dist_css));
   }
   // Always enqueue prototype CSS
   wp_enqueue_style('mtq-aceh-pidie-jaya-prototype-css', get_template_directory_uri() . '/prototype/css/index.css', array(), _S_VERSION);

	// Enqueue main JavaScript
	wp_enqueue_script('mtq-aceh-pidie-jaya-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	// Enqueue prototype JavaScript (UI interactions)
	wp_enqueue_script('mtq-aceh-pidie-jaya-prototype-js', get_template_directory_uri() . '/prototype/js/index.js', array(), _S_VERSION, true);
	// Countdown
	wp_enqueue_script('mtq-aceh-pidie-jaya-countdown', get_template_directory_uri() . '/prototype/js/countdown.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'mtq_aceh_pidie_jaya_scripts');

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