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
                'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
                'deskripsi' => __('Lomba membaca Al-Qur\'an dengan tajwid dan lagu yang indah', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-blue-600 bg-blue-100'
            ),
            'tahfizh' => array(
                'nama' => __('Tahfizh Al-Qur\'an', 'mtq-aceh-pidie-jaya'),
                'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'deskripsi' => __('Lomba menghafal Al-Qur\'an dengan jumlah juz yang ditentukan', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-green-600 bg-green-100'
            ),
            'tafsir' => array(
                'nama' => __('Tafsir Al-Qur\'an', 'mtq-aceh-pidie-jaya'),
                'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
                'deskripsi' => __('Lomba menjelaskan makna dan tafsir ayat Al-Qur\'an', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-purple-600 bg-purple-100'
            ),
            'khattil' => array(
                'nama' => __('Khattil Qur\'an', 'mtq-aceh-pidie-jaya'),
                'icon' => 'M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'deskripsi' => __('Lomba menulis kaligrafi ayat Al-Qur\'an dengan indah', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-amber-600 bg-amber-100'
            ),
            'fahmil' => array(
                'nama' => __('Fahmil Qur\'an', 'mtq-aceh-pidie-jaya'),
                'icon' => 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5',
                'deskripsi' => __('Lomba cerdas cermat pemahaman Al-Qur\'an secara beregu', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-indigo-600 bg-indigo-100'
            ),
            'syarhil' => array(
                'nama' => __('Syarhil Qur\'an', 'mtq-aceh-pidie-jaya'),
                'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z',
                'deskripsi' => __('Lomba menjelaskan kandungan Al-Qur\'an secara berkelompok', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-pink-600 bg-pink-100'
            ),
            'qiraah' => array(
                'nama' => __('Qiraah Sab\'ah', 'mtq-aceh-pidie-jaya'),
                'icon' => 'M19.952 1.651a.75.75 0 01.298.599V16.303a3 3 0 01-2.176 2.884l-1.32.377a2.553 2.553 0 11-1.403-4.909l2.311-.66a1.5 1.5 0 001.088-1.442V6.994l-9 2.572v9.737a3 3 0 01-2.176 2.884l-1.32.377a2.553 2.553 0 11-1.402-4.909l2.31-.66a1.5 1.5 0 001.088-1.442V9.017 5.25a.75.75 0 01.544-.721l10.5-3a.75.75 0 01.658.122z',
                'deskripsi' => __('Lomba membaca Al-Qur\'an dengan tujuh cara bacaan yang berbeda', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-orange-600 bg-orange-100'
            ),
            'ktiq' => array(
                'nama' => __('KTIQ', 'mtq-aceh-pidie-jaya'),
                'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
                'deskripsi' => __('Karya Tulis Ilmiah Al-Qur\'an', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-teal-600 bg-teal-100'
            ),
            'tartil' => array(
                'nama' => __('Tartil', 'mtq-aceh-pidie-jaya'),
                'icon' => 'M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z',
                'deskripsi' => __('Lomba membaca Al-Qur\'an dengan tartil sesuai tajwid', 'mtq-aceh-pidie-jaya'),
                'warna' => 'text-red-600 bg-red-100'
            )
        );
    }
endif;
