<?php
/**
 * Custom Post Type: Cabang Lomba
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!defined('ABSPATH')) {
    exit;
}

class MTQ_Cabang_Lomba_CPT {
    const POST_TYPE = 'mtq_cabang';
    const META_ICON   = '_mtq_cabang_icon_path';
    const META_COLOR  = '_mtq_cabang_color_classes';
    const META_URL    = '_mtq_cabang_custom_url';

    public function __construct() {
        add_action('init', [$this, 'register_post_type']);
        add_action('add_meta_boxes', [$this, 'register_meta_boxes']);
        add_action('save_post_' . self::POST_TYPE, [$this, 'save_meta']);

        // Register post meta for REST and sanitization
        add_action('init', [$this, 'register_post_meta']);
    }

    public function register_post_type() {
        $labels = [
            'name'               => __('Cabang Lomba', 'mtq-aceh-pidie-jaya'),
            'singular_name'      => __('Cabang Lomba', 'mtq-aceh-pidie-jaya'),
            'menu_name'          => __('Cabang Lomba', 'mtq-aceh-pidie-jaya'),
            'name_admin_bar'     => __('Cabang Lomba', 'mtq-aceh-pidie-jaya'),
            'add_new'            => __('Tambah Baru', 'mtq-aceh-pidie-jaya'),
            'add_new_item'       => __('Tambah Cabang Lomba Baru', 'mtq-aceh-pidie-jaya'),
            'new_item'           => __('Cabang Lomba Baru', 'mtq-aceh-pidie-jaya'),
            'edit_item'          => __('Edit Cabang Lomba', 'mtq-aceh-pidie-jaya'),
            'view_item'          => __('Lihat Cabang Lomba', 'mtq-aceh-pidie-jaya'),
            'all_items'          => __('Semua Cabang Lomba', 'mtq-aceh-pidie-jaya'),
            'search_items'       => __('Cari Cabang Lomba', 'mtq-aceh-pidie-jaya'),
            'not_found'          => __('Tidak ditemukan', 'mtq-aceh-pidie-jaya'),
            'not_found_in_trash' => __('Tidak ditemukan di Trash', 'mtq-aceh-pidie-jaya'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'cabang'],
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 22,
            'menu_icon'          => 'dashicons-awards',
            'supports'           => ['title', 'editor', 'excerpt', 'page-attributes'],
            'show_in_rest'       => true,
        ];

        register_post_type(self::POST_TYPE, $args);
    }

    public function register_post_meta() {
        register_post_meta(self::POST_TYPE, self::META_ICON, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'default'       => '',
            'sanitize_callback' => [$this, 'sanitize_icon_path'],
            'auth_callback' => function() { return current_user_can('edit_posts'); },
        ]);
        register_post_meta(self::POST_TYPE, self::META_COLOR, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'default'       => 'text-blue-600 bg-blue-100',
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback' => function() { return current_user_can('edit_posts'); },
        ]);
        register_post_meta(self::POST_TYPE, self::META_URL, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'default'       => '',
            'sanitize_callback' => 'esc_url_raw',
            'auth_callback' => function() { return current_user_can('edit_posts'); },
        ]);
    }

    public function register_meta_boxes() {
        add_meta_box(
            'mtq_cabang_meta',
            __('Pengaturan Cabang Lomba', 'mtq-aceh-pidie-jaya'),
            [$this, 'render_meta_box'],
            self::POST_TYPE,
            'normal',
            'default'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field('mtq_cabang_save_meta', 'mtq_cabang_meta_nonce');
        $icon  = get_post_meta($post->ID, self::META_ICON, true);
        $color = get_post_meta($post->ID, self::META_COLOR, true);
        $url   = get_post_meta($post->ID, self::META_URL, true);
        ?>
        <p>
            <label for="mtq_cabang_icon_path"><strong><?php _e('SVG Icon Path (atribut d)', 'mtq-aceh-pidie-jaya'); ?></strong></label><br>
            <textarea id="mtq_cabang_icon_path" name="mtq_cabang_icon_path" rows="2" style="width:100%;" placeholder="M12 6.042A8.967 ..."><?php echo esc_textarea($icon); ?></textarea>
            <small><?php _e('Hanya path (nilai atribut d) dari elemen <path>.', 'mtq-aceh-pidie-jaya'); ?></small>
        </p>
        <p>
            <label for="mtq_cabang_color_classes"><strong><?php _e('Warna/Classes', 'mtq-aceh-pidie-jaya'); ?></strong></label><br>
            <input type="text" id="mtq_cabang_color_classes" name="mtq_cabang_color_classes" value="<?php echo esc_attr($color ?: 'text-blue-600 bg-blue-100'); ?>" class="regular-text" placeholder="mis: text-green-600 bg-green-100">
            <small><?php _e('Gunakan utilitas Tailwind (text-*, bg-*) untuk ikon.', 'mtq-aceh-pidie-jaya'); ?></small>
        </p>
        <p>
            <label for="mtq_cabang_custom_url"><strong><?php _e('Custom URL (opsional)', 'mtq-aceh-pidie-jaya'); ?></strong></label><br>
            <input type="url" id="mtq_cabang_custom_url" name="mtq_cabang_custom_url" value="<?php echo esc_attr($url); ?>" class="regular-text" placeholder="https://example.com/halaman-detail">
            <small><?php _e('Jika kosong, kartu akan menuju halaman detail (permalink) cabang ini.', 'mtq-aceh-pidie-jaya'); ?></small>
        </p>
        <?php
    }

    public function save_meta($post_id) {
        if (!isset($_POST['mtq_cabang_meta_nonce']) || !wp_verify_nonce($_POST['mtq_cabang_meta_nonce'], 'mtq_cabang_save_meta')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['mtq_cabang_icon_path'])) {
            update_post_meta($post_id, self::META_ICON, $this->sanitize_icon_path($_POST['mtq_cabang_icon_path']));
        }
        if (isset($_POST['mtq_cabang_color_classes'])) {
            update_post_meta($post_id, self::META_COLOR, sanitize_text_field($_POST['mtq_cabang_color_classes']));
        }
        if (isset($_POST['mtq_cabang_custom_url'])) {
            update_post_meta($post_id, self::META_URL, esc_url_raw($_POST['mtq_cabang_custom_url']));
        }
    }

    public function sanitize_icon_path($value) {
        $value = trim((string)$value);
        // Allow only safe characters typical for SVG path data.
        // Remove any HTML tags just in case.
        $value = wp_kses($value, []);
        return $value;
    }
}

// Initialize
new MTQ_Cabang_Lomba_CPT();

/**
 * Helper: Fetch cabang items from CPT in array shape compatible with mtq_get_cabang_lomba().
 */
