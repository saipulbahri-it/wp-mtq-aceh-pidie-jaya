# 📖 User Manual - MTQ Aceh Pidie Jaya WordPress Theme

## 👋 **Welcome to MTQ Aceh Pidie Jaya Theme**

Panduan lengkap penggunaan tema WordPress untuk website resmi MTQ (Musabaqah Tilawatil Quran) ke-37 tingkat Aceh di Kabupaten Pidie Jaya.

## 🚀 **Quick Start Guide**

### **Step 1: Installation**
1. Download theme dari [GitHub Releases](https://github.com/saipulbahri-it/mtq-aceh-pidie-jaya-theme/releases)
2. Login ke WordPress Admin → `Appearance` → `Themes` → `Add New`
3. Click `Upload Theme` dan pilih file ZIP theme
4. Click `Install Now` → `Activate`

### **Step 2: Basic Configuration**
1. Go to `Appearance` → `Customize`
2. Configure `Site Identity` (logo, title, tagline)
3. Set up `Menus` untuk navigation
4. Configure `Homepage Settings`

### **Step 3: Content Setup**
1. Create essential pages (Home, Berita, Galeri, Arena & Lokasi)
2. Set up menu locations
3. Add initial content dan media

## 🎨 **Theme Customization**

### **🎯 WordPress Customizer Options**

#### **Site Identity**
```
Appearance → Customize → Site Identity
├── Site Title: "MTQ Aceh Pidie Jaya 2025"
├── Tagline: "Musabaqah Tilawatil Quran ke-37 Aceh"
├── Site Logo: Upload official MTQ logo
└── Site Icon: Upload favicon (32x32px)
```

#### **Colors & Styling**
```
Appearance → Customize → Colors
├── Primary Color: #2D5A2D (Islamic Green)
├── Secondary Color: #FFD700 (Gold Accent)
├── Background Color: #F8F9FA (Light Gray)
└── Text Color: #212529 (Dark Gray)
```

#### **Menus Configuration**
```
Appearance → Customize → Menus
├── Header Menu: Main navigation
├── Footer Menu: Footer links
└── Social Menu: Social media links
```

### **🛠️ MTQ-Specific Settings**

#### **Event Configuration**
```
WordPress Admin → Settings → MTQ Configuration
├── Event Date: Set countdown target date
├── Event Location: Venue address
├── Event Description: Brief event overview
└── Registration Status: Open/Closed
```

#### **YouTube Live Settings**
```
WordPress Admin → Settings → YouTube Live
├── Stream URL: YouTube live stream link
├── Show Live: Enable/disable live section
├── Stream Title: Live stream title
└── Stream Description: Brief description
```

## 📄 **Page Templates & Usage**

### **🏠 Homepage (Front Page)**
- **Template**: `front-page.php`
- **Features**: Hero section, countdown timer, latest news, gallery preview
- **Configuration**: Set as static front page in `Settings` → `Reading`

#### **Homepage Sections Configuration**
1. **Hero Section**: Configure in Customizer → Hero Settings
2. **Countdown Timer**: Auto-calculates from event date
3. **Latest News**: Automatically displays recent posts
4. **Gallery Preview**: Shows recent gallery items

### **📰 News/Berita Page**
- **Template**: `page-berita.php`
- **Purpose**: Display all news posts with pagination
- **Usage**: Create page with slug `berita`

#### **Creating News Posts**
```
WordPress Admin → Posts → Add New
├── Title: News headline
├── Content: Full news article
├── Featured Image: News thumbnail
├── Categories: Assign relevant categories
└── Tags: Add relevant tags
```

### **🖼️ Gallery Page**
- **Template**: `archive-mtq_gallery.php`
- **Purpose**: Display photo/video galleries
- **Custom Post Type**: `mtq_gallery`

#### **Creating Gallery Items**
```
WordPress Admin → MTQ Gallery → Add New
├── Title: Gallery item title
├── Content: Description
├── Gallery Type: Photo/Video
├── Media Files: Upload images/videos
└── Date: Event date
```

### **📍 Arena & Location Page**
- **Template**: `page-arena-dan-lokasi.php`
- **Purpose**: Venue information with interactive maps
- **Usage**: Create page with slug `arena-dan-lokasi`

#### **Location Configuration**
```
Page Edit → Location Settings
├── Venue Name: Official venue name
├── Address: Complete address
├── Coordinates: Latitude, Longitude
├── Facilities: List of available facilities
└── Contact Info: Phone, email
```

## 🎛️ **Admin Dashboard Features**

### **📊 MTQ Dashboard Widget**
- **Location**: WordPress Admin Dashboard
- **Features**: Quick stats, recent activities, important announcements
- **Access**: Automatic for admin users

### **🎨 Theme Options Panel**
```
WordPress Admin → Appearance → Theme Options
├── Header Settings: Logo, navigation options
├── Footer Settings: Footer content, social links
├── Performance: Optimization settings
└── Advanced: Custom CSS, tracking codes
```

### **🔧 Plugin Integrations**

#### **Required Plugins**
- **Contact Form 7**: Contact forms
- **Yoast SEO**: SEO optimization
- **WP Rocket**: Performance caching (optional)

#### **Recommended Plugins**
- **Akismet**: Spam protection
- **UpdraftPlus**: Backup solution
- **Wordfence**: Security enhancement

## 📱 **Mobile & Responsive Features**

### **📲 Mobile Navigation**
- **Hamburger Menu**: Collapsible navigation for mobile
- **Touch-Friendly**: Optimized for touch interactions
- **Swipe Gestures**: Gallery image navigation

### **📐 Responsive Breakpoints**
```css
/* Mobile First Approach */
Base: 320px+ (Mobile)
SM: 640px+ (Large Mobile)
MD: 768px+ (Tablet)
LG: 1024px+ (Desktop)
XL: 1280px+ (Large Desktop)
```

## 🎯 **Content Management Best Practices**

### **📝 Content Guidelines**

#### **Writing Style**
- Use clear, professional Indonesian language
- Include Arabic terminology where appropriate
- Maintain government official tone
- Use consistent terminology throughout

#### **Image Guidelines**
- **Recommended Size**: 1200x800px for featured images
- **File Format**: JPG for photos, PNG for graphics
- **File Size**: Maximum 500KB per image
- **Alt Text**: Always include descriptive alt text

#### **SEO Best Practices**
- Use descriptive page titles (50-60 characters)
- Write compelling meta descriptions (150-160 characters)
- Include relevant keywords naturally
- Use proper heading structure (H1, H2, H3)

### **🗂️ Content Organization**

#### **Categories Structure**
```
News Categories:
├── Pengumuman (Announcements)
├── Persiapan (Preparation)
├── Lomba (Competition)
├── Hasil (Results)
└── Dokumentasi (Documentation)
```

#### **Gallery Organization**
```
Gallery Types:
├── Foto Persiapan (Preparation Photos)
├── Foto Lomba (Competition Photos)
├── Video Dokumenter (Documentary Videos)
├── Live Streaming (Live Events)
└── Highlight Moments (Best Moments)
```

## 🛡️ **Security & Maintenance**

### **🔒 Security Features**
- **ABSPATH Protection**: All PHP files protected
- **XSS Prevention**: Output escaping implemented
- **SQL Injection Protection**: Prepared statements used
- **File Access Control**: Direct file access prevented

### **🔧 Regular Maintenance Tasks**

#### **Weekly Tasks**
- [ ] Check for WordPress core updates
- [ ] Update plugins and themes
- [ ] Review security logs
- [ ] Backup website content

#### **Monthly Tasks**
- [ ] Performance optimization review
- [ ] SEO analysis and improvements
- [ ] Content audit and cleanup
- [ ] Security scan execution

## 🆘 **Troubleshooting Guide**

### **🐛 Common Issues & Solutions**

#### **Theme Not Displaying Correctly**
1. Check if all required plugins are installed
2. Verify theme files are uploaded completely
3. Clear browser cache and WordPress cache
4. Check for PHP errors in error logs

#### **Gallery Not Loading**
1. Verify gallery custom post type is active
2. Check media file permissions
3. Test with browser developer tools
4. Review JavaScript console for errors

#### **Countdown Timer Not Working**
1. Check event date configuration
2. Verify JavaScript is enabled
3. Test timezone settings
4. Clear browser cache

#### **Performance Issues**
1. Install caching plugin (WP Rocket recommended)
2. Optimize images (use WebP format)
3. Minify CSS and JavaScript
4. Enable GZIP compression

## 📞 **Support & Resources**

### **🎯 Getting Help**

#### **Self-Service Resources**
- **Theme Documentation**: [GitHub Wiki](https://github.com/saipulbahri-it/mtq-aceh-pidie-jaya-theme/wiki)
- **Video Tutorials**: Available on theme website
- **FAQ Section**: Common questions answered
- **Community Forum**: User discussions

#### **Direct Support**
- **GitHub Issues**: [Report bugs](https://github.com/saipulbahri-it/mtq-aceh-pidie-jaya-theme/issues)
- **Email Support**: diskominfo@pidiejayakab.go.id
- **Phone Support**: +62-XXX-XXXX-XXXX (office hours)

### **📚 Additional Resources**

#### **Learning Materials**
- **WordPress Basics**: [WordPress.org Tutorials](https://wordpress.org/support/)
- **Content Management**: Best practices guide
- **SEO Optimization**: Yoast SEO documentation
- **Security Hardening**: WordPress security guide

#### **Developer Resources**
- **Theme Documentation**: Technical documentation
- **Code Examples**: Sample implementations
- **API Reference**: Available hooks and filters
- **Contribution Guide**: How to contribute to theme development

---

**🎯 Need More Help?**

For additional assistance or custom requirements, contact the development team:
- **Email**: saipulbahri.it@gmail.com
- **GitHub**: [@saipulbahri-it](https://github.com/saipulbahri-it)
- **Website**: [mtq.pidiejayakab.go.id](https://mtq.pidiejayakab.go.id)

**📖 Keep This Manual Handy**: Bookmark this page for quick reference during theme usage and administration.
