<?php
/**
 * Reading time helpers and shortcode
 */

if (!defined('ABSPATH')) { exit; }

function mtq_reading_time_shortcode($atts) {
	global $post;
	if (!$post) { return '5'; }
	$content = get_post_field('post_content', $post->ID);
	$word_count = str_word_count(strip_tags($content));
	$reading_time = ceil($word_count / 200);
	return max(1, $reading_time);
}
add_shortcode('reading_time', 'mtq_reading_time_shortcode');

function mtq_get_reading_time($post_id = null) {
	if (!$post_id) {
		global $post; $post_id = $post ? $post->ID : 0;
	}
	if (!$post_id) { return 1; }
	$content = get_post_field('post_content', $post_id);
	$word_count = str_word_count(strip_tags($content));
	$reading_time = ceil($word_count / 200);
	return max(1, $reading_time);
}
