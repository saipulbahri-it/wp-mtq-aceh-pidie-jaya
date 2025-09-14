<?php
/**
 * Simple Gallery Import - MTQ Aceh Pidie Jaya (Admin only)
 * Script sederhana untuk mengimport gallery data ke database
 */

// Load WordPress
require_once dirname(__FILE__) . '/../../wp-load.php';

if (!defined('ABSPATH')) {
    http_response_code(403);
    exit('Forbidden');
}

if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('Anda tidak memiliki permission untuk menjalankan script ini!');
}

class Simple_Gallery_Import {
    
    public function __construct() {
        $this->run_import();
    }
    
    public function run_import() {
        echo "<h1>🚀 Import Gallery MTQ</h1>";
        
        // Check if gallery system exists
        if (!post_type_exists('mtq_gallery')) {
            echo "<p>❌ Gallery post type tidak ditemukan!</p>";
            return;
        }
        
        echo "<p>✅ Gallery system detected</p>";
        
        // Create categories
        $this->create_categories();
        
        // Create gallery with real data
        $this->create_sample_galleries();
        
        echo "<h3>🎉 Import selesai!</h3>";
        echo "<p><a href='" . admin_url('edit.php?post_type=mtq_gallery') . "'>Lihat Gallery di Admin</a></p>";
        echo "<p><a href='" . site_url('/gallery/') . "'>Lihat Gallery di Frontend</a></p>";
    }
    
    private function create_categories() {
        echo "<h3>📂 Creating Categories...</h3>";
        
        $categories = array(
            'kegiatan-mtq' => 'Kegiatan MTQ',
            'rapat-koordinasi' => 'Rapat Koordinasi', 
            'dokumentasi' => 'Dokumentasi'
        );
        
        foreach ($categories as $slug => $name) {
            if (!term_exists($slug, 'mtq_gallery_category')) {
                $result = wp_insert_term($name, 'mtq_gallery_category', array('slug' => $slug));
                if (!is_wp_error($result)) {
                    echo "<p>✅ Category created: {$name}</p>";
                }
            } else {
                echo "<p>⏭️ Category exists: {$name}</p>";
            }
        }
    }
    
