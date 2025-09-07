<?php
/**
 * The front page template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display the front page of the site.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Hero Section -->
    <section id="beranda" class="min-h-screen hero-pattern flex items-center justify-center relative overflow-hidden pt-28 md:pt-24 section-animate">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-10 w-32 h-32 border border-blue-400/30 rounded-full"></div>
            <div class="absolute bottom-20 right-10 w-24 h-24 bg-amber-400/20 rounded-full"></div>
            <div class="absolute top-1/2 left-1/4 w-16 h-16 border-2 border-blue-400/40 rotate-45"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left fade-in">
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-400">
                            MTQ ACEH XXXVII
                        </span>
                    </h1>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold mb-6 text-slate-700">
                        PIDIE JAYA 2025
                    </h2>
                    <p class="text-lg md:text-xl text-slate-600 mb-8 max-w-2xl">
                        Musabaqah Tilawatil Qur'an tingkat Provinsi Aceh yang diselenggarakan di Kabupaten Pidie Jaya tahun 2025.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#tentang" class="px-8 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg">
                            Selengkapnya
                        </a>
                        <button id="share-btn" class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg border-2 border-blue-600 hover:bg-blue-50 transition">
                            Bagikan
                        </button>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="relative fade-in">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-6">
                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/gub-wagub-aceh.png" alt="Gubernur dan Wakil Gubernur Aceh" class="w-full rounded-2xl shadow-xl" loading="lazy">
                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/logo.png" alt="Logo MTQ Aceh XXXVII" class="w-full rounded-2xl shadow-xl mx-auto max-w-[200px]" loading="lazy">
                        </div>
                        <div class="space-y-6 pt-12">
                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/bupati-dan-wakil-2025.png" alt="Bupati dan Wakil Bupati Pidie Jaya 2025" class="w-full rounded-2xl shadow-xl" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 relative section-animate">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-slate-800">Tentang MTQ</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="fade-in">
                    <h3 class="text-xl font-bold text-blue-600 mb-4">MTQ ACEH XXXVII</h3>
                    <p class="text-lg text-slate-600 mb-6">
                        Musabaqah Tilawatil Qur'an (MTQ) adalah ajang perlombaan membaca dan memahami Al-Qur'an yang diselenggarakan setiap tahun oleh Pemerintah Provinsi Aceh. MTQ XXXVII tahun 2025 ini merupakan perayaan ke-37 sejak penyelenggaraan pertama kali di Aceh.
                    </p>
                    <p class="text-lg text-slate-600 mb-6">
                        Acara ini bertujuan untuk meningkatkan keimanan dan ketaqwaan umat Islam terhadap Al-Qur'an serta memperkokoh ukhuwah Islamiyah di kalangan masyarakat Aceh.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-8">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-600 rounded-full mr-3"></div>
                            <span class="text-slate-700">Perlombaan Tilawatil Qur'an</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-600 rounded-full mr-3"></div>
                            <span class="text-slate-700">Perlombaan Tahfizh</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-600 rounded-full mr-3"></div>
                            <span class="text-slate-700">Perlombaan Tafsir</span>
                        </div>
                    </div>
                </div>
                <div class="relative fade-in">
                    <img src="<?php echo get_template_directory_uri(); ?>/dist/images/hero-bg.jpg" alt="MTQ Aceh XXXVII" class="w-full rounded-2xl shadow-xl" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Competition Categories Section -->
    <section id="cabang" class="py-20 bg-slate-50 relative section-animate">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-slate-800">Cabang Lomba</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
                <p class="text-xl text-slate-600 mt-6 max-w-3xl mx-auto">
                    MTQ Aceh XXXVII menyelenggarakan berbagai cabang lomba yang meliputi tiga bidang utama.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Tilawatil Qur'an -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition group">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition">
                        <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-800">Tilawatil Qur'an</h3>
                    <p class="text-slate-600 mb-6">
                        Lomba membaca Al-Qur'an dengan tartil yang meliputi berbagai golongan usia.
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Golongan Anak-anak</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Golongan Remaja</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Golongan Dewasa</span>
                        </li>
                    </ul>
                </div>

                <!-- Tahfizh -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition group">
                    <div class="w-16 h-16 bg-amber-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-amber-600 transition">
                        <svg class="w-8 h-8 text-amber-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-800">Tahfizh</h3>
                    <p class="text-slate-600 mb-6">
                        Lomba hafalan Al-Qur'an yang meliputi berbagai golongan dan juz.
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Juz 1-30</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Berbagai golongan peserta</span>
                        </li>
                    </ul>
                </div>

                <!-- Tafsir -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition group">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition">
                        <svg class="w-8 h-8 text-green-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-800">Tafsir</h3>
                    <p class="text-slate-600 mb-6">
                        Lomba penjelasan makna Al-Qur'an dengan berbagai pendekatan.
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Penjelasan makna ayat</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Berbagai metode tafsir</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Schedule Section -->
    <section id="jadwal" class="py-20 relative section-animate">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-slate-800">Jadwal Kegiatan</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
                <p class="text-xl text-slate-600 mt-6 max-w-3xl mx-auto">
                    Jadwal lengkap kegiatan MTQ Aceh XXXVII di Kabupaten Pidie Jaya 2025.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-slate-200">
                                <th class="text-left py-4 px-4 font-semibold text-slate-700">Tanggal</th>
                                <th class="text-left py-4 px-4 font-semibold text-slate-700">Kegiatan</th>
                                <th class="text-left py-4 px-4 font-semibold text-slate-700">Lokasi</th>
                                <th class="text-left py-4 px-4 font-semibold text-slate-700">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-4 px-4">15-16 Maret 2025</td>
                                <td class="py-4 px-4">Pendaftaran Peserta</td>
                                <td class="py-4 px-4">Kantor MTQ Kabupaten</td>
                                <td class="py-4 px-4">08:00 - 16:00 WIB</td>
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-4 px-4">17 Maret 2025</td>
                                <td class="py-4 px-4">Technical Meeting</td>
                                <td class="py-4 px-4">Gedung Serbaguna</td>
                                <td class="py-4 px-4">09:00 - 12:00 WIB</td>
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-4 px-4">18 Maret 2025</td>
                                <td class="py-4 px-4">Pembukaan MTQ XXXVII</td>
                                <td class="py-4 px-4">Stadion Utama</td>
                                <td class="py-4 px-4">08:00 - 12:00 WIB</td>
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-4 px-4">19-25 Maret 2025</td>
                                <td class="py-4 px-4">Perlombaan</td>
                                <td class="py-4 px-4">Berbagai Arena</td>
                                <td class="py-4 px-4">08:00 - 17:00 WIB</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-4 px-4">26 Maret 2025</td>
                                <td class="py-4 px-4">Penutupan & Penghargaan</td>
                                <td class="py-4 px-4">Stadion Utama</td>
                                <td class="py-4 px-4">14:00 - 17:00 WIB</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section id="berita" class="py-20 bg-slate-50 relative section-animate">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-slate-800">Berita Terbaru</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
                <p class="text-xl text-slate-600 mt-6 max-w-3xl mx-auto">
                    Update terbaru seputar persiapan dan pelaksanaan MTQ Aceh XXXVII.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                // Display latest posts
                $args = array(
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                );
                $latest_posts = new WP_Query($args);

                if ($latest_posts->have_posts()) :
                    while ($latest_posts->have_posts()) :
                        $latest_posts->the_post();
                        ?>
                        <article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition group">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="h-48 overflow-hidden">
                                    <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-300')); ?>
                                </div>
                            <?php endif; ?>
                            <div class="p-6">
                                <div class="flex items-center text-sm text-slate-500 mb-3">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span><?php echo get_the_date(); ?></span>
                                </div>
                                <h3 class="text-xl font-bold mb-3 text-slate-800 group-hover:text-blue-600 transition">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <p class="text-slate-600 mb-4">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </p>
                                <a href="<?php the_permalink(); ?>" class="text-blue-600 font-semibold hover:text-blue-700 transition flex items-center">
                                    Baca selengkapnya
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="col-span-3 text-center py-12">
                        <p class="text-xl text-slate-600">Belum ada berita tersedia.</p>
                    </div>
                    <?php
                endif;
                ?>
            </div>

            <div class="text-center mt-12">
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="inline-block px-8 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg">
                    Lihat Semua Berita
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 relative section-animate">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-slate-800">Fitur Unggulan</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
                <p class="text-xl text-slate-600 mt-6 max-w-3xl mx-auto">
                    Platform digital yang mendukung kelancaran pelaksanaan MTQ Aceh XXXVII.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Live Streaming -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-red-600 transition">
                        <svg class="w-10 h-10 text-red-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-800">Live Streaming</h3>
                    <p class="text-slate-600">
                        Saksikan langsung seluruh rangkaian kegiatan MTQ secara real-time.
                    </p>
                </div>

                <!-- Digital Score -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-600 transition">
                        <svg class="w-10 h-10 text-blue-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-800">Nilai Digital</h3>
                    <p class="text-slate-600">
                        Sistem penilaian terintegrasi yang transparan dan akurat.
                    </p>
                </div>

                <!-- Mobile App -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-green-600 transition">
                        <svg class="w-10 h-10 text-green-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-800">Aplikasi Mobile</h3>
                    <p class="text-slate-600">
                        Aplikasi khusus untuk informasi dan update terkini.
                    </p>
                </div>

                <!-- Social Media -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-purple-600 transition">
                        <svg class="w-10 h-10 text-purple-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-800">Media Sosial</h3>
                    <p class="text-slate-600">
                        Ikuti kami di berbagai platform media sosial.
                    </p>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();