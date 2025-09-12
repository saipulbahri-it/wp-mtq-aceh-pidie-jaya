# MTQ Countdown Show/Hide Configuration

## 📋 Overview
Fitur ini memungkinkan admin untuk mengontrol tampilan elemen-elemen countdown di halaman utama website MTQ Aceh Pidie Jaya.

## 🛠️ Pengaturan Admin

### Akses Pengaturan
1. Login ke WordPress Admin Dashboard
2. Buka **Appearance** → **Countdown MTQ**
3. Atur pengaturan sesuai kebutuhan

### Opsi Pengaturan

#### 1. **Status Countdown**
- **Aktif**: Menampilkan countdown yang berjalan
- **Dijeda**: Menampilkan pesan bahwa countdown dijeda sementara
- **Selesai**: Menampilkan pesan acara telah selesai
- **Sembunyikan**: Menyembunyikan seluruh bagian countdown

#### 2. **Pengaturan Tampilan**
- ✅ **Tampilkan Judul Acara**: Menampilkan/menyembunyikan judul acara di atas countdown
- ✅ **Tampilkan Tanggal & Waktu**: Menampilkan/menyembunyikan informasi tanggal dan waktu acara
- ✅ **Tampilkan Lokasi**: Menampilkan/menyembunyikan informasi lokasi penyelenggaraan

#### 3. **Konfigurasi Event**
- **Tanggal & Waktu Acara**: Atur kapan acara dimulai
- **Judul Acara**: Teks judul yang akan ditampilkan
- **Lokasi Acara**: Informasi lokasi penyelenggaraan

## 🎨 Contoh Tampilan

### Lengkap (Semua Ditampilkan)
```
MTQ Aceh XXXVII Pidie Jaya 2025
📅 01 November 2025, 07:00 • 📍 Kabupaten Pidie Jaya, Aceh

[120] [15] [30] [45]
 Hari   Jam  Menit Detik
```

### Hanya Countdown (Judul & Detail Disembunyikan)
```
[120] [15] [30] [45]
 Hari   Jam  Menit Detik
```

### Hanya Judul & Countdown (Tanggal/Lokasi Disembunyikan)
```
MTQ Aceh XXXVII Pidie Jaya 2025

[120] [15] [30] [45]
 Hari   Jam  Menit Detik
```

## 💻 Implementation Details

### Front-end Integration
Pengaturan ini bekerja dengan:

1. **PHP Conditional Display** - `front-page.php` membaca setting dan menampilkan elemen sesuai konfigurasi
2. **CSS Body Classes** - Menambahkan class ke body untuk kontrol styling
3. **Real-time Preview** - Admin dapat melihat preview langsung saat mengubah pengaturan

### CSS Classes Generated
```css
body.hide-countdown-title .countdown-title { display: none; }
body.hide-countdown-date .countdown-date { display: none; }
body.hide-countdown-location .countdown-location { display: none; }
```

### Database Options
```php
// Setting yang disimpan di wp_options
mtq_show_title     // boolean - default: true
mtq_show_date      // boolean - default: true  
mtq_show_location  // boolean - default: true
mtq_countdown_status   // string - default: 'active'
mtq_event_date         // string - default: '2025-11-01T07:00:00'
mtq_event_title        // string - default: 'MTQ Aceh XXXVII Pidie Jaya 2025'
mtq_event_location     // string - default: 'Kabupaten Pidie Jaya, Aceh'
```

## 🔄 AJAX Preview
Fitur live preview menggunakan AJAX endpoint:
- **Action**: `mtq_update_countdown_preview`
- **Nonce**: `mtq_countdown_nonce`
- **Parameters**: `event_date`, `event_title`, `event_location`, `status`, `show_title`, `show_date`, `show_location`

## 📱 Responsive Design
Pengaturan show/hide bekerja konsisten di semua ukuran layar:
- Desktop (1024px+)
- Tablet (768px - 1023px)  
- Mobile (< 768px)

## 🎯 Use Cases

### Fase Persiapan
- Tampilkan semua informasi untuk memberikan detail lengkap
- Gunakan status "Aktif" dengan countdown berjalan

### Fase Acara
- Ubah status ke "Selesai" atau "Dijeda" sesuai kondisi
- Pertahankan informasi judul dan lokasi untuk referensi

### Post-Event
- Status "Selesai" dengan pesan terima kasih
- Bisa sembunyikan detail tanggal jika tidak relevan lagi

## 🔧 Troubleshooting

### Pengaturan Tidak Tersimpan
1. Pastikan user memiliki capability `manage_options`
2. Cek apakah ada plugin yang conflict dengan WordPress options
3. Verify nonce security pada form submission

### Preview Tidak Update
1. Pastikan jQuery loaded di admin page
2. Cek console browser untuk JavaScript errors
3. Verify AJAX endpoint accessible

### CSS Tidak Bekerja
1. Pastikan `countdown-display.css` ter-enqueue dengan benar
2. Cek apakah body classes ter-generate dengan benar
3. Clear cache jika menggunakan caching plugin

## 🚀 Future Enhancements
- [ ] Visual countdown style presets
- [ ] Multiple event countdown support  
- [ ] Email notifications for countdown milestones
- [ ] Social sharing integration for countdown
- [ ] Countdown widget for sidebar
- [ ] Shortcode support untuk halaman lain