function mtq_get_cabang_lomba_from_cpt() {
    $args = [
        'post_type'      => MTQ_Cabang_Lomba_CPT::POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => ['menu_order' => 'ASC', 'title' => 'ASC'],
    ];
    $q = new WP_Query($args);
    if (!$q->have_posts()) {
        return [];
    }
    $items = [];
    while ($q->have_posts()) { $q->the_post();
        $id    = get_the_ID();
        $title = get_the_title();
        $desc  = has_excerpt() ? get_the_excerpt() : wp_strip_all_tags(wp_trim_words(get_the_content(null, false, $id), 25));
        $icon  = get_post_meta($id, MTQ_Cabang_Lomba_CPT::META_ICON, true);
        $color = get_post_meta($id, MTQ_Cabang_Lomba_CPT::META_COLOR, true);
        $url   = get_post_meta($id, MTQ_Cabang_Lomba_CPT::META_URL, true);
        if (empty($url)) { $url = get_permalink($id); }
        $items[sanitize_key($title) . '-' . $id] = [
            'nama'       => $title,
            'icon'       => $icon ?: 'M12 6.042A8.967 8.967 0 006 3.75...',
            'deskripsi'  => $desc,
            'warna'      => $color ?: 'text-blue-600 bg-blue-100',
            'url'        => $url,
        ];
    }
    wp_reset_postdata();
    return $items;
}
