<?php
/**
 * Social sharing analytics, metadata, widget, and shortcode
 */

if (!defined('ABSPATH')) { exit; }

// AJAX tracking for shares
function mtq_track_social_share() {
	$user_ip = mtq_get_user_ip();
	$rate_limit_key = 'mtq_share_rate_limit_' . md5($user_ip);
	if (get_transient($rate_limit_key)) { wp_send_json_error('Rate limit exceeded. Please try again later.'); return; }
	set_transient($rate_limit_key, true, 60);
	if (!wp_verify_nonce($_POST['nonce'], 'mtq_social_share_nonce')) {
		mtq_log_security_event('social_share_nonce_failed', array('ip' => $user_ip));
		wp_die('Security check failed');
	}
	$post_id = intval($_POST['post_id']); $platform = sanitize_text_field($_POST['platform']);
	if (!$post_id || !$platform || !in_array($platform, ['facebook','twitter','whatsapp','telegram','email','copy'])) {
		wp_send_json_error('Invalid parameters'); return;
	}
	$total_shares = get_post_meta($post_id, '_social_shares_count', true);
	$total_shares = $total_shares ? intval($total_shares) + 1 : 1;
	update_post_meta($post_id, '_social_shares_count', $total_shares);
	$platform_key = '_social_shares_' . $platform;
	$platform_shares = get_post_meta($post_id, $platform_key, true);
	$platform_shares = $platform_shares ? intval($platform_shares) + 1 : 1;
	update_post_meta($post_id, $platform_key, $platform_shares);
	$share_log = get_post_meta($post_id, '_social_shares_log', true); if (!is_array($share_log)) { $share_log = array(); }
	$share_log[] = array(
		'platform' => $platform,
		'timestamp' => current_time('timestamp'),
		'user_ip' => mtq_get_user_ip(),
		'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 255) : '',
		'referrer' => isset($_SERVER['HTTP_REFERER']) ? esc_url_raw($_SERVER['HTTP_REFERER']) : ''
	);
	if (count($share_log) > 100) { $share_log = array_slice($share_log, -100); }
	update_post_meta($post_id, '_social_shares_log', $share_log);
	$today = date('Y-m-d'); $daily_stats_key = '_daily_social_shares_' . $today; $daily_stats = get_option($daily_stats_key, array());
	if (!isset($daily_stats[$platform])) { $daily_stats[$platform] = 0; } $daily_stats[$platform]++;
	update_option($daily_stats_key, $daily_stats);
	mtq_cleanup_old_social_stats();
	wp_send_json_success(array('total_shares' => $total_shares, 'platform_shares' => $platform_shares, 'message' => 'Share tracked successfully'));
}
add_action('wp_ajax_mtq_track_social_share', 'mtq_track_social_share');
add_action('wp_ajax_nopriv_mtq_track_social_share', 'mtq_track_social_share');

