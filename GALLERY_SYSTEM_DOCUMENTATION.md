# MTQ Gallery System Documentation

## Overview
Sistem Gallery MTQ Aceh Pidie Jaya adalah solusi lengkap untuk mengelola foto dan video dokumentasi kegiatan Musabaqah Tilawatil Quran. Sistem ini memungkinkan upload bulk media, kategorisasi, dan tampilan yang responsif.

## Fitur Utama

### 1. Custom Post Type - MTQ Gallery
- **Post Type**: `mtq_gallery`
- **Capabilities**: Public, searchable, has archive
- **Supports**: Title, editor, excerpt, thumbnail, custom fields
- **Hierarchical**: No

### 2. Taxonomies
- **Categories** (`mtq_gallery_category`): Kategori gallery (Pembukaan, Lomba, Penutupan, dll)
- **Tags** (`mtq_gallery_tag`): Tag untuk pengelompokan lebih detail

### 3. Meta Fields
- `_mtq_gallery_images`: Array ID gambar
- `_mtq_gallery_videos`: Array video dengan URL dan caption
- `_mtq_gallery_layout`: Layout tampilan (grid, slider, masonry)
- `_mtq_gallery_columns`: Jumlah kolom (3, 4, 5)
- `_mtq_gallery_show_captions`: Tampilkan caption (yes/no)
- `_mtq_gallery_enable_lightbox`: Aktifkan lightbox (yes/no)

## File Structure

```
wp-content/themes/mtq-aceh-pidie-jaya/
├── inc/
│   ├── gallery-post-type.php      # Custom post type dan meta boxes
│   └── gallery-shortcodes.php     # Shortcode sistem
├── single-mtq_gallery.php         # Template single gallery
├── archive-mtq_gallery.php        # Template archive gallery
└── functions.php                   # Include files
```

## Admin Interface

### 1. Gallery Manager
- Lokasi: **Dashboard > Gallery > Add New Gallery**
- Fitur:
  - Upload multiple images dengan drag & drop
  - Sortable image order
  - Individual image captions
  - Video URL input (YouTube embed dan direct)
  - Layout settings
  - Category dan tag assignment

### 2. Meta Boxes
- **Gallery Images**: Upload dan manage gambar
- **Gallery Videos**: Add video URLs dan captions
- **Gallery Settings**: Layout, columns, dan display options

## Shortcode Usage

### 1. Display Single Gallery
```
[mtq_gallery id="123"]
[mtq_gallery id="123" layout="grid" columns="3"]
[mtq_gallery id="123" layout="slider" show_captions="yes"]
```

**Parameters:**
- `id`: Gallery ID (required jika tidak ada category/tag)
- `layout`: grid, slider, masonry (default: saved setting)
- `columns`: 3, 4, 5 (default: saved setting)
- `show_captions`: yes, no (default: saved setting)
- `enable_lightbox`: yes, no (default: saved setting)
- `limit`: Number limit untuk multiple galleries

### 2. Display Multiple Galleries
```
[mtq_gallery category="kegiatan"]
[mtq_gallery tag="lomba-dewasa" limit="6"]
[mtq_gallery category="pembukaan" layout="grid" columns="4"]
```

**Parameters:**
- `category`: Slug kategori gallery
- `tag`: Slug tag gallery
- `limit`: Jumlah maksimal gallery

### 3. Gallery List
```
[mtq_gallery_list]
[mtq_gallery_list category="kegiatan" limit="6" columns="3"]
[mtq_gallery_list show_excerpt="no" show_meta="no"]
```

**Parameters:**
- `category`: Filter by category slug
- `tag`: Filter by tag slug
- `limit`: Number of galleries (default: 12)
- `columns`: Grid columns 1-4 (default: 3)
- `show_excerpt`: yes, no (default: yes)
- `show_meta`: yes, no (default: yes)

## Templates

### 1. Single Gallery (`single-mtq_gallery.php`)
- Gallery header dengan metadata
- Breadcrumb navigation
- Categories dan tags display
- Gallery content menggunakan shortcode
- Social sharing integration
- Previous/next navigation

### 2. Archive Gallery (`archive-mtq_gallery.php`)
- Category filter buttons
- Search functionality
- Gallery statistics
- Grid layout dengan card design
- Pagination support

## Layout Options

### 1. Grid Layout
- Responsive grid dengan 1-5 kolom
- Equal height cards
- Hover effects
- Lightbox integration