    private function create_sample_galleries() {
        echo "<h3>🎨 Creating Sample Galleries...</h3>";
        
        // Gallery 1: Dokumentasi Foto MTQ
        $gallery1 = array(
            'post_title' => 'Dokumentasi Kegiatan MTQ Aceh Pidie Jaya 2024',
            'post_excerpt' => 'Koleksi foto-foto dokumentasi kegiatan MTQ Aceh Pidie Jaya tahun 2024.',
            'post_content' => 'Dokumentasi lengkap kegiatan MTQ Aceh Pidie Jaya 2024 yang menampilkan berbagai moment penting dalam event bergengsi ini.',
            'post_type' => 'mtq_gallery',
            'post_status' => 'publish',
        );
        
        $gallery1_id = wp_insert_post($gallery1);
        
        if (!is_wp_error($gallery1_id)) {
            // Set gallery metadata
            update_post_meta($gallery1_id, '_mtq_gallery_layout', 'grid');
            update_post_meta($gallery1_id, '_mtq_gallery_columns', '3');
            update_post_meta($gallery1_id, '_mtq_gallery_show_captions', 'yes');
            update_post_meta($gallery1_id, '_mtq_gallery_enable_lightbox', 'yes');
            
            // Add sample image IDs (placeholder - in real implementation you'd import actual images)
            $sample_images = array(1, 2, 3, 4, 5); // These would be real attachment IDs
            update_post_meta($gallery1_id, '_mtq_gallery_images', $sample_images);
            
            // Set category and tags
            wp_set_post_terms($gallery1_id, array('kegiatan-mtq'), 'mtq_gallery_category');
            wp_set_post_terms($gallery1_id, array('mtq-2024', 'aceh-pidie-jaya'), 'mtq_gallery_tag');
            
            echo "<p>✅ Created: " . get_the_title($gallery1_id) . " (ID: {$gallery1_id})</p>";
        }
        
        // Gallery 2: Video Rapat Koordinasi
        $gallery2 = array(
            'post_title' => 'Video Rapat Koordinasi MTQ Aceh Pidie Jaya',
            'post_excerpt' => 'Video dokumentasi rapat koordinasi dan paparan MTQ.',
            'post_content' => 'Video dokumentasi rapat koordinasi MTQ yang membahas persiapan dan teknis pelaksanaan event.',
            'post_type' => 'mtq_gallery',
            'post_status' => 'publish',
        );
        
        $gallery2_id = wp_insert_post($gallery2);
        
        if (!is_wp_error($gallery2_id)) {
            // Set gallery metadata
            update_post_meta($gallery2_id, '_mtq_gallery_layout', 'grid');
            update_post_meta($gallery2_id, '_mtq_gallery_columns', '1');
            update_post_meta($gallery2_id, '_mtq_gallery_show_captions', 'yes');
            
            // Add video data
            $video_data = array(
                array(
                    'url' => site_url('data/Video/Rapat Koorninasi dan Paparan MTQ.mp4'),
                    'type' => 'direct',
                    'caption' => 'Rapat Koordinasi dan Paparan MTQ Aceh Pidie Jaya'
                )
            );
            update_post_meta($gallery2_id, '_mtq_gallery_videos', $video_data);
            
            // Set category and tags
            wp_set_post_terms($gallery2_id, array('rapat-koordinasi'), 'mtq_gallery_category');
            wp_set_post_terms($gallery2_id, array('rapat', 'koordinasi'), 'mtq_gallery_tag');
            
            echo "<p>✅ Created: " . get_the_title($gallery2_id) . " (ID: {$gallery2_id})</p>";
        }
        
        // Gallery 3: Mixed Gallery
        $gallery3 = array(
            'post_title' => 'Gallery Lengkap MTQ Aceh Pidie Jaya 2024',
            'post_excerpt' => 'Koleksi lengkap foto dan video dokumentasi MTQ.',
            'post_content' => 'Gallery komprehensif yang menggabungkan foto dan video dokumentasi MTQ Aceh Pidie Jaya 2024.',
            'post_type' => 'mtq_gallery',
            'post_status' => 'publish',
        );
        
        $gallery3_id = wp_insert_post($gallery3);
        
        if (!is_wp_error($gallery3_id)) {
            // Set gallery metadata
            update_post_meta($gallery3_id, '_mtq_gallery_layout', 'slider');
            update_post_meta($gallery3_id, '_mtq_gallery_columns', '3');
            update_post_meta($gallery3_id, '_mtq_gallery_show_captions', 'yes');
            update_post_meta($gallery3_id, '_mtq_gallery_enable_lightbox', 'yes');
            
            // Add both images and videos
            $sample_images = array(1, 2, 3);
            update_post_meta($gallery3_id, '_mtq_gallery_images', $sample_images);
            
            $video_data = array(
                array(
                    'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'type' => 'youtube',
                    'caption' => 'Video Highlight MTQ Aceh Pidie Jaya 2024'
                )
            );
            update_post_meta($gallery3_id, '_mtq_gallery_videos', $video_data);
            
            // Set category and tags
            wp_set_post_terms($gallery3_id, array('dokumentasi'), 'mtq_gallery_category');
            wp_set_post_terms($gallery3_id, array('mtq-2024', 'highlight'), 'mtq_gallery_tag');
            
            echo "<p>✅ Created: " . get_the_title($gallery3_id) . " (ID: {$gallery3_id})</p>";
        }
    }
}

// Run the import
new Simple_Gallery_Import();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Gallery Import Complete</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #2c3e50; }
        h3 { color: #3498db; }
        p { margin: 10px 0; }
        a { color: #3498db; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h2>🎯 Gallery System Test</h2>
    <p>Untuk menguji gallery system yang sudah diimport:</p>
    
    <h4>📋 Shortcode Examples:</h4>
    <ul>
        <li><code>[mtq_gallery_list]</code> - Tampilkan semua gallery</li>
        <li><code>[mtq_gallery_list category="kegiatan-mtq"]</code> - Gallery kegiatan MTQ</li>
        <li><code>[mtq_gallery id="1"]</code> - Tampilkan gallery tertentu</li>
    </ul>
    
    <h4>🔗 Quick Links:</h4>
    <ul>
        <li><a href="<?php echo admin_url('edit.php?post_type=mtq_gallery'); ?>">Manage Galleries (Admin)</a></li>
        <li><a href="<?php echo site_url('/gallery/'); ?>">View Gallery Archive</a></li>
        <li><a href="<?php echo admin_url('post-new.php?post_type=mtq_gallery'); ?>">Add New Gallery</a></li>
    </ul>
</body>
</html>
