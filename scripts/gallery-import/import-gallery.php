<?php
/**
 * Import Real Gallery Data - MTQ Aceh Pidie Jaya
 * Script untuk mengimport data gallery menggunakan foto dan video real yang sudah ada
 * 
 * PERINGATAN: Script ini untuk development/testing!
 * 
 * Usage: Akses melalui browser
 * URL: /import-gallery.php
 */

// Load WordPress
require_once('./wp-load.php');

// Check if user has admin capability
if (!current_user_can('manage_options')) {
    wp_die('Anda tidak memiliki permission untuk menjalankan script ini!');
}

// Handle form submission
$action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';
$results = array();

if ($action === 'import') {
    $importer = new MTQ_Real_Gallery_Importer();
    $results = $importer->import_all();
}

class MTQ_Real_Gallery_Importer {
    
    private $data_path;
    private $upload_dir;
    
    public function __construct() {
        $this->data_path = ABSPATH . 'data/';
        $this->upload_dir = wp_upload_dir();
    }
    
    public function import_all() {
        $results = array();
        
        // 1. Create categories and tags
        $this->create_taxonomies();
        
        // 2. Import photos as gallery
        $photo_gallery = $this->import_photo_gallery();
        if ($photo_gallery) {
            $results[] = $photo_gallery;
        }
        
        // 3. Import video as gallery
        $video_gallery = $this->import_video_gallery();
        if ($video_gallery) {
            $results[] = $video_gallery;
        }
        
        // 4. Create combined gallery
        $combined_gallery = $this->create_combined_gallery();
        if ($combined_gallery) {
            $results[] = $combined_gallery;
        }
        
        return $results;
    }
    
    private function create_taxonomies() {
        // Create categories
        $categories = array(
            'kegiatan-mtq' => 'Kegiatan MTQ',
            'rapat-koordinasi' => 'Rapat Koordinasi',
            'dokumentasi' => 'Dokumentasi'
        );
        
        foreach ($categories as $slug => $name) {
            if (!term_exists($slug, 'mtq_gallery_category')) {
                wp_insert_term($name, 'mtq_gallery_category', array('slug' => $slug));
            }
        }
        
        // Create tags
        $tags = array('mtq-2024', 'aceh-pidie-jaya', 'rapat', 'koordinasi', 'paparan');
        
        foreach ($tags as $tag) {
            if (!term_exists($tag, 'mtq_gallery_tag')) {
                wp_insert_term($tag, 'mtq_gallery_tag');
            }
        }
    }
    
