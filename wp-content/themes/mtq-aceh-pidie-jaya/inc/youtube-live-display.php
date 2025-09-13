<?php
/**
 * MTQ YouTube Live Display Functions
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * YouTube Live Display Class
 */
class MTQ_YouTube_Live_Display {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_ajax_mtq_check_live_status', array($this, 'ajax_check_live_status'));
        add_action('wp_ajax_nopriv_mtq_check_live_status', array($this, 'ajax_check_live_status'));
        add_action('wp_ajax_mtq_get_viewer_count', array($this, 'ajax_get_viewer_count'));
        add_action('wp_ajax_nopriv_mtq_get_viewer_count', array($this, 'ajax_get_viewer_count'));
        add_action('wp_ajax_mtq_track_youtube_view', array($this, 'ajax_track_youtube_view'));
        add_action('wp_ajax_nopriv_mtq_track_youtube_view', array($this, 'ajax_track_youtube_view'));
    }
    
    /**
     * Initialize display functions
     */
    public function init() {
        add_shortcode('mtq_youtube_live', array($this, 'youtube_live_shortcode'));
        add_action('widgets_init', array($this, 'register_widget'));
    }
    
    /**
     * YouTube Live Shortcode
     */
    public function youtube_live_shortcode($atts = array()) {
        $atts = shortcode_atts(array(
            'show_title' => true,
            'show_description' => true,
            'show_chat' => true,
            'show_stats' => true,
            'autoplay' => false,
            'controls' => true,
            'width' => '100%',
            'height' => 'auto'
        ), $atts, 'mtq_youtube_live');
        
        // Check if live stream is hidden
        $status = get_option('mtq_youtube_status', 'hidden');
        if ($status === 'hidden') {
            return '';
        }
        
        return $this->render_youtube_live($atts);
    }
    
    /**
     * Render YouTube Live HTML
     */
    public function render_youtube_live($args = array()) {
        $defaults = array(
            'show_title' => true,
            'show_description' => true,
            'show_chat' => true,
            'show_stats' => true,
            'autoplay' => false,
            'controls' => true,
            'width' => '100%',
            'height' => 'auto'
        );
        
        $args = wp_parse_args($args, $defaults);
        
        // Get YouTube settings
        $url = get_option('mtq_youtube_url', '');
        $title = get_option('mtq_youtube_title', 'Live Streaming MTQ Aceh XXXVII Pidie Jaya 2025');
        $description = get_option('mtq_youtube_description', '');
        $status = get_option('mtq_youtube_status', 'hidden');
        $autoplay = get_option('mtq_youtube_autoplay', false) || $args['autoplay'];
        $controls = get_option('mtq_youtube_controls', true) && $args['controls'];
        $fullscreen = get_option('mtq_youtube_fullscreen', true);
        $show_chat = get_option('mtq_youtube_chat', true) && $args['show_chat'];
        
        if (empty($url)) {
            return $this->render_no_stream_message();
        }
        
        $video_id = $this->extract_youtube_id($url);
        if (!$video_id) {
            return $this->render_invalid_url_message();
        }
        
        ob_start();
        ?>
        <div class="mtq-youtube-live-section" id="mtq-youtube-live">
            <div class="mtq-youtube-live-container">
                
                <!-- Header -->
                <?php if ($args['show_title'] || $args['show_description']): ?>
                <div class="mtq-youtube-live-header">
                    <?php if ($args['show_title'] && !empty($title)): ?>
                        <h2 class="mtq-youtube-live-title"><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ($args['show_description'] && !empty($description)): ?>
                        <p class="mtq-youtube-live-description"><?php echo esc_html($description); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <!-- Status-specific content -->
                <?php if ($status === 'upcoming'): ?>
                    <?php echo $this->render_upcoming_notification(); ?>
                    
                <?php elseif ($status === 'ended'): ?>
                    <?php echo $this->render_ended_notification(); ?>
                    
                <?php else: ?>
                    <!-- Main Content -->
                    <div class="mtq-youtube-content <?php echo $show_chat ? 'with-chat' : ''; ?>">
                        
                        <!-- Video Container -->
                        <div class="mtq-youtube-video-container">
                            
                            <!-- Live Status -->
                            <div style="text-align: center; margin-bottom: 1rem;">
                                <?php echo $this->render_live_status($status); ?>
                            </div>
                            
                            <!-- YouTube Embed -->
                            <div class="mtq-youtube-embed" 
                                 data-video-id="<?php echo esc_attr($video_id); ?>"
                                 data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>"
                                 data-controls="<?php echo $controls ? 'true' : 'false'; ?>">
                                <?php echo $this->render_youtube_iframe($video_id, $autoplay, $controls, $fullscreen); ?>
                            </div>
                            
                            <!-- Stats -->
                            <?php if ($args['show_stats']): ?>
                                <?php echo $this->render_youtube_stats(); ?>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Chat Container -->
                        <?php if ($show_chat): ?>
                            <div class="mtq-youtube-chat">
                                <div class="mtq-youtube-chat-header">
                                    Chat Live
                                </div>
                                <iframe 
                                    class="mtq-youtube-chat-iframe"
                                    src="https://www.youtube.com/live_chat?v=<?php echo esc_attr($video_id); ?>&embed_domain=<?php echo esc_attr($_SERVER['HTTP_HOST']); ?>"
                                    title="YouTube Live Chat">
                                </iframe>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Render YouTube iframe
     */
    private function render_youtube_iframe($video_id, $autoplay = false, $controls = true, $fullscreen = true) {
        $autoplay_param = $autoplay ? '1' : '0';
        $controls_param = $controls ? '1' : '0';
        
        $embed_url = "https://www.youtube.com/embed/{$video_id}?autoplay={$autoplay_param}&controls={$controls_param}&rel=0&modestbranding=1&enablejsapi=1";
        
        if ($fullscreen) {
            $allowfullscreen = 'allowfullscreen';
        } else {
            $allowfullscreen = '';
        }
        
        return sprintf(
            '<iframe src="%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" %s title="Live Stream MTQ Aceh Pidie Jaya"></iframe>',
            esc_url($embed_url),
            $allowfullscreen
        );
    }
    
    /**
     * Render live status indicator
     */
    private function render_live_status($status) {
        $status_config = array(
            'live' => array(
                'class' => 'status-live',
                'text' => '● LIVE',
                'aria_label' => 'Sedang live streaming'
            ),
            'upcoming' => array(
                'class' => 'status-upcoming',
                'text' => 'Akan Dimulai',
                'aria_label' => 'Live stream akan segera dimulai'
            ),
            'ended' => array(
                'class' => 'status-ended',
                'text' => 'Berakhir',
                'aria_label' => 'Live stream telah berakhir'
            ),
            'replay' => array(
                'class' => 'status-replay',
                'text' => 'Replay',
                'aria_label' => 'Menonton tayangan ulang'
            )
        );
        
        $config = isset($status_config[$status]) ? $status_config[$status] : $status_config['ended'];
        
        return sprintf(
            '<span class="youtube-live-status %s" aria-label="%s">%s</span>',
            esc_attr($config['class']),
            esc_attr($config['aria_label']),
            esc_html($config['text'])
        );
    }
    
    /**
     * Render YouTube stats
     */
    private function render_youtube_stats() {
        ob_start();
        ?>
        <div class="mtq-youtube-stats">
            <div class="mtq-youtube-stat">
                <span class="mtq-youtube-stat-number" data-stat="viewers">-</span>
                <span class="mtq-youtube-stat-label">Viewers</span>
            </div>
            <div class="mtq-youtube-stat">
                <span class="mtq-youtube-stat-number" data-stat="likes">-</span>
                <span class="mtq-youtube-stat-label">Likes</span>
            </div>
            <div class="mtq-youtube-stat">
                <span class="mtq-youtube-stat-number" data-stat="duration"><?php echo $this->get_stream_duration(); ?></span>
                <span class="mtq-youtube-stat-label">Durasi</span>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Render upcoming notification
     */
    private function render_upcoming_notification() {
        ob_start();
        ?>
        <div class="mtq-youtube-upcoming">
            <span class="mtq-youtube-upcoming-icon">⏰</span>
            <h3 class="mtq-youtube-upcoming-title">Live Stream Akan Segera Dimulai</h3>
            <p class="mtq-youtube-upcoming-message">
                Harap tunggu, live streaming acara MTQ Aceh XXXVII akan segera dimulai. 
                Refresh halaman ini secara berkala untuk mendapatkan update terbaru.
            </p>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Render ended notification
     */
    private function render_ended_notification() {
        ob_start();
        ?>
        <div class="mtq-youtube-ended">
            <span class="mtq-youtube-ended-icon">⏹</span>
            <h3 class="mtq-youtube-ended-title">Live Stream Telah Berakhir</h3>
            <p class="mtq-youtube-ended-message">
                Terima kasih telah mengikuti live streaming acara MTQ Aceh XXXVII. 
                Tayangan ulang mungkin akan tersedia setelah acara selesai.
            </p>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Render no stream message
     */
    private function render_no_stream_message() {
        return '<div class="mtq-youtube-no-stream"><p>Live stream belum tersedia saat ini.</p></div>';
    }
    
    /**
     * Render invalid URL message
     */
    private function render_invalid_url_message() {
        return '<div class="mtq-youtube-invalid-url"><p>URL live stream tidak valid.</p></div>';
    }
    
    /**
     * Get stream duration
     */
    private function get_stream_duration() {
        $start_time = get_option('mtq_youtube_start_time');
        
        if ($start_time) {
            $duration = time() - strtotime($start_time);
            $hours = floor($duration / 3600);
            $minutes = floor(($duration % 3600) / 60);
            
            return sprintf('%02d:%02d', $hours, $minutes);
        }
        
        return '00:00';
    }
    
    /**
     * Extract YouTube video ID
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
     * AJAX: Check live status
     */
    public function ajax_check_live_status() {
        // Rate limiting
        $user_ip = $this->get_user_ip();
        $rate_limit_key = 'mtq_youtube_status_' . md5($user_ip);
        
        if (get_transient($rate_limit_key)) {
            wp_send_json_error('Rate limit exceeded');
            return;
        }
        
        set_transient($rate_limit_key, true, 30); // 30 second limit
        
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'mtq_youtube_public_nonce')) {
            wp_send_json_error('Security check failed');
            return;
        }
        
        $current_status = get_option('mtq_youtube_status', 'hidden');
        $last_checked_status = get_transient('mtq_youtube_last_status');
        
        $status_changed = ($last_checked_status !== $current_status);
        
        if ($status_changed) {
            set_transient('mtq_youtube_last_status', $current_status, 3600);
        }
        
        wp_send_json_success(array(
            'status' => $current_status,
            'status_changed' => $status_changed,
            'status_text' => $this->get_status_text($current_status)
        ));
    }
    
    /**
     * AJAX: Get viewer count
     */
    public function ajax_get_viewer_count() {
        // Rate limiting
        $user_ip = $this->get_user_ip();
        $rate_limit_key = 'mtq_youtube_viewers_' . md5($user_ip);
        
        if (get_transient($rate_limit_key)) {
            wp_send_json_error('Rate limit exceeded');
            return;
        }
        
        set_transient($rate_limit_key, true, 60); // 1 minute limit
        
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'mtq_youtube_public_nonce')) {
            wp_send_json_error('Security check failed');
            return;
        }
        
        // Simulate viewer count (in real implementation, you'd use YouTube API)
        $viewers = rand(50, 500);
        
        wp_send_json_success(array(
            'viewers' => $viewers,
            'likes' => rand(10, 100),
            'timestamp' => current_time('timestamp')
        ));
    }
    
    /**
     * AJAX: Track YouTube view
     */
    public function ajax_track_youtube_view() {
        // Rate limiting
        $user_ip = $this->get_user_ip();
        $rate_limit_key = 'mtq_youtube_track_' . md5($user_ip);
        
        if (get_transient($rate_limit_key)) {
            wp_send_json_error('Rate limit exceeded');
            return;
        }
        
        set_transient($rate_limit_key, true, 10); // 10 second limit
        
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'mtq_youtube_public_nonce')) {
            wp_send_json_error('Security check failed');
            return;
        }
        
        $video_id = sanitize_text_field($_POST['video_id']);
        $action = sanitize_text_field($_POST['view_action']);
        
        // Track the view in database or analytics
        $this->track_video_analytics($video_id, $action, $user_ip);
        
        wp_send_json_success(array(
            'tracked' => true,
            'video_id' => $video_id,
            'action' => $action
        ));
    }
    
    /**
     * Track video analytics
     */
    private function track_video_analytics($video_id, $action, $ip) {
        // Implementation for tracking analytics
        // This could save to database, send to external analytics service, etc.
        
        if (function_exists('mtq_log_security_event')) {
            mtq_log_security_event('youtube_view_tracked', array(
                'video_id' => $video_id,
                'action' => $action,
                'ip' => $ip,
                'timestamp' => current_time('mysql')
            ));
        }
    }
    
    /**
     * Get status text
     */
    private function get_status_text($status) {
        $texts = array(
            'live' => 'Sedang Live',
            'upcoming' => 'Akan Dimulai',
            'ended' => 'Berakhir',
            'replay' => 'Replay Tersedia',
            'hidden' => 'Disembunyikan'
        );
        
        return isset($texts[$status]) ? $texts[$status] : 'Tidak Diketahui';
    }
    
    /**
     * Get user IP
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
     * Register YouTube Live Widget
     */
    public function register_widget() {
        register_widget('MTQ_YouTube_Live_Widget');
    }
}

