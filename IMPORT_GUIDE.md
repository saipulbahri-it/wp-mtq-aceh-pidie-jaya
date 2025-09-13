# 🎯 MTQ Gallery Import - Quick Guide

## ✅ Files Ready for Import

Sistem gallery MTQ sudah lengkap dan siap untuk import. Berikut adalah file-file yang bisa digunakan untuk mengimport dummy data gallery:

### 📁 Available Import Scripts

1. **`quick-import.php`** ⭐ (RECOMMENDED)
   - Script paling mudah dan cepat
   - Tidak perlu authentication khusus
   - Import 5 sample galleries dengan berbagai layout
   - URL: `http://your-domain.com/quick-import.php`

2. **`import-gallery.php`**
   - Import dengan media real dari folder `data/`
   - Lengkap dengan foto dan video asli
   - Membutuhkan permission admin
   - URL: `http://your-domain.com/import-gallery.php`

3. **`simple-import.php`**
   - Import basic tanpa authentication
   - Cocok untuk testing awal
   - URL: `http://your-domain.com/simple-import.php`

4. **`import-gallery-sql.sql`**
   - Direct SQL import ke database
   - Untuk user yang prefer database manual
   - Import via phpMyAdmin atau MySQL CLI

5. **`create-dummy-gallery.php`**
   - Generator dummy data paling lengkap
   - 10+ sample galleries dengan variasi
   - URL: `http://your-domain.com/create-dummy-gallery.php`

---

## 🚀 Cara Import (Step by Step)

### Option 1: Quick Import (Tercepat)
```bash
1. Buka: http://your-domain.com/quick-import.php
2. Tunggu proses selesai
3. Lihat hasilnya di WordPress Admin > Gallery
```

### Option 2: SQL Import (Manual)
```bash
1. Login ke phpMyAdmin
2. Pilih database WordPress
3. Import file: import-gallery-sql.sql
4. Refresh WordPress admin
```

### Option 3: Advanced Import
```bash
1. Pastikan folder data/ tersedia
2. Buka: http://your-domain.com/import-gallery.php
3. Klik "Import Gallery Data"
4. Tunggu proses selesai
```

---

## 📋 Yang Akan Diimport

### 🎨 Sample Galleries:
- **Dokumentasi Kegiatan MTQ** (Grid layout, 6 foto)
- **Video Rapat Koordinasi** (Grid layout, 1 video)
- **Pembukaan MTQ 2024** (Grid layout, 8 foto)
- **Lomba Tilawah Dewasa** (Grid layout, 10 foto)
- **Gallery Lengkap MTQ** (Slider layout, foto + video)

### 📂 Categories:
- Kegiatan MTQ
- Rapat Koordinasi
- Dokumentasi
- Pembukaan MTQ
- Lomba Dewasa

### 🏷️ Tags:
- mtq-2024
- aceh-pidie-jaya
- tilawah
- tahfidz
- rapat
- koordinasi

---

## 🔧 Setelah Import

### ✅ Verifikasi Import:
1. **Admin Panel**: Dashboard > Gallery
2. **Frontend**: `/gallery/` (archive page)
3. **Single Gallery**: Klik gallery individual

### 📝 Test Shortcodes:
```
[mtq_gallery_list] - Semua gallery
[mtq_gallery_list category="kegiatan-mtq"] - Gallery kegiatan
[mtq_gallery id="1"] - Gallery tertentu
```

### 🎪 Customize:
- Edit gallery di WordPress admin
- Upload foto/video real
- Sesuaikan layout dan settings
- Tambah categories/tags baru

---

## 🆘 Troubleshooting

### Import Gagal?
- Pastikan theme MTQ aktif
- Check file permissions
- Lihat error log WordPress

### Gallery Tidak Muncul?
- Refresh permalinks: Settings > Permalinks > Save
- Clear cache jika ada
- Check shortcode syntax

### Media Tidak Tampil?
- Upload gambar real via WordPress admin
- Check folder data/ permissions
- Pastikan URL video valid

---

## 📞 Ready to Import!

Pilih salah satu script import di atas dan jalankan. Gallery system MTQ sudah siap menampung **foto dan video kegiatan MTQ** Anda!

**Recommended**: Mulai dengan `quick-import.php` untuk testing awal. 🚀
