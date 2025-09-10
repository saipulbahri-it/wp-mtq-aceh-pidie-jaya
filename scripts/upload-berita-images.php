<?php
/**
 * Upload images for existing berita posts
 * Place this file in WordPress root and run via CLI: php scripts/upload-berita-images.php
 */

require_once dirname(__DIR__) . '/wp-load.php';

// Load required WordPress files for media handling
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

if (php_sapi_name() === 'cli') {
    echo "Starting image upload for existing posts...\n";
}

$json_file = __DIR__ . '/../data/berita-dummy.json';
if (!file_exists($json_file)) {
    wp_die('Data file not found: ' . $json_file);
}

$items = json_decode(file_get_contents($json_file), true);
if (!is_array($items)) {
    wp_die('Invalid JSON data');
}

foreach ($items as $item) {
    // Find existing post by title
    $existing = get_page_by_title($item['title'], OBJECT, 'post');
    if (!$existing) {
        if (php_sapi_name() === 'cli') echo "Post not found: {$item['title']}\n";
        continue;
    }
    
    $post_id = $existing->ID;
    
    // Check if post already has featured image
    if (has_post_thumbnail($post_id)) {
        if (php_sapi_name() === 'cli') echo "Already has image: {$item['title']}\n";
        continue;
    }
    
    // Upload featured image
    if (!empty($item['featured_image'])) {
        $image_url = $item['featured_image'];
        
        if (php_sapi_name() === 'cli') echo "Downloading: $image_url\n";
        
        // download image to tmp
        $tmp = download_url($image_url);
        if (is_wp_error($tmp)) {
            if (php_sapi_name() === 'cli') echo "Failed to download: " . $tmp->get_error_message() . "\n";
            continue;
        }
        
        $file_array = array();
        // Create a proper filename
        $filename = 'mtq-berita-' . $post_id . '-' . time();
        
        // Add proper extension based on image type
        $file_info = getimagesize($tmp);
        if ($file_info !== false) {
            $extensions = [IMAGETYPE_JPEG => '.jpg', IMAGETYPE_PNG => '.png', IMAGETYPE_GIF => '.gif', IMAGETYPE_WEBP => '.webp'];
            $extension = isset($extensions[$file_info[2]]) ? $extensions[$file_info[2]] : '.jpg';
            $file_array['name'] = $filename . $extension;
        } else {
            $file_array['name'] = $filename . '.jpg';
        }
        
        $file_array['tmp_name'] = $tmp;
        
        // Upload to media library
        $attachment_id = media_handle_sideload($file_array, $post_id);
        if (is_wp_error($attachment_id)) {
            if (php_sapi_name() === 'cli') echo "Failed to upload: " . $attachment_id->get_error_message() . "\n";
            @unlink($tmp);
        } else {
            // Set as featured image
            set_post_thumbnail($post_id, $attachment_id);
            if (php_sapi_name() === 'cli') echo "✓ Uploaded image for: {$item['title']} (Media ID: $attachment_id)\n";
        }
    }
}

if (php_sapi_name() === 'cli') {
    echo "Image upload completed.\n";
}

?>