### 2. Slider Layout
- Full-width image slider
- Navigation arrows
- Dot indicators
- Auto-caption overlay
- Touch/swipe support

### 3. Masonry Layout
- Pinterest-style layout
- Variable height items
- Responsive breakpoints
- Currently renders as grid (requires additional JS library)

## Media Management

### 1. Image Handling
- Multiple upload dengan WordPress Media Library
- Drag & drop reordering
- Individual captions per image
- Thumbnail generation
- Lightbox modal integration

### 2. Video Support
- **YouTube**: Embed URL support
- **Direct Video**: MP4, WebM, OGG
- Video thumbnails
- Caption support
- Responsive player

## Styling & Responsiveness

### 1. CSS Framework
- Tailwind CSS integration
- Custom CSS untuk pagination
- Responsive breakpoints:
  - Mobile: 1 column
  - Tablet: 2 columns
  - Desktop: 3-5 columns

### 2. Components
- Gallery cards dengan hover effects
- Modal lightbox untuk images
- Loading states
- Error handling displays

## Integration Features

### 1. Search Integration
- Gallery searchable di WordPress search
- Custom search form di archive
- Category dan tag filtering

### 2. SEO Friendly
- Proper meta titles dan descriptions
- Structured data ready
- Image alt tags
- Canonical URLs

## Usage Examples

### 1. Halaman Gallery Utama
Tambahkan di halaman statis:
```
[mtq_gallery_list limit="12" columns="3"]
```

### 2. Gallery Specific per Kegiatan
```
[mtq_gallery category="pembukaan" layout="slider"]
[mtq_gallery category="lomba-dewasa" layout="grid" columns="4"]
```

### 3. Highlight Gallery di Homepage
```
[mtq_gallery_list limit="6" columns="3" show_excerpt="no"]
```

## Admin Instructions

### 1. Membuat Gallery Baru
1. Go to **Dashboard > Gallery > Add New Gallery**
2. Input title dan description
3. Upload images di **Gallery Images** meta box
4. Add video URLs di **Gallery Videos** meta box
5. Set layout preferences di **Gallery Settings**
6. Assign categories dan tags
7. Publish gallery

### 2. Menampilkan Gallery di Halaman
1. Edit halaman/post yang diinginkan
2. Add shortcode: `[mtq_gallery id="GALLERY_ID"]`
3. Atau untuk list: `[mtq_gallery_list category="CATEGORY_SLUG"]`
4. Update halaman

### 3. Customize Layout
- Grid: Best untuk photo galleries
- Slider: Best untuk featured galleries
- Masonry: Best untuk mixed media sizes

## Technical Notes

### 1. Database
- Gallery data stored sebagai post meta
- Images referenced by attachment ID
- Videos stored as URL array dengan metadata

### 2. Performance
- Lazy loading ready
- Thumbnail generation
- Efficient database queries
- Pagination untuk large datasets

### 3. Security
- Nonce verification untuk form submissions
- Capability checks untuk admin functions
- Sanitized input/output
- Secure file uploads

## Troubleshooting

### 1. Images Not Displaying
- Check file permissions
- Verify attachment IDs exist
- Ensure WordPress media library is accessible

### 2. Videos Not Playing
- Verify YouTube URL format
- Check video URL accessibility
- Ensure proper embed code

### 3. Layout Issues
- Check Tailwind CSS compilation
- Verify responsive breakpoints
- Test browser compatibility

## Future Enhancements

### Planned Features
1. **Advanced Search**: Filter by date, media type
2. **Bulk Actions**: Mass edit capabilities
3. **Image Optimization**: WebP conversion, compression
4. **Advanced Lightbox**: Zoom, fullscreen, slideshow
5. **Social Sharing**: Direct gallery sharing
6. **Export/Import**: Gallery backup dan restore
7. **Analytics**: Gallery view tracking
8. **API Integration**: External gallery services

### Technical Improvements
1. **Lazy Loading**: Intersection Observer implementation
2. **Progressive Enhancement**: Better fallbacks
3. **Cache Integration**: Object caching support
4. **CDN Support**: External media hosting
5. **Accessibility**: ARIA labels, keyboard navigation

## Support

Untuk pertanyaan atau masalah:
1. Check dokumentasi ini terlebih dahulu
2. Test di development environment
3. Backup database sebelum major changes
4. Contact developer untuk custom modifications

---

**Version**: 1.0.0  
**Last Updated**: December 2024  
**Compatible**: WordPress 5.0+, PHP 7.4+
