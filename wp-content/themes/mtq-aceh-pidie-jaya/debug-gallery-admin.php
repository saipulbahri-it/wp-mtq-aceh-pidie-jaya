<?php
/**
 * Debug script untuk MTQ Gallery Admin Panel
 * Akses: domain.com/wp-content/themes/mtq-aceh-pidie-jaya/debug-gallery-admin.php
 */

// Load WordPress
require_once '../../../wp-load.php';

// Security check
if (!current_user_can('manage_options')) {
    wp_die('Unauthorized access');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>MTQ Gallery Admin Debug</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 20px auto; padding: 20px; }
        .ok { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        .info { color: blue; font-weight: bold; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 5px; font-size: 12px; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>

<h1>🔍 MTQ Gallery Admin Panel Debug</h1>
<p><strong>Waktu:</strong> <?php echo current_time('mysql'); ?></p>

<div class="section">
<h2>1. WordPress Environment</h2>
<?php
echo "<strong>WP Version:</strong> " . get_bloginfo('version') . "<br>";
echo "<strong>Theme:</strong> " . get_option('stylesheet') . "<br>";
echo "<strong>Admin URL:</strong> " . admin_url() . "<br>";
echo "<strong>Current User:</strong> " . wp_get_current_user()->user_login . "<br>";
echo "<strong>Can Manage Options:</strong> " . (current_user_can('manage_options') ? 'Yes' : 'No') . "<br>";
?>
</div>

<div class="section">
<h2>2. Gallery Files Check</h2>
<?php
$theme_dir = get_template_directory();
$gallery_files = [
    'gallery-post-type.php' => '/inc/gallery-post-type.php',
    'gallery-shortcodes.php' => '/inc/gallery-shortcodes.php',
    'archive-mtq_gallery.php' => '/archive-mtq_gallery.php',
    'single-mtq_gallery.php' => '/single-mtq_gallery.php'
];

foreach ($gallery_files as $name => $path) {
    $full_path = $theme_dir . $path;
    if (file_exists($full_path)) {
        echo "<span class='ok'>✅ $name</span> - " . $full_path . "<br>";
    } else {
        echo "<span class='error'>❌ $name</span> - Missing: " . $full_path . "<br>";
    }
}
?>
</div>

<div class="section">
<h2>3. Class Existence Check</h2>
<?php
if (class_exists('MTQ_Gallery_Post_Type')) {
    echo "<span class='ok'>✅ MTQ_Gallery_Post_Type class exists</span><br>";
} else {
    echo "<span class='error'>❌ MTQ_Gallery_Post_Type class NOT found</span><br>";
}

if (class_exists('MTQ_Gallery_Shortcodes')) {
    echo "<span class='ok'>✅ MTQ_Gallery_Shortcodes class exists</span><br>";
} else {
    echo "<span class='error'>❌ MTQ_Gallery_Shortcodes class NOT found</span><br>";
}
?>
</div>

<div class="section">
<h2>4. Post Type Registration</h2>
<?php
if (post_type_exists('mtq_gallery')) {
    echo "<span class='ok'>✅ mtq_gallery post type is registered</span><br>";
    
    $post_type_obj = get_post_type_object('mtq_gallery');
    if ($post_type_obj) {
        echo "<strong>Menu Position:</strong> " . ($post_type_obj->menu_position ?? 'default') . "<br>";
        echo "<strong>Menu Icon:</strong> " . ($post_type_obj->menu_icon ?? 'default') . "<br>";
        echo "<strong>Show in Menu:</strong> " . ($post_type_obj->show_in_menu ? 'Yes' : 'No') . "<br>";
        echo "<strong>Show UI:</strong> " . ($post_type_obj->show_ui ? 'Yes' : 'No') . "<br>";
        echo "<strong>Public:</strong> " . ($post_type_obj->public ? 'Yes' : 'No') . "<br>";
        echo "<strong>Capability Type:</strong> " . ($post_type_obj->capability_type ?? 'post') . "<br>";
        
        // Check capabilities
        echo "<strong>Current User Can:</strong><br>";
        echo "- edit_posts: " . (current_user_can('edit_posts') ? 'Yes' : 'No') . "<br>";
        echo "- publish_posts: " . (current_user_can('publish_posts') ? 'Yes' : 'No') . "<br>";
        echo "- edit_mtq_gallerys: " . (current_user_can('edit_posts') ? 'Yes' : 'No') . "<br>";
    }
} else {
    echo "<span class='error'>❌ mtq_gallery post type NOT registered</span><br>";
}
?>
</div>

<div class="section">
<h2>5. Admin Menu Check</h2>
<?php
global $menu, $submenu;

echo "<strong>Looking for Gallery in Admin Menu:</strong><br>";
$gallery_found = false;

if (is_array($menu)) {
    foreach ($menu as $menu_item) {
        if (is_array($menu_item) && isset($menu_item[0])) {
            if (strpos(strtolower($menu_item[0]), 'gallery') !== false || 
                strpos(strtolower($menu_item[2]), 'mtq_gallery') !== false) {
                echo "<span class='ok'>✅ Found in menu:</span> " . $menu_item[0] . " -> " . $menu_item[2] . "<br>";
                $gallery_found = true;
            }
        }
    }
}

if (!$gallery_found) {
    echo "<span class='error'>❌ Gallery menu not found in admin menu</span><br>";
}

echo "<br><strong>All Admin Menu Items:</strong><br>";
if (is_array($menu)) {
    foreach ($menu as $menu_item) {
        if (is_array($menu_item) && isset($menu_item[0]) && !empty(trim($menu_item[0]))) {
            echo "- " . strip_tags($menu_item[0]) . " (" . $menu_item[2] . ")<br>";
        }
    }
}
?>
</div>

<div class="section">
<h2>6. Theme Functions Check</h2>
<?php
echo "<strong>Functions Existence:</strong><br>";
echo "- mtq_init_gallery_system: " . (function_exists('mtq_init_gallery_system') ? 'Yes' : 'No') . "<br>";
echo "- mtq_theme_activation: " . (function_exists('mtq_theme_activation') ? 'Yes' : 'No') . "<br>";
echo "- mtq_gallery_admin_notice: " . (function_exists('mtq_gallery_admin_notice') ? 'Yes' : 'No') . "<br>";

echo "<br><strong>Options Check:</strong><br>";
echo "- mtq_gallery_permalinks_flushed: " . get_option('mtq_gallery_permalinks_flushed', 'not set') . "<br>";
echo "- mtq_theme_version: " . get_option('mtq_theme_version', 'not set') . "<br>";
?>
</div>

<div class="section">
<h2>7. WordPress Hooks Debug</h2>
<?php
global $wp_filter;

echo "<strong>init hooks (priority 5):</strong><br>";
if (isset($wp_filter['init']) && isset($wp_filter['init']->callbacks[5])) {
    foreach ($wp_filter['init']->callbacks[5] as $callback) {
        if (is_array($callback['function'])) {
            echo "- " . get_class($callback['function'][0]) . "::" . $callback['function'][1] . "<br>";
        } else {
            echo "- " . $callback['function'] . "<br>";
        }
    }
} else {
    echo "No init hooks at priority 5<br>";
}
?>
</div>

<div class="section">
<h2>8. Quick Fix Actions</h2>
<p><strong>Try these if Gallery not showing:</strong></p>

<a href="<?php echo admin_url('options-permalink.php'); ?>" target="_blank" 
   style="display: inline-block; padding: 10px 15px; background: #0073aa; color: white; text-decoration: none; border-radius: 3px; margin: 5px;">
   🔄 Flush Permalinks
</a>

<a href="<?php echo admin_url('admin.php?page=gallery_debug&action=force_init'); ?>" 
   style="display: inline-block; padding: 10px 15px; background: #d63638; color: white; text-decoration: none; border-radius: 3px; margin: 5px;">
   🚨 Force Re-initialization
</a>

<a href="<?php echo admin_url('themes.php'); ?>" target="_blank"
   style="display: inline-block; padding: 10px 15px; background: #00a32a; color: white; text-decoration: none; border-radius: 3px; margin: 5px;">
   🎨 Switch Theme (Re-activate)
</a>

<?php
// Force re-initialization if requested
if (isset($_GET['action']) && $_GET['action'] === 'force_init') {
    echo "<br><strong>🔄 Force Re-initialization:</strong><br>";
    
    // Delete all gallery options
    delete_option('mtq_gallery_permalinks_flushed');
    delete_option('mtq_theme_version');
    delete_option('mtq_gallery_needs_flush');
    
    // Try to re-initialize
    if (function_exists('mtq_init_gallery_system')) {
        mtq_init_gallery_system();
        echo "✅ mtq_init_gallery_system() called<br>";
    }
    
    // Force flush
    flush_rewrite_rules(true);
    echo "✅ Permalinks flushed<br>";
    
    echo "<br><a href='?' style='padding: 8px 12px; background: #0073aa; color: white; text-decoration: none; border-radius: 3px;'>🔍 Re-run Debug</a>";
}
?>
</div>

<hr>
<p><em>Debug completed at: <?php echo current_time('mysql'); ?></em></p>

</body>
</html>
