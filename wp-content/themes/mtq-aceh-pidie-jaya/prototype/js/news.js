// News data and functionality
// Developed by @saipulbahri-it

// Sample news data (dalam implementasi nyata, ini bisa dari API)
const newsData = [
    {
        id: 1,
        title: "Penunjukan Pidie Jaya sebagai Tuan Rumah MTQ Aceh ke-37 oleh Gubernur Aceh",
        slug: "penunjukan-pidie-jaya-tuan-rumah-mtq-aceh-ke-37",
        category: "pengumuman",
        excerpt: "Gubernur Aceh Muzakir Manaf menegaskan Kabupaten Pidie Jaya resmi ditunjuk sebagai tuan rumah MTQ Aceh ke-37 tahun 2025 dengan alokasi dana Rp35 miliar.",
        content: `
      <p>Gubernur Aceh, Muzakir Manaf, menegaskan Kabupaten Pidie Jaya resmi ditunjuk sebagai tuan rumah Musabaqah Tilawatil Qur'an (MTQ) Aceh ke-37 tahun 2025. Penetapan itu tertuang dalam SK Gubernur Aceh Nomor 451.14/1677/2023 tentang Penetapan Tuan Rumah MTQ XXXVII. Pidie Jaya, yang dijuluki "Negeri Japakeh", mendapat mandat ini di tengah upaya memantapkan daerah tersebut sebagai pusat syiar Islam di Aceh Barat Daya.</p>
      
      <p>Pemprov Aceh telah mengalokasikan dana sebesar Rp35 miliar untuk mendukung penyelenggaraan MTQ di Pidie Jaya. Pada pelantikan Bupati-Wakil Bupati Pidie Jaya periode 2025–2030, Gubernur Muzakir menyatakan, "Kita sudah plot dana Rp35 Milyar untuk MTQ Aceh XXXVII di Pidie Jaya". Sebagian dana tersebut (Rp15 miliar) bahkan telah ditransfer ke kas daerah Pidie Jaya pada akhir Desember 2024 untuk pembiayaan pembangunan arena utama MTQ.</p>
      
      <h3>Detail Anggaran dan Pembangunan</h3>
      <p>Sisa bantuan (sekitar Rp20 miliar) diperuntukkan untuk penyelenggaraan kegiatan MTQ, termasuk pembangunan venue portabel serta keperluan lomba lainnya. Bangunan utama MTQ dibangun di atas lahan terbuka seluas sekitar 60 ribu meter² (6 hektare) di komplek perkantoran Bupati Pidie Jaya di Cot Trieng, Meureudu.</p>
      
      <p>Sebagai tuan rumah yang baru berusia 18 tahun, Pidie Jaya dipercaya melayani lebih dari 2.000 kafilah dari 23 kabupaten/kota se-Aceh pada MTQ Aceh XXXVII. Pemerintah daerah dan DPRK setempat berkomitmen memaksimalkan persiapan untuk suksesnya hajatan tersebut.</p>
      
      <h3>Komitmen Pemerintah Daerah</h3>
      <p>Bupati Pidie Jaya Syibral Malasyi mengatakan, kepercayaan menjadi tuan rumah MTQ Aceh merupakan amanah besar. Ia menyatakan akan mengerahkan seluruh sumber daya pemerintah daerah agar penyelenggaraan MTQ memberikan kesan istimewa bagi seluruh delegasi peserta. Pidie Jaya bersama masyarakat dan ulama berjanji mendukung penuh suksesi acara MTQ tingkat provinsi tersebut.</p>
      
      <p>Kerjasama seluruh elemen di Pidie Jaya, termasuk aparat keamanan dan swasta, diharapkan semakin memperkuat penyelenggaraan MTQ Aceh ke-37 dengan lancar.</p>
    `,
        author: "Tim Redaksi MTQ",
        date: "2025-04-24",
        views: 2150,
        image: "https://popularitas.com/wp-content/uploads/2025/04/syibral_mtq.webp"
    },
    {
        id: 2,
        title: "Bupati Pidie Jaya Letakkan Batu Pertama Pembangunan Arena MTQ Aceh ke-37",
        slug: "bupati-pidie-jaya-letakkan-batu-pertama-pembangunan-arena-mtq",
        category: "persiapan",
        excerpt: "Bupati Pidie Jaya H. Sibral Malasyi melakukan peletakan batu pertama pembangunan gedung utama arena MTQ di kompleks perkantoran Bupati Pidie Jaya, Cot Trieng, Meureudu.",
        content: `
      <p>Untuk menyambut hajatan MTQ Aceh ke-37, Bupati Pidie Jaya H. Sibral Malasyi melakukan peletakan batu pertama pembangunan gedung utama arena MTQ di kompleks perkantoran Bupati Pidie Jaya, Cot Trieng, Meureudu. Acara tersebut dihadiri Wakil Bupati Hasan Basri, Ketua DPRK, para pejabat Forkopimda, serta sejumlah anggota panitia. Momentum ini menjadi simbol dimulainya proyek fisik yang akan menjadi pusat kegiatan MTQ dan kegiatan keagamaan lainnya.</p>
      
      <p>Dalam sambutannya, Bupati Sibral menegaskan gedung utama MTQ tidak hanya diperuntukkan bagi musabaqah Tilawatil Qur'an semata, tetapi juga sebagai fasilitas multifungsi untuk masyarakat. Ia menyebut pembangunan gedung utama MTQ diharapkan memberi dampak ekonomi dan sosial jangka panjang, misalnya bisa dimanfaatkan untuk pameran produk lokal dan promosi UMKM.</p>
      
      <h3>Visi Pembangunan</h3>
      <p>Lebih lanjut, ia mengatakan gedung MTQ baru ini akan menjadi ikon daerah yang memperkuat citra religius dan progresif Kabupaten Pidie Jaya. Acara peletakan batu pertama berlangsung dengan penuh hikmat dimulai pada Senin, 14 April 2025. Rangkaian kegiatan mencakup pembacaan doa dan tausiyah oleh tokoh agama setempat.</p>
      
      <p>Kehadiran Wakil Bupati, jajaran Forkopimda, serta pimpinan SKPD menunjukkan dukungan penuh Pemkab Pidie Jaya kepada tim panitia MTQ. Bupati Sibral mengajak warga bersama-sama menjaga momentum persiapan fisik dan nonfisik MTQ, agar pembangunan gedung utama dan fasilitas pendukung lainnya dapat tuntas tepat waktu.</p>
      
      <h3>Target Penyelesaian</h3>
      <p>Proses pembangunan gedung utama MTQ seluas 60 ribu m² ini saat ini terus dikebut. Pembangunan dilaksanakan di atas lahan 6 hektare di Cot Trieng dan ditargetkan selesai sebelum November 2025. Dengan adanya gedung utama baru, penyelenggara MTQ juga tengah menyiapkan perlengkapan dan dekorasi pendukung agar perlombaan serta kegiatan lainnya dapat berjalan lancar.</p>
      
      <p>Pidie Jaya optimistis fasilitas baru ini akan meningkatkan kenyamanan dan semarak MTQ Aceh 2025 di daerahnya.</p>
    `,
        author: "Layar Berita",
        date: "2025-04-14",
        views: 1850,
        image: "https://cdn.pixabay.com/photo/2015/01/08/06/19/site-592458_1280.jpg"
    },
    {
        id: 3,
        title: "LPTQ Aceh dan Kanwil Kemenag Aceh Tinjau Lokasi MTQ Aceh ke-37 di Pidie Jaya",
        slug: "lptq-aceh-tinjau-lokasi-mtq-aceh-ke-37-pidie-jaya",
        category: "persiapan",
        excerpt: "Tim LPTQ Aceh melakukan tinjauan lokasi pendukung MTQ Aceh ke-37 di Kabupaten Pidie Jaya untuk memastikan kesiapan arena lomba dan fasilitas pendukung.",
        content: `
      <p>Tim Lembaga Pengembangan Tilawatil Qur'an (LPTQ) Aceh melakukan tinjauan lokasi pendukung Musabaqah Tilawatil Qur'an (MTQ) Aceh ke-37 di Kabupaten Pidie Jaya. Kegiatan lapangan berlangsung pada Kamis, 13 Juni 2024, dan dipimpin oleh Ketua Harian LPTQ Aceh Prof. H. Armiadi Musa. Kunjungan ini bertujuan memastikan kesiapan sejumlah arena lomba dan fasilitas pendukung menjelang MTQ provinsi yang akan digelar Oktober tahun berikutnya.</p>
      
      <p>Beberapa lokasi yang ditinjau antara lain Komplek Kantor Bupati Pidie Jaya, Masjid Agung Tgk Chik Pante Geulima, Madrasah Ulumul Qur'an Pidie Jaya, Kantor Kemenag Pidie Jaya, serta sejumlah masjid dan lapangan di Meureudu. Daftar kunjungan mencakup Masjid Al-Munawwarah Simpang Peut Meureudu, Masjid Al-Istiqamah Rieng Blang Meureudu, dan Lapangan Mideun Meurah Setia dekat pasar Meureudu.</p>
      
      <h3>Hasil Peninjauan</h3>
      <p>Kepala Dinas Syariat Islam Pidie Jaya dan perwakilan Kanwil Kemenag Aceh turut mendampingi tim saat peninjauan. Tim LPTQ menilai secara umum bahwa fasilitas tersebut sudah memenuhi standar sehingga siap digunakan dalam pelaksanaan MTQ.</p>
      
      <p>Dalam tinjauan itu, Asisten 1 Pemkab Pidie Jaya, Said Abdullah, menyatakan Pemkab akan menyiapkan arena-arena yang telah ditunjuk sesuai arahan tim provinsi. Pemkab berkomitmen memaksimalkan sarana dan prasarana seperti sarana panggung, listrik, dan tempat parkir, sehingga saat MTQ berlangsung semua kebutuhan teknis telah terpenuhi.</p>
      
      <h3>Komitmen Dukungan</h3>
      <p>Ketua Harian LPTQ Aceh menambahkan bahwa tim juga akan membantu persiapan dekorasi dan kelengkapan teknis acara, agar setiap lapangan dan lokasi penunjang dapat difungsikan sesuai kebutuhan perlombaan.</p>
      
      <p>Secara keseluruhan, peninjauan ini memastikan bahwa jalannya MTQ Aceh XXXVII di Pidie Jaya akan berjalan dengan tertib dan sesuai standar LPTQ. Diharapkan kesigapan panitia daerah dan dukungan dari Kanwil Kemenag Aceh turut menjamin pelaksanaan lomba berlangsung sukses dan khidmat. Selain itu, koordinasi terus dilakukan antara Pemkab dan instansi terkait agar pembangunan gedung utama MTQ dan infrastruktur pendukung selesai tepat waktu sebelum MTQ digelar.</p>
    `,
        author: "Kemenag Aceh",
        date: "2024-06-14",
        views: 1420,
        image: "https://cdn.pixabay.com/photo/2014/03/03/16/15/mosque-279015_1280.jpg"
    },
    {
        id: 4,
        title: "Pemkab Pidie Jaya Buka Seleksi MTQ Kabupaten 2025 dan Serahkan Bonus kepada Peserta Berprestasi",
        slug: "pemkab-pidie-jaya-buka-seleksi-mtq-kabupaten-2025",
        category: "acara",
        excerpt: "Pemerintah Kabupaten Pidie Jaya resmi membuka seleksi kafilah MTQ tingkat kabupaten 2025 dan menyerahkan bonus kepada peserta berprestasi MTQ sebelumnya.",
        content: `
      <p>Pemerintah Kabupaten Pidie Jaya melalui Dinas Syariat Islam resmi membuka seleksi kafilah MTQ tingkat kabupaten untuk tahun 2025. Upacara pembukaan digelar Selasa, 22 April 2025, di Aula Kantor Bupati Lantai 3, Cot Trieng Meureudu. Pada kesempatan yang sama, Pemerintah Pidie Jaya menyerahkan bonus kepada para kafilah yang meraih prestasi pada MTQ Aceh ke-36 tahun 2023 di Simeulue sebagai bentuk apresiasi dan motivasi.</p>
      
      <p>Penyerahan bonus dilakukan secara simbolis oleh Kapolres Pidie Jaya mewakili pemerintah daerah. Kegiatan pembukaan dimulai dengan pembacaan ayat suci Al-Qur'an, salawat badar, serta lagu Indonesia Raya dan Hymne Aceh, menciptakan suasana khidmat.</p>
      
      <h3>Dukungan Pemerintah Daerah</h3>
      <p>Hadir mendampingi Bupati H. Sibral Malasyi dalam acara tersebut antara lain Wakil Bupati, Ketua DPRK, jajaran Forkopimda, Kepala Kemenag Pidie Jaya, Kajari, serta unsur SKPD dan tokoh agama. Kehadiran pejabat tinggi daerah menandakan dukungan penuh pemerintah terhadap persiapan MTQ provinsi.</p>
      
      <p>Bupati Sibral Malasyi menyampaikan rasa bangga atas kepercayaan Provinsi Aceh memilih Pidie Jaya sebagai tuan rumah MTQ Aceh ke-37 yang akan digelar November 2025. Ia menegaskan seleksi tingkat kabupaten ini bukan semata mencari peserta terbaik, tetapi sebagai upaya menanamkan kecintaan terhadap Al-Qur'an dan menyiapkan duta-duta daerah yang siap bersaing di tingkat provinsi maupun nasional.</p>
      
      <h3>Target dan Harapan</h3>
      <p>Pidie Jaya menargetkan menghasilkan qari dan qariah yang berprestasi dengan merujuk pada tradisi keagamaan setempat. Kapolres Pidie Jaya secara simbolis menyerahkan bonus kepada salah satu peserta yang meraih juara II tingkat provinsi. Bonus diserahkan sebagai penghargaan atas prestasi kafilah daerah di ajang MTQ sebelumnya.</p>
      
      <p>Bupati Sibral berharap insentif tersebut dapat memacu semangat peserta dan meningkatkan perhatian masyarakat terhadap MTQ. Pemkab juga meminta semua panitia tetap fokus mempersiapkan fasilitas dan sarana pendukung agar seleksi dan penyelenggaraan MTQ dapat berjalan lancar sesuai jadwal.</p>
    `,
        author: "Layar Berita",
        date: "2025-04-22",
        views: 980,
        image: "https://cdn.pixabay.com/photo/2014/03/03/16/15/mosque-279015_1280.jpg"
    },
    {
        id: 5,
        title: "Rapat Koordinasi 100 Hari Menjelang MTQ Aceh: Keamanan dan Pemberdayaan UMKM Lokal Ditekankan",
        slug: "rapat-koordinasi-100-hari-menjelang-mtq-aceh",
        category: "persiapan",
        excerpt: "Jajaran Pemerintah Aceh bersama Pemkab Pidie Jaya menggelar rapat koordinasi persiapan MTQ dengan fokus pada keamanan dan pemberdayaan UMKM lokal.",
        content: `
      <p>Menjelang 100 hari pelaksanaan MTQ Aceh ke-37, jajaran Pemerintah Aceh bersama Pemkab Pidie Jaya kembali menggelar rapat koordinasi persiapan MTQ di Meureudu. Dalam rapat tersebut, Kepala Dinas Syariat Islam Aceh, Zahrol Fajri, memaparkan capaian persiapan hingga awal Mei 2025. Ia menyampaikan semua tahapan telah ditempuh sesuai jadwal, termasuk pelantikan panitia MTQ dan finalisasi lokasi utama acara.</p>
      
      <p>Rapat ini juga mengevaluasi progres pembangunan arena utama MTQ. Menurut Zahrol, gedung utama di Cot Trieng kini telah mencapai sekitar 18% pengerjaan. Usai rapat, tim pemantau dari Provinsi Aceh melakukan inspeksi ke lapangan untuk memastikan kualitas konstruksi. Zahrol menegaskan pemerintah provinsi bersama Pemkab Pidie Jaya akan mempercepat pengerjaan, sehingga pada 1 November 2025 bangunan utama siap menampung ribuan peserta MTQ.</p>
      
      <h3>Aspek Keamanan dan Teknis</h3>
      <p>Selain fisik gedung, pembahasan rapat menyangkut berbagai aspek teknis. Panitia diminta menyiapkan jalan utama, lokasi parkir, dan sirkulasi keamanan agar pada hari pelaksanaan MTQ wilayah Pidie Jaya terjaga dengan baik. Sektor keamanan juga menjadi sorotan, terutama koordinasi antara Polres Pidie Jaya dan pihak penyelenggara untuk menjamin acara bebas gangguan.</p>
      
      <p>Sebelumnya, Kapolres telah menegaskan kesiapan institusinya melakukan pengamanan maksimal, termasuk patroli rutin dan pengaturan arus lalu lintas saat MTQ berlangsung.</p>
      
      <h3>Pemberdayaan Ekonomi Lokal</h3>
      <p>Ketua Panitia MTQ Pidie Jaya, H. Syaifuddin, menyampaikan pentingnya melibatkan masyarakat luas, termasuk pemberdayaan ekonomi lokal. Ia menyebut gedung utama MTQ nantinya akan difungsikan untuk promosi produk UMKM lokal saat hajatan berlangsung. Sebagai contoh, stan UMKM Aceh Barat Daya akan disediakan di area acara, sehingga pengunjung dan peserta dapat mengapresiasi kerajinan dan kuliner setempat.</p>
      
      <p>Kegiatan ini diharapkan meninggalkan dampak positif berkelanjutan bagi pelaku usaha kecil di daerah. Komitmen bersama antara Pemprov Aceh, Pemkab Pidie Jaya, kepolisian, dan elemen masyarakat menjadi kunci sukses MTQ Aceh 2025. Rapat koordinasi 100 hari ini menegaskan bahwa selain penyelenggaraan acara, keselamatan peserta dan pengunjung serta pemberdayaan ekonomi lokal melalui UMKM menjadi fokus utama.</p>
    `,
        author: "Popularitas",
        date: "2025-05-07",
        views: 1680,
        image: "https://cdn.pixabay.com/photo/2019/05/03/16/26/street-vendor-4176310_1280.jpg"
    },
    {
        id: 6,
        title: "Peserta MTQ Aceh XXXVII Mulai Berdatangan ke Pidie Jaya, Panitia Siapkan Akomodasi Terbaik",
        slug: "peserta-mtq-aceh-xxxvii-mulai-berdatangan-pidie-jaya",
        category: "peserta",
        excerpt: "Para peserta MTQ Aceh XXXVII dari 23 kabupaten/kota mulai berdatangan ke Pidie Jaya. Panitia telah menyiapkan akomodasi dan fasilitas terbaik untuk kenyamanan seluruh peserta.",
        content: `
      <p>Para peserta Musabaqah Tilawatil Qur'an (MTQ) Aceh ke-37 dari 23 kabupaten/kota se-Aceh mulai berdatangan ke Kabupaten Pidie Jaya. Kedatangan rombongan peserta dimulai sejak Selasa, 25 Oktober 2025, tujuh hari sebelum pembukaan resmi yang dijadwalkan pada 1 November 2025. Panitia penyelenggara telah menyiapkan berbagai fasilitas dan akomodasi terbaik untuk memastikan kenyamanan seluruh peserta selama mengikuti MTQ.</p>
      
      <p>Ketua Panitia Penyelenggara MTQ Aceh XXXVII, H. Syaifuddin, mengatakan bahwa total peserta yang akan mengikuti MTQ tahun ini mencapai lebih dari 2.000 orang, termasuk qari, qariah, pembina, dan tim pendukung. "Kami sangat antusias menyambut kedatangan para peserta dari seluruh Aceh. Semua persiapan akomodasi dan fasilitas sudah disiapkan dengan matang," ungkap Syaifuddin saat memantau kedatangan peserta di Hotel Al-Madinah Meureudu.</p>
      
      <h3>Fasilitas Akomodasi Lengkap</h3>
      <p>Panitia telah menyiapkan akomodasi di berbagai hotel dan penginapan di Pidie Jaya dan sekitarnya. Fasilitas yang disediakan meliputi kamar ber-AC, tempat tidur yang nyaman, akses Wi-Fi gratis, dan kamar mandi dalam. Selain itu, setiap peserta juga mendapatkan welcome pack berisi jadwal kegiatan, peta lokasi, souvenir khas Pidie Jaya, dan buku panduan MTQ.</p>
      
      <p>Khusus untuk para qari dan qariah, panitia juga menyediakan ruang latihan khusus yang dilengkapi dengan sound system berkualitas tinggi. Ruang latihan ini tersedia 24 jam untuk memfasilitasi persiapan para peserta. "Kami memahami pentingnya persiapan yang matang bagi para peserta, karena itu semua fasilitas latihan sudah kami siapkan," tambah Syaifuddin.</p>
      
      <h3>Layanan Transportasi dan Konsumsi</h3>
      <p>Untuk memudahkan mobilitas peserta, panitia menyediakan layanan shuttle bus yang menghubungkan hotel-hotel peserta dengan arena utama MTQ di Cot Trieng. Bus shuttle beroperasi setiap 30 menit mulai pukul 06.00 hingga 22.00 WIB. Selain itu, panitia juga menyediakan layanan antar-jemput dari dan ke Bandara Sultan Iskandar Muda serta Terminal Bus Meureudu.</p>
      
      <p>Untuk konsumsi, setiap peserta mendapatkan tiga kali makan sehari dengan menu yang bervariasi dan halal. Menu disusun oleh ahli gizi dengan mempertimbangkan kebutuhan nutrisi para peserta. Tersedia juga pilihan menu vegetarian dan menu khusus bagi peserta yang memiliki kondisi kesehatan tertentu.</p>
      
      <h3>Protokol Kesehatan dan Keamanan</h3>
      <p>Mengingat masih dalam masa adaptasi kebiasaan baru, panitia juga menerapkan protokol kesehatan yang ketat. Setiap peserta wajib menunjukkan sertifikat vaksin dan hasil tes kesehatan terbaru. Di setiap hotel dan area publik telah disediakan hand sanitizer dan fasilitas cuci tangan. Tim medis juga bersiaga 24 jam untuk memberikan pelayanan kesehatan jika diperlukan.</p>
      
      <p>Dari segi keamanan, panitia berkoordinasi dengan Polres Pidie Jaya untuk memastikan keamanan seluruh peserta. Petugas keamanan ditempatkan di setiap hotel dan area kegiatan. "Keselamatan dan kenyamanan peserta adalah prioritas utama kami," tegas Ketua Panitia.</p>
      
      <h3>Sambutan Hangat Masyarakat</h3>
      <p>Kedatangan para peserta MTQ disambut dengan hangat oleh masyarakat Pidie Jaya. Di berbagai titik, terlihat spanduk selamat datang dan ornamen islami yang menghiasi jalan-jalan utama. Masyarakat lokal juga turut berpartisipasi dengan menawarkan bantuan dan informasi kepada para peserta yang membutuhkan.</p>
      
      <p>Bupati Pidie Jaya, H. Sibral Malasyi, yang turut menyambut kedatangan peserta mengatakan, "Kami sangat bangga bisa menjadi tuan rumah MTQ Aceh ke-37. Semoga dengan fasilitas dan sambutan hangat dari masyarakat Pidie Jaya, para peserta bisa tampil maksimal dalam kompetisi ini."</p>
    `,
        author: "Tim Humas MTQ",
        date: "2025-10-15",
        views: 1520,
        image: "https://cdn.pixabay.com/photo/2016/11/18/17/20/living-room-1835923_1280.jpg"
    }
];

