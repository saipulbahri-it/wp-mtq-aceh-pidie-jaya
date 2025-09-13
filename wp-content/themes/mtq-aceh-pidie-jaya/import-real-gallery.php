<?php
/**
 * Import Real MTQ Gallery Data
 * Script untuk import foto dan video MTQ yang sudah ada di folder data
 * 
 * PERINGATAN: Script ini untuk mengimport data real!
 * Pastikan backup database sebelum menjalankan.
 * 
 * Usage: Akses melalui browser
 * URL: /wp-content/themes/mtq-aceh-pidie-jaya/import-real-gallery.php
 */

// Security check - hanya bisa dijalankan di development
if (!defined('WP_DEBUG') || !WP_DEBUG) {
    die('Script ini hanya dapat dijalankan dalam mode development!');
}

// Load WordPress
require_once('../../../wp-load.php');

// Check if user has admin capability
if (!current_user_can('manage_options')) {
    die('Anda tidak memiliki permission untuk menjalankan script ini!');
}

class MTQ_Real_Gallery_Importer {
    
    private $data_folder;
    private $foto_folder;
    private $video_folder;
    
    public function __construct() {
        $this->data_folder = ABSPATH . 'data/';
        $this->foto_folder = $this->data_folder . 'Foto/';
        $this->video_folder = $this->data_folder . 'Video/';
    }
    
