# 🔧 Gallery Import Scripts

Koleksi script untuk import data gallery MTQ Aceh Pidie Jaya.

## 📁 **Daftar Scripts**

### **1. quick-import.php** ⭐ **(Recommended)**
**Deskripsi:** Script import cepat dengan UI sederhana  
**Fitur:**
- ✅ Interface user-friendly
- ✅ Progress indicator
- ✅ Error handling
- ✅ Sample data built-in

**Usage:**
```bash
# Copy ke root WordPress
cp quick-import.php /path/to/wordpress/

# Akses via browser
https://domain.com/quick-import.php
```

### **2. import-gallery.php**
**Deskripsi:** Script import komprehensif dengan banyak opsi  
**Fitur:**
- ✅ Multiple import methods
- ✅ Category dan tag creation
- ✅ Image download dari URL
- ✅ Metadata lengkap

### **3. simple-import.php**
**Deskripsi:** Script import sederhana untuk data minimal  
**Fitur:**
- ✅ Basic gallery creation
- ✅ Minimal dependencies
- ✅ Quick setup

### **4. create-dummy-gallery.php**
**Deskripsi:** Generator data dummy untuk testing  
**Fitur:**
- ✅ Generate sample galleries
- ✅ Random content
- ✅ Testing purposes

### **5. import-gallery-sql.sql**
**Deskripsi:** Direct SQL import untuk bulk data  
**Fitur:**
- ✅ Direct database import
- ✅ Bulk insert
- ✅ Fast execution

### **6. dummy-gallery-data.sql**
**Deskripsi:** Sample SQL data untuk testing  
**Fitur:**
- ✅ Ready-to-use sample data
- ✅ Complete gallery structure
- ✅ Testing scenarios

## 🚀 **Panduan Penggunaan**

### **Metode 1: Quick Import (Tercepat)**

1. **Copy script ke root WordPress:**
   ```bash
   cp scripts/gallery-import/quick-import.php ./
   ```

2. **Akses via browser:**
   ```
   https://domain.com/quick-import.php
   ```

3. **Follow wizard interface**

4. **Delete script setelah selesai:**
   ```bash
   rm quick-import.php
   ```

### **Metode 2: SQL Import (Bulk Data)**

1. **Backup database terlebih dahulu:**
   ```bash
   mysqldump -u username -p database_name > backup.sql
   ```

2. **Import SQL file:**
   ```bash
   mysql -u username -p database_name < scripts/gallery-import/import-gallery-sql.sql
   ```

3. **Flush permalinks di WordPress Admin**

### **Metode 3: PHP Script Custom**

1. **Edit script sesuai kebutuhan**
2. **Copy ke root WordPress**  
3. **Jalankan via browser atau CLI**
4. **Monitor progress dan error log**

## ⚠️ **Perhatian Penting**

### **Sebelum Import:**
- ✅ **Backup database** terlebih dahulu
- ✅ **Test di environment staging** dulu
- ✅ **Pastikan WordPress dan theme aktif**
- ✅ **Check user permissions** (admin level)

### **Setelah Import:**
- ✅ **Delete script files** untuk keamanan
- ✅ **Flush permalinks** di WP Admin
- ✅ **Verify data** di admin panel
- ✅ **Test gallery display** di frontend

## 🔍 **Troubleshooting**

### **Script Error:**
```bash
# Check PHP error log
tail -f /var/log/php_errors.log

# Enable WordPress debug
# Add to wp-config.php:
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

### **Permission Issues:**
```bash
# Fix file permissions
chmod 644 *.php
chown www-data:www-data *.php
```

### **Memory Limit:**
```php
// Add to script top
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 300);
```

## 📋 **Checklist Import**

### **Pre-Import:**
- [ ] Database backup created
- [ ] WordPress admin access confirmed
- [ ] Theme MTQ active
- [ ] Script files copied
- [ ] User permissions verified

### **Post-Import:**
- [ ] Script files deleted
- [ ] Permalinks flushed
- [ ] Gallery data verified
- [ ] Frontend display tested
- [ ] Admin panel accessible

## 🎯 **Best Practices**

1. **Always backup** before import
2. **Test on staging** environment first
3. **Use quick-import.php** for beginners
4. **Monitor error logs** during import
5. **Delete scripts** after completion
6. **Document customizations** made

---

**⚡ Recommended Order:**
1. `quick-import.php` (untuk pemula)
2. `import-gallery.php` (untuk advanced)
3. `import-gallery-sql.sql` (untuk bulk data)
