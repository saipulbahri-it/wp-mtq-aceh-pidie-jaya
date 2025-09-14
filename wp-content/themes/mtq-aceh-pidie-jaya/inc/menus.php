<?php
/**
 * Theme Menus Registration and Defaults
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!defined('ABSPATH')) {
    exit;
}

// Register navigation menus
add_action('after_setup_theme', function () {
    register_nav_menus([
        'top-header-menu' => __('Top Header Menu', 'mtq-aceh-pidie-jaya'),
    ]);
});

/**
 * Create a default/dummy header menu on first theme activation
 * and assign it to the 'top-header-menu' location used in header.php
 */
function mtq_create_default_header_menu() {
    if (!is_admin()) {
        return;
    }

    $flag_option = 'mtq_dummy_header_menu_created';
    if (get_option($flag_option) === 'yes') {
        return;
    }

    $location_key = 'top-header-menu';

    // Create or get the menu
    $menu_name = __('Menu Header', 'mtq-aceh-pidie-jaya');
    $menu_obj  = wp_get_nav_menu_object($menu_name);
    if (!$menu_obj) {
        $menu_id = wp_create_nav_menu($menu_name);
    } else {
        $menu_id = (int) $menu_obj->term_id;
    }

    if (is_wp_error($menu_id) || !$menu_id) {
        return;
    }

    // Build desired default items
    $home       = home_url('/');
    $berita_page = get_page_by_path('berita');
    $berita_url  = $berita_page ? get_permalink($berita_page) : home_url('/berita/');

    $arena_page = get_page_by_path('arena-dan-lokasi');
    $arena_url  = $arena_page ? get_permalink($arena_page) : home_url('/arena-dan-lokasi/');

    $gallery_url = function_exists('get_post_type_archive_link') && get_post_type_archive_link('mtq_gallery')
        ? get_post_type_archive_link('mtq_gallery')
        : home_url('/galeri/');

    $items = [
        [ 'title' => __('Beranda', 'mtq-aceh-pidie-jaya'), 'url' => $home ],
        [ 'title' => __('Tentang', 'mtq-aceh-pidie-jaya'), 'url' => $home . '#tentang' ],
        [ 'title' => __('Cabang Lomba', 'mtq-aceh-pidie-jaya'), 'url' => $home . '#cabang' ],
        [ 'title' => __('Arena & Lokasi', 'mtq-aceh-pidie-jaya'), 'url' => $arena_url ],
        [ 'title' => __('Galeri', 'mtq-aceh-pidie-jaya'), 'url' => $gallery_url ],
        [ 'title' => __('Berita', 'mtq-aceh-pidie-jaya'), 'url' => $berita_url ],
        [ 'title' => __('Live', 'mtq-aceh-pidie-jaya'), 'url' => $home . '#live-stream' ],
    ];

    // Avoid duplicate items if menu already has some
    $existing = wp_get_nav_menu_items($menu_id);
    $existing_urls = [];
    if ($existing && !is_wp_error($existing)) {
        foreach ($existing as $it) {
            if (!empty($it->url)) {
                $existing_urls[trailingslashit($it->url)] = true;
            }
        }
    }

    foreach ($items as $item) {
        $url_norm = trailingslashit($item['url']);
        if (isset($existing_urls[$url_norm])) {
            continue;
        }
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'  => $item['title'],
            'menu-item-url'    => $item['url'],
            'menu-item-status' => 'publish',
        ]);
    }

    // Assign to location if not already assigned
    $locations = get_theme_mod('nav_menu_locations');
    if (!is_array($locations)) {
        $locations = [];
    }
    if (!isset($locations[$location_key]) || (int)$locations[$location_key] !== (int)$menu_id) {
        $locations[$location_key] = (int)$menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }

    update_option($flag_option, 'yes');
}
add_action('after_switch_theme', 'mtq_create_default_header_menu');
