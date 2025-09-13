<?php
/**
 * Script untuk memperbaiki masalah Gallery tidak ditemukan
 * Jalankan script ini untuk flush permalinks dan setup gallery
 * 
 * Usage: Akses file ini via browser: domain.com/wp-content/themes/mtq-aceh-pidie-jaya/fix-gallery-permalink.php
 * Atau jalankan via WP-CLI atau terminal
 */

// Pastikan WordPress dimuat
if (!defined('ABSPATH')) {
    // Load WordPress
    require_once '../../../wp-load.php';
}

if (!is_admin() && !defined('WP_CLI')) {
    // Simple security check - hanya bisa dijalankan oleh admin
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }
}

echo "<h1>MTQ Gallery Permalink Fix</h1>";
echo "<p>Memperbaiki masalah 'Halaman Galeri Tidak Ditemukan'...</p>";

// 1. Check apakah post type terdaftar
echo "<h2>1. Checking Gallery Post Type</h2>";
if (post_type_exists('mtq_gallery')) {
    echo "✅ Post type 'mtq_gallery' sudah terdaftar<br>";
    
    // Check archive setting
    $post_type_obj = get_post_type_object('mtq_gallery');
    if ($post_type_obj && $post_type_obj->has_archive) {
        echo "✅ Archive gallery enabled: " . $post_type_obj->has_archive . "<br>";
    } else {
        echo "❌ Archive gallery tidak enabled<br>";
    }
    
    if ($post_type_obj && $post_type_obj->public) {
        echo "✅ Gallery post type adalah public<br>";
    } else {
        echo "❌ Gallery post type tidak public<br>";
    }
    
} else {
    echo "❌ Post type 'mtq_gallery' belum terdaftar<br>";
    echo "💡 Pastikan theme sudah diaktifkan dan file gallery-post-type.php ada<br>";
}

// 2. Flush rewrite rules
echo "<h2>2. Flushing Permalink Structure</h2>";
flush_rewrite_rules(true);
delete_option('mtq_gallery_permalinks_flushed');
echo "✅ Permalink structure telah di-flush<br>";

// 3. Check apakah URL gallery bisa diakses
echo "<h2>3. Testing Gallery URLs</h2>";
$gallery_archive_url = get_post_type_archive_link('mtq_gallery');
if ($gallery_archive_url) {
    echo "✅ Gallery archive URL: <a href='" . $gallery_archive_url . "' target='_blank'>" . $gallery_archive_url . "</a><br>";
} else {
    echo "❌ Tidak bisa generate gallery archive URL<br>";
}

// 4. Check templates
echo "<h2>4. Checking Templates</h2>";
$theme_dir = get_template_directory();
$archive_template = $theme_dir . '/archive-mtq_gallery.php';
$single_template = $theme_dir . '/single-mtq_gallery.php';

if (file_exists($archive_template)) {
    echo "✅ Template archive-mtq_gallery.php ditemukan<br>";
} else {
    echo "❌ Template archive-mtq_gallery.php tidak ditemukan<br>";
}

if (file_exists($single_template)) {
    echo "✅ Template single-mtq_gallery.php ditemukan<br>";
} else {
    echo "❌ Template single-mtq_gallery.php tidak ditemukan<br>";
}

// 5. Check apakah ada gallery posts
echo "<h2>5. Checking Gallery Content</h2>";
$gallery_posts = get_posts(array(
    'post_type' => 'mtq_gallery',
    'numberposts' => 5,
    'post_status' => 'publish'
));

if (!empty($gallery_posts)) {
    echo "✅ Ditemukan " . count($gallery_posts) . " gallery posts:<br>";
    foreach ($gallery_posts as $post) {
        $post_url = get_permalink($post->ID);
        echo "- <a href='" . $post_url . "' target='_blank'>" . $post->post_title . "</a><br>";
    }
} else {
    echo "⚠️ Belum ada gallery posts. <a href='/wp-admin/post-new.php?post_type=mtq_gallery'>Buat gallery baru</a><br>";
    echo "💡 Atau jalankan script import-dummy-gallery.php untuk membuat contoh gallery<br>";
}

// 6. Final test
echo "<h2>6. Final Test</h2>";
echo "<p><strong>Silakan test URL berikut:</strong></p>";
echo "<ul>";
echo "<li><a href='" . home_url('/gallery/') . "' target='_blank'>" . home_url('/gallery/') . "</a> (Gallery Archive)</li>";
if ($gallery_archive_url) {
    echo "<li><a href='" . $gallery_archive_url . "' target='_blank'>" . $gallery_archive_url . "</a> (Via WordPress Function)</li>";
}
echo "</ul>";

echo "<hr>";
echo "<p><strong>Jika masih bermasalah:</strong></p>";
echo "<ol>";
echo "<li>Pergi ke WP Admin → Settings → Permalinks</li>";
echo "<li>Klik 'Save Changes' tanpa mengubah apapun</li>";
echo "<li>Atau gunakan permalink structure: /%postname%/</li>";
echo "<li>Test kembali URL gallery</li>";
echo "</ol>";

echo "<p><em>Script selesai dijalankan pada: " . current_time('mysql') . "</em></p>";
?>