// Global variables for pagination and filtering
let currentPage = 1;
let itemsPerPage = 6;
let filteredNews = [...newsData];
let displayedNews = [];

// Initialize page when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    displayNews();
    updateStats();
    setupEventListeners();
});

// Setup event listeners
function setupEventListeners() {
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const searchBtn = document.getElementById('search-btn');
    const loadMoreBtn = document.getElementById('load-more-btn');

    if (searchInput) {
        searchInput.addEventListener('input', debounce(searchNews, 300));
    }

    if (categoryFilter) {
        categoryFilter.addEventListener('change', searchNews);
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', searchNews);
    }

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', loadMoreNews);
    }
}

// Search and filter news
function searchNews() {
    const searchTerm = document.getElementById('search-input')?.value.toLowerCase() || '';
    const selectedCategory = document.getElementById('category-filter')?.value || '';

    filteredNews = newsData.filter(news => {
        const matchesSearch = news.title.toLowerCase().includes(searchTerm) ||
            news.excerpt.toLowerCase().includes(searchTerm) ||
            news.content.toLowerCase().includes(searchTerm);
        const matchesCategory = !selectedCategory || news.category === selectedCategory;
        return matchesSearch && matchesCategory;
    });

    currentPage = 1;
    displayedNews = [];
    displayNews();
    updateStats();
}

