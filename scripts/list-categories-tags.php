<?php
/**
 * Script untuk menampilkan daftar categories dan tags yang ada
 * Jalankan dengan: php scripts/list-categories-tags.php
 */

// Simple WordPress connection
define('WP_USE_THEMES', false);
require_once(dirname(__FILE__) . '/../wp-load.php');

echo "=== DAFTAR CATEGORIES DAN TAGS MTQ ===\n\n";

// Display categories
echo "📁 CATEGORIES:\n";
echo "================\n";
$categories = get_categories([
    'hide_empty' => false,
    'orderby' => 'name'
]);

if ($categories) {
    foreach ($categories as $category) {
        if ($category->name !== 'Uncategorized') {
            echo sprintf("%-20s | ID: %-3d | Posts: %-3d | %s\n", 
                $category->name, 
                $category->term_id, 
                $category->count, 
                $category->slug
            );
        }
    }
} else {
    echo "Tidak ada categories ditemukan.\n";
}

echo "\n";

// Display tags
echo "🏷️  TAGS:\n";
echo "================\n";
$tags = get_terms([
    'taxonomy' => 'post_tag',
    'hide_empty' => false,
    'orderby' => 'name',
    'number' => 50 // Show first 50 tags
]);

if ($tags) {
    $count = 0;
    foreach ($tags as $tag) {
        echo sprintf("%-15s | ID: %-3d | Posts: %-3d | %s\n", 
            $tag->name, 
            $tag->term_id, 
            $tag->count, 
            $tag->slug
        );
        $count++;
    }
    
    if (count($tags) == 50) {
        echo "... dan mungkin lebih banyak lagi\n";
    }
} else {
    echo "Tidak ada tags ditemukan.\n";
}

echo "\n";
echo "=== SUMMARY ===\n";
echo "Total Categories: " . count($categories) . "\n";
echo "Total Tags: " . count($tags) . "\n";

// Sample usage for posts
echo "\n=== CARA PENGGUNAAN ===\n";
echo "Untuk menggunakan categories dan tags ini pada post:\n\n";
echo "1. Categories (gunakan ID atau slug):\n";
echo "   wp_set_post_categories(\$post_id, [1, 2, 3]);\n";
echo "   wp_set_object_terms(\$post_id, 'kegiatan-mtq', 'category');\n\n";
echo "2. Tags (gunakan nama atau slug):\n";
echo "   wp_set_post_tags(\$post_id, 'mtq2024,quran,tilawah');\n";
echo "   wp_set_object_terms(\$post_id, ['mtq2024', 'prestasi'], 'post_tag');\n\n";

echo "Script selesai!\n";
?>
