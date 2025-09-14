<?php
/**
 * Create Dummy Gallery - MTQ Aceh Pidie Jaya (Admin + Dev only)
 * Membuat data dummy untuk gallery
 * PERINGATAN: Script ini hanya untuk development/testing!
 * Jangan jalankan di production server!
 *
 * Usage: Akses melalui browser sebagai Admin (manage_options)
 * Path file: wp-content/themes/mtq-aceh-pidie-jaya/scripts/gallery-import/create-dummy-gallery.php
 */

// Bootstrap WordPress from theme/scripts path
require_once dirname(__FILE__) . '/../../wp-load.php';

// Basic hardening
if (!defined('ABSPATH')) {
    http_response_code(403);
    exit('Forbidden');
}

// Require logged-in Admin
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('Anda tidak memiliki permission untuk menjalankan script ini!');
}

// Dev-only safeguard
if (!defined('WP_DEBUG') || !WP_DEBUG) {
    wp_die('Script ini hanya dapat dijalankan dalam mode development (WP_DEBUG = true).');
}

class MTQ_Dummy_Gallery_Generator {
    
    private $galleries_data = array();
    private $categories_data = array();
    private $tags_data = array();
    
    public function __construct() {
        $this->init_data();
    }
    
    private function init_data() {
        // Categories data
        $this->categories_data = array(
            'pembukaan-mtq' => array(
                'name' => 'Pembukaan MTQ',
                'description' => 'Dokumentasi acara pembukaan MTQ'
            ),
            'lomba-dewasa' => array(
                'name' => 'Lomba Dewasa',
                'description' => 'Dokumentasi lomba kategori dewasa'
            ),
            'lomba-remaja' => array(
                'name' => 'Lomba Remaja',
                'description' => 'Dokumentasi lomba kategori remaja'
            ),
            'lomba-anak-anak' => array(
                'name' => 'Lomba Anak-anak',
                'description' => 'Dokumentasi lomba kategori anak-anak'
            ),
            'penutupan-mtq' => array(
                'name' => 'Penutupan MTQ',
                'description' => 'Dokumentasi acara penutupan MTQ'
            ),
            'behind-the-scene' => array(
                'name' => 'Behind The Scene',
                'description' => 'Dokumentasi di balik layar acara MTQ'
            ),
            'pameran-kaligrafi' => array(
                'name' => 'Pameran Kaligrafi',
                'description' => 'Dokumentasi pameran kaligrafi'
            )
        );
        
        // Tags data
        $this->tags_data = array(
            'tilawah', 'tahfidz', 'syarhil-quran', 'kaligrafi', 'ceramah',
            'qiroah', 'pejabat', 'peserta', 'juri', 'audience'
        );
        
        // Galleries data
        $this->galleries_data = array(
            array(
                'title' => 'Pembukaan MTQ Aceh Pidie Jaya 2024',
                'slug' => 'pembukaan-mtq-aceh-pidie-jaya-2024',
                'excerpt' => 'Dokumentasi acara pembukaan MTQ Aceh Pidie Jaya 2024 yang meriah dengan kehadiran Bupati dan ratusan peserta dari seluruh kecamatan.',
                'content' => 'Dokumentasi lengkap acara pembukaan MTQ Aceh Pidie Jaya 2024. Acara pembukaan yang meriah dengan kehadiran Bupati, Wakil Bupati, dan tokoh-tokoh masyarakat. Acara dimulai dengan pembacaan ayat suci Al-Quran, sambutan-sambutan, dan penyerahan bendera lomba.

Pembukaan MTQ tahun ini sangat istimewa karena dihadiri oleh lebih dari 500 peserta dari seluruh kecamatan di Kabupaten Aceh Pidie Jaya. Para peserta terlihat antusias dan siap untuk berkompetisi dalam berbagai cabang lomba.',
                'category' => 'pembukaan-mtq',
                'tags' => array('pejabat', 'audience'),
                'layout' => 'grid',
                'columns' => '3',
                'image_count' => 8,
                'videos' => array(
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Video Pembukaan MTQ Pidie Jaya 2024'),
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Sambutan Bupati dalam Acara Pembukaan MTQ')
                ),
                'image_captions' => array(
                    'Pembukaan resmi MTQ Aceh Pidie Jaya 2024',
                    'Sambutan Bupati Aceh Pidie Jaya',
                    'Para peserta MTQ berbaris rapi',
                    'Suasana meriah pembukaan MTQ',
                    'Penyerahan bendera lomba',
                    'Doa bersama pembukaan acara',
                    'Antusiasme para peserta',
                    'Dokumentasi moment bersejarah'
                )
            ),
            array(
                'title' => 'Lomba Tilawah Kategori Dewasa',
                'slug' => 'lomba-tilawah-kategori-dewasa',
                'excerpt' => 'Kompetisi tilawah kategori dewasa dengan 25 peserta terbaik dari seluruh kecamatan di Aceh Pidie Jaya.',
                'content' => 'Kompetisi tilawah kategori dewasa merupakan salah satu cabang lomba yang paling bergengsi dalam MTQ Aceh Pidie Jaya. Para peserta menampilkan kemampuan terbaik mereka dalam membaca Al-Quran dengan tartil dan indah.

Lomba ini diikuti oleh 25 peserta terbaik dari seluruh kecamatan. Setiap peserta menunjukkan kemampuan luar biasa dalam hal makhorijul huruf, tajwid, dan keindahan suara. Juri yang terdiri dari ulama dan ahli qiroah memberikan penilaian yang sangat ketat.',
                'category' => 'lomba-dewasa',
                'tags' => array('tilawah', 'peserta', 'juri'),
                'layout' => 'grid',
                'columns' => '4',
                'image_count' => 10,
                'videos' => array(
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Highlight Lomba Tilawah Dewasa')
                ),
                'image_captions' => array(
                    'Peserta tilawah kategori dewasa tampil percaya diri',
                    'Juri menilai dengan seksama',
                    'Konsentrasi tinggi saat membaca Al-Quran',
                    'Suasana khidmat lomba tilawah',
                    'Peserta menunjukkan kemampuan terbaiknya',
                    'Keindahan bacaan Al-Quran',
                    'Moment penilaian juri',
                    'Antusiasme penonton',
                    'Peserta melafalkan ayat dengan sempurna',
                    'Suasana kompetitif yang sehat'
                )
            ),
            array(
                'title' => 'Lomba Tahfidz Kategori Remaja',
                'slug' => 'lomba-tahfidz-kategori-remaja',
                'excerpt' => 'Para hafidz muda berbakat mempertunjukkan hafalan Al-Quran dengan lancar dalam kategori remaja.',
                'content' => 'Lomba tahfidz kategori remaja menampilkan para hafidz muda berbakat dari Aceh Pidie Jaya. Mereka mempertunjukkan hafalan Al-Quran dengan lancar dan penuh penghayatan.

Kategori remaja ini diikuti oleh 20 peserta yang telah menghafal minimal 10 juz Al-Quran. Para peserta menunjukkan kualitas hafalan yang sangat baik dan kemampuan untuk menjawab pertanyaan seputar ayat-ayat yang mereka hafalkan. Semangat dan dedikasi para remaja ini sangat menginspirasi.',
                'category' => 'lomba-remaja',
                'tags' => array('tahfidz', 'peserta'),
                'layout' => 'slider',
                'columns' => '3',
                'image_count' => 6,
                'videos' => array(
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Lomba Tahfidz Kategori Remaja'),
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Wawancara dengan Juara 1 Tahfidz Remaja')
                ),
                'image_captions' => array(
                    'Hafidz muda mempertunjukkan hafalannya',
                    'Semangat para remaja peserta tahfidz',
                    'Juri memberikan pertanyaan kepada peserta',
                    'Konsentrasi peserta saat menjawab',
                    'Kebanggaan orang tua',
                    'Moment inspiratif para remaja'
                )
            ),
            array(
                'title' => 'Lomba Syarhil Quran (Tafsir)',
                'slug' => 'lomba-syarhil-quran-tafsir',
                'excerpt' => 'Kompetisi tafsir Al-Quran yang menguji pemahaman mendalam peserta tentang kandungan ayat-ayat suci.',
                'content' => 'Cabang lomba Syarhil Quran (tafsir Al-Quran) menampilkan para peserta yang memiliki pemahaman mendalam tentang makna dan kandungan ayat-ayat Al-Quran.

Lomba ini menguji kemampuan peserta dalam menjelaskan tafsir ayat-ayat Al-Quran dengan menggunakan bahasa Indonesia dan bahasa Aceh. Para peserta menunjukkan penguasaan ilmu tafsir yang luas dan kemampuan komunikasi yang baik. Lomba ini sangat penting untuk mengembangkan pemahaman Al-Quran di masyarakat.',
                'category' => 'lomba-dewasa',
                'tags' => array('syarhil-quran', 'peserta', 'juri'),
                'layout' => 'grid',
                'columns' => '3',
                'image_count' => 8,
                'videos' => array(
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Kompetisi Syarhil Quran (Tafsir)')
                ),
                'image_captions' => array(
                    'Peserta menjelaskan tafsir dengan baik',
                    'Juri mendengarkan penjelasan peserta',
                    'Diskusi mendalam tentang makna ayat',
                    'Peserta menguasai ilmu tafsir',
                    'Suasana akademis yang kondusif',
                    'Pemahaman Al-Quran yang mendalam',
                    'Komunikasi yang efektif',
                    'Moment berharga dalam lomba tafsir'
                )
            ),
            array(
                'title' => 'Pameran Kaligrafi MTQ 2024',
                'slug' => 'pameran-kaligrafi-mtq-2024',
                'excerpt' => 'Pameran seni kaligrafi Islam dengan lebih dari 50 karya indah dari para kaligrafer lokal dan nasional.',
                'content' => 'Pameran kaligrafi dalam rangka MTQ menampilkan karya-karya seni Islam yang memukau. Para kaligrafer lokal dan nasional memamerkan keindahan seni tulis Arab dalam berbagai gaya dan media.

Pameran ini menampilkan lebih dari 50 karya kaligrafi dengan berbagai teknik dan gaya, mulai dari kaligrafi klasik hingga kontemporer. Pengunjung dapat menikmati keindahan ayat-ayat Al-Quran yang ditulis dengan indah, serta belajar tentang sejarah dan perkembangan seni kaligrafi Islam.',
                'category' => 'pameran-kaligrafi',
                'tags' => array('kaligrafi', 'audience'),
                'layout' => 'grid',
                'columns' => '4',
                'image_count' => 15,
                'videos' => array(),
                'image_captions' => array(
                    'Kaligrafi Ayat Kursi dengan gaya Naskh',
                    'Karya kaligrafi kontemporer',
                    'Kaligrafi Asmaul Husna yang indah',
                    'Pengunjung mengagumi karya kaligrafi',
                    'Kaligrafi modern dengan teknik digital',
                    'Karya master kaligrafer nasional',
                    'Seni kaligrafi tradisional Aceh',
                    'Kolaborasi kaligrafi dan ornamen',
                    'Workshop kaligrafi untuk pengunjung',
                    'Demonstrasi teknik kaligrafi',
                    'Kaligrafi dengan media kanvas',
                    'Seni kaligrafi relief kayu',
                    'Pengunjung belajar menulis kaligrafi',
                    'Pameran kaligrafi yang memukau',
                    'Apresiasi tinggi pengunjung'
                )
            ),
            array(
                'title' => 'Lomba MTQ Kategori Anak-anak',
                'slug' => 'lomba-mtq-kategori-anak-anak',
                'excerpt' => 'Para peserta cilik berusia 7-12 tahun menampilkan kemampuan mengaji dengan penuh semangat dan keceriaan.',
                'content' => 'Kategori anak-anak merupakan masa depan generasi Qurani. Para peserta cilik menampilkan kemampuan mengaji dan menghafal dengan penuh semangat dan keceriaan.

Lomba kategori anak-anak ini diikuti oleh 30 peserta berusia 7-12 tahun. Mereka menunjukkan kemampuan luar biasa dalam membaca Al-Quran dan menghafal surat-surat pendek. Keceriaan dan semangat anak-anak ini membuat suasana lomba menjadi sangat menggembirakan. Para orang tua dan guru pendamping terlihat bangga dengan prestasi anak-anak mereka.',
                'category' => 'lomba-anak-anak',
                'tags' => array('peserta', 'audience'),
                'layout' => 'grid',
                'columns' => '3',
                'image_count' => 12,
                'videos' => array(
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Lomba MTQ Kategori Anak-anak'),
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Aksi Menggemaskan Anak-anak'),
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Interview dengan Peserta Termuda')
                ),
                'image_captions' => array(
                    'Peserta termuda berusia 7 tahun',
                    'Anak-anak membaca Al-Quran dengan fasih',
                    'Kegembiraan anak-anak peserta MTQ',
                    'Orang tua bangga dengan anaknya',
                    'Semangat luar biasa peserta cilik',
                    'Keceriaan yang menggembirakan',
                    'Prestasi membanggakan anak-anak',
                    'Dukungan keluarga yang luar biasa',
                    'Moment berharga bagi keluarga',
                    'Masa depan generasi Qurani',
                    'Kepolosan dan kesungguhan anak-anak',
                    'Inspirasi dari generasi muda'
                )
            ),
            array(
                'title' => 'Behind The Scene MTQ 2024',
                'slug' => 'behind-the-scene-mtq-2024',
                'excerpt' => 'Dokumentasi kerja keras panitia dan sukarelawan di balik kesuksesan penyelenggaraan MTQ Aceh Pidie Jaya.',
                'content' => 'Dokumentasi di balik layar penyelenggaraan MTQ Aceh Pidie Jaya. Mulai dari persiapan venue, koordinasi panitia, hingga proses produksi acara.

Melihat kerja keras panitia dan sukarelawan yang bekerja tanpa lelah untuk mensukseskan acara MTQ. Dari persiapan sejak dini hari, setting panggung, koordinasi teknis, hingga pelayanan peserta dan tamu. Semua bekerja dengan penuh dedikasi untuk mewujudkan MTQ yang berkesan dan berkesan.',
                'category' => 'behind-the-scene',
                'tags' => array(),
                'layout' => 'grid',
                'columns' => '4',
                'image_count' => 18,
                'videos' => array(
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Persiapan Venue MTQ 2024'),
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Koordinasi Tim Panitia dan Sukarelawan')
                ),
                'image_captions' => array(
                    'Persiapan venue sejak dini hari',
                    'Setting panggung utama',
                    'Koordinasi teknis sound system',
                    'Persiapan dekorasi venue',
                    'Tim catering menyiapkan konsumsi',
                    'Briefing panitia pagi hari',
                    'Pemasangan spanduk dan banner',
                    'Pengaturan kursi peserta',
                    'Testing peralatan teknis',
                    'Persiapan area registrasi',
                    'Koordinasi security',
                    'Persiapan area parkir',
                    'Setting kamera dokumentasi',
                    'Persiapan ruang juri',
                    'Koordinasi tim medis',
                    'Persiapan merchandise',
                    'Final check sebelum acara',
                    'Kerja sama tim yang solid'
                )
            ),
            array(
                'title' => 'Penutupan dan Penganugerahan MTQ 2024',
                'slug' => 'penutupan-penganugerahan-mtq-2024',
                'excerpt' => 'Upacara penutupan dengan penganugerahan kepada para juara MTQ Aceh Pidie Jaya 2024.',
                'content' => 'Acara penutupan MTQ Aceh Pidie Jaya 2024 dengan penganugerahan kepada para juara. Momen penuh haru dan kebahagiaan bagi para pemenang dan keluarga mereka.

Upacara penutupan dihadiri oleh seluruh peserta, keluarga, dan masyarakat. Pengumuman juara dilakukan secara bertahap untuk setiap kategori lomba. Para juara menerima piala, sertifikat, dan hadiah dengan penuh kebanggaan. Acara ditutup dengan doa bersama dan komitmen untuk terus mengembangkan budaya Qurani di Aceh Pidie Jaya.',
                'category' => 'penutupan-mtq',
                'tags' => array('pejabat', 'peserta', 'audience'),
                'layout' => 'slider',
                'columns' => '3',
                'image_count' => 10,
                'videos' => array(
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Upacara Penutupan MTQ Pidie Jaya 2024'),
                    array('url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'caption' => 'Penganugerahan Para Juara MTQ')
                ),
                'image_captions' => array(
                    'Penyerahan piala juara 1 kategori dewasa',
                    'Foto bersama para juara',
                    'Kebahagiaan keluarga juara',
                    'Bupati memberikan apresiasi kepada peserta',
                    'Moment penganugerahan yang bersejarah',
                    'Kegembiraan para pemenang',
                    'Dukungan keluarga yang luar biasa',
                    'Upacara penutupan yang khidmat',
                    'Komitmen untuk MTQ mendatang',
                    'Doa penutup bersama'
                )
            )
        );
    }
    
    public function generate_dummy_data() {
        $results = array();
        
        echo "<h2>🎯 Memulai Generate Dummy Gallery Data...</h2>\n";
        
        // 1. Create Categories
        echo "<h3>📁 Membuat Categories...</h3>\n";
        foreach ($this->categories_data as $slug => $cat_data) {
            $term = wp_insert_term(
                $cat_data['name'],
                'mtq_gallery_category',
                array(
                    'slug' => $slug,
                    'description' => $cat_data['description']
                )
            );
            
            if (is_wp_error($term)) {
                if ($term->get_error_code() !== 'term_exists') {
                    echo "❌ Error creating category {$cat_data['name']}: " . $term->get_error_message() . "\n";
                } else {
                    echo "ℹ️ Category '{$cat_data['name']}' sudah ada\n";
                }
            } else {
                echo "✅ Category '{$cat_data['name']}' berhasil dibuat\n";
            }
        }
        
        // 2. Create Tags
        echo "<h3>🏷️ Membuat Tags...</h3>\n";
        foreach ($this->tags_data as $tag_name) {
            $term = wp_insert_term(
                ucfirst(str_replace('-', ' ', $tag_name)),
                'mtq_gallery_tag',
                array('slug' => $tag_name)
            );
            
            if (is_wp_error($term)) {
                if ($term->get_error_code() !== 'term_exists') {
                    echo "❌ Error creating tag {$tag_name}: " . $term->get_error_message() . "\n";
                } else {
                    echo "ℹ️ Tag '{$tag_name}' sudah ada\n";
                }
            } else {
                echo "✅ Tag '{$tag_name}' berhasil dibuat\n";
            }
        }
        
        // 3. Create Galleries
        echo "<h3>🖼️ Membuat Gallery Posts...</h3>\n";
        foreach ($this->galleries_data as $index => $gallery_data) {
            $post_data = array(
                'post_title' => $gallery_data['title'],
                'post_name' => $gallery_data['slug'],
                'post_content' => $gallery_data['content'],
                'post_excerpt' => $gallery_data['excerpt'],
                'post_status' => 'publish',
                'post_type' => 'mtq_gallery',
                'post_author' => 1,
                'comment_status' => 'open',
                'ping_status' => 'open'
            );
            
            $post_id = wp_insert_post($post_data);
            
            if (is_wp_error($post_id)) {
                echo "❌ Error creating gallery '{$gallery_data['title']}': " . $post_id->get_error_message() . "\n";
                continue;
            }
            
            echo "✅ Gallery '{$gallery_data['title']}' berhasil dibuat (ID: {$post_id})\n";
            
            // Assign category
            $category_term = get_term_by('slug', $gallery_data['category'], 'mtq_gallery_category');
            if ($category_term) {
                wp_set_object_terms($post_id, $category_term->term_id, 'mtq_gallery_category');
                echo "   📁 Category '{$category_term->name}' assigned\n";
            }
            
            // Assign tags
            if (!empty($gallery_data['tags'])) {
                $tag_ids = array();
                foreach ($gallery_data['tags'] as $tag_slug) {
                    $tag_term = get_term_by('slug', $tag_slug, 'mtq_gallery_tag');
                    if ($tag_term) {
                        $tag_ids[] = $tag_term->term_id;
                    }
                }
                if (!empty($tag_ids)) {
                    wp_set_object_terms($post_id, $tag_ids, 'mtq_gallery_tag');
                    echo "   🏷️ Tags assigned: " . implode(', ', $gallery_data['tags']) . "\n";
                }
            }
            
            // Create dummy images (placeholder IDs)
            $dummy_image_ids = $this->create_dummy_images($gallery_data['image_count']);
            update_post_meta($post_id, '_mtq_gallery_images', $dummy_image_ids);
            echo "   🖼️ {$gallery_data['image_count']} dummy images created\n";
            
            // Add image captions
            foreach ($dummy_image_ids as $i => $image_id) {
                if (isset($gallery_data['image_captions'][$i])) {
                    update_post_meta($post_id, '_mtq_gallery_image_caption_' . $image_id, $gallery_data['image_captions'][$i]);
                }
            }
            
            // Add videos
            if (!empty($gallery_data['videos'])) {
                $videos_data = array();
                foreach ($gallery_data['videos'] as $video) {
                    $videos_data[] = array(
                        'url' => $video['url'],
                        'type' => 'youtube',
                        'caption' => $video['caption']
                    );
                }
                update_post_meta($post_id, '_mtq_gallery_videos', $videos_data);
                echo "   🎥 " . count($videos_data) . " videos added\n";
            }
            
            // Gallery settings
            update_post_meta($post_id, '_mtq_gallery_layout', $gallery_data['layout']);
            update_post_meta($post_id, '_mtq_gallery_columns', $gallery_data['columns']);
            update_post_meta($post_id, '_mtq_gallery_show_captions', 'yes');
            update_post_meta($post_id, '_mtq_gallery_enable_lightbox', 'yes');
            echo "   ⚙️ Gallery settings configured\n";
            
            $results[] = array(
                'id' => $post_id,
                'title' => $gallery_data['title'],
                'url' => get_permalink($post_id)
            );
            
            echo "\n";
        }
        
        return $results;
    }
    
    private function create_dummy_images($count) {
        $dummy_ids = array();
        
        // Use placeholder image service
        for ($i = 1; $i <= $count; $i++) {
            // Create a dummy attachment post
            $attachment_data = array(
                'post_title' => "Dummy Image MTQ {$i}",
                'post_content' => '',
                'post_status' => 'inherit',
                'post_type' => 'attachment',
                'post_mime_type' => 'image/jpeg',
                'guid' => "https://picsum.photos/800/600?random={$i}"
            );
            
            $attachment_id = wp_insert_post($attachment_data);
            
            if (!is_wp_error($attachment_id)) {
                // Add some attachment metadata
                update_post_meta($attachment_id, '_wp_attachment_metadata', array(
                    'width' => 800,
                    'height' => 600,
                    'file' => "dummy-mtq-{$i}.jpg",
                    'sizes' => array()
                ));
                
                update_post_meta($attachment_id, '_wp_attached_file', "dummy-mtq-{$i}.jpg");
                
                $dummy_ids[] = $attachment_id;
            }
        }
        
        return $dummy_ids;
    }
    
    public function cleanup_dummy_data() {
        echo "<h2>🧹 Membersihkan Dummy Data...</h2>\n";
        
        // Delete all mtq_gallery posts
        $galleries = get_posts(array(
            'post_type' => 'mtq_gallery',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        
        foreach ($galleries as $gallery) {
            wp_delete_post($gallery->ID, true);
            echo "🗑️ Gallery '{$gallery->post_title}' deleted\n";
        }
        
        // Delete terms
        $categories = get_terms(array('taxonomy' => 'mtq_gallery_category', 'hide_empty' => false));
        foreach ($categories as $term) {
            wp_delete_term($term->term_id, 'mtq_gallery_category');
            echo "🗑️ Category '{$term->name}' deleted\n";
        }
        
        $tags = get_terms(array('taxonomy' => 'mtq_gallery_tag', 'hide_empty' => false));
        foreach ($tags as $term) {
            wp_delete_term($term->term_id, 'mtq_gallery_tag');
            echo "🗑️ Tag '{$term->name}' deleted\n";
        }
        
        // Delete dummy attachments
        $attachments = get_posts(array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_wp_attached_file',
                    'value' => 'dummy-mtq-',
                    'compare' => 'LIKE'
                )
            )
        ));
        
        foreach ($attachments as $attachment) {
            wp_delete_attachment($attachment->ID, true);
            echo "🗑️ Dummy image '{$attachment->post_title}' deleted\n";
        }
        
        echo "<h3>✅ Cleanup selesai!</h3>\n";
    }
}