    private function import_photo_gallery() {
        $photo_dir = $this->data_path . 'Foto/';
        
        if (!is_dir($photo_dir)) {
            return false;
        }
        
        // Get all JPG files
        $photos = glob($photo_dir . '*.jpg');
        
        if (empty($photos)) {
            return false;
        }
        
        // Create gallery post
        $gallery_data = array(
            'post_title' => 'Dokumentasi Kegiatan MTQ Aceh Pidie Jaya 2024',
            'post_excerpt' => 'Koleksi foto-foto dokumentasi kegiatan MTQ Aceh Pidie Jaya tahun 2024 yang menampilkan berbagai moment penting dalam event tersebut.',
            'post_content' => 'Dokumentasi lengkap kegiatan MTQ Aceh Pidie Jaya 2024. Foto-foto ini mengabadikan berbagai moment penting dari persiapan hingga pelaksanaan event MTQ yang meriah dan berkesan.

Setiap foto menggambarkan semangat dan antusiasme peserta, panitia, dan masyarakat dalam mendukung event bergengsi ini. MTQ Aceh Pidie Jaya 2024 merupakan ajang kompetisi yang mempertemukan para qori dan qoriah terbaik se-kabupaten.',
            'post_type' => 'mtq_gallery',
            'post_status' => 'publish',
        );
        
        $gallery_id = wp_insert_post($gallery_data);
        
        if (is_wp_error($gallery_id)) {
            return false;
        }
        
        // Import photos to media library
        $attachment_ids = array();
        $imported_count = 0;
        
        foreach ($photos as $photo_path) {
            if ($imported_count >= 10) break; // Limit to 10 photos for demo
            
            $attachment_id = $this->import_image_to_media_library($photo_path);
            if ($attachment_id) {
                $attachment_ids[] = $attachment_id;
                $imported_count++;
            }
        }
        
        // Save gallery images
        update_post_meta($gallery_id, '_mtq_gallery_images', $attachment_ids);
        
        // Set gallery settings
        update_post_meta($gallery_id, '_mtq_gallery_layout', 'grid');
        update_post_meta($gallery_id, '_mtq_gallery_columns', '3');
        update_post_meta($gallery_id, '_mtq_gallery_show_captions', 'yes');
        update_post_meta($gallery_id, '_mtq_gallery_enable_lightbox', 'yes');
        
        // Assign to category
        wp_set_post_terms($gallery_id, array('kegiatan-mtq'), 'mtq_gallery_category');
        wp_set_post_terms($gallery_id, array('mtq-2024', 'aceh-pidie-jaya'), 'mtq_gallery_tag');
        
        // Set featured image
        if (!empty($attachment_ids)) {
            set_post_thumbnail($gallery_id, $attachment_ids[0]);
        }
        
        return array(
            'id' => $gallery_id,
            'title' => get_the_title($gallery_id),
            'url' => get_permalink($gallery_id),
            'images_count' => count($attachment_ids)
        );
    }
    
    private function import_video_gallery() {
        $video_dir = $this->data_path . 'Video/';
        
        if (!is_dir($video_dir)) {
            return false;
        }
        
        // Get video files
        $videos = glob($video_dir . '*.mp4');
        
        if (empty($videos)) {
            return false;
        }
        
        // Create video gallery post
        $gallery_data = array(
            'post_title' => 'Video Rapat Koordinasi MTQ Aceh Pidie Jaya',
            'post_excerpt' => 'Video dokumentasi rapat koordinasi dan paparan MTQ Aceh Pidie Jaya yang membahas persiapan dan teknis pelaksanaan event.',
            'post_content' => 'Video dokumentasi rapat koordinasi MTQ Aceh Pidie Jaya yang membahas berbagai aspek persiapan event. Rapat ini menghadirkan stakeholder terkait untuk memastikan kelancaran pelaksanaan MTQ.

Video ini merekam pembahasan mengenai teknis pelaksanaan, jadwal kegiatan, dan koordinasi antar panitia. Sangat bermanfaat sebagai referensi untuk event-event sejenis di masa mendatang.',
            'post_type' => 'mtq_gallery',
            'post_status' => 'publish',
        );
        
        $gallery_id = wp_insert_post($gallery_data);
        
        if (is_wp_error($gallery_id)) {
            return false;
        }
        
        // Prepare video data
        $video_data = array();
        
        foreach ($videos as $video_path) {
            $filename = basename($video_path);
            $video_url = site_url('data/Video/' . $filename);
            
            $video_data[] = array(
                'url' => $video_url,
                'type' => 'direct',
                'caption' => 'Rapat Koordinasi dan Paparan MTQ Aceh Pidie Jaya'
            );
            
            break; // Only process first video for demo
        }
        
        // Save video data
        update_post_meta($gallery_id, '_mtq_gallery_videos', $video_data);
        
        // Set gallery settings
        update_post_meta($gallery_id, '_mtq_gallery_layout', 'grid');
        update_post_meta($gallery_id, '_mtq_gallery_columns', '1');
        update_post_meta($gallery_id, '_mtq_gallery_show_captions', 'yes');
        update_post_meta($gallery_id, '_mtq_gallery_enable_lightbox', 'no');
        
        // Assign to category
        wp_set_post_terms($gallery_id, array('rapat-koordinasi'), 'mtq_gallery_category');
        wp_set_post_terms($gallery_id, array('rapat', 'koordinasi', 'paparan'), 'mtq_gallery_tag');
        
        return array(
            'id' => $gallery_id,
            'title' => get_the_title($gallery_id),
            'url' => get_permalink($gallery_id),
            'videos_count' => count($video_data)
        );
    }
    
