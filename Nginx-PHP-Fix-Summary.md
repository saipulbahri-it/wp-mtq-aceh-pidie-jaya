# Nginx and PHP Fix Summary

## Issues Identified

1. **PHP Constant Redefinition Warning**: The constants `WP_IMAGE_EDIT_OVERWRITE` and `IMAGE_EDIT_OVERWRITE` were being redefined in wp-config.php, causing warnings in the error logs.

2. **Nginx Client Body Temp Directory Permission Issue**: Nginx was unable to write to the default client body temp directory due to permission issues, causing 500 Internal Server Errors when uploading files.

## Fixes Applied

### 1. PHP Configuration Fix

**File Modified**: `/Users/saipulbahri.it/Projects/github/web-mtq-pijay/wp-mtq-aceh-pidie-jaya/wp-config.php`

**Change**: Added conditional checks to prevent redefinition of constants:

```php
// Image processing settings
if (!defined('WP_IMAGE_EDIT_OVERWRITE')) {
    define('WP_IMAGE_EDIT_OVERWRITE', true);
}
if (!defined('IMAGE_EDIT_OVERWRITE')) {
    define('IMAGE_EDIT_OVERWRITE', true);
}
```

### 2. Nginx Configuration Fixes

#### A. User Directive Configuration

**File Modified**: `/opt/homebrew/etc/nginx/nginx.conf`

**Change**: Uncommented and set the user directive to the correct user:

```nginx
user  saipulbahri.it admin;
```

#### B. Custom Client Body Temp Directory

**Directory Created**: `/Users/saipulbahri.it/Projects/github/web-mtq-pijay/wp-mtq-aceh-pidie-jaya/nginx-temp`

**Permissions Set**: 
- Owner: saipulbahri.it
- Group: staff
- Permissions: 700 (drwx------)

#### C. Nginx Client Body Temp Path Configuration

**File Modified**: `/opt/homebrew/etc/nginx/nginx.conf`

**Change**: Added client_body_temp_path directive to use the custom directory:

```nginx
http {
  client_body_temp_path /Users/saipulbahri.it/Projects/github/web-mtq-pijay/wp-mtq-aceh-pidie-jaya/nginx-temp;
  # ... rest of the configuration
}
```

## Services Restarted

1. Nginx: `brew services restart nginx`
2. PHP-FPM: `brew services restart php@8.3`

## Verification

After applying these fixes:
- The async-upload.php endpoint now properly redirects to the login page (expected behavior) instead of returning a 500 error
- No more permission denied errors in the Nginx error logs
- File uploads should now work correctly in the WordPress admin interface

## Additional Notes

- The fixes address both the immediate 500 error and prevent future occurrences
- The custom temp directory approach is more reliable than trying to modify system directories
- The PHP constant fix eliminates warning messages that could potentially cause issues