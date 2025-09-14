<?php
/**
 * Quick Gallery Import - MTQ Aceh Pidie Jaya (Admin only)
 * Script cepat untuk mengimport dummy data gallery
 */

// WordPress Bootstrap
define('WP_USE_THEMES', false);
require_once dirname(__FILE__) . '/../../wp-load.php';

if (!defined('ABSPATH')) {
    http_response_code(403);
    exit('Forbidden');
}

if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('Anda tidak memiliki permission untuk menjalankan script ini!');
}

echo "<h1>🚀 Quick Gallery Import</h1>";

// Check system
if (!post_type_exists('mtq_gallery')) {
    echo "<p style='color: red;'>❌ Gallery post type tidak ditemukan! Pastikan theme MTQ sudah aktif.</p>";
    exit;
}

echo "<p>✅ Gallery system terdeteksi</p>";

// Create categories if not exists
$categories = array(
    'kegiatan-mtq' => 'Kegiatan MTQ',
    'rapat-koordinasi' => 'Rapat Koordinasi',
    'dokumentasi' => 'Dokumentasi',
    'pembukaan-mtq' => 'Pembukaan MTQ',
    'lomba-dewasa' => 'Lomba Dewasa'
);

echo "<h3>📂 Creating Categories...</h3>";
foreach ($categories as $slug => $name) {
    if (!term_exists($slug, 'mtq_gallery_category')) {
        wp_insert_term($name, 'mtq_gallery_category', array('slug' => $slug));
        echo "<p>✅ Created: {$name}</p>";
    } else {
        echo "<p>⏭️ Exists: {$name}</p>";
    }
}

// Create tags
$tags = array('mtq-2024', 'aceh-pidie-jaya', 'tilawah', 'tahfidz', 'rapat', 'koordinasi');
echo "<h3>🏷️ Creating Tags...</h3>";
foreach ($tags as $tag) {
    if (!term_exists($tag, 'mtq_gallery_tag')) {
        wp_insert_term($tag, 'mtq_gallery_tag');
        echo "<p>✅ Created: {$tag}</p>";
    } else {
        echo "<p>⏭️ Exists: {$tag}</p>";
    }
}

// Create sample galleries
echo "<h3>🎨 Creating Sample Galleries...</h3>";

$galleries = array(
    array(
        'title' => 'Dokumentasi Kegiatan MTQ Aceh Pidie Jaya 2024',
        'excerpt' => 'Koleksi foto-foto dokumentasi kegiatan MTQ Aceh Pidie Jaya tahun 2024.',
        'content' => 'Dokumentasi lengkap kegiatan MTQ Aceh Pidie Jaya 2024 yang menampilkan berbagai moment penting dalam event bergengsi ini. Setiap foto menggambarkan semangat dan antusiasme peserta, panitia, dan masyarakat.',
        'category' => 'kegiatan-mtq',
        'tags' => array('mtq-2024', 'aceh-pidie-jaya'),
        'layout' => 'grid',
        'columns' => '3',
        'image_count' => 6
    ),
    array(
        'title' => 'Video Rapat Koordinasi MTQ Aceh Pidie Jaya',
        'excerpt' => 'Video dokumentasi rapat koordinasi dan paparan MTQ.',
        'content' => 'Video dokumentasi rapat koordinasi MTQ yang membahas persiapan dan teknis pelaksanaan event. Sangat bermanfaat sebagai referensi untuk event sejenis.',
        'category' => 'rapat-koordinasi',
        'tags' => array('rapat', 'koordinasi'),
        'layout' => 'grid',
        'columns' => '1',
        'has_video' => true
    ),
    array(
        'title' => 'Pembukaan MTQ Aceh Pidie Jaya 2024',
        'excerpt' => 'Dokumentasi acara pembukaan MTQ yang meriah dengan kehadiran Bupati.',
        'content' => 'Dokumentasi acara pembukaan MTQ Aceh Pidie Jaya 2024 yang meriah. Acara dimulai dengan pembacaan ayat suci Al-Quran, sambutan-sambutan, dan penyerahan bendera lomba.',
        'category' => 'pembukaan-mtq',
        'tags' => array('mtq-2024', 'aceh-pidie-jaya'),
        'layout' => 'grid',
        'columns' => '3',
        'image_count' => 8
    ),
    array(
        'title' => 'Lomba Tilawah Kategori Dewasa',
        'excerpt' => 'Kompetisi tilawah kategori dewasa dengan peserta terbaik.',
        'content' => 'Kompetisi tilawah kategori dewasa merupakan cabang lomba bergengsi dalam MTQ. Para peserta menampilkan kemampuan terbaik dalam membaca Al-Quran dengan tartil.',
        'category' => 'lomba-dewasa',
        'tags' => array('tilawah', 'mtq-2024'),
        'layout' => 'grid',
        'columns' => '4',
        'image_count' => 10
    ),
    array(
        'title' => 'Gallery Lengkap MTQ Aceh Pidie Jaya 2024',
        'excerpt' => 'Koleksi lengkap foto dan video dokumentasi MTQ.',
        'content' => 'Gallery komprehensif yang menggabungkan foto dan video dokumentasi MTQ Aceh Pidie Jaya 2024. Menjadi arsip digital berharga untuk mengenang event ini.',
        'category' => 'dokumentasi',
        'tags' => array('mtq-2024', 'aceh-pidie-jaya'),
        'layout' => 'slider',
        'columns' => '3',
        'image_count' => 5,
        'has_video' => true
    )
);

