<?php
/**
 * Breadcrumb schema helpers
 */

if (!defined('ABSPATH')) { exit; }

function mtq_enable_breadcrumbs_for_post_type($post_type) {
	$allowed_post_types = ['post', 'page', 'product', 'event'];
	return in_array($post_type, $allowed_post_types);
}

function mtq_get_breadcrumb_schema() {
	if (is_front_page()) { return ''; }
	$breadcrumbs = [];
	$position = 1;
	$breadcrumbs[] = [
		'@type' => 'ListItem',
		'position' => $position++,
		'name' => get_bloginfo('name'),
		'item' => home_url('/')
	];
	if (is_single() && get_post_type() == 'post') {
		$blog_page_id = get_option('page_for_posts');
		if ($blog_page_id) {
			$breadcrumbs[] = [
				'@type' => 'ListItem',
				'position' => $position++,
				'name' => get_the_title($blog_page_id),
				'item' => get_permalink($blog_page_id)
			];
		}
		$categories = get_the_category();
		if ($categories) {
			$breadcrumbs[] = [
				'@type' => 'ListItem',
				'position' => $position++,
				'name' => $categories[0]->name,
				'item' => get_category_link($categories[0]->term_id)
			];
		}
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

function mtq_add_breadcrumb_schema() {
	if (!is_front_page()) { echo mtq_get_breadcrumb_schema(); }
}
add_action('wp_head', 'mtq_add_breadcrumb_schema');