// Get action from URL parameter
$action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'generate';

$generator = new MTQ_Dummy_Gallery_Generator();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MTQ Gallery Dummy Data Generator</title>
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
            background: #007cba; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
        }
        .actions a:hover { background: #005a87; }
        .actions a.danger { background: #dc3545; }
        .actions a.danger:hover { background: #c82333; }
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
        .gallery-list { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
            gap: 20px; 
            margin: 20px 0; 
        }
        .gallery-card { 
            background: #f8f9fa; 
            padding: 15px; 
            border-radius: 6px; 
            border-left: 4px solid #007cba; 
        }
        h1 { color: #23282d; }
        h2 { color: #007cba; }
        h3 { color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎯 MTQ Gallery Dummy Data Generator</h1>
        <p>Tool untuk membuat dummy data gallery MTQ Aceh Pidie Jaya untuk testing dan development.</p>
        
        <div class="actions">
            <a href="?action=generate">🚀 Generate Dummy Data</a>
            <a href="?action=cleanup" class="danger">🧹 Cleanup All Data</a>
            <a href="?action=info">ℹ️ Show Info</a>
        </div>
        
        <div class="output">
<?php
if ($action === 'generate') {
    $results = $generator->generate_dummy_data();
    
    echo "<h2>🎉 Generate Dummy Data Selesai!</h2>\n";
    echo "<p>Total gallery yang dibuat: " . count($results) . "</p>\n";
    
    if (!empty($results)) {
        echo "<h3>📋 Daftar Gallery yang Dibuat:</h3>\n";
        foreach ($results as $result) {
            echo "• {$result['title']} (ID: {$result['id']})\n";
            echo "  URL: {$result['url']}\n\n";
        }
        
        echo "<h3>🔗 Link untuk Testing:</h3>\n";
        echo "• Archive Gallery: " . get_post_type_archive_link('mtq_gallery') . "\n";
        echo "• Admin Gallery: " . admin_url('edit.php?post_type=mtq_gallery') . "\n\n";
        
        echo "<h3>📝 Shortcode Examples:</h3>\n";
        echo "[mtq_gallery_list]\n";
        echo "[mtq_gallery_list category=\"lomba-dewasa\" limit=\"6\"]\n";
        echo "[mtq_gallery id=\"{$results[0]['id']}\"]\n\n";
    }
    
} elseif ($action === 'cleanup') {
    $generator->cleanup_dummy_data();
    
} elseif ($action === 'info') {
    echo "<h2>ℹ️ System Information</h2>\n";
    echo "WordPress Version: " . get_bloginfo('version') . "\n";
    echo "Theme: " . get_template() . "\n";
    echo "Gallery Post Type: " . (post_type_exists('mtq_gallery') ? '✅ Registered' : '❌ Not Registered') . "\n";
    echo "Gallery Categories: " . (taxonomy_exists('mtq_gallery_category') ? '✅ Registered' : '❌ Not Registered') . "\n";
    echo "Gallery Tags: " . (taxonomy_exists('mtq_gallery_tag') ? '✅ Registered' : '❌ Not Registered') . "\n\n";
    
    // Count existing data
    $existing_galleries = wp_count_posts('mtq_gallery');
    $existing_categories = wp_count_terms(array('taxonomy' => 'mtq_gallery_category'));
    $existing_tags = wp_count_terms(array('taxonomy' => 'mtq_gallery_tag'));
    
    echo "<h3>📊 Existing Data:</h3>\n";
    echo "Galleries: {$existing_galleries->publish} published\n";
    echo "Categories: {$existing_categories}\n";
    echo "Tags: {$existing_tags}\n\n";
    
    if ($existing_galleries->publish > 0) {
        $galleries = get_posts(array(
            'post_type' => 'mtq_gallery',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));
        
        echo "<h3>📋 Existing Galleries:</h3>\n";
        foreach ($galleries as $gallery) {
            echo "• {$gallery->post_title} (ID: {$gallery->ID})\n";
        }
    }
}
?>
        </div>
        
        <div class="gallery-list">
            <?php if ($action === 'generate' && !empty($results)) : ?>
                <?php foreach ($results as $result) : ?>
                    <div class="gallery-card">
                        <h4><?php echo esc_html($result['title']); ?></h4>
                        <p><strong>ID:</strong> <?php echo $result['id']; ?></p>
                        <p><a href="<?php echo esc_url($result['url']); ?>" target="_blank">View Gallery →</a></p>
                        <p><a href="<?php echo admin_url('post.php?post=' . $result['id'] . '&action=edit'); ?>" target="_blank">Edit Gallery →</a></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 14px;">
            <p><strong>⚠️ Peringatan:</strong> Script ini hanya untuk development/testing. Jangan gunakan di production server!</p>
            <p><strong>📝 Note:</strong> Dummy images menggunakan placeholder dari Picsum. Untuk production, upload gambar asli melalui admin panel.</p>
        </div>
    </div>
</body>
</html>
