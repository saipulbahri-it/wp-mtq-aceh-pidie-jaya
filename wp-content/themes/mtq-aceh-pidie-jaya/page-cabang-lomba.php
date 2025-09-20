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
    <!-- Inlined from template-parts/cabang-lomba.php per request -->
    <section id="cabang" class="py-20 bg-gradient-to-br from-blue-50 to-indigo-50 section-animate">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $cabang_lomba = mtq_get_cabang_lomba();
                foreach ($cabang_lomba as $key => $cabang) :
                ?>
                    <div class="glass-card p-6 fade-in hover:scale-105 transition-transform duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex-shrink-0">
                                <div class="p-3 rounded-lg <?php echo esc_attr($cabang['warna']); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo esc_attr($cabang['icon']); ?>" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-semibold text-slate-800"><?php echo esc_html($cabang['nama']); ?></h3>
                        </div>
                        <p class="text-sm text-slate-600"><?php echo esc_html($cabang['deskripsi']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
