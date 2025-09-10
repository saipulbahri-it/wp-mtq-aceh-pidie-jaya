<?php
/**
 * Custom Shortcodes for MTQ Aceh Pidie Jaya theme
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

/**
 * Register all shortcodes
 */
function mtq_aceh_pidie_jaya_register_shortcodes() {
    add_shortcode('mtq_countdown', 'mtq_countdown_shortcode');
    add_shortcode('mtq_schedule', 'mtq_schedule_shortcode');
    add_shortcode('mtq_competition', 'mtq_competition_shortcode');
    add_shortcode('mtq_participant', 'mtq_participant_shortcode');
    add_shortcode('mtq_venue', 'mtq_venue_shortcode');
}
add_action('init', 'mtq_aceh_pidie_jaya_register_shortcodes');

/**
 * Countdown Timer Shortcode
 * Usage: [mtq_countdown]
 */
function mtq_countdown_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => __('Hitung Mundur MTQ', 'mtq-aceh-pidie-jaya'),
        'date'  => '2025-11-01'
    ), $atts);

    ob_start();
    ?>
    <div class="mtq-countdown glass-card p-6">
        <h3 class="text-xl font-semibold mb-4"><?php echo esc_html($atts['title']); ?></h3>
        <div class="countdown-container">
            <div class="countdown-item">
                <div class="countdown-number" data-count="days">00</div>
                <div class="countdown-label"><?php _e('Hari', 'mtq-aceh-pidie-jaya'); ?></div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" data-count="hours">00</div>
                <div class="countdown-label"><?php _e('Jam', 'mtq-aceh-pidie-jaya'); ?></div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" data-count="minutes">00</div>
                <div class="countdown-label"><?php _e('Menit', 'mtq-aceh-pidie-jaya'); ?></div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" data-count="seconds">00</div>
                <div class="countdown-label"><?php _e('Detik', 'mtq-aceh-pidie-jaya'); ?></div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const eventDate = new Date('<?php echo esc_js($atts['date']); ?>').getTime();
                
                const countdown = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = eventDate - now;
                    
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    document.querySelector('[data-count="days"]').textContent = String(days).padStart(2, '0');
                    document.querySelector('[data-count="hours"]').textContent = String(hours).padStart(2, '0');
                    document.querySelector('[data-count="minutes"]').textContent = String(minutes).padStart(2, '0');
                    document.querySelector('[data-count="seconds"]').textContent = String(seconds).padStart(2, '0');
                    
                    if (distance < 0) {
                        clearInterval(countdown);
                    }
                }, 1000);
            });
        </script>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Schedule Shortcode
 * Usage: [mtq_schedule date="2025-11-01"]
 */
function mtq_schedule_shortcode($atts) {
    $atts = shortcode_atts(array(
        'date' => date('Y-m-d')
    ), $atts);

    $schedule = get_posts(array(
        'post_type'      => 'schedule',
        'posts_per_page' => -1,
        'meta_key'       => 'event_date',
        'meta_value'     => $atts['date'],
        'orderby'        => 'meta_value',
        'order'          => 'ASC'
    ));

    ob_start();
    ?>
    <div class="mtq-schedule glass-card p-6">
        <h3 class="text-xl font-semibold mb-4"><?php echo date_i18n(get_option('date_format'), strtotime($atts['date'])); ?></h3>
        <?php if ($schedule) : ?>
            <div class="schedule-list space-y-4">
                <?php foreach ($schedule as $event) : ?>
                    <div class="schedule-item flex gap-4 items-start">
                        <div class="schedule-time text-blue-600 font-semibold">
                            <?php echo esc_html(get_post_meta($event->ID, 'event_time', true)); ?>
                        </div>
                        <div class="schedule-details flex-1">
                            <h4 class="font-semibold"><?php echo esc_html($event->post_title); ?></h4>
                            <p class="text-slate-600"><?php echo esc_html($event->post_excerpt); ?></p>
                            <?php if ($venue = get_post_meta($event->ID, 'event_venue', true)) : ?>
                                <p class="text-sm text-slate-500">
                                    <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    <?php echo esc_html($venue); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-slate-600"><?php _e('Tidak ada jadwal untuk tanggal ini.', 'mtq-aceh-pidie-jaya'); ?></p>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Competition Category Shortcode
 * Usage: [mtq_competition id="123"]
 */
function mtq_competition_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => 0
    ), $atts);

    $competition = get_post($atts['id']);
    if (!$competition || $competition->post_type !== 'competition') {
        return '';
    }

    ob_start();
    ?>
    <div class="mtq-competition glass-card p-6">
        <?php if (has_post_thumbnail($competition)) : ?>
            <div class="competition-image mb-4">
                <?php echo get_the_post_thumbnail($competition, 'medium', array('class' => 'rounded-lg')); ?>
            </div>
        <?php endif; ?>
        
        <h3 class="text-xl font-semibold mb-2"><?php echo esc_html($competition->post_title); ?></h3>
        
        <?php if ($description = get_post_meta($competition->ID, 'competition_description', true)) : ?>
            <p class="text-slate-600 mb-4"><?php echo esc_html($description); ?></p>
        <?php endif; ?>
        
        <div class="competition-details space-y-2">
            <?php if ($categories = get_post_meta($competition->ID, 'competition_categories', true)) : ?>
                <div class="detail-item">
                    <span class="font-semibold"><?php _e('Kategori:', 'mtq-aceh-pidie-jaya'); ?></span>
                    <span class="text-slate-600"><?php echo esc_html($categories); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($age_groups = get_post_meta($competition->ID, 'age_groups', true)) : ?>
                <div class="detail-item">
                    <span class="font-semibold"><?php _e('Kelompok Usia:', 'mtq-aceh-pidie-jaya'); ?></span>
                    <span class="text-slate-600"><?php echo esc_html($age_groups); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($requirements = get_post_meta($competition->ID, 'requirements', true)) : ?>
                <div class="detail-item">
                    <span class="font-semibold"><?php _e('Persyaratan:', 'mtq-aceh-pidie-jaya'); ?></span>
                    <span class="text-slate-600"><?php echo esc_html($requirements); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Participant Info Shortcode
 * Usage: [mtq_participant id="123"]
 */
