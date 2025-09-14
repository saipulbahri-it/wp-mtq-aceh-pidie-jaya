# 🚀 Template-only Release Workflow

Panduan singkat untuk merilis tema WordPress (template only) dari repo ini. Proses ini tidak menyentuh core WordPress atau plugin, hanya folder theme: `wp-content/themes/mtq-aceh-pidie-jaya`.

## ✅ Prasyarat
- Git terkonfigurasi dan working tree bersih
- Node.js + npm terinstal
- GitHub CLI (gh) login: `gh auth login`
- Akses push ke branch `main`

## 🧱 Struktur yang terkait
- Script: `scripts/release-theme.sh`
- Theme: `wp-content/themes/mtq-aceh-pidie-jaya`
- Aset build: `wp-content/themes/mtq-aceh-pidie-jaya/dist/app.css`
- Release notes: `RELEASE_NOTES.md`

## 🔍 Dry-run (simulasi)
Menjalankan seluruh langkah tanpa menulis perubahan, tag, atau release.

```bash
bash scripts/release-theme.sh 1.0.1 --dry-run --no-release --no-tag
```

Apa yang disimulasikan:
- Bump `style.css` (Version) dan `package.json` (version)
- Build aset (`npm ci`, `npm run build`)
- Pembuatan ZIP `mtq-aceh-pidie-jaya-theme-v1.0.1.zip`
- Commit bump, tag, release — DISKIP saat dry-run

## 📦 Rilis nyata
Jalankan tanpa flag dry-run untuk menulis perubahan, membuat tag, dan GitHub Release.

```bash
# Contoh rilis patch 1.0.1
bash scripts/release-theme.sh 1.0.1
```

Langkah otomatis yang dilakukan:
1) Validasi working tree bersih
2) Update versi di `style.css` dan `package.json`
3) Build CSS produksi (`npm ci && npm run build`)
4) Membuat ZIP bersih: `mtq-aceh-pidie-jaya-theme-v<versi>.zip`
5) Commit "chore(release): bump theme version to v<versi>"
6) Tag git `v<versi>` dan push ke origin
7) GitHub Release `v<versi>` plus lampiran ZIP dan `RELEASE_NOTES.md`

Opsi:
- `--no-tag`       → Lewati pembuatan tag
- `--no-release`   → Lewati GitHub Release
- `--dry-run`      → Simulasi tanpa menulis perubahan

## 🗂️ Isi paket ZIP
- Semua file tema (PHP, template-parts, inc, assets, js)
- `dist/app.css` hasil build
- Tidak menyertakan file pengembangan: `node_modules`, `.git*`, `postcss.config.js`, `tailwind.config.js`, `package*.json`, dll.

## 🚀 Deploy ke produksi
- WP Admin: Appearance → Themes → Add New → Upload ZIP → Install → Activate
- WP-CLI: `wp theme install /path/mtq-aceh-pidie-jaya-theme-vX.Y.Z.zip --force && wp theme activate mtq-aceh-pidie-jaya`

## 🔄 Rollback
- Simpan ZIP versi sebelumnya
- WP-CLI cepat: `wp theme install /path/mtq-aceh-pidie-jaya-theme-vPrev.zip --force`

## 🧪 Checklist pasca-rilis (smoke test)
- Halaman utama, berita, galeri, arena & lokasi terbuka normal
- Tidak ada error PHP di error log
- Tidak ada error JS di console
- Header/footer, menu, dan customizer tetap sesuai

## 🛠️ Troubleshooting
- `gh: command not found` → install GitHub CLI dan login `gh auth login`
- Sed in-place di macOS → script sudah fallback ke `sed` jika `gsed` tidak ada
- Working tree tidak bersih → commit/stash dulu sebelum rilis
- CSS tidak terupdate → pastikan build sukses dan `dist/app.css` ada di ZIP

---
Dokumen ini melengkapi: `DEPLOYMENT_CHECKLIST.md` dan `WORDPRESS_DISTRIBUTION_GUIDE.md`.
