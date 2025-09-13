<?php
/**
 * Script untuk flush permalinks di server live
 * Akses via: https://mtq.pidiejayakab.go.id/wp-content/themes/mtq-aceh-pidie-jaya/flush-permalinks-live.php
 * 
 * PENTING: Hapus file ini setelah digunakan untuk keamanan!
 */

// Security check - hanya bisa diakses oleh admin atau dengan password
$admin_password = 'mtq2025gallery'; // Password sementara
$input_password = isset($_GET['password']) ? $_GET['password'] : '';

if ($input_password !== $admin_password) {
    die('Access denied. Use: ?password=mtq2025gallery');
}

// Load WordPress
require_once '../../../wp-load.php';

if (!is_admin() && !current_user_can('manage_options')) {
    // Allow execution with correct password for emergency fix
    if ($input_password !== $admin_password) {
        wp_die('Unauthorized access');
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>MTQ Gallery Permalink Fix - Live Server</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 20px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .info { color: blue; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
        .step { margin: 20px 0; padding: 15px; border-left: 4px solid #0073aa; background: #f9f9f9; }
    </style>
</head>
<body>

<h1>🔧 MTQ Gallery Permalink Fix - Live Server</h1>
<p><strong>Server:</strong> <?php echo home_url(); ?></p>
<p><strong>Waktu:</strong> <?php echo current_time('mysql'); ?></p>

<div class="step">
<h2>Step 1: Checking WordPress Environment</h2>
<?php
echo "<strong>WordPress Version:</strong> " . get_bloginfo('version') . "<br>";
echo "<strong>Active Theme:</strong> " . get_option('stylesheet') . "<br>";
echo "<strong>Home URL:</strong> " . home_url() . "<br>";
echo "<strong>Site URL:</strong> " . site_url() . "<br>";
?>
</div>

<div class="step">
<h2>Step 2: Gallery Post Type Status</h2>
<?php
if (post_type_exists('mtq_gallery')) {
    echo "<span class='success'>✅ Post type 'mtq_gallery' is registered</span><br>";
    
    $post_type_obj = get_post_type_object('mtq_gallery');
    if ($post_type_obj) {
        echo "<strong>Archive enabled:</strong> " . ($post_type_obj->has_archive ? 'Yes (' . $post_type_obj->has_archive . ')' : 'No') . "<br>";
        echo "<strong>Public:</strong> " . ($post_type_obj->public ? 'Yes' : 'No') . "<br>";
        echo "<strong>Publicly queryable:</strong> " . ($post_type_obj->publicly_queryable ? 'Yes' : 'No') . "<br>";
        echo "<strong>Rewrite:</strong> ";
        if (is_array($post_type_obj->rewrite)) {
            echo "Slug: " . $post_type_obj->rewrite['slug'];
        } else {
            echo $post_type_obj->rewrite ? 'Enabled' : 'Disabled';
        }
        echo "<br>";
    }
} else {
    echo "<span class='error'>❌ Post type 'mtq_gallery' NOT registered</span><br>";
    echo "<span class='warning'>⚠️ Theme files may not be loaded properly</span><br>";
}
?>
</div>

<div class="step">
<h2>Step 3: Permalink Structure</h2>
<?php
$permalink_structure = get_option('permalink_structure');
echo "<strong>Current structure:</strong> " . ($permalink_structure ? $permalink_structure : 'Plain (not SEO friendly)') . "<br>";

if (empty($permalink_structure)) {
    echo "<span class='warning'>⚠️ WARNING: Plain permalinks detected. Gallery may not work properly.</span><br>";
    echo "<span class='info'>💡 Recommended: Change to /%postname%/ in WP Admin → Settings → Permalinks</span><br>";
}
?>
</div>

<div class="step">
<h2>Step 4: Flushing Rewrite Rules</h2>
<?php
// Force flush rewrite rules
flush_rewrite_rules(true);
delete_option('mtq_gallery_permalinks_flushed');
update_option('mtq_gallery_permalinks_flushed', 'yes');

echo "<span class='success'>✅ Rewrite rules flushed successfully</span><br>";
echo "<span class='success'>✅ Gallery permalink cache cleared</span><br>";
?>
</div>

<div class="step">
<h2>Step 5: Testing Gallery URLs</h2>
<?php
$gallery_archive_url = get_post_type_archive_link('mtq_gallery');
echo "<strong>Generated Gallery URL:</strong> ";
if ($gallery_archive_url) {
    echo "<a href='" . $gallery_archive_url . "' target='_blank'>" . $gallery_archive_url . "</a><br>";
    echo "<span class='success'>✅ URL generation successful</span><br>";
} else {
    echo "<span class='error'>❌ Failed to generate gallery URL</span><br>";
}

// Test different URL variations
$test_urls = array(
    home_url('/gallery/'),
    home_url('/gallery'),
    site_url('/gallery/'),
    site_url('/gallery')
);

echo "<br><strong>Testing URL variations:</strong><br>";
foreach ($test_urls as $url) {
    echo "- <a href='" . $url . "' target='_blank'>" . $url . "</a><br>";
}
?>
</div>

<div class="step">
<h2>Step 6: Gallery Content Check</h2>
<?php
$gallery_count = wp_count_posts('mtq_gallery');
if ($gallery_count) {
    echo "<strong>Published galleries:</strong> " . ($gallery_count->publish ?? 0) . "<br>";
    echo "<strong>Draft galleries:</strong> " . ($gallery_count->draft ?? 0) . "<br>";
    
    if ($gallery_count->publish > 0) {
        echo "<span class='success'>✅ Gallery content exists</span><br>";
        
        // Show some examples
        $galleries = get_posts(array(
            'post_type' => 'mtq_gallery',
            'numberposts' => 3,
            'post_status' => 'publish'
        ));
        
        if (!empty($galleries)) {
            echo "<br><strong>Sample galleries:</strong><br>";
            foreach ($galleries as $gallery) {
                $gallery_url = get_permalink($gallery->ID);
                echo "- <a href='" . $gallery_url . "' target='_blank'>" . $gallery->post_title . "</a><br>";
            }
        }
    } else {
        echo "<span class='warning'>⚠️ No published galleries found</span><br>";
        echo "<span class='info'>💡 Create some galleries first: <a href='" . admin_url('post-new.php?post_type=mtq_gallery') . "'>Add New Gallery</a></span><br>";
    }
}
?>
</div>

<div class="step">
<h2>Step 7: Template Files Check</h2>
<?php
$theme_dir = get_template_directory();
$archive_template = $theme_dir . '/archive-mtq_gallery.php';
$single_template = $theme_dir . '/single-mtq_gallery.php';

echo "<strong>Theme directory:</strong> " . $theme_dir . "<br>";
echo "<strong>Archive template:</strong> " . (file_exists($archive_template) ? '✅ Found' : '❌ Missing') . "<br>";
echo "<strong>Single template:</strong> " . (file_exists($single_template) ? '✅ Found' : '❌ Missing') . "<br>";
?>
</div>

<div class="step">
<h2>Step 8: Server Configuration</h2>
<?php
echo "<strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "<strong>PHP Version:</strong> " . PHP_VERSION . "<br>";
echo "<strong>WordPress Debug:</strong> " . (WP_DEBUG ? 'Enabled' : 'Disabled') . "<br>";

// Check .htaccess
$htaccess_file = ABSPATH . '.htaccess';
if (file_exists($htaccess_file)) {
    echo "<strong>.htaccess:</strong> ✅ Exists<br>";
    if (is_writable($htaccess_file)) {
        echo "<strong>.htaccess writable:</strong> ✅ Yes<br>";
    } else {
        echo "<strong>.htaccess writable:</strong> ❌ No (may cause permalink issues)<br>";
    }
} else {
    echo "<strong>.htaccess:</strong> ❌ Missing<br>";
}
?>
</div>

<div class="step">
<h2>🎯 Final Test Results</h2>
<p><strong>Main Gallery URL to test:</strong></p>
<p style="font-size: 18px; font-weight: bold;">
    <a href="<?php echo home_url('/gallery/'); ?>" target="_blank" style="color: #0073aa;">
        <?php echo home_url('/gallery/'); ?>
    </a>
</p>

<?php if ($gallery_archive_url && $gallery_archive_url !== home_url('/gallery/')) : ?>
<p><strong>Alternative URL:</strong></p>
<p style="font-size: 18px;">
    <a href="<?php echo $gallery_archive_url; ?>" target="_blank" style="color: #0073aa;">
        <?php echo $gallery_archive_url; ?>
    </a>
</p>
<?php endif; ?>

<div style="background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h3>📋 Next Steps if Still Not Working:</h3>
    <ol>
        <li><strong>Manual Permalink Refresh:</strong>
            <br>• Go to <a href="<?php echo admin_url('options-permalink.php'); ?>">WP Admin → Settings → Permalinks</a>
            <br>• Click "Save Changes" without changing anything
        </li>
        <li><strong>Check Server Configuration:</strong>
            <br>• Ensure Apache mod_rewrite is enabled
            <br>• Check .htaccess permissions
        </li>
        <li><strong>Plugin Conflicts:</strong>
            <br>• Temporarily deactivate all plugins
            <br>• Test gallery URL again
        </li>
        <li><strong>Cache Issues:</strong>
            <br>• Clear any caching plugins
            <br>• Clear server-side cache
        </li>
    </ol>
</div>
</div>

<hr>
<p><em>Script completed at: <?php echo current_time('mysql'); ?></em></p>
<p><strong style="color: red;">SECURITY NOTE: Delete this file after use!</strong></p>

</body>
</html>
<?php
// Log the execution
error_log('MTQ Gallery permalink fix executed at ' . current_time('mysql') . ' from IP: ' . $_SERVER['REMOTE_ADDR']);
?>
