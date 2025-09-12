<?php
/**
 * MTQ Countdown Admin Configuration
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add countdown settings to WordPress admin
 */
class MTQ_Countdown_Admin {
    
    public function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_menu', array($this, 'add_admin_page'));
        add_action('wp_ajax_mtq_update_countdown_preview', array($this, 'ajax_update_countdown_preview'));
    }
    
    /**
     * Register countdown settings
     */
    public function register_settings() {
        // Add settings section
        add_settings_section(
            'mtq_countdown_section',
            __('Pengaturan Countdown MTQ', 'mtq-aceh-pidie-jaya'),
            array($this, 'settings_section_callback'),
            'mtq_countdown_settings'
        );
        
        // Event date setting
        add_settings_field(
            'mtq_event_date',
            __('Tanggal & Waktu Acara', 'mtq-aceh-pidie-jaya'),
            array($this, 'event_date_callback'),
            'mtq_countdown_settings',
            'mtq_countdown_section'
        );
        
        // Event title setting
        add_settings_field(
            'mtq_event_title',
            __('Judul Acara', 'mtq-aceh-pidie-jaya'),
            array($this, 'event_title_callback'),
            'mtq_countdown_settings',
            'mtq_countdown_section'
        );
        
        // Event location setting
        add_settings_field(
            'mtq_event_location',
            __('Lokasi Acara', 'mtq-aceh-pidie-jaya'),
            array($this, 'event_location_callback'),
            'mtq_countdown_settings',
            'mtq_countdown_section'
        );
        
        // Countdown status setting
        add_settings_field(
            'mtq_countdown_status',
            __('Status Countdown', 'mtq-aceh-pidie-jaya'),
            array($this, 'countdown_status_callback'),
            'mtq_countdown_settings',
            'mtq_countdown_section'
        );
        
        // Display options section
        add_settings_field(
            'mtq_show_title',
            __('Tampilkan Judul Acara', 'mtq-aceh-pidie-jaya'),
            array($this, 'show_title_callback'),
            'mtq_countdown_settings',
            'mtq_countdown_section'
        );
        
        add_settings_field(
            'mtq_show_date',
            __('Tampilkan Tanggal & Waktu', 'mtq-aceh-pidie-jaya'),
            array($this, 'show_date_callback'),
            'mtq_countdown_settings',
            'mtq_countdown_section'
        );
        
        add_settings_field(
            'mtq_show_location',
            __('Tampilkan Lokasi', 'mtq-aceh-pidie-jaya'),
            array($this, 'show_location_callback'),
            'mtq_countdown_settings',
            'mtq_countdown_section'
        );
        
        add_settings_field(
            'mtq_show_progress',
            __('Tampilkan Progress Bar', 'mtq-aceh-pidie-jaya'),
            array($this, 'show_progress_callback'),
            'mtq_countdown_settings',
            'mtq_countdown_section'
        );
        
        // Register settings
        register_setting('mtq_countdown_settings', 'mtq_event_date', array(
            'type' => 'string',
            'default' => '2025-11-01T07:00:00',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        register_setting('mtq_countdown_settings', 'mtq_event_title', array(
            'type' => 'string',
            'default' => 'MTQ Aceh XXXVII Pidie Jaya 2025',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        register_setting('mtq_countdown_settings', 'mtq_event_location', array(
            'type' => 'string',
            'default' => 'Kabupaten Pidie Jaya, Aceh',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        register_setting('mtq_countdown_settings', 'mtq_countdown_status', array(
            'type' => 'string',
            'default' => 'active',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        register_setting('mtq_countdown_settings', 'mtq_show_title', array(
            'type' => 'boolean',
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
        
        register_setting('mtq_countdown_settings', 'mtq_show_date', array(
            'type' => 'boolean',
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
        
        register_setting('mtq_countdown_settings', 'mtq_show_location', array(
            'type' => 'boolean',
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
        
        register_setting('mtq_countdown_settings', 'mtq_show_progress', array(
            'type' => 'boolean',
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
    }
    
    /**
     * Add admin menu page
     */
    public function add_admin_page() {
        add_theme_page(
            __('Pengaturan Countdown', 'mtq-aceh-pidie-jaya'),
            __('Countdown MTQ', 'mtq-aceh-pidie-jaya'),
            'manage_options',
            'mtq-countdown-settings',
            array($this, 'admin_page_content')
        );
    }
    
    /**
     * Settings section callback
     */
    public function settings_section_callback() {
        echo '<p>' . __('Konfigurasi pengaturan countdown untuk acara MTQ Aceh XXXVII.', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * Event date field callback
     */
    public function event_date_callback() {
        $value = get_option('mtq_event_date', '2025-11-01T07:00:00');
        echo '<input type="datetime-local" name="mtq_event_date" value="' . esc_attr($value) . '" class="regular-text" />';
        echo '<p class="description">' . __('Pilih tanggal dan waktu mulai acara MTQ (format: YYYY-MM-DD HH:MM)', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * Event title field callback
     */
    public function event_title_callback() {
        $value = get_option('mtq_event_title', 'MTQ Aceh XXXVII Pidie Jaya 2025');
        echo '<input type="text" name="mtq_event_title" value="' . esc_attr($value) . '" class="large-text" />';
        echo '<p class="description">' . __('Judul acara yang akan ditampilkan di countdown', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * Event location field callback
     */
    public function event_location_callback() {
        $value = get_option('mtq_event_location', 'Kabupaten Pidie Jaya, Aceh');
        echo '<input type="text" name="mtq_event_location" value="' . esc_attr($value) . '" class="large-text" />';
        echo '<p class="description">' . __('Lokasi penyelenggaraan acara MTQ', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * Countdown status field callback
     */
    public function countdown_status_callback() {
        $value = get_option('mtq_countdown_status', 'active');
        $options = array(
            'active' => __('Aktif - Tampilkan countdown', 'mtq-aceh-pidie-jaya'),
            'paused' => __('Dijeda - Hentikan sementara', 'mtq-aceh-pidie-jaya'),
            'completed' => __('Selesai - Acara telah berlangsung', 'mtq-aceh-pidie-jaya'),
            'hidden' => __('Sembunyikan - Tidak tampilkan countdown', 'mtq-aceh-pidie-jaya')
        );
        
        echo '<select name="mtq_countdown_status" class="regular-text">';
        foreach ($options as $key => $label) {
            echo '<option value="' . esc_attr($key) . '"' . selected($value, $key, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
        echo '<p class="description">' . __('Status tampilan countdown di website', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * Show title field callback
     */
    public function show_title_callback() {
        $value = get_option('mtq_show_title', false);
        echo '<label><input type="checkbox" name="mtq_show_title" value="1"' . checked(1, $value, false) . ' /> ';
        echo __('Tampilkan judul acara di atas countdown', 'mtq-aceh-pidie-jaya') . '</label>';
        echo '<p class="description">' . __('Centang untuk menampilkan judul acara di bagian atas countdown', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * Show date field callback
     */
    public function show_date_callback() {
        $value = get_option('mtq_show_date', false);
        echo '<label><input type="checkbox" name="mtq_show_date" value="1"' . checked(1, $value, false) . ' /> ';
        echo __('Tampilkan tanggal dan waktu acara', 'mtq-aceh-pidie-jaya') . '</label>';
        echo '<p class="description">' . __('Centang untuk menampilkan tanggal dan waktu mulai acara', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * Show location field callback
     */
    public function show_location_callback() {
        $value = get_option('mtq_show_location', false);
        echo '<label><input type="checkbox" name="mtq_show_location" value="1"' . checked(1, $value, false) . ' /> ';
        echo __('Tampilkan lokasi penyelenggaraan', 'mtq-aceh-pidie-jaya') . '</label>';
        echo '<p class="description">' . __('Centang untuk menampilkan lokasi penyelenggaraan acara', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * Show progress field callback
     */
    public function show_progress_callback() {
        $value = get_option('mtq_show_progress', true);
        echo '<label><input type="checkbox" name="mtq_show_progress" value="1"' . checked(1, $value, false) . ' /> ';
        echo __('Tampilkan progress bar countdown', 'mtq-aceh-pidie-jaya') . '</label>';
        echo '<p class="description">' . __('Centang untuk menampilkan indikator progress acara (Pengumuman → Persiapan → Pelaksanaan)', 'mtq-aceh-pidie-jaya') . '</p>';
    }
    
    /**
     * Admin page content
     */
    public function admin_page_content() {
        if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
            add_settings_error('mtq_countdown_messages', 'mtq_countdown_message', __('Pengaturan berhasil disimpan!', 'mtq-aceh-pidie-jaya'), 'updated');
        }
        
        settings_errors('mtq_countdown_messages');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <!-- Event Status Info -->
            <div class="notice notice-info">
                <p><strong><?php _e('Status Saat Ini:', 'mtq-aceh-pidie-jaya'); ?></strong> 
                <?php echo $this->get_current_event_status_text(); ?>
                </p>
            </div>
            
            <!-- Live Preview -->
            <div class="postbox" style="margin: 20px 0;">
                <div class="postbox-header">
                    <h2 class="hndle"><?php _e('Preview Countdown', 'mtq-aceh-pidie-jaya'); ?></h2>
                </div>
                <div class="inside">
                    <div id="countdown-preview" style="padding: 20px; text-align: center; background: #f9f9f9; border-radius: 8px;">
                        <?php echo $this->get_countdown_preview(); ?>
                    </div>
                </div>
            </div>
            
            <form action="options.php" method="post">
                <?php
                settings_fields('mtq_countdown_settings');
                do_settings_sections('mtq_countdown_settings');
                submit_button(__('Simpan Pengaturan', 'mtq-aceh-pidie-jaya'));
                ?>
            </form>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            // Update preview when settings change
            $('input, select').on('change', function() {
                updateCountdownPreview();
            });
            
            function updateCountdownPreview() {
                var eventDate = $('input[name="mtq_event_date"]').val();
                var eventTitle = $('input[name="mtq_event_title"]').val();
                var eventLocation = $('input[name="mtq_event_location"]').val();
                var status = $('select[name="mtq_countdown_status"]').val();
                var showTitle = $('input[name="mtq_show_title"]').is(':checked');
                var showDate = $('input[name="mtq_show_date"]').is(':checked');
                var showLocation = $('input[name="mtq_show_location"]').is(':checked');
                var showProgress = $('input[name="mtq_show_progress"]').is(':checked');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'mtq_update_countdown_preview',
                        event_date: eventDate,
                        event_title: eventTitle,
                        event_location: eventLocation,
                        status: status,
                        show_title: showTitle,
                        show_date: showDate,
                        show_location: showLocation,
                        show_progress: showProgress,
                        nonce: '<?php echo wp_create_nonce('mtq_countdown_nonce'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#countdown-preview').html(response.data);
                        }
                    }
                });
            }
        });
        </script>
        <?php
    }
    
    /**
     * Get current event status text
     */
    private function get_current_event_status_text() {
        $event_date = get_option('mtq_event_date', '2025-11-01T07:00:00');
        $status = get_option('mtq_countdown_status', 'active');
        $current_time = current_time('timestamp');
        $event_timestamp = strtotime($event_date);
        
        if ($status === 'hidden') {
            return '<span style="color: #666;">' . __('Countdown disembunyikan', 'mtq-aceh-pidie-jaya') . '</span>';
        } elseif ($status === 'completed') {
            return '<span style="color: #46b450;">' . __('Acara telah selesai', 'mtq-aceh-pidie-jaya') . '</span>';
        } elseif ($status === 'paused') {
            return '<span style="color: #f56e28;">' . __('Countdown dijeda', 'mtq-aceh-pidie-jaya') . '</span>';
        } elseif ($current_time >= $event_timestamp) {
            return '<span style="color: #46b450;">' . __('Acara sedang berlangsung atau telah selesai', 'mtq-aceh-pidie-jaya') . '</span>';
        } else {
            $time_left = human_time_diff($current_time, $event_timestamp);
            return '<span style="color: #0073aa;">' . sprintf(__('Countdown aktif - %s tersisa', 'mtq-aceh-pidie-jaya'), $time_left) . '</span>';
        }
    }
    
    /**
     * Get countdown preview HTML
     */
    private function get_countdown_preview() {
        $event_title = get_option('mtq_event_title', 'MTQ Aceh XXXVII Pidie Jaya 2025');
        $event_location = get_option('mtq_event_location', 'Kabupaten Pidie Jaya, Aceh');
        $status = get_option('mtq_countdown_status', 'active');
        $show_title = get_option('mtq_show_title', true);
        $show_date = get_option('mtq_show_date', true);
        $show_location = get_option('mtq_show_location', true);
        $show_progress = get_option('mtq_show_progress', true);
        
        if ($status === 'hidden') {
            return '<p style="color: #666; font-style: italic;">' . __('Countdown tidak akan ditampilkan di website', 'mtq-aceh-pidie-jaya') . '</p>';
        }
        
        $event_date = get_option('mtq_event_date', '2025-11-01T07:00:00');
        return $this->generate_preview_html($event_date, $event_title, $event_location, $status, $show_title, $show_date, $show_location, $show_progress);
    }
    
    /**
     * AJAX handler for updating countdown preview
     */
    public function ajax_update_countdown_preview() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'mtq_countdown_nonce')) {
            wp_die(__('Security check failed', 'mtq-aceh-pidie-jaya'));
        }
        
        // Get POST data
        $event_date = sanitize_text_field($_POST['event_date']);
        $event_title = sanitize_text_field($_POST['event_title']);
        $event_location = sanitize_text_field($_POST['event_location']);
        $status = sanitize_text_field($_POST['status']);
        $show_title = isset($_POST['show_title']) ? rest_sanitize_boolean($_POST['show_title']) : false;
        $show_date = isset($_POST['show_date']) ? rest_sanitize_boolean($_POST['show_date']) : false;
        $show_location = isset($_POST['show_location']) ? rest_sanitize_boolean($_POST['show_location']) : false;
        $show_progress = isset($_POST['show_progress']) ? rest_sanitize_boolean($_POST['show_progress']) : false;
        
        // Generate preview HTML
        $preview_html = $this->generate_preview_html($event_date, $event_title, $event_location, $status, $show_title, $show_date, $show_location, $show_progress);
        
        wp_send_json_success($preview_html);
    }
    
    /**
     * Generate preview HTML with current settings
     */
    private function generate_preview_html($event_date, $event_title, $event_location, $status, $show_title = true, $show_date = true, $show_location = true, $show_progress = true) {
        if ($status === 'hidden') {
            return '<p style="color: #666; font-style: italic;">' . __('Countdown tidak akan ditampilkan di website', 'mtq-aceh-pidie-jaya') . '</p>';
        }
        
        ob_start();
        ?>
        <div style="max-width: 400px; margin: 0 auto;">
            <?php if ($show_title): ?>
            <h3 style="color: #2563eb; margin-bottom: 10px; font-size: 18px; font-weight: 600;">
                <?php echo esc_html($event_title); ?>
            </h3>
            <?php endif; ?>
            
            <?php if ($show_date || $show_location): ?>
            <p style="color: #64748b; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <?php if ($show_date): ?>
                <span style="color: #3b82f6;">📅</span>
                <?php echo date('d F Y, H:i', strtotime($event_date)); ?>
                <?php endif; ?>
                
                <?php if ($show_date && $show_location): ?>
                <span style="margin: 0 4px;">•</span>
                <?php endif; ?>
                
                <?php if ($show_location): ?>
                <span style="color: #3b82f6;">📍</span>
                <?php echo esc_html($event_location); ?>
                <?php endif; ?>
            </p>
            <?php endif; ?>
            
            <?php if ($status === 'completed'): ?>
                <div style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border: 2px solid #10b981; border-radius: 12px; padding: 20px; animation: pulse 2s infinite;">
                    <div style="font-size: 3rem; margin-bottom: 15px; text-align: center;">🎉</div>
                    <h4 style="color: #065f46; margin: 0 0 8px 0; font-size: 20px; font-weight: 700; text-align: center;">
                        Acara Telah Selesai!
                    </h4>
                    <p style="color: #047857; margin: 0; font-size: 14px; text-align: center;">
                        Terima kasih atas partisipasi Anda
                    </p>
                </div>
                
            <?php elseif ($status === 'paused'): ?>
                <div style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%); border: 2px solid #f59e0b; border-radius: 12px; padding: 20px; animation: pulse 2s infinite;">
                    <div style="font-size: 3rem; margin-bottom: 15px; text-align: center;">⏸️</div>
                    <h4 style="color: #92400e; margin: 0 0 8px 0; font-size: 20px; font-weight: 700; text-align: center;">
                        Countdown Dijeda
                    </h4>
                    <p style="color: #b45309; margin: 0; font-size: 14px; text-align: center;">
                        Countdown sementara tidak aktif
                    </p>
                </div>
                
            <?php else: ?>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 15px;">
                    <?php 
                    // Calculate time left for preview
                    $current_time = current_time('timestamp');
                    $event_timestamp = strtotime($event_date);
                    $time_left = max(0, $event_timestamp - $current_time);
                    
                    $days = floor($time_left / (60 * 60 * 24));
                    $hours = floor(($time_left % (60 * 60 * 24)) / (60 * 60));
                    $minutes = floor(($time_left % (60 * 60)) / 60);
                    $seconds = floor($time_left % 60);
                    ?>
                    <div style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; padding: 15px; text-align: center;">
                        <div style="font-size: 24px; font-weight: bold; color: #1e293b; font-family: monospace;">
                            <?php echo str_pad($days, 3, '0', STR_PAD_LEFT); ?>
                        </div>
                        <div style="font-size: 12px; color: #64748b;">Hari</div>
                    </div>
                    <div style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; padding: 15px; text-align: center;">
                        <div style="font-size: 24px; font-weight: bold; color: #1e293b; font-family: monospace;">
                            <?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>
                        </div>
                        <div style="font-size: 12px; color: #64748b;">Jam</div>
                    </div>
                    <div style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; padding: 15px; text-align: center;">
                        <div style="font-size: 24px; font-weight: bold; color: #1e293b; font-family: monospace;">
                            <?php echo str_pad($minutes, 2, '0', STR_PAD_LEFT); ?>
                        </div>
                        <div style="font-size: 12px; color: #64748b;">Menit</div>
                    </div>
                    <div style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; padding: 15px; text-align: center;">
                        <div style="font-size: 24px; font-weight: bold; color: #1e293b; font-family: monospace;">
                            <?php echo str_pad($seconds, 2, '0', STR_PAD_LEFT); ?>
                        </div>
                        <div style="font-size: 12px; color: #64748b;">Detik</div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <?php if ($show_progress): ?>
                <?php 
                // Calculate progress (assuming event planning started 6 months ago)
                $planning_start = strtotime('-6 months', $event_timestamp);
                $total_duration = $event_timestamp - $planning_start;
                $elapsed = $current_time - $planning_start;
                $progress = max(0, min(100, ($elapsed / $total_duration) * 100));
                ?>
                <div style="margin-top: 15px;">
                    <div style="display: flex; justify-content: space-between; font-size: 10px; color: #64748b; margin-bottom: 5px;">
                        <span>Pengumuman</span>
                        <span>Persiapan</span>
                        <span>Pelaksanaan</span>
                    </div>
                    <div style="width: 100%; background: #e5e7eb; border-radius: 10px; height: 6px; overflow: hidden;">
                        <div style="background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 100%); height: 100%; border-radius: 10px; width: <?php echo $progress; ?>%; transition: width 0.5s ease;"></div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <style>
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        </style>
        <?php
        return ob_get_clean();
    }
}

// Initialize admin class
$mtq_countdown_admin = new MTQ_Countdown_Admin();