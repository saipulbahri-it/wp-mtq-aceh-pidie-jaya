# Workflow Pengembangan

Dokumen ini mendefinisikan alur kerja (workflow) pengembangan untuk repository `wp-mtq-aceh-pidie-jaya` agar konsisten, mudah ditinjau, dan siap rilis.

## Cabang (Branches)

- `main`
  - Cabang produksi (stabil). Hanya menerima merge dari `dev` saat rilis.
  - Proteksi disarankan: require PR, review, dan status checks (opsional).

- `dev`
  - Cabang integrasi pengembangan. Semua fitur/hotfix non-produksi di-merge ke sini dulu.
  - QA/UAT bisa dilakukan terhadap cabang ini.

- `feature/*`
  - Untuk pengembangan fitur baru.
  - Nama contoh: `feature/gallery-masonry`, `feature/csp-headers`, `feature/youtube-api`.

- `fix/*` atau `hotfix/*`
  - Untuk perbaikan bug kecil/urgent.
  - `hotfix/*` yang kritikal bisa ditargetkan langsung ke `main` (lalu back-merge ke `dev`).

## Alur Kerja Harian

1. Mulai dari `dev` terbaru
   ```zsh
   git fetch origin
   git switch dev
   git pull --ff-only origin dev
   ```
2. Buat branch fitur dari `dev`
   ```zsh
   git switch -c feature/nama-fitur
   ```
3. Commit kecil, jelas, dan terstruktur
   - Gunakan pesan commit Bahasa Indonesia yang ringkas dan deskriptif.
   - Contoh: `feat(gallery): tambah layout masonry dan enqueue library`.
4. Push dan buka PR ke `dev`
   ```zsh
   git push -u origin feature/nama-fitur
   ```
   - Buka PR ke `dev`, isi template PR, sertakan cara uji.
5. Review & merge
   - Minimal 1 review (atau sesuai kebijakan).
   - Squash merge atau merge biasa sesuai preferensi tim.

## Rilis ke Produksi

1. Pastikan `dev` stabil dan lulus QA
2. Buat PR dari `dev` ke `main`
3. Setelah merge, buat tag rilis (opsional):
   ```zsh
   git checkout main
   git pull --ff-only origin main
   git tag -a v1.0.1 -m "Rilis 1.0.1: ringkasan perubahan"
   git push origin v1.0.1
   ```
4. Siapkan paket distribusi theme bila diperlukan (lihat `scripts/release-theme.sh`).

## Pedoman Commit Message

- Format disarankan (opsional):
  - `feat(scope): deskripsi` untuk fitur
  - `fix(scope): deskripsi` untuk perbaikan bug
  - `chore(scope): deskripsi` untuk perubahan non-fungsional (docs, tooling)
  - `refactor(scope): deskripsi` untuk refaktor
  - `docs(scope): deskripsi` untuk dokumentasi
- Contoh:
  - `fix(ajax): escape URL pada output load more` 
  - `docs(workflow): tambahkan panduan rilis`

## Pull Request Checklist

- [ ] Judul PR jelas dan deskriptif
- [ ] Ringkasan perubahan ditulis singkat
- [ ] Cara uji dijelaskan (langkah konkret)
- [ ] Perubahan aman untuk rollback (jika perlu)
- [ ] Tidak ada credential/secret yang ter-commit

## QA/UAT Checklist (Contoh)

- [ ] Build CSS/JS sukses (`npm run build` bila perlu)
- [ ] Halaman utama dan halaman berita tidak error di console
- [ ] Fitur yang diubah diuji di halaman terkait (Gallery/YouTube Live/Social Sharing)
- [ ] Tidak ada regresi tampilan mayor (header/footer/responsive)

## Hotfix

- Bila mendesak ke produksi:
  - Buat branch `hotfix/*` dari `main`
  - Setelah merge ke `main`, back-merge ke `dev` agar tidak divergen

---

Dokumen ini dapat diperbarui sesuai kebutuhan tim. Pastikan semua kontributor membaca dan mengikuti workflow ini untuk memudahkan kolaborasi dan rilis yang tertib.
