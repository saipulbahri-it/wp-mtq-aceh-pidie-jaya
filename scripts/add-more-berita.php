<?php
// CLI only
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("CLI only.\n");
}

// Load WordPress
require_once dirname(__DIR__) . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

echo "Menambah artikel berita tambahan untuk test pagination...\n";

// Additional news articles
$additional_berita = [
    [
        "title" => "Workshop Pelatihan Qiraah untuk Peserta Muda",
        "content" => "Dalam rangka mempersiapkan generasi muda yang handal dalam seni qiraah, panitia MTQ Aceh XXXVII mengadakan workshop intensif pelatihan qiraah. Workshop ini diikuti oleh 150 peserta muda dari berbagai daerah di Aceh.\n\nPelatihan dipimpin langsung oleh para qari dan qariah terbaik Indonesia yang telah berpengalaman di tingkat internasional. Materi yang diajarkan meliputi teknik vokal, tajwid, makharijul huruf, dan seni interpretasi Al-Quran.\n\nPeserta antusias mengikuti setiap sesi pelatihan yang berlangsung selama tiga hari berturut-turut. Mereka berharap dapat menerapkan ilmu yang didapat dalam kompetisi MTQ mendatang.\n\n'Ini adalah kesempatan emas bagi kami untuk belajar langsung dari para master qiraah terbaik,' ujar Siti Aisyah, salah satu peserta dari Banda Aceh.\n\nWorkshop ini merupakan bagian dari rangkaian persiapan MTQ Aceh XXXVII yang akan diselenggarakan dalam waktu dekat.",
        "excerpt" => "Panitia MTQ Aceh XXXVII mengadakan workshop intensif pelatihan qiraah yang diikuti 150 peserta muda dari berbagai daerah di Aceh.",
        "image_url" => "https://images.unsplash.com/photo-1544027993-37dbfe43562a?w=1200&h=800&fit=crop&crop=center"
    ],
    [
        "title" => "Sistem Teknologi Canggih Dukung Pelaksanaan MTQ",
        "content" => "MTQ Aceh XXXVII menghadirkan inovasi teknologi terdepan untuk mendukung kelancaran seluruh rangkaian acara. Sistem teknologi yang digunakan meliputi live streaming HD, sistem scoring digital, dan aplikasi mobile untuk peserta.\n\nDr. Ahmad Rizky, Ketua Divisi Teknologi menjelaskan, 'Kami menggunakan teknologi live streaming beresolusi 4K yang memungkinkan masyarakat luas menyaksikan kompetisi secara real-time melalui berbagai platform digital.'\n\nSistem scoring digital yang terintegrasi memastikan penilaian yang akurat dan transparan. Setiap juri memiliki tablet khusus yang terhubung langsung ke server pusat untuk input nilai secara real-time.\n\nAplikasi mobile 'MTQ Aceh 37' juga telah diluncurkan untuk memudahkan peserta mengakses jadwal, pengumuman, dan informasi penting lainnya. Aplikasi ini dapat diunduh gratis di Play Store dan App Store.\n\nSelain itu, sistem keamanan cyber yang ketat diterapkan untuk melindungi data peserta dan menjamin integritas kompetisi.",
        "excerpt" => "MTQ Aceh XXXVII menghadirkan teknologi canggih termasuk live streaming 4K, sistem scoring digital, dan aplikasi mobile.",
        "image_url" => "https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=1200&h=800&fit=crop&crop=center"
    ],
    [
        "title" => "Kerjasama Lintas Daerah Perkuat MTQ Aceh XXXVII",
        "content" => "Solidaritas dan kerjasama antar daerah di Aceh semakin menguat dalam menyukseskan penyelenggaraan MTQ Aceh XXXVII. Seluruh kabupaten dan kota di Aceh memberikan dukungan penuh baik dari segi sumber daya manusia maupun finansial.\n\nGubernur Aceh dalam kunjungan kerjanya menyatakan apresiasi tinggi terhadap sinergitas yang terbangun. 'Ini adalah bukti nyata bahwa Aceh bersatu untuk kemajuan bersama,' ujarnya.\n\nSetiap daerah mengirimkan tim relawan terbaiknya untuk membantu berbagai aspek penyelenggaraan. Mulai dari tim keamanan, kesehatan, akomodasi, hingga dokumentasi acara.\n\nKabupaten Aceh Besar menyediakan dukungan logistik transportasi, sementara Kota Banda Aceh membantu dalam hal promosi dan publikasi acara. Kabupaten lainnya juga tidak ketinggalan memberikan kontribusi sesuai dengan keunggulan masing-masing.\n\nKerjasama ini diharapkan menjadi model yang dapat diterapkan dalam event-event besar lainnya di masa mendatang.",
        "excerpt" => "Solidaritas antar daerah di Aceh menguat dalam menyukseskan MTQ Aceh XXXVII dengan dukungan sumber daya dan finansial.",
        "image_url" => "https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=1200&h=800&fit=crop&crop=center"
    ],
    [
        "title" => "Program Beasiswa untuk Juara MTQ Terealisasi",
        "content" => "Komitmen pemerintah dalam mengapresiasi prestasi para juara MTQ terwujud melalui program beasiswa pendidikan yang komprehensif. Program ini mencakup beasiswa untuk jenjang S1, S2, hingga S3 di dalam dan luar negeri.\n\nMenteri Agama RI dalam sambutannya menyatakan, 'Para hafidz dan huffadz adalah aset bangsa yang harus terus dibina dan dikembangkan potensinya melalui pendidikan berkualitas.'\n\nBeasiswa tersedia untuk berbagai bidang studi, tidak hanya ilmu agama tetapi juga sains, teknologi, ekonomi, dan bidang lainnya. Ini membuktikan bahwa menghafal Al-Quran tidak membatasi seseorang untuk menguasai ilmu duniawi.\n\nSelain beasiswa, para juara juga mendapat kesempatan magang di berbagai instansi pemerintah dan swasta. Program mentoring khusus juga disediakan untuk membantu mereka merencanakan karir masa depan.\n\nHingga saat ini, lebih dari 200 alumni juara MTQ telah merasakanmanfaat program beasiswa ini dan berhasil menyelesaikan pendidikan tinggi dengan prestasi gemilang.",
        "excerpt" => "Program beasiswa komprehensif untuk juara MTQ mencakup pendidikan S1-S3 dalam dan luar negeri serta program magang.",
        "image_url" => "https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200&h=800&fit=crop&crop=center"
    ],
    [
        "title" => "Dampak Ekonomi Positif MTQ bagi Pidie Jaya",
        "content" => "Penyelenggaraan MTQ Aceh XXXVII memberikan dampak ekonomi yang signifikan bagi masyarakat Pidie Jaya. Sektor pariwisata, kuliner, dan perdagangan mengalami peningkatan omzet hingga 300% selama periode pelaksanaan.\n\nKepala Dinas Pariwisata Pidie Jaya melaporkan bahwa tingkat hunian hotel mencapai 95% dengan tamu dari berbagai daerah. Homestay dan penginapan rakyat juga mengalami lonjakan pemesanan yang luar biasa.\n\nPelaku usaha kuliner merasakan berkah luar biasa dengan meningkatnya permintaan makanan khas Aceh. Warteg, rumah makan, dan pedagang kaki lima melaporkan peningkatan penjualan yang fantastis.\n\nSouvenir dan kerajinan khas daerah juga laris manis diburu pengunjung sebagai oleh-oleh. Industri kreatif lokal mendapat exposure yang sangat berharga untuk mengembangkan pasar.\n\nBupati Pidie Jaya menyatakan optimisme tinggi bahwa momentum ini dapat dimanfaatkan untuk mengembangkan potensi pariwisata daerah secara berkelanjutan.",
        "excerpt" => "MTQ Aceh XXXVII memberi dampak ekonomi positif dengan peningkatan omzet sektor pariwisata, kuliner, dan perdagangan hingga 300%.",
        "image_url" => "https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200&h=800&fit=crop&crop=center"
    ],
    [
        "title" => "Inovasi Ramah Lingkungan dalam Penyelenggaraan MTQ",
        "content" => "MTQ Aceh XXXVII menjadi pionir dalam penerapan konsep green event dengan berbagai inovasi ramah lingkungan. Mulai dari penggunaan energi terbarukan hingga sistem pengelolaan sampah yang berkelanjutan.\n\nPanel surya berkapasitas 500 kWp dipasang untuk memenuhi sebagian besar kebutuhan listrik venue utama. Ini merupakan langkah konkret dalam mendukung program pemerintah mengurangi emisi karbon.\n\nSistem pengelolaan sampah terpadu diterapkan dengan metode 3R (Reduce, Reuse, Recycle). Setiap peserta dan pengunjung diwajibkan memilah sampah sesuai jenisnya melalui tempat sampah khusus yang disediakan.\n\nPenggunaan botol air minum sekali pakai dihindari dengan menyediakan dispenser air bersih dan menganjurkan peserta membawa tumbler sendiri. Souvenir yang diberikan juga menggunakan bahan ramah lingkungan.\n\nDr. Siti Khadijah, Koordinator Program Lingkungan menyatakan, 'MTQ ini membuktikan bahwa acara religius dapat sejalan dengan kepedulian terhadap kelestarian alam.'",
        "excerpt" => "MTQ Aceh XXXVII menerapkan konsep green event dengan panel surya, pengelolaan sampah terpadu, dan pengurangan plastik sekali pakai.",
        "image_url" => "https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=1200&h=800&fit=crop&crop=center"
    ]
];