    public function check_data_availability() {
        $results = array(
            'data_folder_exists' => is_dir($this->data_folder),
            'foto_folder_exists' => is_dir($this->foto_folder),
            'video_folder_exists' => is_dir($this->video_folder),
            'foto_count' => 0,
            'video_count' => 0,
            'foto_files' => array(),
            'video_files' => array()
        );
        
        if ($results['foto_folder_exists']) {
            $foto_files = glob($this->foto_folder . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
            $results['foto_count'] = count($foto_files);
            $results['foto_files'] = array_slice($foto_files, 0, 10); // Show first 10
        }
        
        if ($results['video_folder_exists']) {
            $video_files = glob($this->video_folder . '*.{mp4,mov,avi,wmv,flv,webm}', GLOB_BRACE);
            $results['video_count'] = count($video_files);
            $results['video_files'] = array_slice($video_files, 0, 5); // Show first 5
        }
        
        return $results;
    }
    
    public function import_media_to_wordpress() {
        if (!function_exists('wp_handle_sideload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
        }
        
        $results = array(
            'imported_images' => array(),
            'imported_videos' => array(),
            'errors' => array()
        );
        
        // Import Images
        echo "<h3>📸 Importing Images...</h3>\n";
        if (is_dir($this->foto_folder)) {
            $foto_files = glob($this->foto_folder . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
            
            foreach ($foto_files as $index => $file_path) {
                if ($index >= 20) break; // Limit to first 20 images for demo
                
                $filename = basename($file_path);
                $upload_dir = wp_upload_dir();
                
                // Copy file to uploads directory
                $new_file_path = $upload_dir['path'] . '/' . $filename;
                
                if (copy($file_path, $new_file_path)) {
                    // Create attachment
                    $file_array = array(
                        'name' => $filename,
                        'tmp_name' => $new_file_path
                    );
                    
                    $attachment_id = media_handle_sideload($file_array, 0, 'MTQ Photo - ' . pathinfo($filename, PATHINFO_FILENAME));
                    
                    if (!is_wp_error($attachment_id)) {
                        $results['imported_images'][] = array(
                            'id' => $attachment_id,
                            'filename' => $filename,
                            'url' => wp_get_attachment_url($attachment_id)
                        );
                        echo "✅ Imported: {$filename} (ID: {$attachment_id})\n";
                    } else {
                        $results['errors'][] = "Error importing {$filename}: " . $attachment_id->get_error_message();
                        echo "❌ Error: {$filename} - " . $attachment_id->get_error_message() . "\n";
                    }
                } else {
                    $results['errors'][] = "Failed to copy file: {$filename}";
                    echo "❌ Failed to copy: {$filename}\n";
                }
            }
        }
        
        // Import Videos (as attachments for reference, actual playback will be via file URL)
        echo "<h3>🎥 Processing Videos...</h3>\n";
        if (is_dir($this->video_folder)) {
            $video_files = glob($this->video_folder . '*.{mp4,mov,avi,wmv,flv,webm}', GLOB_BRACE);
            
            foreach ($video_files as $index => $file_path) {
                if ($index >= 5) break; // Limit to first 5 videos
                
                $filename = basename($file_path);
                $upload_dir = wp_upload_dir();
                
                // For videos, we'll create a reference but not necessarily copy large files
                // Instead, we'll use the original path for now
                $relative_path = str_replace(ABSPATH, '', $file_path);
                
                $results['imported_videos'][] = array(
                    'filename' => $filename,
                    'path' => $relative_path,
                    'url' => home_url($relative_path),
                    'size' => filesize($file_path)
                );
                echo "✅ Processed: {$filename} (" . $this->format_bytes(filesize($file_path)) . ")\n";
            }
        }
        
        return $results;
    }
    
    public function create_real_galleries($imported_media) {
        // Create realistic galleries based on imported media
        $galleries_config = array(
            array(
                'title' => 'Pembukaan MTQ Aceh Pidie Jaya 2025',
                'slug' => 'pembukaan-mtq-2025',
                'excerpt' => 'Dokumentasi acara pembukaan MTQ Aceh Pidie Jaya 2025 dengan kehadiran pejabat daerah dan peserta dari seluruh kecamatan.',
                'content' => 'Acara pembukaan MTQ Aceh Pidie Jaya 2025 berlangsung meriah di Gedung Serba Guna Kabupaten. Acara dihadiri oleh Bupati Aceh Pidie Jaya, Wakil Bupati, para Camat, tokoh agama, dan ratusan peserta MTQ dari 23 kecamatan di Kabupaten Aceh Pidie Jaya.',
                'category' => 'pembukaan-mtq',
                'tags' => array('pejabat', 'audience'),
                'layout' => 'grid',
                'columns' => '3',
                'image_start' => 0,
                'image_count' => 8
            ),
            array(
                'title' => 'Lomba Tilawah dan Qiroah MTQ 2025',
                'slug' => 'lomba-tilawah-qiroah-2025',
                'excerpt' => 'Kompetisi tilawah dan qiroah Al-Quran dengan peserta terbaik dari seluruh kecamatan di Aceh Pidie Jaya.',
                'content' => 'Cabang lomba tilawah dan qiroah merupakan cabang utama dalam MTQ. Para peserta menampilkan kemampuan membaca Al-Quran dengan tartil, indah, dan sesuai kaidah tajwid yang benar.',
                'category' => 'lomba-dewasa',
                'tags' => array('tilawah', 'qiroah', 'peserta', 'juri'),
                'layout' => 'grid',
                'columns' => '4',
                'image_start' => 8,
                'image_count' => 6
            ),
            array(
                'title' => 'Rapat Koordinasi dan Paparan MTQ',
                'slug' => 'rapat-koordinasi-paparan-mtq',
                'excerpt' => 'Dokumentasi rapat koordinasi persiapan MTQ dan paparan program kegiatan.',
                'content' => 'Rapat koordinasi antara panitia penyelenggara MTQ dengan berbagai pihak terkait untuk membahas persiapan dan pelaksanaan MTQ Aceh Pidie Jaya 2025.',
                'category' => 'behind-the-scene',
                'tags' => array('pejabat'),
                'layout' => 'slider',
                'columns' => '3',
                'image_start' => 14,
                'image_count' => 4,
                'video_file' => 'Rapat Koorninasi dan Paparan MTQ.mp4'
            ),
            array(
                'title' => 'Dokumentasi Lengkap MTQ 2025',
                'slug' => 'dokumentasi-lengkap-mtq-2025',
                'excerpt' => 'Koleksi lengkap dokumentasi kegiatan MTQ Aceh Pidie Jaya 2025 dari berbagai sesi.',
                'content' => 'Dokumentasi komprehensif dari seluruh rangkaian kegiatan MTQ Aceh Pidie Jaya 2025, mulai dari persiapan, pembukaan, pelaksanaan lomba, hingga penutupan.',
                'category' => 'lomba-dewasa',
                'tags' => array('peserta', 'juri', 'audience'),
                'layout' => 'grid',
                'columns' => '3',
                'image_start' => 18,
                'image_count' => 0 // Use remaining images
            )
        );
        
        $results = array();
        
        foreach ($galleries_config as $config) {
            // Create gallery post
            $post_data = array(
                'post_title' => $config['title'],
                'post_name' => $config['slug'],
                'post_content' => $config['content'],
                'post_excerpt' => $config['excerpt'],
                'post_status' => 'publish',
                'post_type' => 'mtq_gallery',
                'post_author' => 1,
                'comment_status' => 'open',
                'ping_status' => 'open'
            );
            
            $post_id = wp_insert_post($post_data);
            
            if (is_wp_error($post_id)) {
                echo "❌ Error creating gallery '{$config['title']}': " . $post_id->get_error_message() . "\n";
                continue;
            }
            
            echo "✅ Gallery '{$config['title']}' created (ID: {$post_id})\n";
            
            // Assign category
            $category_term = get_term_by('slug', $config['category'], 'mtq_gallery_category');
            if ($category_term) {
                wp_set_object_terms($post_id, $category_term->term_id, 'mtq_gallery_category');
            }
            
            // Assign tags
            if (!empty($config['tags'])) {
                $tag_ids = array();
                foreach ($config['tags'] as $tag_slug) {
                    $tag_term = get_term_by('slug', $tag_slug, 'mtq_gallery_tag');
                    if ($tag_term) {
                        $tag_ids[] = $tag_term->term_id;
                    }
                }
                if (!empty($tag_ids)) {
                    wp_set_object_terms($post_id, $tag_ids, 'mtq_gallery_tag');
                }
            }
            
            // Assign images
            $gallery_images = array();
            $image_count = $config['image_count'] > 0 ? $config['image_count'] : count($imported_media['imported_images']);
            $available_images = array_slice($imported_media['imported_images'], $config['image_start'], $image_count);
            
            foreach ($available_images as $image) {
                $gallery_images[] = $image['id'];
                
                // Add caption based on filename
                $caption = $this->generate_caption_from_filename($image['filename']);
                update_post_meta($post_id, '_mtq_gallery_image_caption_' . $image['id'], $caption);
            }
            
            update_post_meta($post_id, '_mtq_gallery_images', $gallery_images);
            echo "   📸 {$image_count} images assigned\n";
            
            // Add video if specified
            $videos_data = array();
            if (isset($config['video_file'])) {
                $video = array_filter($imported_media['imported_videos'], function($v) use ($config) {
                    return basename($v['filename']) === $config['video_file'];
                });
                
                if (!empty($video)) {
                    $video = array_values($video)[0];
                    $videos_data[] = array(
                        'url' => $video['url'],
                        'type' => 'direct',
                        'caption' => 'Video ' . pathinfo($video['filename'], PATHINFO_FILENAME)
                    );
                    echo "   🎥 Video added: {$video['filename']}\n";
                }
            }
            
            update_post_meta($post_id, '_mtq_gallery_videos', $videos_data);
            
            // Gallery settings
            update_post_meta($post_id, '_mtq_gallery_layout', $config['layout']);
            update_post_meta($post_id, '_mtq_gallery_columns', $config['columns']);
            update_post_meta($post_id, '_mtq_gallery_show_captions', 'yes');
            update_post_meta($post_id, '_mtq_gallery_enable_lightbox', 'yes');
            
            $results[] = array(
                'id' => $post_id,
                'title' => $config['title'],
                'url' => get_permalink($post_id),
                'image_count' => count($gallery_images),
                'video_count' => count($videos_data)
            );
            
            echo "\n";
        }
        
        return $results;
    }
    
    private function generate_caption_from_filename($filename) {
        // Generate meaningful captions from filename
        $base_name = pathinfo($filename, PATHINFO_FILENAME);
        
        // Remove common prefixes
        $base_name = preg_replace('/^IMG-\d{8}-WA\d{4}/', '', $base_name);
        
        // Generate contextual captions
        $captions = array(
            'Dokumentasi kegiatan MTQ Aceh Pidie Jaya',
            'Suasana pelaksanaan MTQ yang khidmat',
            'Para peserta MTQ menunjukkan kemampuan terbaiknya',
            'Moment berharga dalam kompetisi Al-Quran',
            'Antusiasme peserta dan audiens',
            'Koordinasi panitia dan peserta',
            'Kegiatan MTQ yang penuh makna',
            'Semangat kompetisi yang sportif',
            'Apresiasi terhadap budaya Qurani',
            'Dokumentasi moment bersejarah MTQ'
        );
        
        return $captions[array_rand($captions)];
    }
    
    private function format_bytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
    
    public function cleanup_imported_galleries() {
        // Delete galleries created by this importer
        $galleries = get_posts(array(
            'post_type' => 'mtq_gallery',
            'posts_per_page' => -1,
            'post_status' => 'any',
            'meta_query' => array(
                array(
                    'key' => '_imported_by_script',
                    'value' => 'real_gallery_importer',
                    'compare' => '='
                )
            )
        ));
        
        foreach ($galleries as $gallery) {
            wp_delete_post($gallery->ID, true);
            echo "🗑️ Gallery '{$gallery->post_title}' deleted\n";
        }
        
        echo "✅ Cleanup completed!\n";
    }
}

// Get action from URL parameter
$action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'check';

$importer = new MTQ_Real_Gallery_Importer();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MTQ Real Gallery Importer</title>
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 20px; 
            background: #f5f5f5; 
        }
        .container { 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        .actions { 
            margin: 20px 0; 
            padding: 20px; 
            background: #f8f9fa; 
            border-radius: 6px; 
        }
        .actions a { 
            display: inline-block; 
            padding: 10px 20px; 
            margin: 5px; 
            background: #28a745; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
        }
        .actions a:hover { background: #218838; }
        .actions a.danger { background: #dc3545; }
        .actions a.danger:hover { background: #c82333; }
        .actions a.info { background: #17a2b8; }
        .actions a.info:hover { background: #138496; }
        .output { 
            background: #000; 
            color: #00ff00; 
            padding: 20px; 
            border-radius: 6px; 
            font-family: 'Courier New', monospace; 
            margin: 20px 0; 
            max-height: 500px; 
            overflow-y: auto; 
        }
        .status-card { 
            background: #f8f9fa; 
            border: 1px solid #dee2e6; 
            border-radius: 6px; 
            padding: 20px; 
            margin: 10px 0; 
        }
        .status-card.success { 
            background: #d4edda; 
            border-color: #c3e6cb; 
        }
        .status-card.warning { 
            background: #fff3cd; 
            border-color: #ffeaa7; 
        }
        .status-card.error { 
            background: #f8d7da; 
            border-color: #f5c6cb; 
        }
        h1 { color: #28a745; }
        h2 { color: #17a2b8; }
        h3 { color: #666; }
        .file-list { 
            max-height: 200px; 
            overflow-y: auto; 
            background: #f8f9fa; 
            padding: 10px; 
            border-radius: 4px; 
            font-family: monospace; 
            font-size: 12px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎯 MTQ Real Gallery Importer</h1>
        <p>Tool untuk import foto dan video MTQ yang sudah ada di folder <code>/data/</code> ke dalam sistem gallery WordPress.</p>
        
        <div class="actions">
            <a href="?action=check" class="info">📊 Check Data</a>
            <a href="?action=import">🚀 Import Media</a>
            <a href="?action=create_galleries">📁 Create Galleries</a>
            <a href="?action=full_import">⚡ Full Import</a>
            <a href="?action=cleanup" class="danger">🧹 Cleanup</a>
        </div>
        
        <div class="output">
<?php
if ($action === 'check') {
    $data_check = $importer->check_data_availability();
    
    echo "<h2>📊 Data Availability Check</h2>\n";
    echo "Data Folder: " . ($data_check['data_folder_exists'] ? '✅ Found' : '❌ Not Found') . "\n";
    echo "Foto Folder: " . ($data_check['foto_folder_exists'] ? '✅ Found' : '❌ Not Found') . "\n";
    echo "Video Folder: " . ($data_check['video_folder_exists'] ? '✅ Found' : '❌ Not Found') . "\n\n";
    
    echo "<h3>📸 Photos Available: {$data_check['foto_count']}</h3>\n";
    if (!empty($data_check['foto_files'])) {
        echo "Sample files:\n";
        foreach ($data_check['foto_files'] as $file) {
            echo "• " . basename($file) . "\n";
        }
        if ($data_check['foto_count'] > 10) {
            echo "... and " . ($data_check['foto_count'] - 10) . " more files\n";
        }
    }
    echo "\n";
    
    echo "<h3>🎥 Videos Available: {$data_check['video_count']}</h3>\n";
    if (!empty($data_check['video_files'])) {
        echo "Sample files:\n";
        foreach ($data_check['video_files'] as $file) {
            $size = filesize($file);
            echo "• " . basename($file) . " (" . $this->format_bytes($size) . ")\n";
        }
        if ($data_check['video_count'] > 5) {
            echo "... and " . ($data_check['video_count'] - 5) . " more files\n";
        }
    }
    echo "\n";
    
    if ($data_check['foto_count'] > 0 || $data_check['video_count'] > 0) {
        echo "✅ Ready for import!\n";
    } else {
        echo "⚠️ No media files found. Please check data folder.\n";
    }
    
} elseif ($action === 'import') {
    echo "<h2>🚀 Importing Media Files...</h2>\n";
    $imported_media = $importer->import_media_to_wordpress();
    
    echo "<h3>📊 Import Summary:</h3>\n";
    echo "Images imported: " . count($imported_media['imported_images']) . "\n";
    echo "Videos processed: " . count($imported_media['imported_videos']) . "\n";
    echo "Errors: " . count($imported_media['errors']) . "\n\n";
    
    if (!empty($imported_media['errors'])) {
        echo "<h3>❌ Errors:</h3>\n";
        foreach ($imported_media['errors'] as $error) {
            echo "• {$error}\n";
        }
    }
    
} elseif ($action === 'create_galleries') {
    // First check if media is imported
    $existing_attachments = get_posts(array(
        'post_type' => 'attachment',
        'posts_per_page' => 20,
        'post_status' => 'inherit',
        'meta_query' => array(
            array(
                'key' => '_wp_attached_file',
                'value' => 'IMG-',
                'compare' => 'LIKE'
            )
        )
    ));
    
    if (empty($existing_attachments)) {
        echo "⚠️ No imported media found. Please run 'Import Media' first.\n";
    } else {
        echo "<h2>📁 Creating Real Galleries...</h2>\n";
        
        // Prepare media data
        $media_data = array(
            'imported_images' => array(),
            'imported_videos' => array()
        );
        
        foreach ($existing_attachments as $attachment) {
            $media_data['imported_images'][] = array(
                'id' => $attachment->ID,
                'filename' => basename(get_attached_file($attachment->ID)),
                'url' => wp_get_attachment_url($attachment->ID)
            );
        }
        
        // Check for videos
        $data_check = $importer->check_data_availability();
        $media_data['imported_videos'] = array();
        if (!empty($data_check['video_files'])) {
            foreach ($data_check['video_files'] as $video_file) {
                $relative_path = str_replace(ABSPATH, '', $video_file);
                $media_data['imported_videos'][] = array(
                    'filename' => basename($video_file),
                    'path' => $relative_path,
                    'url' => home_url($relative_path),
                    'size' => filesize($video_file)
                );
            }
        }
        
        $gallery_results = $importer->create_real_galleries($media_data);
        
        echo "<h3>📊 Gallery Creation Summary:</h3>\n";
        echo "Galleries created: " . count($gallery_results) . "\n\n";
        
        echo "<h3>📋 Created Galleries:</h3>\n";
        foreach ($gallery_results as $result) {
            echo "• {$result['title']} (ID: {$result['id']})\n";
            echo "  Images: {$result['image_count']}, Videos: {$result['video_count']}\n";
            echo "  URL: {$result['url']}\n\n";
        }
    }
    
} elseif ($action === 'full_import') {
    echo "<h2>⚡ Full Import Process...</h2>\n";
    
    // Step 1: Import Media
    echo "<h3>Step 1: Importing Media...</h3>\n";
    $imported_media = $importer->import_media_to_wordpress();
    
    // Step 2: Create Galleries
    echo "<h3>Step 2: Creating Galleries...</h3>\n";
    $gallery_results = $importer->create_real_galleries($imported_media);
    
    echo "<h2>🎉 Full Import Complete!</h2>\n";
    echo "Media imported: " . count($imported_media['imported_images']) . " images, " . count($imported_media['imported_videos']) . " videos\n";
    echo "Galleries created: " . count($gallery_results) . "\n\n";
    
    echo "<h3>🔗 Quick Links:</h3>\n";
    echo "• Gallery Archive: " . get_post_type_archive_link('mtq_gallery') . "\n";
    echo "• Admin Galleries: " . admin_url('edit.php?post_type=mtq_gallery') . "\n\n";
    
} elseif ($action === 'cleanup') {
    echo "<h2>🧹 Cleaning up imported data...</h2>\n";
    $importer->cleanup_imported_galleries();
}
?>
        </div>
        
        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 14px;">
            <p><strong>📂 Data Structure Expected:</strong></p>
            <div class="file-list">
/data/<br>
├── Foto/<br>
│   ├── IMG-20250912-WA0001.jpg<br>
│   ├── IMG-20250912-WA0002.jpg<br>
│   └── ...<br>
└── Video/<br>
    ├── Rapat Koorninasi dan Paparan MTQ.mp4<br>
    └── ...
            </div>
            <p><strong>⚠️ Important:</strong> This script imports real MTQ photos and videos. Make sure you have permission and backup your database!</p>
        </div>
    </div>
</body>
</html>