$created_galleries = array();

foreach ($galleries as $gallery_data) {
    // Create gallery post
    $post_data = array(
        'post_title' => $gallery_data['title'],
        'post_excerpt' => $gallery_data['excerpt'],
        'post_content' => $gallery_data['content'],
        'post_type' => 'mtq_gallery',
        'post_status' => 'publish'
    );
    
    $gallery_id = wp_insert_post($post_data);
    
    if (!is_wp_error($gallery_id)) {
        // Set gallery settings
        update_post_meta($gallery_id, '_mtq_gallery_layout', $gallery_data['layout']);
        update_post_meta($gallery_id, '_mtq_gallery_columns', $gallery_data['columns']);
        update_post_meta($gallery_id, '_mtq_gallery_show_captions', 'yes');
        update_post_meta($gallery_id, '_mtq_gallery_enable_lightbox', 'yes');
        
        // Add dummy images
        if (isset($gallery_data['image_count'])) {
            $dummy_images = array();
            for ($i = 1; $i <= $gallery_data['image_count']; $i++) {
                $dummy_images[] = $i; // Placeholder attachment IDs
            }
            update_post_meta($gallery_id, '_mtq_gallery_images', $dummy_images);
        }
        
        // Add video if specified
        if (isset($gallery_data['has_video']) && $gallery_data['has_video']) {
            $video_data = array(
                array(
                    'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'type' => 'youtube',
                    'caption' => 'Video ' . $gallery_data['title']
                )
            );
            update_post_meta($gallery_id, '_mtq_gallery_videos', $video_data);
        }
        
        // Set category
        wp_set_post_terms($gallery_id, array($gallery_data['category']), 'mtq_gallery_category');
        
        // Set tags
        wp_set_post_terms($gallery_id, $gallery_data['tags'], 'mtq_gallery_tag');
        
        $created_galleries[] = array(
            'id' => $gallery_id,
            'title' => $gallery_data['title'],
            'url' => get_permalink($gallery_id)
        );
        
        echo "<p>✅ Created: {$gallery_data['title']} (ID: {$gallery_id})</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create: {$gallery_data['title']}</p>";
    }
}

echo "<h3>🎉 Import Completed!</h3>";
echo "<p>Created " . count($created_galleries) . " galleries successfully.</p>";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gallery Import Success</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f0f0f0; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
        h1, h3 { color: #2c3e50; }
        .gallery-list { margin: 20px 0; }
        .gallery-item { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #3498db; }
        .button { background: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block; }
        .button:hover { background: #2980b9; }
        .shortcuts { background: #e8f4fd; padding: 20px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎯 Gallery System Ready!</h2>
        
        <div class="gallery-list">
            <h3>📋 Created Galleries:</h3>
            <?php foreach ($created_galleries as $gallery) : ?>
                <div class="gallery-item">
                    <h4><?php echo esc_html($gallery['title']); ?></h4>
                    <p>ID: <?php echo $gallery['id']; ?></p>
                    <a href="<?php echo esc_url($gallery['url']); ?>" class="button" target="_blank">View Gallery</a>
                    <a href="<?php echo admin_url('post.php?post=' . $gallery['id'] . '&action=edit'); ?>" class="button" target="_blank">Edit Gallery</a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="shortcuts">
            <h3>🔗 Quick Access:</h3>
            <a href="<?php echo admin_url('edit.php?post_type=mtq_gallery'); ?>" class="button">Manage All Galleries</a>
            <a href="<?php echo admin_url('post-new.php?post_type=mtq_gallery'); ?>" class="button">Add New Gallery</a>
            <a href="<?php echo site_url('/gallery/'); ?>" class="button">View Gallery Archive</a>
        </div>
        
        <div class="shortcuts">
            <h3>📝 Shortcode Examples:</h3>
            <p><code>[mtq_gallery_list]</code> - Tampilkan semua gallery</p>
            <p><code>[mtq_gallery_list category="kegiatan-mtq" limit="6"]</code> - Gallery kegiatan MTQ</p>
            <p><code>[mtq_gallery id="<?php echo isset($created_galleries[0]) ? $created_galleries[0]['id'] : '1'; ?>"]</code> - Tampilkan gallery tertentu</p>
            <p><code>[mtq_gallery category="pembukaan-mtq" layout="slider"]</code> - Gallery pembukaan dengan slider</p>
        </div>
        
        <div style="margin-top: 30px; padding: 15px; background: #d4edda; border-radius: 5px; color: #155724;">
            <p><strong>✅ Success!</strong> Gallery system telah berhasil diimport dengan <?php echo count($created_galleries); ?> sample galleries.</p>
            <p>Sekarang Anda dapat mengelola gallery melalui WordPress admin atau menampilkannya menggunakan shortcode.</p>
        </div>
    </div>
</body>
</html>
