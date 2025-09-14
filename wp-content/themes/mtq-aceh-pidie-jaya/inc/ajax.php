<?php
/**
 * AJAX handlers
 */

if (!defined('ABSPATH')) { exit; }

function mtq_ajax_track_post_view() {
	if (!wp_verify_nonce($_POST['nonce'], 'track_post_view')) { wp_die('Security check failed'); }
	$post_id = intval($_POST['post_id']);
	if ($post_id && get_post($post_id)) {
		$views = get_post_meta($post_id, 'post_views_count', true); $views = $views ? intval($views) : 0; $views++;
		update_post_meta($post_id, 'post_views_count', $views);
		if (function_exists('mtq_track_post_views')) { mtq_track_post_views($post_id); }
		wp_send_json_success(array('views' => $views));
	} else { wp_send_json_error('Invalid post ID'); }
}
add_action('wp_ajax_track_post_view', 'mtq_ajax_track_post_view');
add_action('wp_ajax_nopriv_track_post_view', 'mtq_ajax_track_post_view');

function mtq_ajax_load_more_posts() {
	if (!wp_verify_nonce($_POST['nonce'], 'load_more_posts')) { wp_die('Security check failed'); }
	$page = intval($_POST['page']); $exclude_id = intval($_POST['exclude']);
	if ($page <= 0) { wp_send_json_error('Invalid page number'); return; }
	$posts = get_posts(['numberposts' => 6,'post__not_in' => [$exclude_id],'orderby' => 'date','order' => 'DESC','offset' => ($page - 1) * 6]);
	if (empty($posts)) { wp_send_json_success(['html' => '', 'has_more' => false]); return; }
	ob_start(); foreach ($posts as $post) : setup_postdata($post); ?>
		<article class="group relative bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
			<div class="relative overflow-hidden">
				<?php if (has_post_thumbnail($post->ID)) : ?>
					<div class="aspect-video"><?php echo get_the_post_thumbnail($post->ID, 'medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?></div>
				<?php else : ?>
					<div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center"><i class="fas fa-newspaper text-gray-400 text-3xl"></i></div>
				<?php endif; ?>
				<div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-50 transition-all duration-300"></div>
				<?php $post_categories = get_the_category($post->ID); if (!empty($post_categories)) : ?>
					<span class="absolute top-4 left-4 px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-full"><?php echo esc_html($post_categories[0]->name); ?></span>
				<?php endif; ?>
				<div class="absolute bottom-0 left-0 right-0 p-6 text-white">
					<h3 class="text-lg font-bold leading-tight mb-3 group-hover:text-orange-300 transition-colors"><a href="<?php echo get_permalink($post->ID); ?>" class="line-clamp-3"><?php echo get_the_title($post->ID); ?></a></h3>
					<div class="flex items-center gap-4 text-sm opacity-90">
						<div class="flex items-center gap-1"><i class="fas fa-calendar text-orange-300"></i><time datetime="<?php echo get_the_date('c', $post->ID); ?>"><?php echo get_the_date('d M Y', $post->ID); ?></time></div>
						<div class="flex items-center gap-1"><i class="fas fa-eye text-orange-300"></i><span><?php echo get_post_meta($post->ID, 'post_views_count', true) ?: '0'; ?></span></div>
					</div>
				</div>
			</div>
		</article>
	<?php endforeach; wp_reset_postdata(); $html = ob_get_clean(); $next_posts = get_posts(['numberposts' => 1,'post__not_in' => [$exclude_id],'orderby' => 'date','order' => 'DESC','offset' => $page * 6]); $has_more = !empty($next_posts); wp_send_json_success(['html' => $html,'has_more' => $has_more]);
}
add_action('wp_ajax_load_more_posts', 'mtq_ajax_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'mtq_ajax_load_more_posts');

function mtq_ajax_load_more_category() {
	if (!wp_verify_nonce($_POST['nonce'], 'load_more_category')) { wp_die('Security check failed'); }
	$page = intval($_POST['page']); $category_id = intval($_POST['category']);
	if ($page <= 0 || $category_id <= 0) { wp_send_json_error('Invalid parameters'); return; }
	$posts = get_posts(['numberposts' => 6,'cat' => $category_id,'orderby' => 'date','order' => 'DESC','offset' => ($page - 1) * 6]);
	if (empty($posts)) { wp_send_json_success(['html' => '', 'has_more' => false]); return; }
	ob_start(); foreach ($posts as $post) : setup_postdata($post); ?>
		<article class="group bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
			<div class="relative overflow-hidden">
				<?php if (has_post_thumbnail($post->ID)) : ?>
					<div class="aspect-video"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_post_thumbnail($post->ID, 'medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?></a></div>
				<?php else : ?>
					<div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center"><i class="fas fa-newspaper text-gray-400 text-3xl"></i></div>
				<?php endif; ?>
				<div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-50 transition-all duration-300"></div>
				<?php $post_categories = get_the_category($post->ID); if (!empty($post_categories)) : ?>
					<span class="absolute top-4 left-4 px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-full"><?php echo esc_html($post_categories[0]->name); ?></span>
				<?php endif; ?>
				<div class="absolute bottom-0 left-0 right-0 p-6 text-white">
					<h3 class="text-lg font-bold leading-tight mb-3 group-hover:text-orange-300 transition-colors"><a href="<?php echo get_permalink($post->ID); ?>" class="line-clamp-3"><?php echo get_the_title($post->ID); ?></a></h3>
					<div class="flex items-center gap-4 text-sm opacity-90">
						<div class="flex items-center gap-1"><i class="fas fa-calendar text-orange-300"></i><time datetime="<?php echo get_the_date('c', $post->ID); ?>"><?php echo get_the_date('d M Y', $post->ID); ?></time></div>
						<div class="flex items-center gap-1"><i class="fas fa-user text-orange-300"></i><span><?php echo get_the_author_meta('display_name', $post->post_author); ?></span></div>
						<div class="flex items-center gap-1"><i class="fas fa-eye text-orange-300"></i><span><?php echo get_post_meta($post->ID, 'post_views_count', true) ?: '0'; ?></span></div>
					</div>
				</div>
			</div>
		</article>
	<?php endforeach; wp_reset_postdata(); $html = ob_get_clean(); $next_posts = get_posts(['numberposts' => 1,'cat' => $category_id,'orderby' => 'date','order' => 'DESC','offset' => $page * 6]); $has_more = !empty($next_posts); wp_send_json_success(['html' => $html,'has_more' => $has_more]);
}
add_action('wp_ajax_load_more_category', 'mtq_ajax_load_more_category');
add_action('wp_ajax_nopriv_load_more_category', 'mtq_ajax_load_more_category');

function mtq_ajax_load_more_news_page() {
	if (!wp_verify_nonce($_POST['nonce'], 'load_more_news')) { wp_die('Security check failed'); }
	$page = intval($_POST['page']); if ($page <= 0) { wp_send_json_error('Invalid page number'); return; }
	$posts = get_posts(['numberposts' => 9,'orderby' => 'date','order' => 'DESC','offset' => ($page - 1) * 9]);
	if (empty($posts)) { wp_send_json_success(['html' => '', 'has_more' => false]); return; }
	ob_start(); foreach ($posts as $post) : setup_postdata($post); ?>
		<article class="news-article group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 overflow-hidden transition-all duration-300 hover:-translate-y-1 flex flex-col h-full" data-categories="<?php echo implode(',', wp_get_post_categories($post->ID)); ?>">
			<?php if (has_post_thumbnail($post->ID)) : ?>
				<div class="relative overflow-hidden">
					<a href="<?php echo get_permalink($post->ID); ?>" class="block"><?php echo get_the_post_thumbnail($post->ID, 'medium_large', ['class' => 'w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105','loading' => 'lazy']); ?></a>
					<div class="absolute top-4 left-4">
						<?php $categories = get_the_category($post->ID); if (!empty($categories)) : ?>
							<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-600 text-white backdrop-blur-sm"><?php echo esc_html($categories[0]->name); ?></span>
						<?php endif; ?>
					</div>
					<div class="absolute top-4 right-4">
						<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-black/50 text-white backdrop-blur-sm"><i class="fas fa-eye mr-1"></i><?php echo get_post_meta($post->ID, 'post_views_count', true) ?: '0'; ?></span>
					</div>
				</div>
			<?php endif; ?>
			<div class="p-6 flex flex-col flex-grow">
				<div class="flex items-center gap-4 text-sm text-slate-500 mb-3">
					<div class="flex items-center gap-1.5"><svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg><time datetime="<?php echo get_the_date('c', $post->ID); ?>"><?php echo get_the_date('d M Y', $post->ID); ?></time></div>
					<div class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg><span><?php echo get_the_author_meta('display_name', $post->post_author); ?></span></div>
				</div>
				<h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 leading-tight"><a href="<?php echo get_permalink($post->ID); ?>" class="hover:text-red-600 transition-colors duration-200" aria-label="Baca artikel: <?php echo esc_attr(get_the_title($post->ID)); ?>"><?php echo get_the_title($post->ID); ?></a></h3>
				<div class="text-slate-600 mb-6 line-clamp-3 leading-relaxed flex-grow"><?php echo wp_trim_words(get_the_excerpt($post->ID), 18, '...'); ?></div>
				<div class="mt-auto"><a href="<?php echo get_permalink($post->ID); ?>" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-semibold text-sm transition-colors duration-200 group-hover:gap-3" aria-label="Baca selengkapnya: <?php echo esc_attr(get_the_title($post->ID)); ?>">Baca Selengkapnya<svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></div>
			</div>
		</article>
	<?php endforeach; wp_reset_postdata(); $html = ob_get_clean(); $next_posts = get_posts(['numberposts' => 1,'orderby' => 'date','order' => 'DESC','offset' => $page * 9]); $has_more = !empty($next_posts); wp_send_json_success(['html' => $html,'has_more' => $has_more]);
}
add_action('wp_ajax_load_more_news_page', 'mtq_ajax_load_more_news_page');
add_action('wp_ajax_nopriv_load_more_news_page', 'mtq_ajax_load_more_news_page');
