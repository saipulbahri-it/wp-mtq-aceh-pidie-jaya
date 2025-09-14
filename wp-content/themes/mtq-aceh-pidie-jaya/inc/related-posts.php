<?php
/**
 * Related posts helpers and shortcode
 */

if (!defined('ABSPATH')) { exit; }

function mtq_get_cached_related_posts($post_id, $limit = 6) {
	$cache_key = "mtq_related_posts_{$post_id}_{$limit}";
	$cached_posts = wp_cache_get($cache_key, 'mtq_related_posts');
	if ($cached_posts !== false) { return $cached_posts; }
	$related_posts = mtq_get_related_posts($post_id, $limit);
	wp_cache_set($cache_key, $related_posts, 'mtq_related_posts', HOUR_IN_SECONDS);
	return $related_posts;
}

function mtq_clear_related_posts_cache($post_id) {
	wp_cache_delete("mtq_related_posts_{$post_id}_6", 'mtq_related_posts');
	$categories = wp_get_post_categories($post_id);
	$tags = wp_get_post_tags($post_id);
	if (!empty($categories) || !empty($tags)) {
		$args = [
			'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 50, 'fields' => 'ids'
		];
		if (!empty($categories)) { $args['category__in'] = $categories; }
		if (!empty($tags)) { $args['tag__in'] = wp_list_pluck($tags, 'term_id'); }
		$related_post_ids = get_posts($args);
		foreach ($related_post_ids as $id) {
			wp_cache_delete("mtq_related_posts_{$id}_6", 'mtq_related_posts');
		}
	}
}
add_action('save_post', 'mtq_clear_related_posts_cache');
add_action('delete_post', 'mtq_clear_related_posts_cache');

function mtq_calculate_content_similarity($post_id_1, $post_id_2) {
	$post_1 = get_post($post_id_1); $post_2 = get_post($post_id_2);
	if (!$post_1 || !$post_2) { return 0; }
	$title_1_words = array_map('strtolower', explode(' ', $post_1->post_title));
	$title_2_words = array_map('strtolower', explode(' ', $post_2->post_title));
	$stopwords = ['dan','atau','yang','di','ke','dari','untuk','pada','dengan','dalam','adalah','ini','itu','akan','telah','sudah','dapat','bisa'];
	$title_1_words = array_diff($title_1_words, $stopwords);
	$title_2_words = array_diff($title_2_words, $stopwords);
	$common_words = array_intersect($title_1_words, $title_2_words);
	if (empty($title_1_words) || empty($title_2_words)) { return 0; }
	$union_size = count(array_unique(array_merge($title_1_words, $title_2_words)));
	$intersection_size = count($common_words);
	return $union_size > 0 ? $intersection_size / $union_size : 0;
}

function mtq_get_trending_posts($limit = 6, $exclude_ids = []) {
	$args = [
		'post_type' => 'post','post_status' => 'publish','posts_per_page' => $limit,
		'post__not_in' => $exclude_ids,'date_query' => [['after' => '30 days ago']],
		'meta_query' => [[ 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ]],
		'orderby' => 'comment_count','order' => 'DESC'
	];
	$query = new WP_Query($args); $posts = $query->posts; wp_reset_postdata(); return $posts;
}

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

function mtq_track_post_views($post_id = null) {
	if (!$post_id) { $post_id = get_the_ID(); }
	if (!$post_id || is_admin() || is_preview()) { return; }
	$views = (int) get_post_meta($post_id, '_mtq_post_views', true); $views++;
	update_post_meta($post_id, '_mtq_post_views', $views);
}

function mtq_add_view_tracking() {
	if (is_single() && get_post_type() == 'post') { mtq_track_post_views(); }
}
add_action('wp_head', 'mtq_add_view_tracking');

function mtq_get_popular_posts($limit = 6, $exclude_ids = []) {
	$args = [
		'post_type' => 'post','post_status' => 'publish','posts_per_page' => $limit,
		'post__not_in' => $exclude_ids,'meta_key' => '_mtq_post_views','orderby' => 'meta_value_num','order' => 'DESC',
		'meta_query' => [[ 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ]]
	];
	$query = new WP_Query($args); $posts = $query->posts; wp_reset_postdata(); return $posts;
}

function mtq_related_posts_shortcode($atts) {
	$atts = shortcode_atts([
		'count' => 3,'post_id' => get_the_ID(),'style' => 'grid','show_excerpt' => 'true','show_date' => 'true','show_author' => 'false'
	], $atts, 'mtq_related_posts');
	$post_id = (int) $atts['post_id']; $count = (int) $atts['count']; if (!$post_id) { return ''; }
	$related_posts = mtq_get_related_posts($post_id, $count); if (empty($related_posts)) { return ''; }
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
		<?php foreach ($related_posts as $post) : setup_postdata($post); ?>
			<article class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
				<?php if ($atts['style'] !== 'compact') : ?>
					<div class="aspect-video overflow-hidden">
						<a href="<?php the_permalink(); ?>">
							<?php if (has_post_thumbnail()) : ?>
								<?php the_post_thumbnail('medium', [ 'class' => 'w-full h-full object-cover hover:scale-105 transition-transform', 'alt' => get_the_title() ]); ?>
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
						<a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors"><?php the_title(); ?></a>
					</h3>
					<?php if ($atts['show_excerpt'] === 'true' && $atts['style'] !== 'compact') : ?>
						<p class="text-gray-600 text-sm mb-2"><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
					<?php endif; ?>
					<?php if ($atts['show_date'] === 'true' || $atts['show_author'] === 'true') : ?>
						<div class="text-xs text-gray-500 flex items-center gap-2">
							<?php if ($atts['show_date'] === 'true') : ?>
								<time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo get_the_date(); ?></time>
							<?php endif; ?>
							<?php if ($atts['show_author'] === 'true') : ?>
								<?php if ($atts['show_date'] === 'true') : ?><span>•</span><?php endif; ?>
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
