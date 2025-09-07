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
  }
];