// Get existing category ID
$category = get_category_by_slug('berita-mtq');
if (!$category) {
    // Create category if not exists
    $category_id = wp_insert_term('Berita MTQ', 'category', [
        'slug' => 'berita-mtq',
        'description' => 'Berita terbaru seputar MTQ Aceh XXXVII'
    ]);
    if (is_wp_error($category_id)) {
        echo "Error creating category: " . $category_id->get_error_message() . "\n";
        exit;
    }
    $category_id = $category_id['term_id'];
} else {
    $category_id = $category->term_id;
}

function download_and_upload_image($image_url, $post_id) {
    $tmp = download_url($image_url);
    if (is_wp_error($tmp)) {
        return false;
    }
    
    $file_array = [
        'name' => 'berita-' . $post_id . '.jpg',
        'tmp_name' => $tmp
    ];
    
    $id = media_handle_sideload($file_array, $post_id);
    
    if (is_wp_error($id)) {
        @unlink($tmp);
        return false;
    }
    
    return $id;
}

foreach ($additional_berita as $index => $berita) {
    // Create post
    $post_data = [
        'post_title' => $berita['title'],
        'post_content' => $berita['content'],
        'post_excerpt' => $berita['excerpt'],
        'post_status' => 'publish',
        'post_type' => 'post',
        'post_category' => [$category_id],
        'post_date' => date('Y-m-d H:i:s', strtotime('-' . ($index + 1) . ' days'))
    ];
    
    $post_id = wp_insert_post($post_data);
    
    if (!is_wp_error($post_id)) {
        echo "✓ Artikel dibuat: {$berita['title']} (ID: $post_id)\n";
        
        // Download and set featured image
        echo "  Downloading: {$berita['image_url']}\n";
        $attachment_id = download_and_upload_image($berita['image_url'], $post_id);
        
        if ($attachment_id) {
            set_post_thumbnail($post_id, $attachment_id);
            echo "  ✓ Featured image set (Media ID: $attachment_id)\n";
        } else {
            echo "  ✗ Failed to upload image\n";
        }
    } else {
        echo "✗ Failed to create post: {$berita['title']}\n";
    }
}

echo "\nSelesai menambah artikel berita tambahan!\n";
?>
