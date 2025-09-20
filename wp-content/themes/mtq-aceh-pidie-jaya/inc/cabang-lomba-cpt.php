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
    const META_COLOR  = '_mtq_cabang_color_classes';
    const META_URL    = '_mtq_cabang_custom_url';
    const META_ICON_MEDIA = '_mtq_cabang_icon_media_id';

    public function __construct() {
        add_action('init', [$this, 'register_post_type']);
    add_action('add_meta_boxes', [$this, 'register_meta_boxes']);
        add_action('save_post_' . self::POST_TYPE, [$this, 'save_meta']);
    add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);

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
        register_post_meta(self::POST_TYPE, self::META_ICON_MEDIA, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'integer',
            'default'       => 0,
            'sanitize_callback' => 'absint',
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
        $color = get_post_meta($post->ID, self::META_COLOR, true);
        $url   = get_post_meta($post->ID, self::META_URL, true);
        $icon_media_id = (int) get_post_meta($post->ID, self::META_ICON_MEDIA, true);
        $icon_media_url = $icon_media_id ? wp_get_attachment_url($icon_media_id) : '';
        ?>
        <p>
            <label><strong><?php _e('Ikon (Media Library)', 'mtq-aceh-pidie-jaya'); ?></strong></label><br>
            <input type="hidden" id="mtq_cabang_icon_media_id" name="mtq_cabang_icon_media_id" value="<?php echo esc_attr($icon_media_id ?: 0); ?>">
            <div id="mtq-cabang-icon-preview" style="margin:8px 0; min-height:40px;">
                <?php if ($icon_media_url): ?>
                    <img src="<?php echo esc_url($icon_media_url); ?>" alt="" style="max-width:64px; max-height:64px;" />
                <?php endif; ?>
            </div>
            <button type="button" class="button" id="mtq-cabang-icon-upload"><?php _e('Pilih/Upload Ikon', 'mtq-aceh-pidie-jaya'); ?></button>
            <button type="button" class="button" id="mtq-cabang-icon-remove" style="margin-left:8px;<?php echo $icon_media_id ? '' : 'display:none;'; ?>"><?php _e('Hapus', 'mtq-aceh-pidie-jaya'); ?></button>
            <small style="display:block; margin-top:4px;">
                <?php _e('Dukungan PNG/JPG/SVG melalui Media Library.', 'mtq-aceh-pidie-jaya'); ?>
            </small>
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

        if (isset($_POST['mtq_cabang_icon_media_id'])) {
            update_post_meta($post_id, self::META_ICON_MEDIA, absint($_POST['mtq_cabang_icon_media_id']));
        }
        if (isset($_POST['mtq_cabang_color_classes'])) {
            update_post_meta($post_id, self::META_COLOR, sanitize_text_field($_POST['mtq_cabang_color_classes']));
        }
        if (isset($_POST['mtq_cabang_custom_url'])) {
            update_post_meta($post_id, self::META_URL, esc_url_raw($_POST['mtq_cabang_custom_url']));
        }
    }

    public function enqueue_admin_assets($hook) {
        // Only enqueue on Cabang Lomba edit/add screens
        $screen = function_exists('get_current_screen') ? get_current_screen() : null;
        if (!$screen || $screen->post_type !== self::POST_TYPE) {
            return;
        }
        // Media for uploader
        wp_enqueue_media();
        // Admin JS
        wp_enqueue_script(
            'mtq-cabang-meta',
            get_template_directory_uri() . '/assets/admin/cabang-meta.js',
            array('jquery'),
            defined('_S_VERSION') ? _S_VERSION : '1.0.0',
            true
        );
        // Admin CSS (optional minimal)
        wp_enqueue_style(
            'mtq-cabang-meta',
            get_template_directory_uri() . '/assets/admin/cabang-meta.css',
            array(),
            defined('_S_VERSION') ? _S_VERSION : '1.0.0'
        );
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
        $icon_media_id = (int) get_post_meta($id, MTQ_Cabang_Lomba_CPT::META_ICON_MEDIA, true);
        $color = get_post_meta($id, MTQ_Cabang_Lomba_CPT::META_COLOR, true);
        $url   = get_post_meta($id, MTQ_Cabang_Lomba_CPT::META_URL, true);
        if (empty($url)) { $url = get_permalink($id); }
        $items[sanitize_key($title) . '-' . $id] = [
            'nama'       => $title,
            'icon_media_id' => $icon_media_id,
            'deskripsi'  => $desc,
            'warna'      => $color ?: 'text-blue-600 bg-blue-100',
            'url'        => $url,
        ];
    }
    wp_reset_postdata();
    return $items;
}

/**
 * Helper: Inline sanitized SVG from attachment ID (restrict allowed tags/attrs).
 */
function mtq_inline_svg_attachment($attachment_id) {
    $attachment_id = absint($attachment_id);
    if (!$attachment_id) return '';
    $mime = get_post_mime_type($attachment_id);
    if ($mime !== 'image/svg+xml') return '';
    $path = get_attached_file($attachment_id);
    if (!$path || !file_exists($path)) return '';
    $svg = file_get_contents($path);
    if ($svg === false) return '';
    // Sanitize SVG with strict whitelist
    $allowed_tags = array(
        'svg'  => array(
            'xmlns' => true,
            'viewBox' => true,
            'width' => true,
            'height' => true,
            'fill' => true,
            'stroke' => true,
            'stroke-width' => true,
            'class' => true,
        ),
        'g'    => array('fill'=>true, 'stroke'=>true, 'class'=>true),
        'title'=> array(),
        'path' => array(
            'd' => true,
            'fill' => true,
            'stroke' => true,
            'stroke-width' => true,
            'stroke-linecap' => true,
            'stroke-linejoin' => true,
            'class' => true,
        ),
    );
    $svg = wp_kses($svg, $allowed_tags);
    // Ensure no script/style sneaks in
    $svg = preg_replace('#<\/(?:script|style)>#i', '', $svg);
    return $svg;
}
