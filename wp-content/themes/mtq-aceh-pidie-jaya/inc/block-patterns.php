<?php
/**
 * Block Patterns
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

/**
 * Register Block Pattern Category.
 */
function mtq_aceh_pidie_jaya_register_block_pattern_category() {
    register_block_pattern_category(
        'mtq-patterns',
        array('label' => __('MTQ Components', 'mtq-aceh-pidie-jaya'))
    );
}
add_action('init', 'mtq_aceh_pidie_jaya_register_block_pattern_category');

/**
 * Register Block Patterns.
 */
function mtq_aceh_pidie_jaya_register_block_patterns() {
    // Event Countdown Pattern
    register_block_pattern(
        'mtq-aceh-pidie-jaya/event-countdown',
        array(
            'title'       => __('Event Countdown', 'mtq-aceh-pidie-jaya'),
            'description' => __('Displays a countdown timer to the MTQ event', 'mtq-aceh-pidie-jaya'),
            'categories'  => array('mtq-patterns'),
            'content'     => '<!-- wp:group {"className":"countdown-container"} -->
<div class="wp-block-group countdown-container">
    <!-- wp:heading {"level":3,"className":"countdown-title"} -->
    <h3 class="countdown-title">Hitung Mundur Menuju MTQ</h3>
    <!-- /wp:heading -->
    
    <!-- wp:columns {"className":"countdown-items"} -->
    <div class="wp-block-columns countdown-items">
        <!-- wp:column -->
        <div class="wp-block-column">
            <div class="countdown-item">
                <div class="countdown-number" data-count="days">00</div>
                <div class="countdown-label">Hari</div>
            </div>
        </div>
        <!-- /wp:column -->
        
        <!-- wp:column -->
        <div class="wp-block-column">
            <div class="countdown-item">
                <div class="countdown-number" data-count="hours">00</div>
                <div class="countdown-label">Jam</div>
            </div>
        </div>
        <!-- /wp:column -->
        
        <!-- wp:column -->
        <div class="wp-block-column">
            <div class="countdown-item">
                <div class="countdown-number" data-count="minutes">00</div>
                <div class="countdown-label">Menit</div>
            </div>
        </div>
        <!-- /wp:column -->
        
        <!-- wp:column -->
        <div class="wp-block-column">
            <div class="countdown-item">
                <div class="countdown-number" data-count="seconds">00</div>
                <div class="countdown-label">Detik</div>
            </div>
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->'
        )
    );

    // Competition Category Card Pattern
    register_block_pattern(
        'mtq-aceh-pidie-jaya/competition-category',
        array(
            'title'       => __('Competition Category Card', 'mtq-aceh-pidie-jaya'),
            'description' => __('Displays a competition category with icon and details', 'mtq-aceh-pidie-jaya'),
            'categories'  => array('mtq-patterns'),
            'content'     => '<!-- wp:group {"className":"glass-card p-6"} -->
<div class="wp-block-group glass-card p-6">
    <!-- wp:group {"className":"flex items-center gap-3 mb-4"} -->
    <div class="wp-block-group flex items-center gap-3 mb-4">
        <!-- wp:image {"className":"w-12 h-12 text-blue-600"} -->
        <figure class="wp-block-image w-12 h-12 text-blue-600">
            <img src="' . get_template_directory_uri() . '/assets/images/icons/quran.svg" alt=""/>
        </figure>
        <!-- /wp:image -->
        
        <!-- wp:heading {"level":3,"className":"text-xl font-semibold text-blue-600"} -->
        <h3 class="text-xl font-semibold text-blue-600">Tilawah Al-Quran</h3>
        <!-- /wp:heading -->
    </div>
    <!-- /wp:group -->
    
    <!-- wp:paragraph {"className":"text-slate-600"} -->
    <p class="text-slate-600">Lomba membaca Al-Quran dengan tajwid dan lagu yang indah.</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:list {"className":"text-slate-600 mt-4"} -->
    <ul class="text-slate-600 mt-4">
        <li>Kategori Putra & Putri</li>
        <li>Usia 15 tahun ke atas</li>
        <li>Minimal hafal 5 juz</li>
    </ul>
    <!-- /wp:list -->
</div>
<!-- /wp:group -->'
        )
    );

    // Event Schedule Pattern
    register_block_pattern(
        'mtq-aceh-pidie-jaya/event-schedule',
        array(
            'title'       => __('Event Schedule', 'mtq-aceh-pidie-jaya'),
            'description' => __('Displays event schedule in a table format', 'mtq-aceh-pidie-jaya'),
            'categories'  => array('mtq-patterns'),
            'content'     => '<!-- wp:group {"className":"schedule-container"} -->
<div class="wp-block-group schedule-container">
    <!-- wp:table {"className":"wp-block-table is-style-stripes"} -->
    <figure class="wp-block-table is-style-stripes">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Kegiatan</th>
                    <th>Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1 Nov 2025</td>
                    <td>08:00 - 10:00</td>
                    <td>Pembukaan MTQ</td>
                    <td>Lapangan Utama</td>
                </tr>
            </tbody>
        </table>
    </figure>
    <!-- /wp:table -->
</div>
<!-- /wp:group -->'
        )
    );
}
add_action('init', 'mtq_aceh_pidie_jaya_register_block_patterns');
