<?php
/**
 * Simple script to create dummy categories and tags
 * Add this temporarily to your theme's functions.php
 */

// Add to functions.php and call via admin panel or URL trigger
function create_mtq_dummy_data() {
    // Only run once
    if (get_option('mtq_dummy_data_created')) {
        return "Data sudah pernah dibuat sebelumnya.";
    }

    $result = [];
    
    // Categories to create
    $categories = [
        'Kegiatan MTQ' => 'Berbagai kegiatan dan acara MTQ Aceh Pidie Jaya',
        'Pengumuman' => 'Pengumuman resmi terkait MTQ dan kegiatan keagamaan',
        'Prestasi' => 'Pencapaian dan prestasi para peserta MTQ',
        'Peserta' => 'Informasi tentang para peserta MTQ',
        'Jadwal' => 'Jadwal kegiatan dan perlombaan MTQ',
        'Berita Terkini' => 'Berita terbaru seputar MTQ dan kegiatan keagamaan',
        'Lomba' => 'Informasi tentang berbagai cabang lomba MTQ',
        'Galeri' => 'Dokumentasi foto dan video kegiatan MTQ'
    ];
    
    // Create categories
    foreach ($categories as $name => $desc) {
        $cat = wp_create_category($name);
        if ($cat) {
            // Update category description
            wp_update_term($cat, 'category', ['description' => $desc]);
            $result[] = "✓ Category: $name";
        }
    }
    
    // Tags to create
    $tags = [
        'mtq2024', 'mtq-aceh', 'pidie-jaya', 'quran', 'tilawah', 'hafalan',
        'tafsir', 'kaligrafi', 'adzan', 'qasidah', 'prestasi', 'juara',
        'peserta', 'lomba', 'kegiatan', 'acara', 'islam', 'keagamaan',
        'masyarakat', 'budaya', 'tradisi', 'kompetisi', 'festival',
        'ramadan', 'ceramah', 'dakwah', 'santri', 'remaja', 'indah'
    ];
    
    // Create tags
    foreach ($tags as $tag) {
        $term = wp_insert_term($tag, 'post_tag');
        if (!is_wp_error($term)) {
            $result[] = "✓ Tag: $tag";
        }
    }
    
    // Mark as created
    update_option('mtq_dummy_data_created', true);
    
    return implode("<br>", $result);
}

// Uncomment line below to run the function
// echo create_mtq_dummy_data();

/*
INSTRUKSI PENGGUNAAN:

1. Copy kode di atas
2. Paste ke bagian bawah functions.php
3. Uncomment baris terakhir (hapus // di depan echo)
4. Refresh halaman website mana saja
5. Categories dan tags akan dibuat otomatis
6. Comment kembali atau hapus kode ini setelah selesai

ATAU jalankan via wp-admin:
- Buka wp-admin/edit.php
- Tambahkan ?mtq_create_data=1 di URL
- Jika ada kode trigger untuk parameter ini
*/
?>