// Display news articles
function displayNews() {
    const container = document.getElementById('news-container');
    const noResults = document.getElementById('no-results');
    const loadMoreBtn = document.getElementById('load-more-btn');

    if (!container) return;

    // Get news items for current page
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const newsToAdd = filteredNews.slice(startIndex, endIndex);

    // Add new news to displayed array
    displayedNews.push(...newsToAdd);

    if (displayedNews.length === 0) {
        container.innerHTML = '';
        noResults?.classList.remove('hidden');
        loadMoreBtn?.classList.add('hidden');
        return;
    }

    // Hide no results message
    noResults?.classList.add('hidden');

    // Render all displayed news
    container.innerHTML = displayedNews.map(news => createNewsCard(news)).join('');

    // Show/hide load more button
    if (loadMoreBtn) {
        if (displayedNews.length >= filteredNews.length) {
            loadMoreBtn.classList.add('hidden');
        } else {
            loadMoreBtn.classList.remove('hidden');
        }
    }

    // Update showing count
    updateShowingCount();
}

// Create news card HTML
function createNewsCard(news) {
    const categoryColor = getCategoryColor(news.category);
    const categoryName = getCategoryName(news.category);

    return `
        <article class="bg-white rounded-xl shadow-sm border border-slate-200 group hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="relative overflow-hidden">
                <img 
                    src="${news.image}" 
                    alt="${news.title}"
                    class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500"
                    loading="lazy"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                <div class="absolute top-4 left-4">
                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full ${categoryColor} shadow-sm">
                        ${categoryName}
                    </span>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex items-center text-sm text-slate-500 mb-3">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>${formatDate(news.date)}</span>
                    <span class="mx-2">•</span>
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span>${news.views.toLocaleString()}</span>
                </div>
                
                <h3 class="text-xl font-bold text-slate-800 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                    ${news.title}
                </h3>
                
                <p class="text-slate-600 mb-4 line-clamp-3">
                    ${news.excerpt}
                </p>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-sm text-slate-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>${news.author}</span>
                    </div>
                    
                    <a 
                        href="news-detail.html?id=${news.id}" 
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105"
                    >
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </article>
    `;
}

