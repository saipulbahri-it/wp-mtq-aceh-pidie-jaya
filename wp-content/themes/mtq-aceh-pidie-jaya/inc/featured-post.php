<?php
/**
 * Featured post meta box
 */

if (!defined('ABSPATH')) { exit; }

function mtq_add_featured_post_meta_box() {
	add_meta_box('mtq_featured_post','Berita Utama','mtq_featured_post_meta_box_callback','post','side','high');
}
add_action('add_meta_boxes', 'mtq_add_featured_post_meta_box');

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

function mtq_save_featured_post_meta($post_id) {
	if (!isset($_POST['mtq_featured_post_nonce']) || !wp_verify_nonce($_POST['mtq_featured_post_nonce'], 'mtq_featured_post_nonce')) { return; }
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
	if (!current_user_can('edit_post', $post_id)) { return; }
	$featured = isset($_POST['mtq_featured_post']) ? '1' : '0';
	update_post_meta($post_id, '_featured_post', $featured);
}
add_action('save_post', 'mtq_save_featured_post_meta');
