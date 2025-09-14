# Rekonfigurasi SSL dengan mkcert untuk Local Development

## Tanggal Rekonfigurasi
12 September 2025

## Langkah-langkah Rekonfigurasi SSL

### 1. Verifikasi Instalasi mkcert
```bash
which mkcert
mkcert -version
```

### 2. Periksa dan Install CA Lokal
```bash
mkcert -CAROOT
mkcert -install
```

### 3. Generate Ulang Sertifikat
```bash
mkdir -p /opt/homebrew/etc/nginx/ssl/mkcert
cd /opt/homebrew/etc/nginx/ssl/mkcert
mkcert mtq.pidiejayakab.go.id www.mtq.pidiejayakab.go.id
```

### 4. Verifikasi Konfigurasi Nginx
Memastikan konfigurasi Nginx menggunakan sertifikat yang benar:
- Certificate: `/opt/homebrew/etc/nginx/ssl/mkcert/mtq.pidiejayakab.go.id+1.pem`
- Private Key: `/opt/homebrew/etc/nginx/ssl/mkcert/mtq.pidiejayakab.go.id+1-key.pem`

### 5. Restart Layanan
```bash
brew services restart nginx
```

## Verifikasi

Setelah rekonfigurasi:
- Sertifikat diverifikasi dengan benar oleh OpenSSL (`Verify return code: 0 (ok)`)
- Tidak ada peringatan keamanan di browser
- Sertifikat valid sampai 12 Desember 2027

## Informasi Sertifikat

- Subject: O=mkcert development certificate
- Issuer: O=mkcert development CA
- Validity: Sampai 12 Desember 2027

## Troubleshooting

Jika mengalami masalah:
1. Pastikan `mkcert` terinstal: `brew install mkcert`
2. Pastikan CA terinstal: `mkcert -install`
3. Regenerate sertifikat jika perlu
4. Restart Nginx: `brew services restart nginx`