// Load more news
function loadMoreNews() {
    currentPage++;
    displayNews();
}

// Get category color
function getCategoryColor(category) {
    const colors = {
        'pengumuman': 'bg-red-600 text-white',
        'persiapan': 'bg-blue-600 text-white',
        'acara': 'bg-green-600 text-white',
        'peserta': 'bg-purple-600 text-white',
        'lomba': 'bg-orange-600 text-white'
    };
    return colors[category] || 'bg-slate-600 text-white';
}

// Get category name
function getCategoryName(category) {
    const names = {
        'pengumuman': 'Pengumuman',
        'persiapan': 'Persiapan',
        'acara': 'Acara',
        'peserta': 'Peserta',
        'lomba': 'Lomba'
    };
    return names[category] || 'Umum';
}

// Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        locale: 'id-ID'
    };
    return date.toLocaleDateString('id-ID', options);
}

// Update statistics
function updateStats() {
    const totalNewsEl = document.getElementById('total-news');
    const recentNewsEl = document.getElementById('recent-news');
    const totalViewsEl = document.getElementById('total-views');

    if (totalNewsEl) {
        updateCounters(totalNewsEl, filteredNews.length);
    }

    if (recentNewsEl) {
        const today = new Date().toISOString().split('T')[0];
        const todayNews = filteredNews.filter(news => news.date === today).length;
        updateCounters(recentNewsEl, todayNews);
    }

    if (totalViewsEl) {
        const totalViews = filteredNews.reduce((sum, news) => sum + news.views, 0);
        updateCounters(totalViewsEl, totalViews);
    }
}

// Update showing count
function updateShowingCount() {
    const showingCountEl = document.getElementById('showing-count');
    const totalCountEl = document.getElementById('total-count');

    if (showingCountEl) {
        showingCountEl.textContent = displayedNews.length;
    }

    if (totalCountEl) {
        totalCountEl.textContent = filteredNews.length;
    }
}

// Animated counter
function updateCounters(element, targetValue) {
    const startValue = 0;
    const duration = 1000;
    const increment = targetValue / (duration / 16);
    let currentValue = startValue;

    const timer = setInterval(() => {
        currentValue += increment;
        if (currentValue >= targetValue) {
            element.textContent = targetValue.toLocaleString();
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(currentValue).toLocaleString();
        }
    }, 16);
}

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Make functions and data available globally
window.searchNews = searchNews;
window.newsData = newsData;
window.getCategoryName = getCategoryName;
window.formatDate = formatDate;