function mtq_get_user_ip() {
	if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) { return sanitize_text_field($_SERVER['HTTP_CLIENT_IP']); }
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']); return sanitize_text_field(trim($ips[0])); }
	elseif (isset($_SERVER['HTTP_X_FORWARDED']) && !empty($_SERVER['HTTP_X_FORWARDED'])) { return sanitize_text_field($_SERVER['HTTP_X_FORWARDED']); }
	elseif (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && !empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) { return sanitize_text_field($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']); }
	elseif (isset($_SERVER['HTTP_FORWARDED_FOR']) && !empty($_SERVER['HTTP_FORWARDED_FOR'])) { return sanitize_text_field($_SERVER['HTTP_FORWARDED_FOR']); }
	elseif (isset($_SERVER['HTTP_FORWARDED']) && !empty($_SERVER['HTTP_FORWARDED'])) { return sanitize_text_field($_SERVER['HTTP_FORWARDED']); }
	elseif (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) { return sanitize_text_field($_SERVER['REMOTE_ADDR']); }
	return '0.0.0.0';
}

function mtq_cleanup_old_social_stats() {
	global $wpdb;
	if (rand(1, 100) > 1) { return; }
	$cutoff_date = date('Y-m-d', strtotime('-30 days'));
	$old_options = $wpdb->get_results($wpdb->prepare("SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '_daily_social_shares_%' AND option_name < %s", '_daily_social_shares_' . $cutoff_date));
	foreach ($old_options as $option) { delete_option($option->option_name); }
}

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

function mtq_get_daily_social_stats($date = null) {
	if (!$date) { $date = date('Y-m-d'); }
	$stats_key = '_daily_social_shares_' . $date; return get_option($stats_key, array());
}

function mtq_get_social_sharing_trends($days = 7) {
	$trends = array();
	for ($i = 0; $i < $days; $i++) { $date = date('Y-m-d', strtotime("-{$i} days")); $trends[$date] = mtq_get_daily_social_stats($date); }
	return array_reverse($trends, true);
}

function mtq_add_social_sharing_meta_box() {
	add_meta_box('mtq-social-sharing-stats','Social Sharing Statistics','mtq_social_sharing_meta_box_callback','post','side','default');
}
add_action('add_meta_boxes', 'mtq_add_social_sharing_meta_box');

function mtq_social_sharing_meta_box_callback($post) {
	$stats = mtq_get_social_sharing_stats($post->ID);
	$share_log = get_post_meta($post->ID, '_social_shares_log', true);
	echo '<div class="mtq-social-stats">';
	echo '<h4>Total Shares: ' . $stats['total_shares'] . '</h4>';
	if ($stats['total_shares'] > 0) {
		echo '<ul>';
		foreach ($stats as $platform => $count) {
			if ($platform !== 'total_shares' && $count > 0) { echo '<li><strong>' . ucfirst($platform) . ':</strong> ' . $count . '</li>'; }
		}
		echo '</ul>';
		if (is_array($share_log) && !empty($share_log)) {
			$recent_shares = array_slice($share_log, -5);
			echo '<h4>Recent Shares:</h4><ul>';
			foreach (array_reverse($recent_shares) as $share) { $date = date('M j, Y H:i', $share['timestamp']); echo '<li>' . $share['platform'] . ' - ' . $date . '</li>'; }
			echo '</ul>';
		}
	} else { echo '<p>No shares yet.</p>'; }
	echo '</div>';
	echo '<style>.mtq-social-stats ul { list-style: disc; margin-left: 20px; } .mtq-social-stats li { margin-bottom: 5px; } .mtq-social-stats h4 { margin-top: 15px; margin-bottom: 10px; }</style>';
}

class MTQ_Social_Sharing_Widget extends WP_Widget {
	public function __construct() { parent::__construct('mtq_social_sharing_widget','MTQ Social Sharing Widget', array('description' => 'Display social sharing buttons for the current post')); }
	public function widget($args, $instance) {
		if (!is_single()) { return; }
		echo $args['before_widget'];
		if (!empty($instance['title'])) { echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']; }
		get_template_part('template-parts/social-sharing');
		echo $args['after_widget'];
	}
	public function form($instance) { $title = isset($instance['title']) ? $instance['title'] : 'Bagikan Artikel'; ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
	<?php }
	public function update($new_instance, $old_instance) { $instance = array(); $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : ''; return $instance; }
}

function mtq_register_social_sharing_widget() { register_widget('MTQ_Social_Sharing_Widget'); }
add_action('widgets_init', 'mtq_register_social_sharing_widget');

function mtq_social_sharing_shortcode($atts) {
	$atts = shortcode_atts(array('style' => 'default','show_counters' => 'true','platforms' => 'facebook,twitter,whatsapp,telegram,linkedin,email,copy'), $atts);
	if (!is_single() && !is_page()) { return ''; }
	ob_start(); get_template_part('template-parts/social-sharing'); return ob_get_clean();
}
add_shortcode('mtq_social_sharing', 'mtq_social_sharing_shortcode');

function mtq_add_opengraph_meta() {
	if (is_single() || is_page()) {
		global $post;
		$title = get_the_title();
		$description = get_the_excerpt() ?: wp_trim_words(strip_tags($post->post_content), 20);
		$url = get_permalink();
		$image = get_the_post_thumbnail_url($post->ID, 'large');
		$site_name = get_bloginfo('name');
		echo "\n<!-- Open Graph Meta Tags by MTQ Theme -->\n";
		echo '<meta property="og:title" content="' . esc_attr($title) . '">\n';
		echo '<meta property="og:description" content="' . esc_attr($description) . '">\n';
		echo '<meta property="og:url" content="' . esc_url($url) . '">\n';
		echo '<meta property="og:type" content="article">\n';
		echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">\n';
		if ($image) { echo '<meta property="og:image" content="' . esc_url($image) . '">\n<meta property="og:image:width" content="1200">\n<meta property="og:image:height" content="630">\n'; }
		echo '<meta name="twitter:card" content="summary_large_image">\n<meta name="twitter:title" content="' . esc_attr($title) . '">\n<meta name="twitter:description" content="' . esc_attr($description) . '">\n';
		if ($image) { echo '<meta name="twitter:image" content="' . esc_url($image) . '">\n'; }
		echo '<meta name="description" content="' . esc_attr($description) . '">\n<!-- End Open Graph Meta Tags -->\n\n';
	}
}
add_action('wp_head', 'mtq_add_opengraph_meta');

// Extend view tracking to alternative key
add_action('wp_head', function() {
	if (is_single() && !current_user_can('edit_posts')) {
		$post_id = get_the_ID();
		if ($post_id) {
			mtq_track_post_views($post_id);
			$count_key = '_post_views_count';
			$count = get_post_meta($post_id, $count_key, true);
			if ($count == '') { $count = get_post_meta($post_id, '_mtq_post_views', true) ?: 1; } else { $count++; }
			update_post_meta($post_id, $count_key, $count);
		}
	}
});
