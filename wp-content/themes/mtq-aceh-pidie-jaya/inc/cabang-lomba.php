<?php
/**
 * Fungsi-fungsi terkait cabang lomba MTQ
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!function_exists('mtq_get_cabang_lomba')) :
    /**
     * Mendapatkan daftar cabang lomba MTQ
     *
     * @return array Daftar cabang lomba dengan detailnya
     */
    function mtq_get_cabang_lomba() {
        // Prefer items from CPT if present
        if (function_exists('mtq_get_cabang_lomba_from_cpt')) {
            $from_cpt = mtq_get_cabang_lomba_from_cpt();
            if (!empty($from_cpt)) {
                return $from_cpt;
            }
        }
        return array(
            'tilawah' => array(
                'nama' => __('Tilawah Al-Qur\'an', 'mtq-aceh-pidie-jaya'),
                'deskripsi' => __('Lomba membaca Al-Qur\'an dengan tajwid dan lagu yang indah', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-blue-600 bg-blue-100'
            ),
            'tahfizh' => array(
                'nama' => __('Tahfizh Al-Qur\'an', 'mtq-aceh-pidie-jaya'),
                'deskripsi' => __('Lomba menghafal Al-Qur\'an dengan jumlah juz yang ditentukan', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-green-600 bg-green-100'
            ),
            'tafsir' => array(
                'nama' => __('Tafsir Al-Qur\'an', 'mtq-aceh-pidie-jaya'),
                'deskripsi' => __('Lomba menjelaskan makna dan tafsir ayat Al-Qur\'an', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-purple-600 bg-purple-100'
            ),
            'khattil' => array(
                'nama' => __('Khattil Qur\'an', 'mtq-aceh-pidie-jaya'),
                'deskripsi' => __('Lomba menulis kaligrafi ayat Al-Qur\'an dengan indah', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-amber-600 bg-amber-100'
            ),
            'fahmil' => array(
                'nama' => __('Fahmil Qur\'an', 'mtq-aceh-pidie-jaya'),
                'deskripsi' => __('Lomba cerdas cermat pemahaman Al-Qur\'an secara beregu', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-indigo-600 bg-indigo-100'
            ),
            'syarhil' => array(
                'nama' => __('Syarhil Qur\'an', 'mtq-aceh-pidie-jaya'),
                'deskripsi' => __('Lomba menjelaskan kandungan Al-Qur\'an secara berkelompok', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-pink-600 bg-pink-100'
            ),
            'qiraah' => array(
                'nama' => __('Qiraah Sab\'ah', 'mtq-aceh-pidie-jaya'),
                'deskripsi' => __('Lomba membaca Al-Qur\'an dengan tujuh cara bacaan yang berbeda', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-orange-600 bg-orange-100'
            ),
            'ktiq' => array(
                'nama' => __('KTIQ', 'mtq-aceh-pidie-jaya'),
                'deskripsi' => __('Karya Tulis Ilmiah Al-Qur\'an', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-teal-600 bg-teal-100'
            ),
            'tartil' => array(
                'nama' => __('Tartil', 'mtq-aceh-pidie-jaya'),
                'deskripsi' => __('Lomba membaca Al-Qur\'an dengan tartil sesuai tajwid', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-red-600 bg-red-100'
            )
        );
    }
endif;
