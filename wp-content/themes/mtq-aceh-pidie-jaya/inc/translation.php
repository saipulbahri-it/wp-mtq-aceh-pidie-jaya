<?php
/**
 * Translation setup for MTQ Aceh Pidie Jaya theme
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

/**
 * Load theme textdomain.
 */
function mtq_aceh_pidie_jaya_load_theme_textdomain() {
    load_theme_textdomain('mtq-aceh-pidie-jaya', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'mtq_aceh_pidie_jaya_load_theme_textdomain');

/**
 * Register translatable theme strings.
 */
function mtq_aceh_pidie_jaya_register_strings() {
    // Event Information
    __('MTQ Aceh XXXVII', 'mtq-aceh-pidie-jaya');
    __('Pidie Jaya 2025', 'mtq-aceh-pidie-jaya');
    __('Mari Tingkatkan SDM Qur\'ani yang Unggul Menuju Aceh Maju Pidie Jaya Meusyuhu', 'mtq-aceh-pidie-jaya');
    
    // Navigation Labels
    __('Beranda', 'mtq-aceh-pidie-jaya');
    __('Tentang', 'mtq-aceh-pidie-jaya');
    __('Cabang Lomba', 'mtq-aceh-pidie-jaya');
    __('Arena & Lokasi', 'mtq-aceh-pidie-jaya');
    __('Jadwal', 'mtq-aceh-pidie-jaya');
    __('Berita', 'mtq-aceh-pidie-jaya');
    __('Live', 'mtq-aceh-pidie-jaya');
    
    // Section Titles
    __('Tentang Event', 'mtq-aceh-pidie-jaya');
    __('Cabang Perlombaan', 'mtq-aceh-pidie-jaya');
    __('Waktu & Tempat', 'mtq-aceh-pidie-jaya');
    __('Tujuan', 'mtq-aceh-pidie-jaya');
    __('Peserta', 'mtq-aceh-pidie-jaya');
    
    // Time Labels
    __('Hari', 'mtq-aceh-pidie-jaya');
    __('Jam', 'mtq-aceh-pidie-jaya');
    __('Menit', 'mtq-aceh-pidie-jaya');
    __('Detik', 'mtq-aceh-pidie-jaya');
    
    // Competition Categories
    __('Tilawah Al-Qur\'an', 'mtq-aceh-pidie-jaya');
    __('Tahfizh Al-Qur\'an', 'mtq-aceh-pidie-jaya');
    __('Tafsir Al-Qur\'an', 'mtq-aceh-pidie-jaya');
    __('Khattil Qur\'an', 'mtq-aceh-pidie-jaya');
    __('Fahmil Qur\'an', 'mtq-aceh-pidie-jaya');
    __('Syarhil Qur\'an', 'mtq-aceh-pidie-jaya');
    __('Qiraah Sab\'ah', 'mtq-aceh-pidie-jaya');
    __('KTIQ', 'mtq-aceh-pidie-jaya');
    __('Tartil', 'mtq-aceh-pidie-jaya');
    
    // Customizer Labels
    __('MTQ Event Settings', 'mtq-aceh-pidie-jaya');
    __('Social Media Links', 'mtq-aceh-pidie-jaya');
    __('Contact Information', 'mtq-aceh-pidie-jaya');
}
// This function is just for reference, no need to add_action
