<?php
/**
 * Template part for displaying cabang lomba section
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */
?>

<!-- Cabang Lomba Section -->
<section id="cabang" class="py-20 bg-gradient-to-br from-blue-50 to-indigo-50 section-animate">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16 fade-in">
            <span class="inline-block bg-green-100/80 text-green-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                <?php esc_html_e('Cabang Perlombaan', 'mtq-aceh-pidie-jaya'); ?>
            </span>
            <h2 class="text-4xl md:text-5xl font-bold mb-6 text-slate-800">
                <?php esc_html_e('Cabang Lomba MTQ', 'mtq-aceh-pidie-jaya'); ?>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-green-600 to-transparent mx-auto mb-8"></div>
            <p class="text-xl text-slate-600 max-w-3xl mx-auto">
                <?php esc_html_e('Berbagai kategori lomba Al-Qur\'an untuk semua tingkatan usia', 'mtq-aceh-pidie-jaya'); ?>
            </p>
        </div>

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
