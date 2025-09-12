<?php
/**
 * MTQ YouTube Live Stream Admin Configuration
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * YouTube Live Stream Settings Admin
 */
class MTQ_YouTube_Live_Admin {
    
    public function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_menu', array($this, 'add_admin_page'));
        add_action('wp_ajax_mtq_update_youtube_preview', array($this, 'ajax_update_youtube_preview'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_youtube_scripts'));
    }
    
    /**
     * Register YouTube live stream settings
     */
    public function register_settings() {
        // Add settings section
        add_settings_section(
            'mtq_youtube_live_section',
            __('Pengaturan Live Stream YouTube', 'mtq-aceh-pidie-jaya'),
            array($this, 'settings_section_callback'),
            'mtq_youtube_live_settings'
        );
        
        // YouTube URL setting
        add_settings_field(
            'mtq_youtube_url',
            __('URL YouTube Live Stream', 'mtq-aceh-pidie-jaya'),
            array($this, 'youtube_url_callback'),
            'mtq_youtube_live_settings',
            'mtq_youtube_live_section'
        );
        
        // Live stream title
        add_settings_field(
            'mtq_youtube_title',
            __('Judul Live Stream', 'mtq-aceh-pidie-jaya'),
            array($this, 'youtube_title_callback'),
            'mtq_youtube_live_settings',
            'mtq_youtube_live_section'
        );
        
        // Live stream description
        add_settings_field(
            'mtq_youtube_description',
            __('Deskripsi Live Stream', 'mtq-aceh-pidie-jaya'),
            array($this, 'youtube_description_callback'),
            'mtq_youtube_live_settings',
            'mtq_youtube_live_section'
        );
        
        // Live stream status
        add_settings_field(
            'mtq_youtube_status',
            __('Status Live Stream', 'mtq-aceh-pidie-jaya'),
            array($this, 'youtube_status_callback'),
            'mtq_youtube_live_settings',
            'mtq_youtube_live_section'
        );
        
        // Display options
        add_settings_field(
            'mtq_youtube_autoplay',
            __('Auto Play', 'mtq-aceh-pidie-jaya'),
            array($this, 'youtube_autoplay_callback'),
            'mtq_youtube_live_settings',
            'mtq_youtube_live_section'
        );
        
        add_settings_field(
            'mtq_youtube_controls',
            __('Tampilkan Controls', 'mtq-aceh-pidie-jaya'),
            array($this, 'youtube_controls_callback'),
            'mtq_youtube_live_settings',
            'mtq_youtube_live_section'
        );
        
        add_settings_field(
            'mtq_youtube_fullscreen',
            __('Allow Fullscreen', 'mtq-aceh-pidie-jaya'),
            array($this, 'youtube_fullscreen_callback'),
            'mtq_youtube_live_settings',
            'mtq_youtube_live_section'
        );
        
        add_settings_field(
            'mtq_youtube_chat',
            __('Tampilkan Chat', 'mtq-aceh-pidie-jaya'),
            array($this, 'youtube_chat_callback'),
            'mtq_youtube_live_settings',
            'mtq_youtube_live_section'
        );
        
        // Register settings
        register_setting('mtq_youtube_live_settings', 'mtq_youtube_url', array(
            'sanitize_callback' => array($this, 'sanitize_youtube_url')
        ));
        
        register_setting('mtq_youtube_live_settings', 'mtq_youtube_title', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        register_setting('mtq_youtube_live_settings', 'mtq_youtube_description', array(
            'sanitize_callback' => 'sanitize_textarea_field'
        ));
        
        register_setting('mtq_youtube_live_settings', 'mtq_youtube_status', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        register_setting('mtq_youtube_live_settings', 'mtq_youtube_autoplay', array(
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
        
        register_setting('mtq_youtube_live_settings', 'mtq_youtube_controls', array(
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
        
        register_setting('mtq_youtube_live_settings', 'mtq_youtube_fullscreen', array(
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
        
        register_setting('mtq_youtube_live_settings', 'mtq_youtube_chat', array(
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
    }
    
    /**
     * Sanitize YouTube URL
     */
    public function sanitize_youtube_url($url) {
        if (empty($url)) {
            return '';
        }
        
        // Extract video ID from various YouTube URL formats
        $video_id = $this->extract_youtube_id($url);
        
        if ($video_id) {
            return 'https://www.youtube.com/watch?v=' . $video_id;
        }
        
        return '';
    }
    
    /**
     * Extract YouTube video ID from URL
     */
    private function extract_youtube_id($url) {
        $patterns = array(
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/v\/([a-zA-Z0-9_-]+)/'
        );
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }
        
        return false;
    }
    
    /**
     * Add admin menu page
     */
    public function add_admin_page() {
        add_theme_page(
            __('Pengaturan YouTube Live', 'mtq-aceh-pidie-jaya'),
            __('YouTube Live', 'mtq-aceh-pidie-jaya'),
            'manage_options',
            'mtq-youtube-live-settings',
            array($this, 'admin_page_content')
        );
    }
    
    /**
     * Settings section callback
     */
    public function settings_section_callback() {
        echo '<p>' . __('Konfigurasi pengaturan live streaming YouTube untuk acara MTQ Aceh XXXVII.', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * YouTube URL field callback
     */
    public function youtube_url_callback() {
        $value = get_option('mtq_youtube_url', '');
        echo '<input type="url" name="mtq_youtube_url" value="' . esc_attr($value) . '" class="large-text" placeholder="https://www.youtube.com/watch?v=VIDEO_ID" />';
        echo '<p class="description">' . __('Masukkan URL YouTube live stream. Format yang didukung: youtube.com/watch?v=ID, youtu.be/ID, youtube.com/embed/ID', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * YouTube title field callback
     */
    public function youtube_title_callback() {
        $value = get_option('mtq_youtube_title', 'Live Streaming MTQ Aceh XXXVII Pidie Jaya 2025');
        echo '<input type="text" name="mtq_youtube_title" value="' . esc_attr($value) . '" class="large-text" />';
        echo '<p class="description">' . __('Judul yang akan ditampilkan di atas video live stream', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * YouTube description field callback
     */
    public function youtube_description_callback() {
        $value = get_option('mtq_youtube_description', 'Saksikan langsung acara Musabaqah Tilawatil Quran (MTQ) Aceh XXXVII yang diselenggarakan di Kabupaten Pidie Jaya.');
        echo '<textarea name="mtq_youtube_description" rows="4" class="large-text">' . esc_textarea($value) . '</textarea>';
        echo '<p class="description">' . __('Deskripsi singkat tentang live stream yang sedang berlangsung', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * YouTube status field callback
     */
    public function youtube_status_callback() {
        $value = get_option('mtq_youtube_status', 'hidden');
        $options = array(
            'hidden' => __('Sembunyikan Live Stream', 'mtq-aceh-pidie-jaya'),
            'upcoming' => __('Akan Segera Dimulai', 'mtq-aceh-pidie-jaya'),
            'live' => __('Sedang Live', 'mtq-aceh-pidie-jaya'),
            'ended' => __('Live Stream Berakhir', 'mtq-aceh-pidie-jaya'),
            'replay' => __('Tayangan Ulang Tersedia', 'mtq-aceh-pidie-jaya')
        );
        
        echo '<select name="mtq_youtube_status" class="regular-text">';
        foreach ($options as $key => $label) {
            echo '<option value="' . esc_attr($key) . '"' . selected($value, $key, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
        echo '<p class="description">' . __('Status live stream yang akan ditampilkan kepada pengunjung', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * YouTube autoplay field callback
     */
    public function youtube_autoplay_callback() {
        $value = get_option('mtq_youtube_autoplay', false);
        echo '<label><input type="checkbox" name="mtq_youtube_autoplay" value="1"' . checked(1, $value, false) . ' /> ';
        echo __('Otomatis putar video saat halaman dimuat', 'mtq-aceh-pidie-jaya') . '</label>';
        echo '<p class="description">' . __('Catatan: Autoplay mungkin tidak berfungsi di semua browser karena kebijakan browser', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * YouTube controls field callback
     */
    public function youtube_controls_callback() {
        $value = get_option('mtq_youtube_controls', true);
        echo '<label><input type="checkbox" name="mtq_youtube_controls" value="1"' . checked(1, $value, false) . ' /> ';
        echo __('Tampilkan kontrol pemutar (play, pause, volume, dll)', 'mtq-aceh-pidie-jaya') . '</label>';
    }
    
    /**
     * YouTube fullscreen field callback
     */
    public function youtube_fullscreen_callback() {
        $value = get_option('mtq_youtube_fullscreen', true);
        echo '<label><input type="checkbox" name="mtq_youtube_fullscreen" value="1"' . checked(1, $value, false) . ' /> ';
        echo __('Izinkan mode layar penuh', 'mtq-aceh-pidie-jaya') . '</label>';
    }
    
    /**
     * YouTube chat field callback
     */
    public function youtube_chat_callback() {
        $value = get_option('mtq_youtube_chat', true);
        echo '<label><input type="checkbox" name="mtq_youtube_chat" value="1"' . checked(1, $value, false) . ' /> ';
        echo __('Tampilkan chat live YouTube di samping video', 'mtq-aceh-pidie-jaya') . '</label>';
        echo '<p class="description">' . __('Chat akan muncul di layout desktop, tersembunyi di mobile untuk menghemat ruang', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * Admin page content
     */
    public function admin_page_content() {
        if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
            add_settings_error('mtq_youtube_messages', 'mtq_youtube_message', __('Pengaturan berhasil disimpan', 'mtq-aceh-pidie-jaya'), 'updated');
        }
        
        settings_errors('mtq_youtube_messages');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <div class="mtq-admin-container" style="display: flex; gap: 20px; margin-top: 20px;">
                <!-- Settings Form -->
                <div class="mtq-settings-form" style="flex: 1; max-width: 600px;">
                    <form action="options.php" method="post">
                        <?php
                        settings_fields('mtq_youtube_live_settings');
                        do_settings_sections('mtq_youtube_live_settings');
                        submit_button(__('Simpan Pengaturan', 'mtq-aceh-pidie-jaya'));
                        ?>
                    </form>
                </div>
                
                <!-- Live Preview -->
                <div class="mtq-youtube-preview" style="flex: 1; min-width: 300px;">
                    <h3><?php _e('Preview Live Stream', 'mtq-aceh-pidie-jaya'); ?></h3>
                    <div id="youtube-preview-container" style="background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
                        <?php echo $this->get_youtube_preview(); ?>
                    </div>
                    
                    <h4 style="margin-top: 20px;"><?php _e('Status Saat Ini', 'mtq-aceh-pidie-jaya'); ?></h4>
                    <div id="youtube-status-display" style="padding: 10px; background: #fff; border-left: 4px solid #0073aa; margin-top: 10px;">
                        <?php echo $this->get_current_status_text(); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            // Auto-update preview when settings change
            var previewTimeout;
            
            function updatePreview() {
                clearTimeout(previewTimeout);
                previewTimeout = setTimeout(function() {
                    var formData = {
                        action: 'mtq_update_youtube_preview',
                        nonce: '<?php echo wp_create_nonce('mtq_youtube_nonce'); ?>',
                        youtube_url: $('input[name="mtq_youtube_url"]').val(),
                        youtube_title: $('input[name="mtq_youtube_title"]').val(),
                        youtube_description: $('textarea[name="mtq_youtube_description"]').val(),
                        youtube_status: $('select[name="mtq_youtube_status"]').val(),
                        youtube_autoplay: $('input[name="mtq_youtube_autoplay"]').is(':checked'),
                        youtube_controls: $('input[name="mtq_youtube_controls"]').is(':checked'),
                        youtube_fullscreen: $('input[name="mtq_youtube_fullscreen"]').is(':checked'),
                        youtube_chat: $('input[name="mtq_youtube_chat"]').is(':checked')
                    };
                    
                    $.post(ajaxurl, formData, function(response) {
                        if (response.success) {
                            $('#youtube-preview-container').html(response.data.preview);
                            $('#youtube-status-display').html(response.data.status);
                        }
                    });
                }, 1000);
            }
            
            // Bind events
            $('input, textarea, select').on('input change', updatePreview);
        });
        </script>
        
        <style>
        .mtq-admin-container {
            margin-top: 20px;
        }
        
        .mtq-youtube-preview iframe {
            width: 100%;
            height: 200px;
            border: none;
            border-radius: 4px;
        }
        
        .youtube-live-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-live {
            background: #ff0000;
            color: white;
        }
        
        .status-upcoming {
            background: #ff9800;
            color: white;
        }
        
        .status-ended {
            background: #757575;
            color: white;
        }
        
        .status-replay {
            background: #4caf50;
            color: white;
        }
        
        .status-hidden {
            background: #e0e0e0;
            color: #666;
        }
        </style>
        <?php
    }
    
    /**
     * Get current status text
     */
    private function get_current_status_text() {
        $status = get_option('mtq_youtube_status', 'hidden');
        $url = get_option('mtq_youtube_url', '');
        
        $status_texts = array(
            'hidden' => '<span class="youtube-live-status status-hidden">Disembunyikan</span> Live stream tidak ditampilkan di website',
            'upcoming' => '<span class="youtube-live-status status-upcoming">Akan Dimulai</span> Live stream belum dimulai, pengunjung akan melihat pemberitahuan',
            'live' => '<span class="youtube-live-status status-live">● LIVE</span> Live stream sedang berlangsung dan dapat ditonton',
            'ended' => '<span class="youtube-live-status status-ended">Berakhir</span> Live stream telah berakhir',
            'replay' => '<span class="youtube-live-status status-replay">Replay</span> Tayangan ulang tersedia untuk ditonton'
        );
        
        $text = isset($status_texts[$status]) ? $status_texts[$status] : $status_texts['hidden'];
        
        if (empty($url) && $status !== 'hidden') {
            $text .= '<br><strong style="color: #d54e21;">⚠ Peringatan:</strong> URL YouTube belum diatur';
        }
        
        return $text;
    }
    
    /**
     * Get YouTube preview HTML
     */
    private function get_youtube_preview() {
        $url = get_option('mtq_youtube_url', '');
        $title = get_option('mtq_youtube_title', 'Live Streaming MTQ Aceh XXXVII Pidie Jaya 2025');
        $description = get_option('mtq_youtube_description', '');
        $status = get_option('mtq_youtube_status', 'hidden');
        
        if ($status === 'hidden') {
            return '<div style="text-align: center; padding: 40px; color: #666;"><strong>Live Stream Disembunyikan</strong><br>Pengunjung tidak akan melihat live stream di website</div>';
        }
        
        if (empty($url)) {
            return '<div style="text-align: center; padding: 40px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 4px; color: #856404;"><strong>URL YouTube Belum Diatur</strong><br>Masukkan URL YouTube untuk melihat preview</div>';
        }
        
        return $this->generate_youtube_preview($url, $title, $description, $status);
    }
    
    /**
     * Generate YouTube preview HTML
     */
    private function generate_youtube_preview($url, $title, $description, $status) {
        $video_id = $this->extract_youtube_id($url);
        
        if (!$video_id) {
            return '<div style="text-align: center; padding: 40px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24;"><strong>URL YouTube Tidak Valid</strong><br>Periksa format URL YouTube</div>';
        }
        
        $autoplay = get_option('mtq_youtube_autoplay', false) ? '1' : '0';
        $controls = get_option('mtq_youtube_controls', true) ? '1' : '0';
        
        $embed_url = "https://www.youtube.com/embed/{$video_id}?autoplay={$autoplay}&controls={$controls}&rel=0&modestbranding=1";
        
        ob_start();
        ?>
        <div class="youtube-live-container">
            <?php if (!empty($title)): ?>
                <h4 style="margin: 0 0 10px 0; color: #333;"><?php echo esc_html($title); ?></h4>
            <?php endif; ?>
            
            <?php if ($status === 'live'): ?>
                <div style="margin-bottom: 10px;">
                    <span class="youtube-live-status status-live">● LIVE</span>
                </div>
            <?php elseif ($status === 'upcoming'): ?>
                <div style="margin-bottom: 10px; padding: 10px; background: #fff3cd; border-radius: 4px; border: 1px solid #ffeaa7;">
                    <span class="youtube-live-status status-upcoming">Akan Dimulai</span>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #856404;">Live stream akan segera dimulai. Harap tunggu...</p>
                </div>
            <?php elseif ($status === 'ended'): ?>
                <div style="margin-bottom: 10px;">
                    <span class="youtube-live-status status-ended">Berakhir</span>
                </div>
            <?php elseif ($status === 'replay'): ?>
                <div style="margin-bottom: 10px;">
                    <span class="youtube-live-status status-replay">Replay</span>
                </div>
            <?php endif; ?>
            
            <div class="youtube-embed" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                <iframe 
                    src="<?php echo esc_url($embed_url); ?>" 
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
            
            <?php if (!empty($description)): ?>
                <p style="margin: 10px 0 0 0; font-size: 14px; color: #666; line-height: 1.4;"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * AJAX handler for updating YouTube preview
     */
    public function ajax_update_youtube_preview() {
        // Rate limiting check
        $user_ip = $this->get_user_ip();
        $rate_limit_key = 'mtq_youtube_rate_limit_' . md5($user_ip);
        
        if (get_transient($rate_limit_key)) {
            wp_send_json_error('Rate limit exceeded. Please try again later.');
            return;
        }
        
        // Set rate limit (max 30 requests per minute for admin)
        set_transient($rate_limit_key, true, 60);
        
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'mtq_youtube_nonce')) {
            $this->log_security_event('youtube_nonce_failed', array('ip' => $user_ip));
            wp_die(__('Security check failed', 'mtq-aceh-pidie-jaya'));
        }
        
        // Get POST data
        $url = esc_url_raw($_POST['youtube_url']);
        $title = sanitize_text_field($_POST['youtube_title']);
        $description = sanitize_textarea_field($_POST['youtube_description']);
        $status = sanitize_text_field($_POST['youtube_status']);
        $autoplay = isset($_POST['youtube_autoplay']) ? rest_sanitize_boolean($_POST['youtube_autoplay']) : false;
        $controls = isset($_POST['youtube_controls']) ? rest_sanitize_boolean($_POST['youtube_controls']) : false;
        $fullscreen = isset($_POST['youtube_fullscreen']) ? rest_sanitize_boolean($_POST['youtube_fullscreen']) : false;
        $chat = isset($_POST['youtube_chat']) ? rest_sanitize_boolean($_POST['youtube_chat']) : false;
        
        // Generate preview HTML
        $preview_html = $this->generate_youtube_preview_ajax($url, $title, $description, $status, $autoplay, $controls, $fullscreen, $chat);
        $status_html = $this->get_current_status_text_ajax($status, $url);
        
        wp_send_json_success(array(
            'preview' => $preview_html,
            'status' => $status_html
        ));
    }
    
    /**
     * Generate YouTube preview for AJAX
     */
    private function generate_youtube_preview_ajax($url, $title, $description, $status, $autoplay = false, $controls = true, $fullscreen = true, $chat = true) {
        if ($status === 'hidden') {
            return '<div style="text-align: center; padding: 40px; color: #666;"><strong>Live Stream Disembunyikan</strong><br>Pengunjung tidak akan melihat live stream di website</div>';
        }
        
        if (empty($url)) {
            return '<div style="text-align: center; padding: 40px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 4px; color: #856404;"><strong>URL YouTube Belum Diatur</strong><br>Masukkan URL YouTube untuk melihat preview</div>';
        }
        
        $video_id = $this->extract_youtube_id($url);
        
        if (!$video_id) {
            return '<div style="text-align: center; padding: 40px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24;"><strong>URL YouTube Tidak Valid</strong><br>Periksa format URL YouTube</div>';
        }
        
        $autoplay_param = $autoplay ? '1' : '0';
        $controls_param = $controls ? '1' : '0';
        
        $embed_url = "https://www.youtube.com/embed/{$video_id}?autoplay={$autoplay_param}&controls={$controls_param}&rel=0&modestbranding=1";
        
        ob_start();
        ?>
        <div class="youtube-live-container">
            <?php if (!empty($title)): ?>
                <h4 style="margin: 0 0 10px 0; color: #333;"><?php echo esc_html($title); ?></h4>
            <?php endif; ?>
            
            <?php if ($status === 'live'): ?>
                <div style="margin-bottom: 10px;">
                    <span class="youtube-live-status status-live">● LIVE</span>
                </div>
            <?php elseif ($status === 'upcoming'): ?>
                <div style="margin-bottom: 10px; padding: 10px; background: #fff3cd; border-radius: 4px; border: 1px solid #ffeaa7;">
                    <span class="youtube-live-status status-upcoming">Akan Dimulai</span>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #856404;">Live stream akan segera dimulai. Harap tunggu...</p>
                </div>
            <?php elseif ($status === 'ended'): ?>
                <div style="margin-bottom: 10px;">
                    <span class="youtube-live-status status-ended">Berakhir</span>
                </div>
            <?php elseif ($status === 'replay'): ?>
                <div style="margin-bottom: 10px;">
                    <span class="youtube-live-status status-replay">Replay</span>
                </div>
            <?php endif; ?>
            
            <div class="youtube-embed" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                <iframe 
                    src="<?php echo esc_url($embed_url); ?>" 
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    <?php echo $fullscreen ? 'allowfullscreen' : ''; ?>>
                </iframe>
            </div>
            
            <?php if (!empty($description)): ?>
                <p style="margin: 10px 0 0 0; font-size: 14px; color: #666; line-height: 1.4;"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
            
            <?php if ($chat && !empty($video_id)): ?>
                <div style="margin-top: 15px; font-size: 12px; color: #999;">
                    💬 Chat tersedia di desktop • 📱 Disembunyikan di mobile
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Get current status text for AJAX
     */
    private function get_current_status_text_ajax($status, $url) {
        $status_texts = array(
            'hidden' => '<span class="youtube-live-status status-hidden">Disembunyikan</span> Live stream tidak ditampilkan di website',
            'upcoming' => '<span class="youtube-live-status status-upcoming">Akan Dimulai</span> Live stream belum dimulai, pengunjung akan melihat pemberitahuan',
            'live' => '<span class="youtube-live-status status-live">● LIVE</span> Live stream sedang berlangsung dan dapat ditonton',
            'ended' => '<span class="youtube-live-status status-ended">Berakhir</span> Live stream telah berakhir',
            'replay' => '<span class="youtube-live-status status-replay">Replay</span> Tayangan ulang tersedia untuk ditonton'
        );
        
        $text = isset($status_texts[$status]) ? $status_texts[$status] : $status_texts['hidden'];
        
        if (empty($url) && $status !== 'hidden') {
            $text .= '<br><strong style="color: #d54e21;">⚠ Peringatan:</strong> URL YouTube belum diatur';
        }
        
        return $text;
    }
    
    /**
     * Enqueue YouTube scripts
     */
    public function enqueue_youtube_scripts() {
        $status = get_option('mtq_youtube_status', 'hidden');
        
        if ($status !== 'hidden') {
            wp_enqueue_style('mtq-youtube-live-css', get_template_directory_uri() . '/assets/css/youtube-live.css', array(), _S_VERSION);
            wp_enqueue_script('mtq-youtube-live-js', get_template_directory_uri() . '/assets/js/youtube-live.js', array('jquery'), _S_VERSION, true);
            
            // Localize script for AJAX
            wp_localize_script('mtq-youtube-live-js', 'mtq_youtube_ajax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('mtq_youtube_public_nonce')
            ));
        }
    }
    
    /**
     * Get user IP address
     */
    private function get_user_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            return sanitize_text_field($_SERVER['REMOTE_ADDR']);
        }
    }
    
    /**
     * Log security events
     */
    private function log_security_event($event_type, $details = array()) {
        if (function_exists('mtq_log_security_event')) {
            mtq_log_security_event($event_type, $details);
        }
    }
}

// Initialize YouTube Live admin class
$mtq_youtube_live_admin = new MTQ_YouTube_Live_Admin();