    private function create_combined_gallery() {
        // Create a combined gallery with both photos and videos
        $gallery_data = array(
            'post_title' => 'Gallery Lengkap MTQ Aceh Pidie Jaya 2024',
            'post_excerpt' => 'Koleksi lengkap foto dan video dokumentasi MTQ Aceh Pidie Jaya 2024 dari persiapan hingga pelaksanaan event.',
            'post_content' => 'Gallery lengkap yang menampilkan dokumentasi MTQ Aceh Pidie Jaya 2024 dalam bentuk foto dan video. Menggabungkan moment-moment terbaik dari persiapan, rapat koordinasi, hingga pelaksanaan event MTQ yang meriah.

Gallery ini menjadi arsip digital yang berharga untuk mengenang event MTQ Aceh Pidie Jaya 2024 dan dapat menjadi referensi untuk event-event sejenis di masa mendatang.',
            'post_type' => 'mtq_gallery',
            'post_status' => 'publish',
        );
        
        $gallery_id = wp_insert_post($gallery_data);
        
        if (is_wp_error($gallery_id)) {
            return false;
        }
        
        // Import sample photos
        $photo_dir = $this->data_path . 'Foto/';
        $photos = glob($photo_dir . '*.jpg');
        $attachment_ids = array();
        
        // Import first 5 photos
        for ($i = 0; $i < min(5, count($photos)); $i++) {
            $attachment_id = $this->import_image_to_media_library($photos[$i]);
            if ($attachment_id) {
                $attachment_ids[] = $attachment_id;
            }
        }
        
        // Add video
        $video_data = array(
            array(
                'url' => site_url('data/Video/Rapat Koorninasi dan Paparan MTQ.mp4'),
                'type' => 'direct',
                'caption' => 'Video Rapat Koordinasi MTQ'
            )
        );
        
        // Save data
        update_post_meta($gallery_id, '_mtq_gallery_images', $attachment_ids);
        update_post_meta($gallery_id, '_mtq_gallery_videos', $video_data);
        
        // Set gallery settings
        update_post_meta($gallery_id, '_mtq_gallery_layout', 'slider');
        update_post_meta($gallery_id, '_mtq_gallery_columns', '3');
        update_post_meta($gallery_id, '_mtq_gallery_show_captions', 'yes');
        update_post_meta($gallery_id, '_mtq_gallery_enable_lightbox', 'yes');
        
        // Assign to category
        wp_set_post_terms($gallery_id, array('dokumentasi'), 'mtq_gallery_category');
        wp_set_post_terms($gallery_id, array('mtq-2024', 'aceh-pidie-jaya'), 'mtq_gallery_tag');
        
        // Set featured image
        if (!empty($attachment_ids)) {
            set_post_thumbnail($gallery_id, $attachment_ids[0]);
        }
        
        return array(
            'id' => $gallery_id,
            'title' => get_the_title($gallery_id),
            'url' => get_permalink($gallery_id),
            'images_count' => count($attachment_ids),
            'videos_count' => count($video_data)
        );
    }
    
    private function import_image_to_media_library($image_path) {
        if (!file_exists($image_path)) {
            return false;
        }
        
        $filename = basename($image_path);
        $upload_file = wp_upload_bits($filename, null, file_get_contents($image_path));
        
        if ($upload_file['error']) {
            return false;
        }
        
        $wp_filetype = wp_check_filetype($filename, null);
        
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        
        $attachment_id = wp_insert_attachment($attachment, $upload_file['file']);
        
        if (!is_wp_error($attachment_id)) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);
            wp_update_attachment_metadata($attachment_id, $attachment_data);
            
