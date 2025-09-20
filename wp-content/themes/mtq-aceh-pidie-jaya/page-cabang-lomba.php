<?php
/**
 * Template Name: Cabang Lomba
 * Description: Halaman khusus yang menampilkan daftar cabang lomba MTQ.
 * Layout mengikuti halaman "Arena dan Lokasi" dan konten mengambil dari template part cabang lomba.
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main id="primary" class="site-main">
    <!-- Hero Section (follow layout style from Arena & Lokasi) -->
    <section class="pt-28 pb-16 bg-gradient-to-br from-blue-50 via-white to-slate-50 section-animate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="fade-in-delay">
                <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                    </svg>
                    Cabang Perlombaan
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-slate-800 mb-6">
                    Cabang Lomba MTQ <span class="text-green-600">Aceh XXXVII</span>
                </h1>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto mb-8">
                    Jelajahi seluruh cabang perlombaan Al-Qur'an yang dipertandingkan pada MTQ Aceh.
                </p>
                <div class="flex justify-center items-center gap-4 text-sm text-slate-500">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        Kabupaten Pidie Jaya
                    </span>
                    <span>•</span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        1-8 November 2025
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Cabang Lomba Section (content) -->
    <?php
    // Render the cabang lomba cards/section from template part
    get_template_part('template-parts/cabang-lomba');
    ?>
</main>

<?php get_footer(); ?>
