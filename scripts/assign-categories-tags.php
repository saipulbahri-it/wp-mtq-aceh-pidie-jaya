<?php
/**
 * Script untuk menambahkan categories dan tags pada berita yang sudah ada
 * Jalankan dari root WordPress
 */

// Load WordPress
define('WP_USE_THEMES', false);
require_once(dirname(__FILE__) . '/../wp-load.php');

echo "🏷️ Menambahkan Categories dan Tags pada Berita MTQ...\n\n";

// Get all posts
$posts = get_posts([
    'numberposts' => -1,
    'post_type' => 'post',
    'post_status' => 'publish'
]);

if (empty($posts)) {
    echo "❌ Tidak ada posts ditemukan.\n";
    exit;
}

echo "📊 Ditemukan " . count($posts) . " artikel untuk diupdate.\n\n";

// Get available categories and tags
$categories = get_categories(['hide_empty' => false]);
$tags = get_terms(['taxonomy' => 'post_tag', 'hide_empty' => false]);

echo "📁 Available Categories: " . count($categories) . "\n";
foreach ($categories as $cat) {
    if ($cat->name !== 'Uncategorized') {
        echo "   - {$cat->name} (ID: {$cat->term_id})\n";
    }
}

echo "\n🏷️ Available Tags: " . count($tags) . "\n";
foreach (array_slice($tags, 0, 10) as $tag) {
    echo "   - {$tag->name} (ID: {$tag->term_id})\n";
}
if (count($tags) > 10) {
    echo "   ... dan " . (count($tags) - 10) . " lainnya\n";
}

echo "\n=== UPDATING POSTS ===\n";

// Define mapping based on post titles/content
$category_mapping = [
    'presiden' => ['Berita Terkini', 'Pengumuman'],
    'mtq' => ['Kegiatan MTQ', 'Berita Terkini'],
    'juara' => ['Prestasi', 'Lomba'],
    'kompetisi' => ['Lomba', 'Kegiatan MTQ'],
    'tilawah' => ['Lomba', 'Prestasi'],
    'peserta' => ['Peserta', 'Kegiatan MTQ'],
    'jadwal' => ['Jadwal', 'Pengumuman'],
    'acara' => ['Kegiatan MTQ', 'Jadwal'],
    'lomba' => ['Lomba', 'Kompetisi'],
    'kegiatan' => ['Kegiatan MTQ'],
    'pengumuman' => ['Pengumuman'],
    'galeri' => ['Galeri']
];

$tag_mapping = [
    'presiden' => ['mtq2024', 'pengumuman', 'berita-terkini'],
    'republik' => ['indonesia', 'pemerintah', 'negara'],
    'mtq' => ['mtq2024', 'mtq-aceh', 'pidie-jaya', 'quran'],
    'quran' => ['quran', 'tilawah', 'islam'],
    'tilawah' => ['tilawah', 'quran', 'suara-emas', 'merdu'],
    'juara' => ['prestasi', 'juara', 'kompetisi'],
    'peserta' => ['peserta', 'lomba', 'kompetisi'],
    'kegiatan' => ['kegiatan', 'acara', 'mtq2024'],
    'lomba' => ['lomba', 'kompetisi', 'prestasi'],
    'islam' => ['islam', 'keagamaan', 'budaya'],
    'aceh' => ['mtq-aceh', 'pidie-jaya', 'budaya'],
    'masyarakat' => ['masyarakat', 'budaya', 'tradisi'],
    'kaligrafi' => ['kaligrafi', 'seni', 'islam'],
    'adzan' => ['adzan', 'islam', 'suara-emas'],
    'hafalan' => ['hafalan', 'quran', 'prestasi'],
    'tafsir' => ['tafsir', 'quran', 'islam']
];

$updated_posts = 0;
$errors = 0;

foreach ($posts as $post) {
    $post_title = strtolower($post->post_title);
    $post_content = strtolower($post->post_content);
    $post_text = $post_title . ' ' . $post_content;
    
    echo "📰 Processing: " . wp_trim_words($post->post_title, 8) . " (ID: {$post->ID})\n";
    
    // Determine categories based on content
    $assigned_categories = [];
    foreach ($category_mapping as $keyword => $cats) {
        if (strpos($post_text, $keyword) !== false) {
            foreach ($cats as $cat_name) {
                $category = get_category_by_slug(sanitize_title($cat_name));
                if ($category && !in_array($category->term_id, $assigned_categories)) {
                    $assigned_categories[] = $category->term_id;
                }
            }
        }
    }
    
    // Default category if none found
    if (empty($assigned_categories)) {
        $default_cat = get_category_by_slug('berita-terkini');
        if ($default_cat) {
            $assigned_categories[] = $default_cat->term_id;
        }
    }
    
    // Determine tags based on content
    $assigned_tags = [];
    foreach ($tag_mapping as $keyword => $tag_names) {
        if (strpos($post_text, $keyword) !== false) {
            foreach ($tag_names as $tag_name) {
                if (!in_array($tag_name, $assigned_tags)) {
                    $assigned_tags[] = $tag_name;
                }
            }
        }
    }
    
    // Add some random relevant tags if none found
    if (empty($assigned_tags)) {
        $assigned_tags = ['mtq2024', 'berita-terkini', 'kegiatan'];
    }
    
    // Limit to max 5 tags
    $assigned_tags = array_slice($assigned_tags, 0, 5);
    
    // Update post categories
    if (!empty($assigned_categories)) {
        $cat_result = wp_set_post_categories($post->ID, $assigned_categories);
        if ($cat_result) {
            echo "   ✅ Categories: " . implode(', ', $assigned_categories) . "\n";
        } else {
            echo "   ❌ Failed to update categories\n";
            $errors++;
        }
    }
    
    // Update post tags
    if (!empty($assigned_tags)) {
        $tag_result = wp_set_post_tags($post->ID, $assigned_tags);
        if ($tag_result !== false) {
            echo "   ✅ Tags: " . implode(', ', $assigned_tags) . "\n";
        } else {
            echo "   ❌ Failed to update tags\n";
            $errors++;
        }
    }
    
    $updated_posts++;
    echo "\n";
}

echo "=== SUMMARY ===\n";
echo "✅ Posts Updated: $updated_posts\n";
echo "❌ Errors: $errors\n";

// Show sample of updated posts
echo "\n=== SAMPLE VERIFICATION ===\n";
$sample_posts = get_posts(['numberposts' => 3, 'post_status' => 'publish']);
foreach ($sample_posts as $sample) {
    echo "📰 " . wp_trim_words($sample->post_title, 6) . "\n";
    
    $post_categories = get_the_category($sample->ID);
    if ($post_categories) {
        echo "   Categories: ";
        foreach ($post_categories as $cat) {
            echo $cat->name . " ";
        }
        echo "\n";
    }
    
    $post_tags = get_the_tags($sample->ID);
    if ($post_tags) {
        echo "   Tags: ";
        foreach ($post_tags as $tag) {
            echo $tag->name . " ";
        }
        echo "\n";
    }
    echo "\n";
}

echo "Script completed! ✨\n";
?>
