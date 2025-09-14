<?php
/**
 * Simple import script for berita-dummy.json
 * Run via CLI only: php scripts/import-berita.php
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("CLI only.\n");
}

require_once dirname(__DIR__) . '/wp-load.php';

// Load required WordPress files for media handling
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

if (php_sapi_name() === 'cli') {
    echo "Starting import...\n";
}

$json_file = __DIR__ . '/../data/berita-dummy.json';
if (!file_exists($json_file)) {
    wp_die('Data file not found: ' . $json_file);
}

$items = json_decode(file_get_contents($json_file), true);
if (!is_array($items)) {
    wp_die('Invalid JSON data');
}

// Ensure category 'Berita' exists
$cat = get_category_by_slug('berita');
if (!$cat) {
    $cat_result = wp_insert_term('Berita', 'category', array(
        'slug' => 'berita',
        'description' => 'Kategori berita MTQ Aceh XXXVII'
    ));
    if (!is_wp_error($cat_result)) {
        $cat_id = $cat_result['term_id'];
    } else {
        $cat_id = 1; // Default to uncategorized
    }
} else {
    $cat_id = $cat->term_id;
}

foreach ($items as $item) {
    // Check existing by title + date using WP_Query (get_page_by_title is deprecated since WP 6.2.0)
    $existing_query = new WP_Query(array(
        'post_type' => 'post',
        'post_status' => 'any',
        'title' => $item['title'],
        'posts_per_page' => 1,
        'fields' => 'ids'
    ));
    
    if ($existing_query->have_posts()) {
        if (php_sapi_name() === 'cli') echo "Skipping existing: {$item['title']}\n";
        wp_reset_postdata();
        continue;
    }
    wp_reset_postdata();

    $post_data = array(
        'post_title'    => $item['title'],
        'post_content'  => $item['content'],
        'post_excerpt'  => $item['excerpt'],
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_date'     => $item['date'],
        'post_category' => array($cat_id),
    );

    $post_id = wp_insert_post($post_data);
    if (is_wp_error($post_id) || !$post_id) {
        if (php_sapi_name() === 'cli') echo "Failed to insert: {$item['title']}\n";
        continue;
    }

    // Featured image - force update even for existing posts
    if (!empty($item['featured_image']) && !has_post_thumbnail($post_id)) {
        $image_url = $item['featured_image'];
        // download image to tmp
        $tmp = download_url($image_url);
        if (is_wp_error($tmp)) {
            if (php_sapi_name() === 'cli') echo "Failed to download image: $image_url - " . $tmp->get_error_message() . "\n";
        } else {
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
            
            // check file type
            $id = media_handle_sideload($file_array, $post_id);
            if (is_wp_error($id)) {
                if (php_sapi_name() === 'cli') echo "Failed to sideload: {$file_array['name']} - " . $id->get_error_message() . "\n";
                @unlink($tmp);
            } else {
                set_post_thumbnail($post_id, $id);
                if (php_sapi_name() === 'cli') echo "Image uploaded for: {$item['title']} (Media ID: $id)\n";
            }
        }
    } else {
        if (php_sapi_name() === 'cli') echo "Imported without image: {$item['title']} (ID: $post_id)\n";
    }
}

if (php_sapi_name() === 'cli') {
    echo "Import selesai.\n";
}

?>
