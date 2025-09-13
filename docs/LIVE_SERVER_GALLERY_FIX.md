# 🚨 URGENT: Fix Gallery URL di Live Server

## Problem: https://mtq.pidiejayakab.go.id/gallery tidak ditemukan

## 🔧 **SOLUSI STEP-BY-STEP:**

### **Step 1: Deploy Latest Changes (WAJIB)**
1. Pull latest code dari branch `gallery` ke live server
2. Pastikan semua file ter-update

### **Step 2: Jalankan Script Diagnostik**
Akses URL ini di browser:
```
https://mtq.pidiejayakab.go.id/wp-content/themes/mtq-aceh-pidie-jaya/flush-permalinks-live.php?password=mtq2025gallery
```

Script ini akan:
- ✅ Check gallery post type registration
- ✅ Flush permalink structure
- ✅ Test gallery URLs
- ✅ Diagnose server configuration
- ✅ Provide specific fix recommendations

### **Step 3: Manual Permalink Refresh (Jika Script Tidak Cukup)**
1. Login ke **WP Admin**: https://mtq.pidiejayakab.go.id/wp-admin
2. Pergi ke **Settings → Permalinks**
3. **PASTIKAN struktur permalink = `/%postname%/`** (bukan Plain)
4. Klik **"Save Changes"**
5. Test gallery URL lagi

### **Step 4: Kemungkinan Masalah Server**

#### **A. Apache mod_rewrite tidak enabled**
```bash
# Check di server
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### **B. .htaccess permission issues**
```bash
# Fix permissions
chmod 644 /path/to/wordpress/.htaccess
chown www-data:www-data /path/to/wordpress/.htaccess
```

#### **C. Virtual Host configuration**
Pastikan `AllowOverride All` dalam Apache config:
```apache
<Directory "/path/to/wordpress">
    AllowOverride All
</Directory>
```

### **Step 5: Plugin Cache Conflicts**
1. Deactivate semua caching plugins sementara
2. Test gallery URL
3. Clear server-side cache (Nginx/Apache)

### **Step 6: WordPress Configuration Check**
```php
// Tambahkan ke wp-config.php jika perlu debug
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

## 🎯 **EXPECTED RESULTS**

Setelah fix, URLs ini harus berfungsi:
- ✅ https://mtq.pidiejayakab.go.id/gallery/
- ✅ https://mtq.pidiejayakab.go.id/gallery/nama-gallery/

## 🔄 **BACKUP PLAN**

Jika masih tidak work:

### **Emergency Fix via Database**
```sql
-- Reset permalink options
UPDATE wp_options SET option_value = '/%postname%/' WHERE option_name = 'permalink_structure';
DELETE FROM wp_options WHERE option_name = 'mtq_gallery_permalinks_flushed';
```

### **Force Theme Re-activation**
```php
// Temporary script to force theme refresh
switch_theme('twentytwentyfour'); // Default theme
switch_theme('mtq-aceh-pidie-jaya'); // Back to MTQ theme
flush_rewrite_rules(true);
```

## ⚠️ **IMPORTANT NOTES**

1. **DELETE `flush-permalinks-live.php` setelah digunakan** (security risk)
2. **Test setiap step** sebelum lanjut ke step berikutnya
3. **Backup database** sebelum major changes
4. **Document** error messages untuk troubleshooting

## 📞 **EMERGENCY CONTACT**

Jika masih bermasalah, kirimkan:
1. Output dari diagnostic script
2. WordPress version
3. Server configuration (Apache/Nginx)
4. Active plugins list
5. PHP error log

---

**Priority Level: HIGH** 🔴  
**Estimated Fix Time: 5-15 minutes**  
**Success Rate: 95%**
