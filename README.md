# 🕌 MTQ Aceh Pidie Jaya WordPress Theme

> **Premium WordPress Theme untuk Musabaqah Tilawatil Quran (MTQ) dan Event Islamic**

![MTQ Aceh Pidie Jaya](https://mtq.pidiejayakab.go.id/wp-content/themes/mtq-aceh-pidie-jaya/screenshot.png)

[![WordPress](https://img.shields.io/badge/WordPress-5.0%2B-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://php.net/)
[![License](https://img.shields.io/badge/License-GPL%20v2%2B-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![Version](https://img.shields.io/badge/Version-1.0.0-orange.svg)](https://github.com/saipulbahri-it/mtq-aceh-pidie-jaya-theme/releases)

## � **Quick Download (For WordPress Users)**

### **🎯 Install Theme Only:**
1. **[📦 Download Latest Theme](https://github.com/saipulbahri-it/mtq-aceh-pidie-jaya-theme/releases/download/v1.0.0/mtq-aceh-pidie-jaya-theme-v1.0.0.zip)** (~12MB)
2. **Upload**: WordPress Admin → `Appearance` → `Themes` → `Add New` → `Upload Theme`
3. **Activate** the theme
4. **Follow**: [📚 Installation Guide](https://github.com/saipulbahri-it/mtq-aceh-pidie-jaya-theme/blob/main/README.md)

### **🔧 For Developers:**
```bash
# Clone main repository (full WordPress)
git clone https://github.com/saipulbahri-it/wp-mtq-aceh-pidie-jaya.git
cd wp-mtq-aceh-pidie-jaya

# OR clone theme only
git clone https://github.com/saipulbahri-it/mtq-aceh-pidie-jaya-theme.git
cd mtq-aceh-pidie-jaya-theme

# Install dependencies & build
npm install && npm run build

# Start development
npm run dev
```

---

## 📋 **Tentang Tema**

Website dan tema khusus untuk event MTQ (Musabaqah Tilawatil Quran) ke-37 tingkat Aceh yang diselenggarakan di Kabupaten Pidie Jaya tahun 2025. Tema ini dirancang khusus untuk event Islamic, competition, dan website pemerintahan dengan fitur lengkap dan keamanan tingkat tinggi.

## ✨ **Fitur Tema**

### 🎯 **Core Features**
- **🏠 Homepage Dinamis** dengan countdown timer dan live updates
- **📰 Sistem Berita** untuk pengumuman dan update terkini  
- **🖼️ Gallery Multimedia** untuk foto dan video dokumentasi
- **🏟️ Arena & Lokasi** dengan informasi detail venue dan maps
- **📺 Live Streaming** integration untuk siaran langsung
- **📱 Social Sharing** (WhatsApp, Facebook, Twitter)

### � **Security Features**
- **🛡️ ABSPATH Protection** pada semua file PHP
- **🔐 Server-level Security** dengan .htaccess headers
- **🚫 XSS & Clickjacking Protection**
- **🔒 Direct Access Prevention**
- **✅ WordPress Security Standards** compliant

### 🎨 **Design Features**
- **📱 Mobile-First Responsive** design
- **🕌 Islamic-themed Styling** dengan government branding
- **🎨 Modern Gradient Backgrounds** 
- **👆 Touch-friendly Interface** untuk mobile
- **🌍 Arabic Typography Support**
- **⚡ Smooth Animations** dan hover effects

## 🚀 **Quick Start**

### **📦 Untuk Pengguna WordPress:**

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