            return $attachment_id;
        }
        
        return false;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Import MTQ Gallery Data</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; border-bottom: 3px solid #3498db; padding-bottom: 10px; }
        .button { background: #3498db; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 5px; }
        .button:hover { background: #2980b9; }
        .button.danger { background: #e74c3c; }
        .button.danger:hover { background: #c0392b; }
        .result { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 15px 0; border-radius: 5px; }
        .gallery-item { background: #f8f9fa; border: 1px solid #dee2e6; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .status { padding: 20px; background: #e9ecef; border-radius: 5px; margin: 20px 0; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎯 Import MTQ Gallery Data</h1>
        
        <div class="status">
            <h3>📊 System Status:</h3>
            <?php
            echo "WordPress Version: " . get_bloginfo('version') . "<br>";
            echo "Gallery Post Type: " . (post_type_exists('mtq_gallery') ? '✅ Ready' : '❌ Not Found') . "<br>";
            echo "Data Directory: " . (is_dir(ABSPATH . 'data/') ? '✅ Found' : '❌ Not Found') . "<br>";
            
            $photo_count = is_dir(ABSPATH . 'data/Foto/') ? count(glob(ABSPATH . 'data/Foto/*.jpg')) : 0;
            $video_count = is_dir(ABSPATH . 'data/Video/') ? count(glob(ABSPATH . 'data/Video/*.mp4')) : 0;
            
            echo "Photos Available: {$photo_count} files<br>";
            echo "Videos Available: {$video_count} files<br>";
            ?>
        </div>
        
        <?php if ($action === 'import' && !empty($results)) : ?>
            <div class="result">
                <h3>✅ Import Berhasil!</h3>
                <p>Berhasil mengimport <?php echo count($results); ?> gallery ke database.</p>
            </div>
            
            <?php foreach ($results as $result) : ?>
                <div class="gallery-item">
                    <h4><?php echo esc_html($result['title']); ?></h4>
                    <p><strong>ID:</strong> <?php echo $result['id']; ?></p>
                    <?php if (isset($result['images_count'])) : ?>
                        <p><strong>Images:</strong> <?php echo $result['images_count']; ?></p>
                    <?php endif; ?>
                    <?php if (isset($result['videos_count'])) : ?>
                        <p><strong>Videos:</strong> <?php echo $result['videos_count']; ?></p>
                    <?php endif; ?>
                    <p>
                        <a href="<?php echo esc_url($result['url']); ?>" target="_blank" class="button">Lihat Gallery</a>
                        <a href="<?php echo admin_url('post.php?post=' . $result['id'] . '&action=edit'); ?>" target="_blank" class="button">Edit Gallery</a>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <div class="warning">
            <h3>⚠️ Perhatian:</h3>
            <ul>
                <li>Script ini akan mengimport foto dari folder <code>data/Foto/</code></li>
                <li>Video akan diimport dari folder <code>data/Video/</code></li>
                <li>Gallery yang sudah ada tidak akan ditimpa</li>
                <li>Pastikan folder data sudah tersedia di root website</li>
            </ul>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="?action=import" class="button" onclick="return confirm('Apakah Anda yakin ingin mengimport gallery data?')">
                🚀 Import Gallery Data
            </a>
            
            <a href="<?php echo admin_url('edit.php?post_type=mtq_gallery'); ?>" class="button">
                📋 Lihat Semua Gallery
            </a>
            
            <a href="<?php echo site_url('/gallery/'); ?>" class="button">
                🎨 Lihat Gallery Frontend
            </a>
        </div>
        
        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 14px;">
            <p><strong>📁 File Locations:</strong></p>
            <ul>
                <li>Photos: <code><?php echo ABSPATH; ?>data/Foto/</code></li>
                <li>Videos: <code><?php echo ABSPATH; ?>data/Video/</code></li>
                <li>Upload Directory: <code><?php echo wp_upload_dir()['basedir']; ?></code></li>
            </ul>
        </div>
    </div>
</body>
</html>
