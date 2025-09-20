<?php

/**
 * Server-side render callback for Cabang Lomba Grid block
 * This file must return a callable for block.json "render": "file:..." to work.
 */
if (!defined('ABSPATH')) exit;

return function ($attributes = array(), $content = '', $block = null) {
    $columns = isset($attributes['columns']) ? (int)$attributes['columns'] : 3;
    $gap = isset($attributes['gap']) ? sanitize_text_field($attributes['gap']) : 'gap-6';

    $items = function_exists('mtq_get_cabang_lomba') ? mtq_get_cabang_lomba() : [];

    // Fallback: if helper function wasn't loaded yet, try to include it, then refetch
    if (empty($items) && !function_exists('mtq_get_cabang_lomba')) {
        $helper = get_template_directory() . '/inc/cabang-lomba.php';
        if (file_exists($helper)) {
            include_once $helper;
        }
        if (function_exists('mtq_get_cabang_lomba')) {
            $items = mtq_get_cabang_lomba();
        }
    }

    // If still empty, render a friendly empty-state instead of blank output
    if (empty($items)) {
        ob_start();
?>
        <section class="py-8">
            <div class="text-center text-slate-500">
                <?php echo esc_html__('Belum ada cabang lomba untuk ditampilkan.', 'mtq-aceh-pidie-jaya'); ?>
            </div>
        </section>
    <?php
        return ob_get_clean();
    }

    $colClass = 'lg:grid-cols-' . max(1, min(4, $columns));

    ob_start();
    ?>
    <!-- <section class="py-20 bg-gradient-to-br from-blue-50 to-indigo-50 section-animate" id="blocks_cabang-grid-render">
        <div class="max-w-6xl mx-auto px-4"> -->
            <div class="grid md:grid-cols-2 <?php echo esc_attr($colClass . ' ' . $gap); ?>">
                <?php foreach ($items as $key => $cabang):
                    $url = isset($cabang['url']) ? esc_url($cabang['url']) : '';
                    $open = $url ? '<a href="' . $url . '" class="block glass-card p-6 fade-in hover:scale-105 transition-transform duration-300">' : '<div class="glass-card p-6 fade-in hover:scale-105 transition-transform duration-300">';
                    $close = $url ? '</a>' : '</div>';
                    echo $open;
                ?>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex-shrink-0">
                            <div class="p-3 rounded-lg <?php echo esc_attr($cabang['warna']); ?>">
                                <?php
                                $icon_media_id = isset($cabang['icon_media_id']) ? absint($cabang['icon_media_id']) : 0;
                                if ($icon_media_id) {
                                    $mime = get_post_mime_type($icon_media_id);
                                    if ($mime === 'image/svg+xml' && function_exists('mtq_inline_svg_attachment')) {
                                        echo mtq_inline_svg_attachment($icon_media_id);
                                    } else {
                                        $img = wp_get_attachment_image($icon_media_id, 'thumbnail', false, array('class' => 'w-6 h-6'));
                                        if ($img) {
                                            echo $img;
                                        }
                                    }
                                } else {
                                ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo esc_attr($cabang['icon']); ?>" />
                                    </svg>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-800"><?php echo esc_html($cabang['nama']); ?></h3>
                    </div>
                    <p class="text-sm text-slate-600"><?php echo esc_html($cabang['deskripsi']); ?></p>
                    <?php echo $close; ?>
                <?php endforeach; ?>
            </div>
        <!-- </div>
    </section> -->
<?php
    return ob_get_clean();
};
