<?php
/**
 * Script untuk membuat dummy categories dan tags
 * Tambahkan ke functions.php dan akses via ?create_dummy_data=1 di URL
 */

// Fungsi untuk membuat dummy categories dan tags
function mtq_create_dummy_categories_tags() {
    // Categories data
    $categories_data = [
        [
            'name' => 'Kegiatan MTQ',
            'slug' => 'kegiatan-mtq',
            'description' => 'Berbagai kegiatan dan acara MTQ Aceh Pidie Jaya'
        ],
        [
            'name' => 'Pengumuman',
            'slug' => 'pengumuman',
            'description' => 'Pengumuman resmi terkait MTQ dan kegiatan keagamaan'
        ],
        [
            'name' => 'Prestasi',
            'slug' => 'prestasi',
            'description' => 'Pencapaian dan prestasi para peserta MTQ'
        ],
        [
            'name' => 'Peserta',
            'slug' => 'peserta',
            'description' => 'Informasi tentang para peserta MTQ'
        ],
        [
            'name' => 'Jadwal',
            'slug' => 'jadwal',
            'description' => 'Jadwal kegiatan dan perlombaan MTQ'
        ],
        [
            'name' => 'Berita Terkini',
            'slug' => 'berita-terkini',
            'description' => 'Berita terbaru seputar MTQ dan kegiatan keagamaan'
        ],
        [
            'name' => 'Lomba',
            'slug' => 'lomba',
            'description' => 'Informasi tentang berbagai cabang lomba MTQ'
        ],
        [
            'name' => 'Galeri',
            'slug' => 'galeri',
            'description' => 'Dokumentasi foto dan video kegiatan MTQ'
        ]
    ];

    // Tags data
    $tags_data = [
        'mtq2024', 'mtq-aceh', 'pidie-jaya', 'quran', 'tilawah', 'hafalan', 
        'tafsir', 'kaligrafi', 'adzan', 'qasidah', 'prestasi', 'juara',
        'peserta', 'lomba', 'kegiatan', 'acara', 'islam', 'keagamaan',
        'masyarakat', 'budaya', 'tradisi', 'kompetisi', 'festival',
        'ramadan', 'syawal', 'muharram', 'rajab', 'ceramah', 'dakwah',
        'ulama', 'santri', 'mahasiswa', 'pelajar', 'dewasa', 'remaja',
        'anak-anak', 'putra', 'putri', 'suara-emas', 'merdu', 'indah'
    ];

    echo "<div style='margin: 20px; font-family: monospace;'>";
    echo "<h2>🏷️ Membuat Dummy Categories dan Tags untuk MTQ</h2>";

    // Create Categories
    echo "<h3>=== MEMBUAT CATEGORIES ===</h3>";
    foreach ($categories_data as $cat_data) {
        // Check if category already exists
        $existing_cat = get_category_by_slug($cat_data['slug']);
        
        if (!$existing_cat) {
            $cat_id = wp_insert_category([
                'cat_name' => $cat_data['name'],
                'category_nicename' => $cat_data['slug'],
                'category_description' => $cat_data['description']
            ]);
            
            if ($cat_id && !is_wp_error($cat_id)) {
                echo "<div style='color: green;'>✓ Category '<strong>{$cat_data['name']}</strong>' berhasil dibuat (ID: $cat_id)</div>";
            } else {
                echo "<div style='color: red;'>✗ Gagal membuat category '<strong>{$cat_data['name']}</strong>'</div>";
            }
        } else {
            echo "<div style='color: orange;'>- Category '<strong>{$cat_data['name']}</strong>' sudah ada (ID: {$existing_cat->term_id})</div>";
        }
    }

    // Create Tags
    echo "<h3>=== MEMBUAT TAGS ===</h3>";
    $created_tags = 0;
    $existing_tags = 0;

    foreach ($tags_data as $tag_name) {
        // Check if tag already exists
        $existing_tag = get_term_by('name', $tag_name, 'post_tag');
        
        if (!$existing_tag) {
            $tag_result = wp_insert_term(
                $tag_name,
                'post_tag',
                [
                    'slug' => sanitize_title($tag_name)
                ]
            );
            
            if (!is_wp_error($tag_result)) {
                echo "<div style='color: green;'>✓ Tag '<strong>$tag_name</strong>' berhasil dibuat (ID: {$tag_result['term_id']})</div>";
                $created_tags++;
            } else {
                echo "<div style='color: red;'>✗ Gagal membuat tag '<strong>$tag_name</strong>': " . $tag_result->get_error_message() . "</div>";
            }
        } else {
            echo "<div style='color: orange;'>- Tag '<strong>$tag_name</strong>' sudah ada (ID: {$existing_tag->term_id})</div>";
            $existing_tags++;
        }
    }

    echo "<h3>=== SUMMARY ===</h3>";
    echo "<div><strong>Categories:</strong> " . count($categories_data) . " items processed</div>";
    echo "<div><strong>Tags:</strong> $created_tags baru dibuat, $existing_tags sudah ada</div>";
    echo "<div><strong>Total tags:</strong> " . count($tags_data) . " items processed</div>";

    // Display all categories
    echo "<h3>=== DAFTAR CATEGORIES ===</h3>";
    $categories = get_categories([
        'hide_empty' => false,
        'orderby' => 'name'
    ]);

    echo "<ul>";
    foreach ($categories as $category) {
        if ($category->name !== 'Uncategorized') {
            echo "<li><strong>{$category->name}</strong> (slug: {$category->slug}, ID: {$category->term_id})</li>";
        }
    }
    echo "</ul>";

    // Display sample tags
    echo "<h3>=== SAMPLE TAGS (10 pertama) ===</h3>";
    $tags = get_terms([
        'taxonomy' => 'post_tag',
        'hide_empty' => false,
        'number' => 10,
        'orderby' => 'name'
    ]);

    echo "<ul>";
    foreach ($tags as $tag) {
        echo "<li><strong>{$tag->name}</strong> (slug: {$tag->slug}, ID: {$tag->term_id})</li>";
    }
    echo "</ul>";

    echo "<div style='background: #e7f3ff; padding: 15px; border-left: 4px solid #2196F3; margin-top: 20px;'>";
    echo "<h4>✅ Script selesai!</h4>";
    echo "<p>Categories dan tags telah dibuat. Anda dapat menggunakannya untuk artikel berita MTQ.</p>";
    echo "<p><strong>Langkah selanjutnya:</strong></p>";
    echo "<ul>";
    echo "<li>Hapus kode ini dari functions.php setelah selesai</li>";
    echo "<li>Gunakan categories dan tags ini saat membuat/edit artikel</li>";
    echo "<li>Import artikel dummy jika diperlukan</li>";
    echo "</ul>";
    echo "</div>";

    echo "</div>";
}

// Trigger function jika ada parameter URL
if (isset($_GET['create_dummy_data']) && $_GET['create_dummy_data'] == '1' && current_user_can('manage_options')) {
    add_action('wp_head', 'mtq_create_dummy_categories_tags');
}

/*
CARA PENGGUNAAN:

1. Copy seluruh kode ini
2. Paste ke bagian bawah functions.php tema MTQ
3. Buka URL: https://mtq.pidiejayakab.go.id/?create_dummy_data=1
4. Script akan berjalan dan menampilkan hasilnya
5. Hapus kode ini dari functions.php setelah selesai

ATAU gunakan wp-cli:
wp term create category "Kegiatan MTQ" --description="Berbagai kegiatan dan acara MTQ"
wp term create post_tag "mtq2024"
*/
?>
