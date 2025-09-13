# 🕌 M## 📋 **Deskripsi**

Website resmi untuk event MTQ (Musabaqah Tilawatil Quran) ke-37 tingkat Aceh yang diselenggarakan di Kabupaten Pidie Jaya tahun 2025. Website ini menyediakan informasi lengkap tentang kompetisi, peserta, jadwal, hasil, dan dokumentasi kegiatan.

## 📁 **Repository Structure**

```
wp-mtq-aceh-pidie-jaya/
├── 📄 README.md              # Project documentation
├── 📄 CHANGELOG.md           # Version history
├── 📄 THEME_DEVELOPMENT_PLAN.md  # Development roadmap
├── 📄 DEPLOYMENT_GUIDE.md    # Deployment instructions
├── 📦 package.json           # Node.js dependencies
├── 🎨 tailwind.config.js     # Tailwind CSS configuration
├── 📂 wp-content/themes/mtq-aceh-pidie-jaya/  # Main theme
├── 📂 scripts/               # Development scripts
├── 📂 docs/                  # Additional documentation
└── 📂 archive/               # Archived files and documentation
```aya 2025

> **Musabaqah Tilawatil Quran (MTQ) ke-37 Aceh di Kabupaten Pidie Jaya**

![MTQ Aceh Pidie Jaya](https://mtq.pidiejayakab.go.id/wp-content/themes/mtq-aceh-pidie-jaya/screenshot.png)

## � **Repository Structure**

```
wp-mtq-aceh-pidie-jaya/
├── 📄 README.md              # Project documentation
├── 📄 CHANGELOG.md           # Version history
├── 📄 THEME_DEVELOPMENT_PLAN.md  # Development roadmap
├── 📄 DEPLOYMENT_GUIDE.md    # Deployment instructions
├── 📦 package.json           # Node.js dependencies
├── 🎨 tailwind.config.js     # Tailwind CSS configuration
├── 📂 wp-content/themes/mtq-aceh-pidie-jaya/  # Main theme
├── 📂 scripts/               # Development scripts
├── 📂 docs/                  # Additional documentation
└── 📂 archive/               # Archived files and documentation
```

## ✨ **Fitur Utama**

### 🎯 **Core Features**
- **Homepage Dinamis** dengan countdown timer dan live updates
- **Sistem Berita** untuk pengumuman dan update terkini
- **Gallery Multimedia** untuk foto dan video dokumentasi
- **Arena & Lokasi** dengan informasi detail venue
- **Live Streaming** integration untuk siaran langsung
- **Social Media** integration dan sharing

### 🛠️ **Technical Features**
- **Responsive Design** - Mobile-first approach
- **Performance Optimized** - Fast loading dengan caching
- **SEO Friendly** - Meta tags dan structured data
- **Security Enhanced** - Input validation dan sanitization
- **Admin Dashboard** - Custom post types dan meta boxes

## 🚀 **Quick Start**

### **Untuk Pengembang:**

```bash
# Clone repository
git clone https://github.com/saipulbahri-it/wp-mtq-aceh-pidie-jaya.git
cd wp-mtq-aceh-pidie-jaya

# Install dependencies
npm install

# Development mode
npm run dev

# Production build
npm run build
```

### **Untuk Admin:**

1. **Access Admin Panel:** `https://mtq.pidiejayakab.go.id/wp-admin`
2. **Buat Berita Baru:** Gallery MTQ → Add New Gallery
3. **Upload Media:** Media → Add New
4. **Kelola Gallery:** Gallery MTQ → All Galleries

## 📁 **Struktur Proyek**

```
wp-mtq-aceh-pidie-jaya/
├── wp-content/themes/mtq-aceh-pidie-jaya/   # Theme utama
│   ├── inc/                                  # Custom functionality
│   ├── template-parts/                       # Template components
│   ├── assets/                              # Source CSS/JS
│   └── dist/                                # Compiled assets
├── scripts/                                 # Utility scripts
│   └── gallery-import/                      # Gallery import tools
├── docs/                                    # Dokumentasi
└── data/                                    # Sample data
```

## 🔧 **Instalasi & Deployment**

### **Development Setup:**

1. **WordPress Requirements:**
   - PHP 7.4+
   - MySQL 5.7+
   - WordPress 5.8+

2. **Theme Installation:**
   ```bash
   # Navigate to WordPress themes directory
   cd wp-content/themes/
   
   # Activate theme via WP Admin
   # Appearance → Themes → MTQ Aceh Pidie Jaya → Activate
   ```

3. **Dependencies:**
   ```bash
   # Install Node.js dependencies
   npm install
   
   # Build assets
   npm run build
   ```

### **Production Deployment:**

Lihat [DEPLOYMENT_GUIDE.md](./DEPLOYMENT_GUIDE.md) untuk panduan lengkap.

## 📚 **Dokumentasi**

### **User Guides:**
- [Gallery System](./docs/GALLERY_SYSTEM_DOCUMENTATION.md) - Panduan lengkap sistem gallery
- [Import Guide](./IMPORT_GUIDE.md) - Cara import data gallery
- [Admin Panel](./docs/GALLERY_ADMIN_PANEL_FIX.md) - Troubleshooting admin panel

### **Technical Docs:**
- [Theme Development](./THEME_DEVELOPMENT_PLAN.md) - Rencana pengembangan theme
- [Deployment Guide](./DEPLOYMENT_GUIDE.md) - Panduan deployment
- [Changelog](./docs/CHANGELOG.md) - Riwayat perubahan

### **Troubleshooting:**
- [Gallery Issues](./docs/GALLERY_FIX_SOLUTION.md) - Solusi masalah gallery
- [Live Server Fix](./docs/LIVE_SERVER_GALLERY_FIX.md) - Perbaikan server live

## 🎨 **Gallery System**

### **Features:**
- ✅ **Multi-media Support** - Foto dan video
- ✅ **Kategorisasi** - Organized by categories dan tags  
- ✅ **Responsive Gallery** - Grid, slider, dan masonry layouts
- ✅ **Lightbox Modal** - Full-screen viewing experience
- ✅ **Admin Interface** - Drag & drop upload
- ✅ **Shortcode Support** - Easy embedding

### **Usage:**
```php
// Display gallery grid
[mtq_gallery category="pembukaan" limit="12"]

// Display gallery slider  
[mtq_gallery layout="slider" category="lomba"]

// List all galleries
[mtq_gallery_list limit="6"]
```

## 🛡️ **Security & Performance**

- **Input Validation** - Semua input di-sanitize
- **CSRF Protection** - Nonce verification  
- **XSS Prevention** - Output escaping
- **Image Optimization** - Automatic compression
- **Caching Support** - Compatible dengan caching plugins
- **CDN Ready** - Asset optimization

## 🌐 **Browser Support**

- ✅ Chrome 80+
- ✅ Firefox 75+
- ✅ Safari 13+
- ✅ Edge 80+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## 🤝 **Contributing**

Kontribusi sangat diterima! Silakan:

1. Fork repository ini
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 **License**

Distributed under the GPL v2 License. See `license.txt` for more information.

## 👥 **Team**

- **Developer:** Saipul Bahri IT
- **Client:** Pemerintah Kabupaten Pidie Jaya
- **Event:** MTQ Aceh XXXVII Pidie Jaya 2025

## 📞 **Support**

- **Website:** https://mtq.pidiejayakab.go.id
- **Issues:** [GitHub Issues](https://github.com/saipulbahri-it/wp-mtq-aceh-pidie-jaya/issues)
- **Documentation:** [Project Docs](./docs/)

---

**🕌 Pidie Jaya - Bumi Pejuang Meumakmu**
