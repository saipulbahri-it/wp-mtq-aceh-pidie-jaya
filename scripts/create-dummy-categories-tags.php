<?php
/**
 * Script untuk membuat dummy categories dan tags
 * Salin kode ini ke functions.php sementara atau jalankan via wp-admin
 */

// Pastikan ini hanya dijalankan di admin atau saat dibutuhkan
if (!function_exists('wp_insert_category')) {
    echo "Error: WordPress functions not loaded. Please run this from WordPress admin or include wp-load.php properly.\n";
    exit;
}

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

echo "Mulai membuat categories dan tags...\n";

// Create Categories
echo "\n=== MEMBUAT CATEGORIES ===\n";
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
            echo "✓ Category '{$cat_data['name']}' berhasil dibuat (ID: $cat_id)\n";
        } else {
            echo "✗ Gagal membuat category '{$cat_data['name']}'\n";
        }
    } else {
        echo "- Category '{$cat_data['name']}' sudah ada (ID: {$existing_cat->term_id})\n";
    }
}

// Create Tags
echo "\n=== MEMBUAT TAGS ===\n";
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
            echo "✓ Tag '$tag_name' berhasil dibuat (ID: {$tag_result['term_id']})\n";
            $created_tags++;
        } else {
            echo "✗ Gagal membuat tag '$tag_name': " . $tag_result->get_error_message() . "\n";
        }
    } else {
        echo "- Tag '$tag_name' sudah ada (ID: {$existing_tag->term_id})\n";
        $existing_tags++;
    }
}

echo "\n=== SUMMARY ===\n";
echo "Categories: " . count($categories_data) . " items processed\n";
echo "Tags: $created_tags baru dibuat, $existing_tags sudah ada\n";
echo "Total tags: " . count($tags_data) . " items processed\n";

// Display all categories
echo "\n=== DAFTAR CATEGORIES ===\n";
$categories = get_categories([
    'hide_empty' => false,
    'orderby' => 'name'
]);

foreach ($categories as $category) {
    if ($category->name !== 'Uncategorized') {
        echo "- {$category->name} (slug: {$category->slug}, ID: {$category->term_id})\n";
    }
}

// Display all tags
echo "\n=== DAFTAR TAGS (10 pertama) ===\n";
$tags = get_terms([
    'taxonomy' => 'post_tag',
    'hide_empty' => false,
    'number' => 10,
    'orderby' => 'name'
]);

foreach ($tags as $tag) {
    echo "- {$tag->name} (slug: {$tag->slug}, ID: {$tag->term_id})\n";
}

echo "\nScript selesai!\n";
echo "Anda dapat menggunakan categories dan tags ini untuk artikel berita.\n";
?>
