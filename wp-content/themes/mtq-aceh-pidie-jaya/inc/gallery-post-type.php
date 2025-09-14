<?php
/**
 * MTQ Gallery Custom Post Type
 * Untuk mengelola foto dan video kegiatan MTQ
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!defined('ABSPATH')) {
    exit;
}

class MTQ_Gallery_Post_Type {
    
    public function __construct() {
        // Remove init hooks from constructor to prevent double initialization
        add_action('add_meta_boxes', array($this, 'add_gallery_meta_boxes'));
        add_action('save_post', array($this, 'save_gallery_meta'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_filter('manage_mtq_gallery_posts_columns', array($this, 'set_custom_columns'));
        add_action('manage_mtq_gallery_posts_custom_column', array($this, 'custom_column_content'), 10, 2);
        
        // Register post type and taxonomies immediately
        $this->register_gallery_post_type();
        $this->register_gallery_taxonomies();
    }
    
    /**
     * Register Gallery Custom Post Type
     */
    public function register_gallery_post_type() {
        $labels = array(
            'name'                  => 'Gallery MTQ',
            'singular_name'         => 'Gallery',
            'menu_name'             => 'Gallery MTQ',
            'name_admin_bar'        => 'Gallery',
            'archives'              => 'Gallery Archives',
            'attributes'            => 'Gallery Attributes',
            'parent_item_colon'     => 'Parent Gallery:',
            'all_items'             => 'Semua Gallery',
            'add_new_item'          => 'Tambah Gallery Baru',
            'add_new'               => 'Tambah Gallery',
            'new_item'              => 'Gallery Baru',
            'edit_item'             => 'Edit Gallery',
            'update_item'           => 'Update Gallery',
            'view_item'             => 'Lihat Gallery',
            'view_items'            => 'Lihat Gallery',
            'search_items'          => 'Cari Gallery',
            'not_found'             => 'Gallery tidak ditemukan',
            'not_found_in_trash'    => 'Gallery tidak ditemukan di trash',
            'featured_image'        => 'Gambar Unggulan',
            'set_featured_image'    => 'Set gambar unggulan',
            'remove_featured_image' => 'Remove gambar unggulan',
            'use_featured_image'    => 'Gunakan sebagai gambar unggulan',
            'insert_into_item'      => 'Insert ke gallery',
            'uploaded_to_this_item' => 'Upload ke gallery ini',
            'items_list'            => 'Daftar gallery',
            'items_list_navigation' => 'Navigasi daftar gallery',
            'filter_items_list'     => 'Filter daftar gallery',
        );
        
        $args = array(
            'label'                 => 'Gallery',
            'description'           => 'Gallery foto dan video kegiatan MTQ',
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'comments'),
            'taxonomies'            => array('mtq_gallery_category', 'mtq_gallery_tag'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 25,
            'menu_icon'             => 'dashicons-format-gallery',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'gallery',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rewrite'               => array(
                'slug' => 'gallery',
                'with_front' => false,
                'pages' => true,
                'feeds' => true,
            ),
            'query_var'             => true,
        );
        
        register_post_type('mtq_gallery', $args);
    }
    
    /**
     * Register Gallery Taxonomies
     */
    public function register_gallery_taxonomies() {
        // Gallery Categories
        $category_labels = array(
            'name'              => 'Kategori Gallery',
            'singular_name'     => 'Kategori',
            'search_items'      => 'Cari Kategori',
            'all_items'         => 'Semua Kategori',
            'parent_item'       => 'Parent Kategori',
            'parent_item_colon' => 'Parent Kategori:',
            'edit_item'         => 'Edit Kategori',
            'update_item'       => 'Update Kategori',
            'add_new_item'      => 'Tambah Kategori Baru',
            'new_item_name'     => 'Nama Kategori Baru',
            'menu_name'         => 'Kategori',
        );
        
        register_taxonomy('mtq_gallery_category', array('mtq_gallery'), array(
            'hierarchical'      => true,
            'labels'            => $category_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_rest'      => true,
            'rewrite'           => array('slug' => 'gallery-category'),
        ));
        
        // Gallery Tags
        $tag_labels = array(
            'name'                       => 'Tag Gallery',
            'singular_name'              => 'Tag',
            'search_items'               => 'Cari Tag',
            'popular_items'              => 'Tag Populer',
            'all_items'                  => 'Semua Tag',
            'edit_item'                  => 'Edit Tag',
            'update_item'                => 'Update Tag',
            'add_new_item'               => 'Tambah Tag Baru',
            'new_item_name'              => 'Nama Tag Baru',
            'separate_items_with_commas' => 'Pisahkan tag dengan koma',
            'add_or_remove_items'        => 'Tambah atau hapus tag',
            'choose_from_most_used'      => 'Pilih dari tag yang sering digunakan',
            'not_found'                  => 'Tag tidak ditemukan',
            'menu_name'                  => 'Tag',
        );
        
        register_taxonomy('mtq_gallery_tag', array('mtq_gallery'), array(
            'hierarchical'          => false,
            'labels'                => $tag_labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'query_var'             => true,
            'show_in_rest'          => true,
            'rewrite'               => array('slug' => 'gallery-tag'),
        ));
    }
    
    /**
     * Add Meta Boxes
     */
    public function add_gallery_meta_boxes() {
        add_meta_box(
            'mtq_gallery_images',
            'Gallery Images',
            array($this, 'gallery_images_meta_box'),
            'mtq_gallery',
            'normal',
            'high'
        );
        
        add_meta_box(
            'mtq_gallery_videos',
            'Gallery Videos',
            array($this, 'gallery_videos_meta_box'),
            'mtq_gallery',
            'normal',
            'high'
        );
        
        add_meta_box(
            'mtq_gallery_settings',
            'Gallery Settings',
            array($this, 'gallery_settings_meta_box'),
            'mtq_gallery',
            'side',
            'default'
        );
        
        add_meta_box(
            'mtq_gallery_help',
            '📚 Gallery Help & Features',
            array($this, 'gallery_help_meta_box'),
            'mtq_gallery',
            'side',
            'low'
        );
    }
    
    /**
     * Gallery Images Meta Box
     */
    public function gallery_images_meta_box($post) {
        wp_nonce_field('mtq_gallery_meta_nonce', 'mtq_gallery_meta_nonce');
        
        $gallery_images = get_post_meta($post->ID, '_mtq_gallery_images', true);
        $gallery_images = !empty($gallery_images) ? $gallery_images : array();
        ?>
        <div id="mtq-gallery-images-container">
            <div class="mtq-gallery-upload-area">
                <button type="button" id="mtq-upload-images-btn" class="button button-primary">
                    📸 Upload Images
                </button>
                <p class="description">Upload multiple images untuk gallery ini. Klik dan drag untuk mengatur urutan.</p>
            </div>
            
            <div id="mtq-gallery-images-list" class="mtq-gallery-items-grid">
                <?php foreach ($gallery_images as $index => $image_id): ?>
                    <div class="mtq-gallery-item" data-id="<?php echo esc_attr($image_id); ?>">
                        <div class="mtq-gallery-item-preview">
                            <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                            <div class="mtq-gallery-item-actions">
                                <button type="button" class="mtq-remove-item" data-id="<?php echo esc_attr($image_id); ?>">×</button>
                            </div>
                        </div>
                        <input type="hidden" name="mtq_gallery_images[]" value="<?php echo esc_attr($image_id); ?>">
                        <div class="mtq-gallery-item-caption">
                            <input type="text" name="mtq_gallery_image_captions[<?php echo esc_attr($image_id); ?>]" 
                                   value="<?php echo esc_attr(get_post_meta($post->ID, '_mtq_gallery_image_caption_' . $image_id, true)); ?>" 
                                   placeholder="Caption untuk gambar ini...">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <style>
        .mtq-gallery-items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .mtq-gallery-item {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            background: #f9f9f9;
            cursor: move;
        }
        
        .mtq-gallery-item-preview {
            position: relative;
            margin-bottom: 10px;
        }
        
        .mtq-gallery-item-preview img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }
        
        .mtq-gallery-item-actions {
            position: absolute;
            top: 5px;
            right: 5px;
        }
        
        .mtq-remove-item {
            background: #dc3232;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .mtq-gallery-item-caption input {
            width: 100%;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 12px;
        }
        
        .mtq-gallery-upload-area {
            text-align: center;
            padding: 20px;
            border: 2px dashed #ddd;
            border-radius: 4px;
            background: #fafafa;
        }
        </style>
        <?php
    }
    
    /**
     * Gallery Videos Meta Box
     */
    public function gallery_videos_meta_box($post) {
        $gallery_videos = get_post_meta($post->ID, '_mtq_gallery_videos', true);
        $gallery_videos = !empty($gallery_videos) ? $gallery_videos : array();
        ?>
        <div id="mtq-gallery-videos-container">
            <div class="mtq-gallery-upload-area">
                <button type="button" id="mtq-upload-videos-btn" class="button button-primary">
                    🎬 Upload Videos
                </button>
                <button type="button" id="mtq-add-youtube-btn" class="button">
                    📺 Tambah YouTube Video
                </button>
                <p class="description">Upload video files atau tambahkan YouTube videos.</p>
            </div>
            
            <div id="mtq-gallery-videos-list" class="mtq-gallery-items-grid">
                <?php foreach ($gallery_videos as $index => $video): ?>
                    <div class="mtq-gallery-video-item" data-type="<?php echo esc_attr($video['type']); ?>">
                        <div class="mtq-gallery-item-preview">
                            <?php if ($video['type'] === 'file'): ?>
                                <video width="100%" height="auto" controls>
                                    <source src="<?php echo esc_url($video['url']); ?>" type="video/mp4">
                                </video>
                            <?php else: ?>
                                <iframe width="100%" height="120" src="<?php echo esc_url($video['url']); ?>" frameborder="0" allowfullscreen></iframe>
                            <?php endif; ?>
                            <div class="mtq-gallery-item-actions">
                                <button type="button" class="mtq-remove-video" data-index="<?php echo esc_attr($index); ?>">×</button>
                            </div>
                        </div>
                        <input type="hidden" name="mtq_gallery_videos[<?php echo esc_attr($index); ?>][type]" value="<?php echo esc_attr($video['type']); ?>">
                        <input type="hidden" name="mtq_gallery_videos[<?php echo esc_attr($index); ?>][url]" value="<?php echo esc_attr($video['url']); ?>">
                        <div class="mtq-gallery-item-caption">
                            <input type="text" name="mtq_gallery_videos[<?php echo esc_attr($index); ?>][caption]" 
                                   value="<?php echo esc_attr($video['caption']); ?>" 
                                   placeholder="Caption untuk video ini...">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- YouTube URL Input Modal -->
        <div id="youtube-url-modal" style="display: none;">
            <div class="youtube-modal-content">
                <h3>Tambah YouTube Video</h3>
                <input type="url" id="youtube-url-input" placeholder="Masukkan URL YouTube..." style="width: 100%; padding: 10px; margin: 10px 0;">
                <div class="youtube-modal-actions">
                    <button type="button" id="add-youtube-video" class="button button-primary">Tambah</button>
                    <button type="button" id="cancel-youtube" class="button">Batal</button>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Gallery Settings Meta Box
     */
    public function gallery_settings_meta_box($post) {
        $gallery_layout = get_post_meta($post->ID, '_mtq_gallery_layout', true);
        $gallery_columns = get_post_meta($post->ID, '_mtq_gallery_columns', true);
        $show_captions = get_post_meta($post->ID, '_mtq_gallery_show_captions', true);
        $enable_lightbox = get_post_meta($post->ID, '_mtq_gallery_enable_lightbox', true);
        
        $gallery_layout = !empty($gallery_layout) ? $gallery_layout : 'grid';
        $gallery_columns = !empty($gallery_columns) ? $gallery_columns : '3';
        $show_captions = !empty($show_captions) ? $show_captions : 'yes';
        $enable_lightbox = !empty($enable_lightbox) ? $enable_lightbox : 'yes';
        ?>
        <table class="form-table">
            <tr>
                <th><label for="mtq_gallery_layout">Layout</label></th>
                <td>
                    <select name="mtq_gallery_layout" id="mtq_gallery_layout">
                        <option value="grid" <?php selected($gallery_layout, 'grid'); ?>>Grid</option>
                        <option value="masonry" <?php selected($gallery_layout, 'masonry'); ?>>Masonry</option>
                        <option value="slider" <?php selected($gallery_layout, 'slider'); ?>>Slider/Carousel</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="mtq_gallery_columns">Columns</label></th>
                <td>
                    <select name="mtq_gallery_columns" id="mtq_gallery_columns">
                        <option value="2" <?php selected($gallery_columns, '2'); ?>>2 Kolom</option>
                        <option value="3" <?php selected($gallery_columns, '3'); ?>>3 Kolom</option>
                        <option value="4" <?php selected($gallery_columns, '4'); ?>>4 Kolom</option>
                        <option value="5" <?php selected($gallery_columns, '5'); ?>>5 Kolom</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="mtq_gallery_show_captions">Show Captions</label></th>
                <td>
                    <input type="checkbox" name="mtq_gallery_show_captions" id="mtq_gallery_show_captions" value="yes" <?php checked($show_captions, 'yes'); ?>>
                    <label for="mtq_gallery_show_captions">Tampilkan caption pada gallery</label>
                </td>
            </tr>
            <tr>
                <th><label for="mtq_gallery_enable_lightbox">Enhanced Modal Gallery</label></th>
                <td>
                    <input type="checkbox" name="mtq_gallery_enable_lightbox" id="mtq_gallery_enable_lightbox" value="yes" <?php checked($enable_lightbox, 'yes'); ?>>
                    <label for="mtq_gallery_enable_lightbox">Enable enhanced modal gallery</label>
                    <p class="description">
                        🚀 <strong>Features:</strong> Navigation arrows, zoom controls, fullscreen mode, touch gestures, dan keyboard shortcuts (←/→ arrows, ESC to close)
                    </p>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Gallery Help Meta Box
     */
    public function gallery_help_meta_box($post) {
        ?>
        <div style="font-size: 13px; line-height: 1.5;">
            <h4 style="margin-top: 0;">🎯 Enhanced Modal Features</h4>
            <ul style="margin: 0; padding-left: 20px;">
                <li><strong>Navigation:</strong> Arrow buttons & keyboard (←/→)</li>
                <li><strong>Zoom:</strong> Mouse wheel & zoom buttons</li>
                <li><strong>Fullscreen:</strong> Double-click or fullscreen button</li>
                <li><strong>Touch:</strong> Swipe gestures on mobile</li>
                <li><strong>Exit:</strong> ESC key, close button, or backdrop click</li>
            </ul>
            
            <h4>💡 Quick Tips</h4>
            <ul style="margin: 0; padding-left: 20px;">
                <li>Drag images to reorder gallery sequence</li>
                <li>Mixed content (images + videos) supported</li>
                <li>Captions appear in modal overlay</li>
                <li>Test gallery by using shortcode: <code>[mtq_gallery id="<?php echo $post->ID; ?>"]</code></li>
            </ul>
            
            <h4>🔧 Display Options</h4>
            <p style="margin: 10px 0;">
                <strong>Shortcode:</strong><br>
                <code>[mtq_gallery id="<?php echo $post->ID; ?>" columns="3" show_title="true"]</code>
            </p>
            
            <div style="background: #f0f6fc; padding: 10px; border-radius: 4px; margin-top: 15px;">
                <strong>🚀 Ready to use!</strong><br>
                Gallery dengan enhanced modal sudah siap. Enable lightbox di settings untuk mengaktifkan semua fitur.
            </div>
        </div>
        <?php
    }
    
    /**
     * Save Gallery Meta
     */
    public function save_gallery_meta($post_id) {
        if (!isset($_POST['mtq_gallery_meta_nonce']) || !wp_verify_nonce($_POST['mtq_gallery_meta_nonce'], 'mtq_gallery_meta_nonce')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Save images
        if (isset($_POST['mtq_gallery_images'])) {
            $images = array_map('intval', $_POST['mtq_gallery_images']);
            update_post_meta($post_id, '_mtq_gallery_images', $images);
            
            // Save image captions
            if (isset($_POST['mtq_gallery_image_captions'])) {
                foreach ($_POST['mtq_gallery_image_captions'] as $image_id => $caption) {
                    update_post_meta($post_id, '_mtq_gallery_image_caption_' . intval($image_id), sanitize_text_field($caption));
                }
            }
        } else {
            delete_post_meta($post_id, '_mtq_gallery_images');
        }
        
        // Save videos
        if (isset($_POST['mtq_gallery_videos'])) {
            $videos = array();
            foreach ($_POST['mtq_gallery_videos'] as $video) {
                $videos[] = array(
                    'type' => sanitize_text_field($video['type']),
                    'url' => esc_url_raw($video['url']),
                    'caption' => sanitize_text_field($video['caption'])
                );
            }
            update_post_meta($post_id, '_mtq_gallery_videos', $videos);
        } else {
            delete_post_meta($post_id, '_mtq_gallery_videos');
        }
        
        // Save settings
        $layout = isset($_POST['mtq_gallery_layout']) ? sanitize_text_field($_POST['mtq_gallery_layout']) : 'grid';
        update_post_meta($post_id, '_mtq_gallery_layout', $layout);
        
        $columns = isset($_POST['mtq_gallery_columns']) ? sanitize_text_field($_POST['mtq_gallery_columns']) : '3';
        update_post_meta($post_id, '_mtq_gallery_columns', $columns);
        
        $show_captions = isset($_POST['mtq_gallery_show_captions']) ? 'yes' : 'no';
        update_post_meta($post_id, '_mtq_gallery_show_captions', $show_captions);
        
        $enable_lightbox = isset($_POST['mtq_gallery_enable_lightbox']) ? 'yes' : 'no';
        update_post_meta($post_id, '_mtq_gallery_enable_lightbox', $enable_lightbox);
    }
    
    /**
     * Enqueue Admin Scripts
     */
    public function enqueue_admin_scripts($hook) {
        global $post;
        
        if ($hook != 'post-new.php' && $hook != 'post.php') {
            return;
        }
        
        if ('mtq_gallery' != $post->post_type) {
            return;
        }
        
        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-sortable');
        
        // Add admin CSS
        wp_add_inline_style('wp-admin', '
            .mtq-gallery-item, .mtq-gallery-video-item {
                position: relative;
                display: inline-block;
                margin: 5px;
                border: 2px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
                transition: all 0.3s ease;
            }
            .mtq-gallery-item:hover, .mtq-gallery-video-item:hover {
                border-color: #0073aa;
                box-shadow: 0 2px 8px rgba(0,115,170,0.2);
            }
            .mtq-gallery-item-preview {
                position: relative;
                background: #f5f5f5;
            }
            .mtq-gallery-item-preview img {
                display: block;
                max-width: 100%;
                height: auto;
            }
            .mtq-gallery-item-actions {
                position: absolute;
                top: 5px;
                right: 5px;
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            .mtq-gallery-item:hover .mtq-gallery-item-actions,
            .mtq-gallery-video-item:hover .mtq-gallery-item-actions {
                opacity: 1;
            }
            .mtq-remove-item, .mtq-remove-video {
                background: #dc3232;
                color: white;
                border: none;
                border-radius: 50%;
                width: 24px;
                height: 24px;
                font-size: 16px;
                line-height: 1;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .mtq-remove-item:hover, .mtq-remove-video:hover {
                background: #a00;
            }
            .mtq-gallery-item-caption input {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 0 0 6px 6px;
                font-size: 12px;
            }
            #youtube-url-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.7);
                z-index: 9999;
                display: none;
                align-items: center;
                justify-content: center;
            }
            .youtube-modal-content {
                background: white;
                padding: 20px;
                border-radius: 8px;
                max-width: 400px;
                width: 90%;
            }
            .enhanced-modal-info {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 15px;
                border-radius: 8px;
                margin: 10px 0;
            }
            .enhanced-modal-info h4 {
                margin: 0 0 10px 0;
                color: white;
            }
        ');
        
        
        wp_add_inline_script('jquery', '
            jQuery(document).ready(function($) {
                // Media uploader for images
                $("#mtq-upload-images-btn").click(function(e) {
                    e.preventDefault();
                    var frame = wp.media({
                        title: "Select Gallery Images",
                        multiple: true,
                        library: { type: "image" }
                    });
                    
                    frame.on("select", function() {
                        var selection = frame.state().get("selection");
                        selection.each(function(attachment) {
                            addImageToGallery(attachment.toJSON());
                        });
                    });
                    
                    frame.open();
                });
                
                // Media uploader for videos
                $("#mtq-upload-videos-btn").click(function(e) {
                    e.preventDefault();
                    var frame = wp.media({
                        title: "Select Gallery Videos",
                        multiple: true,
                        library: { type: "video" }
                    });
                    
                    frame.on("select", function() {
                        var selection = frame.state().get("selection");
                        selection.each(function(attachment) {
                            addVideoToGallery(attachment.toJSON(), "file");
                        });
                    });
                    
                    frame.open();
                });
                
                // YouTube video modal
                $("#mtq-add-youtube-btn").click(function() {
                    $("#youtube-url-modal").show();
                });
                
                $("#cancel-youtube").click(function() {
                    $("#youtube-url-modal").hide();
                    $("#youtube-url-input").val("");
                });
                
                $("#add-youtube-video").click(function() {
                    var url = $("#youtube-url-input").val();
                    if (url) {
                        var embedUrl = convertToEmbedUrl(url);
                        if (embedUrl) {
                            addVideoToGallery({url: embedUrl}, "youtube");
                            $("#youtube-url-modal").hide();
                            $("#youtube-url-input").val("");
                        } else {
                            alert("URL YouTube tidak valid!");
                        }
                    }
                });
                
                // Remove items
                $(document).on("click", ".mtq-remove-item", function() {
                    $(this).closest(".mtq-gallery-item").remove();
                });
                
                $(document).on("click", ".mtq-remove-video", function() {
                    $(this).closest(".mtq-gallery-video-item").remove();
                });
                
                // Sortable
                $("#mtq-gallery-images-list").sortable({
                    placeholder: "ui-state-highlight"
                });
                
                $("#mtq-gallery-videos-list").sortable({
                    placeholder: "ui-state-highlight"
                });
                
                function addImageToGallery(attachment) {
                    var html = `
                        <div class="mtq-gallery-item" data-id="${attachment.id}">
                            <div class="mtq-gallery-item-preview">
                                <img src="${attachment.sizes.thumbnail.url}" alt="${attachment.alt}">
                                <div class="mtq-gallery-item-actions">
                                    <button type="button" class="mtq-remove-item" data-id="${attachment.id}">×</button>
                                </div>
                            </div>
                            <input type="hidden" name="mtq_gallery_images[]" value="${attachment.id}">
                            <div class="mtq-gallery-item-caption">
                                <input type="text" name="mtq_gallery_image_captions[${attachment.id}]" value="" placeholder="Caption untuk gambar ini...">
                            </div>
                        </div>
                    `;
                    $("#mtq-gallery-images-list").append(html);
                }
                
                function addVideoToGallery(attachment, type) {
                    var index = Date.now();
                    var videoHtml = "";
                    
                    if (type === "file") {
                        videoHtml = `<video width="100%" height="120" controls><source src="${attachment.url}" type="video/mp4"></video>`;
                    } else {
                        videoHtml = `<iframe width="100%" height="120" src="${attachment.url}" frameborder="0" allowfullscreen></iframe>`;
                    }
                    
                    var html = `
                        <div class="mtq-gallery-video-item" data-type="${type}">
                            <div class="mtq-gallery-item-preview">
                                ${videoHtml}
                                <div class="mtq-gallery-item-actions">
                                    <button type="button" class="mtq-remove-video" data-index="${index}">×</button>
                                </div>
                            </div>
                            <input type="hidden" name="mtq_gallery_videos[${index}][type]" value="${type}">
                            <input type="hidden" name="mtq_gallery_videos[${index}][url]" value="${attachment.url}">
                            <div class="mtq-gallery-item-caption">
                                <input type="text" name="mtq_gallery_videos[${index}][caption]" value="" placeholder="Caption untuk video ini...">
                            </div>
                        </div>
                    `;
                    $("#mtq-gallery-videos-list").append(html);
                }
                
                function convertToEmbedUrl(url) {
                    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                    var match = url.match(regExp);
                    
                    if (match && match[2].length == 11) {
                        return "https://www.youtube.com/embed/" + match[2];
                    }
                    return false;
                }
            });
        ');
    }
    
    /**
     * Set Custom Columns
     */
    public function set_custom_columns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['title'] = $columns['title'];
        $new_columns['gallery_preview'] = 'Preview';
        $new_columns['gallery_type'] = 'Type';
        $new_columns['gallery_count'] = 'Items';
        $new_columns['mtq_gallery_category'] = 'Kategori';
        $new_columns['date'] = $columns['date'];
        
        return $new_columns;
    }
    
    /**
     * Custom Column Content
     */
    public function custom_column_content($column, $post_id) {
        switch ($column) {
            case 'gallery_preview':
                $images = get_post_meta($post_id, '_mtq_gallery_images', true);
                if (!empty($images) && is_array($images)) {
                    $first_image = wp_get_attachment_image($images[0], array(50, 50));
                    echo $first_image ? $first_image : '—';
                } else {
                    echo '—';
                }
                break;
                
            case 'gallery_type':
                $images = get_post_meta($post_id, '_mtq_gallery_images', true);
                $videos = get_post_meta($post_id, '_mtq_gallery_videos', true);
                
                $types = array();
                if (!empty($images)) $types[] = 'Images';
                if (!empty($videos)) $types[] = 'Videos';
                
                echo !empty($types) ? implode(', ', $types) : 'Empty';
                break;
                
            case 'gallery_count':
                $images = get_post_meta($post_id, '_mtq_gallery_images', true);
                $videos = get_post_meta($post_id, '_mtq_gallery_videos', true);
                
                $image_count = !empty($images) ? count($images) : 0;
                $video_count = !empty($videos) ? count($videos) : 0;
                
                if ($image_count > 0 && $video_count > 0) {
                    echo sprintf('%d foto, %d video', $image_count, $video_count);
                } elseif ($image_count > 0) {
                    echo sprintf('%d foto', $image_count);
                } elseif ($video_count > 0) {
                    echo sprintf('%d video', $video_count);
                } else {
                    echo '0 items';
                }
                break;
        }
    }
}