/**
 * YouTube Live Widget
 */
class MTQ_YouTube_Live_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mtq_youtube_live_widget',
            __('MTQ YouTube Live', 'mtq-aceh-pidie-jaya'),
            array(
                'description' => __('Tampilkan YouTube live stream MTQ di sidebar', 'mtq-aceh-pidie-jaya')
            )
        );
    }
    
    /**
     * Widget output
     */
    public function widget($args, $instance) {
        $status = get_option('mtq_youtube_status', 'hidden');
        
        if ($status === 'hidden') {
            return;
        }
        
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $display = new MTQ_YouTube_Live_Display();
        echo $display->render_youtube_live(array(
            'show_title' => false,
            'show_description' => false,
            'show_chat' => false,
            'show_stats' => isset($instance['show_stats']) ? $instance['show_stats'] : true,
            'autoplay' => false,
            'controls' => true
        ));
        
        echo $args['after_widget'];
    }
    
    /**
     * Widget form
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Live Stream MTQ', 'mtq-aceh-pidie-jaya');
        $show_stats = isset($instance['show_stats']) ? (bool) $instance['show_stats'] : true;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_stats); ?> id="<?php echo esc_attr($this->get_field_id('show_stats')); ?>" name="<?php echo esc_attr($this->get_field_name('show_stats')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_stats')); ?>"><?php _e('Tampilkan statistik viewer', 'mtq-aceh-pidie-jaya'); ?></label>
        </p>
        <?php
    }
    
    /**
     * Update widget
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['show_stats'] = !empty($new_instance['show_stats']);
        
        return $instance;
    }
}
