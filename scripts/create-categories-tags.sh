#!/bin/bash

# Script untuk membuat dummy categories dan tags menggunakan WP-CLI
# Pastikan WP-CLI sudah terinstall dan berjalan dari root WordPress

echo "🏷️ Membuat Categories dan Tags untuk MTQ..."

# Navigate to WordPress root
cd /Users/saipulbahri.it/Projects/github/web-mtq-pijay/wp-mtq-aceh-pidie-jaya

# Create Categories
echo "📁 Membuat Categories..."
wp term create category "Kegiatan MTQ" --description="Berbagai kegiatan dan acara MTQ Aceh Pidie Jaya" --slug="kegiatan-mtq"
wp term create category "Pengumuman" --description="Pengumuman resmi terkait MTQ dan kegiatan keagamaan" --slug="pengumuman"
wp term create category "Prestasi" --description="Pencapaian dan prestasi para peserta MTQ" --slug="prestasi"
wp term create category "Peserta" --description="Informasi tentang para peserta MTQ" --slug="peserta"
wp term create category "Jadwal" --description="Jadwal kegiatan dan perlombaan MTQ" --slug="jadwal"
wp term create category "Berita Terkini" --description="Berita terbaru seputar MTQ dan kegiatan keagamaan" --slug="berita-terkini"
wp term create category "Lomba" --description="Informasi tentang berbagai cabang lomba MTQ" --slug="lomba"
wp term create category "Galeri" --description="Dokumentasi foto dan video kegiatan MTQ" --slug="galeri"

# Create Tags
echo "🏷️ Membuat Tags..."
wp term create post_tag "mtq2024" --slug="mtq2024"
wp term create post_tag "mtq-aceh" --slug="mtq-aceh"
wp term create post_tag "pidie-jaya" --slug="pidie-jaya"
wp term create post_tag "quran" --slug="quran"
wp term create post_tag "tilawah" --slug="tilawah"
wp term create post_tag "hafalan" --slug="hafalan"
wp term create post_tag "tafsir" --slug="tafsir"
wp term create post_tag "kaligrafi" --slug="kaligrafi"
wp term create post_tag "adzan" --slug="adzan"
wp term create post_tag "qasidah" --slug="qasidah"
wp term create post_tag "prestasi" --slug="prestasi"
wp term create post_tag "juara" --slug="juara"
wp term create post_tag "peserta" --slug="peserta"
wp term create post_tag "lomba" --slug="lomba"
wp term create post_tag "kegiatan" --slug="kegiatan"
wp term create post_tag "acara" --slug="acara"
wp term create post_tag "islam" --slug="islam"
wp term create post_tag "keagamaan" --slug="keagamaan"
wp term create post_tag "masyarakat" --slug="masyarakat"
wp term create post_tag "budaya" --slug="budaya"
wp term create post_tag "tradisi" --slug="tradisi"
wp term create post_tag "kompetisi" --slug="kompetisi"
wp term create post_tag "festival" --slug="festival"
wp term create post_tag "ramadan" --slug="ramadan"
wp term create post_tag "syawal" --slug="syawal"
wp term create post_tag "muharram" --slug="muharram"
wp term create post_tag "rajab" --slug="rajab"
wp term create post_tag "ceramah" --slug="ceramah"
wp term create post_tag "dakwah" --slug="dakwah"
wp term create post_tag "ulama" --slug="ulama"
wp term create post_tag "santri" --slug="santri"
wp term create post_tag "mahasiswa" --slug="mahasiswa"
wp term create post_tag "pelajar" --slug="pelajar"
wp term create post_tag "dewasa" --slug="dewasa"
wp term create post_tag "remaja" --slug="remaja"
wp term create post_tag "anak-anak" --slug="anak-anak"
wp term create post_tag "putra" --slug="putra"
wp term create post_tag "putri" --slug="putri"
wp term create post_tag "suara-emas" --slug="suara-emas"
wp term create post_tag "merdu" --slug="merdu"
wp term create post_tag "indah" --slug="indah"

echo "✅ Selesai! Categories dan Tags telah dibuat."
echo "📊 Untuk melihat hasilnya:"
echo "   wp term list category"
echo "   wp term list post_tag"