function mtq_participant_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => 0
    ), $atts);

    $participant = get_post($atts['id']);
    if (!$participant || $participant->post_type !== 'participant') {
        return '';
    }

    ob_start();
    ?>
    <div class="mtq-participant glass-card p-6">
        <?php if (has_post_thumbnail($participant)) : ?>
            <div class="participant-image mb-4">
                <?php echo get_the_post_thumbnail($participant, 'thumbnail', array('class' => 'rounded-full mx-auto')); ?>
            </div>
        <?php endif; ?>
        
        <h3 class="text-xl font-semibold text-center mb-2"><?php echo esc_html($participant->post_title); ?></h3>
        
        <div class="participant-details space-y-2 text-center">
            <?php if ($region = get_post_meta($participant->ID, 'participant_region', true)) : ?>
                <div class="text-slate-600"><?php echo esc_html($region); ?></div>
            <?php endif; ?>
            
            <?php if ($competition = get_post_meta($participant->ID, 'participant_competition', true)) : ?>
                <div class="text-blue-600 font-medium"><?php echo esc_html($competition); ?></div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Venue Information Shortcode
 * Usage: [mtq_venue id="123"]
 */
function mtq_venue_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => 0
    ), $atts);

    $venue = get_post($atts['id']);
    if (!$venue || $venue->post_type !== 'venue') {
        return '';
    }

    ob_start();
    ?>
    <div class="mtq-venue glass-card p-6">
        <?php if (has_post_thumbnail($venue)) : ?>
            <div class="venue-image mb-4">
                <?php echo get_the_post_thumbnail($venue, 'large', array('class' => 'rounded-lg')); ?>
            </div>
        <?php endif; ?>
        
        <h3 class="text-xl font-semibold mb-2"><?php echo esc_html($venue->post_title); ?></h3>
        
        <div class="venue-details space-y-4">
            <?php if ($address = get_post_meta($venue->ID, 'venue_address', true)) : ?>
                <div class="detail-item flex gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-slate-600"><?php echo esc_html($address); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($capacity = get_post_meta($venue->ID, 'venue_capacity', true)) : ?>
                <div class="detail-item flex gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-slate-600"><?php printf(__('Kapasitas: %s orang', 'mtq-aceh-pidie-jaya'), number_format_i18n($capacity)); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($facilities = get_post_meta($venue->ID, 'venue_facilities', true)) : ?>
                <div class="detail-item flex gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <div class="text-slate-600">
                        <div class="font-semibold mb-1"><?php _e('Fasilitas:', 'mtq-aceh-pidie-jaya'); ?></div>
                        <?php echo wpautop($facilities); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($maps_url = get_post_meta($venue->ID, 'venue_maps_url', true)) : ?>
                <a href="<?php echo esc_url($maps_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <?php _e('Lihat di Google Maps', 'mtq-aceh-pidie-jaya'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
