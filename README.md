# WordPress MTQ Aceh Pidie Jaya

Website resmi Musabaqah Tilawatil Quran (MTQ) Kabupaten Pidie Jaya, Aceh.

## Deskripsi

Proyek ini adalah website WordPress untuk Musabaqah Tilawatil Quran (MTQ) Kabupaten Pidie Jaya. Website ini bertujuan untuk menyediakan informasi terkini seputar kegiatan MTQ, berita, jadwal, hasil pertandingan, dan informasi lainnya kepada masyarakat.

## Teknologi yang Digunakan

- **WordPress 6.8.2** - Sistem manajemen konten
- **Nginx** - Web server
- **PHP 8.3** - Interpreter bahasa pemrograman
- **Self-signed SSL Certificate** - Untuk koneksi HTTPS di lingkungan pengembangan

## Konfigurasi Lokal

### Prasyarat

- Sistem operasi macOS
- Homebrew (package manager)
- Nginx
- PHP 8.3
- WordPress 6.8.2

### Instalasi

1. **Clone repository**

   ```bash
   git clone <repository-url>
   cd wp-mtq-aceh-pidie-jaya
   ```

2. **Instalasi dependensi menggunakan Homebrew**

   ```bash
   brew install nginx php@8.3
   ```

3. **Memulai layanan**
   ```bash
   brew services start nginx
   brew services start php@8.3
   ```

### Konfigurasi Nginx

File konfigurasi Nginx terletak di:

```
/opt/homebrew/etc/nginx/sites-available/mtq.pidiejayakab.go.id
```

Konfigurasi mencakup:

- Server block untuk domain `mtq.pidiejayakab.go.id`
- Redirect HTTP ke HTTPS
- SSL dengan sertifikat self-signed
- Integrasi PHP-FPM
- Aturan khusus WordPress

### Konfigurasi SSL

Sertifikat SSL self-signed dibuat untuk pengembangan lokal:

- Certificate: `/opt/homebrew/etc/nginx/ssl/mtq.pidiejayakab.go.id.crt`
- Private Key: `/opt/homebrew/etc/nginx/ssl/mtq.pidiejayakab.go.id.key`

Sertifikat telah ditambahkan ke keychain pengguna untuk menghindari peringatan browser.

### Akses Website

Website dapat diakses melalui:

- URL: https://mtq.pidiejayakab.go.id/
- Alamat IP lokal: https://127.0.0.1/

### Konfigurasi Hosts

Entri berikut telah ditambahkan ke file `/etc/hosts`:

```
127.0.0.1 mtq.pidiejayakab.go.id
```

## Struktur Direktori

```
wp-mtq-aceh-pidie-jaya/
├── wp-admin/           # Admin panel WordPress
├── wp-content/         # Tema, plugin, dan media
├── wp-includes/        # File inti WordPress
├── index.php           # File index utama
└── ...                 # File konfigurasi WordPress lainnya
```

## Pengembangan

### Menjalankan Server

Untuk memulai server:

```bash
brew services start nginx
brew services start php@8.3
```

Untuk merestart server:

```bash
brew services restart nginx
brew services restart php@8.3
```

### Testing

Untuk menguji koneksi:

```bash
curl -I https://mtq.pidiejayakab.go.id/
```

## Troubleshooting

### Masalah SSL

Jika terjadi masalah dengan sertifikat SSL:

1. Pastikan sertifikat telah ditambahkan ke keychain
2. Restart layanan Nginx
3. Clear cache browser

### Masalah PHP

Jika PHP tidak merespon:

1. Periksa status layanan PHP: `brew services list | grep php`
2. Restart layanan PHP: `brew services restart php@8.3`

### Masalah Nginx

Jika Nginx tidak merespon:

1. Periksa konfigurasi: `nginx -t`
2. Periksa log error: `tail -f /opt/homebrew/var/log/nginx/error.log`
3. Restart layanan: `brew services restart nginx`

## Kontribusi

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

## Kontak

Dikembangkan oleh: DISKOMINFOTIK PIDIE JAYA - Dinas Komunikasi dan Informatika, Statistik dan Persandian

BERANDA
Email: -

## Lisensi

Proyek ini dikembangkan khusus untuk Pemerintah Kabupaten Pidie Jaya.
