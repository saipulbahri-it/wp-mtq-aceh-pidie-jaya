# Changelog

## [Unreleased]

### Added
- **Kustomisasi Footer**
  - Implementasi fitur kustomisasi footer melalui WordPress Customizer
  - Logo footer yang dapat disesuaikan
  - Teks footer yang dapat diedit
  - Pengaturan alamat, email, dan nomor telepon
  - Link media sosial (Facebook, Instagram, YouTube, Twitter)
  - Template part baru untuk footer dengan tampilan yang lebih terorganisir
  - Dukungan live preview untuk pengaturan footer di Customizer
  - Tampilan footer yang responsif dengan grid system

- **Peta Lokasi**
  - Menambahkan customizer untuk peta lokasi event MTQ
  - Pengaturan URL embed Google Maps
  - Pengaturan tinggi peta yang dapat disesuaikan
  - Judul dan deskripsi lokasi yang dapat diedit
  - Template part baru untuk menampilkan peta
  - Live preview untuk semua pengaturan peta
  - Tampilan responsif dengan desain modern

### Added
- **Kategori Lomba**
  - Menambahkan kategori baru: Qiraah Sab'ah, KTIQ, dan Tartil
  - Membuat fungsi helper `mtq_get_cabang_lomba()` untuk mengelola data kategori
  - Menambahkan ikon dan warna yang unik untuk setiap kategori
  - Menambahkan deskripsi untuk setiap kategori lomba

### Changed
- **Restrukturisasi Kode**
  - Memindahkan logika kategori lomba ke file terpisah `inc/cabang-lomba.php`
  - Membuat template part baru `template-parts/cabang-lomba.php`
  - Merapikan struktur kode di `front-page.php`
  - Menyeragamkan penulisan "Qur'an" di semua kategori

### Fixed
- **Bug Fixes**
  - Menghapus duplikasi include `customizer.php` di `functions.php`
  - Memperbaiki error "Cannot redeclare mtq_aceh_pidie_jaya_customize_register()"
  - Mengoptimalkan loading theme files

## update-menu (2025-09-10)

- Register menu `top-header-menu` di functions.php untuk navigasi dinamis.
- Update fallback menu di header.php: semua link menggunakan home URL + hash, kecuali "Arena & Lokasi" ke permalink.
- Tambah pengaturan Customizer untuk Link Terkait di footer (label & URL bisa diedit dari admin).
- Default link Link Terkait tetap muncul jika Customizer belum diisi.
- Footer otomatis menampilkan link dari Customizer atau default.

### Technical Details

#### Struktur File Baru
```
wp-content/themes/mtq-aceh-pidie-jaya/
├── inc/
│   └── cabang-lomba.php         # Helper functions untuk kategori lomba
├── template-parts/
│   └── cabang-lomba.php         # Template untuk tampilan kategori lomba
```

#### Daftar Kategori Lomba
1. Tilawah Al-Qur'an
2. Tahfizh Al-Qur'an
3. Tafsir Al-Qur'an
4. Khattil Qur'an
5. Fahmil Qur'an
6. Syarhil Qur'an
7. Qiraah Sab'ah
8. KTIQ
9. Tartil

#### Fitur UI/UX
- Layout responsif dengan grid system
  - Mobile: 1 kolom
  - Tablet: 2 kolom
  - Desktop: 3 kolom
- Animasi dan transisi
  - Hover effect pada kartu kategori
  - Fade-in animation saat scroll
  - Smooth transitions
- Konsistensi desain
  - Warna yang sesuai dengan tema
  - Tipografi yang konsisten
  - Spacing yang seragam

#### Internationalization
- Semua string menggunakan fungsi translasi WordPress
- Text domain: 'mtq-aceh-pidie-jaya'
- Mendukung multi-bahasa

### Pengujian
- [x] Verifikasi tidak ada error redeclaration function
- [x] Cek tampilan responsive di berbagai device
- [x] Memastikan semua kategori lomba tampil dengan benar
- [x] Verifikasi konsistensi penulisan "Qur'an"
- [x] Cek fungsi customizer tetap berjalan normal
- [x] Validasi animasi dan transisi berjalan smooth

### Catatan Pengembangan Selanjutnya
1. Tambahkan halaman detail untuk setiap kategori lomba
2. Implementasikan filter dan pencarian kategori
3. Tambahkan informasi peserta per kategori
4. Integrasi dengan sistem pendaftaran
5. Tambahkan galeri foto/video per kategori

### Referensi
- [WordPress Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)
