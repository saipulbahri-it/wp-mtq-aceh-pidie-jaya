<?php
/**
 * Custom Widgets for MTQ Aceh Pidie Jaya theme
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

/**
 * Register custom widgets.
 */
function mtq_aceh_pidie_jaya_register_widgets() {
    register_widget('MTQ_Event_Countdown_Widget');
    register_widget('MTQ_Competition_Categories_Widget');
    register_widget('MTQ_Latest_News_Widget');
    register_widget('MTQ_Social_Media_Widget');
}
add_action('widgets_init', 'mtq_aceh_pidie_jaya_register_widgets');

/**
 * Event Countdown Widget
 */
class MTQ_Event_Countdown_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'mtq_event_countdown',
            __('MTQ Event Countdown', 'mtq-aceh-pidie-jaya'),
            array('description' => __('Displays countdown to MTQ event', 'mtq-aceh-pidie-jaya'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        ?>
        <div class="countdown-container">
            <div class="countdown-item">
                <div class="countdown-number" id="days">00</div>
                <div class="countdown-label"><?php _e('Hari', 'mtq-aceh-pidie-jaya'); ?></div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" id="hours">00</div>
                <div class="countdown-label"><?php _e('Jam', 'mtq-aceh-pidie-jaya'); ?></div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" id="minutes">00</div>
                <div class="countdown-label"><?php _e('Menit', 'mtq-aceh-pidie-jaya'); ?></div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" id="seconds">00</div>
                <div class="countdown-label"><?php _e('Detik', 'mtq-aceh-pidie-jaya'); ?></div>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mtq-aceh-pidie-jaya'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * Competition Categories Widget
 */
class MTQ_Competition_Categories_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'mtq_competition_categories',
            __('MTQ Competition Categories', 'mtq-aceh-pidie-jaya'),
            array('description' => __('Displays MTQ competition categories', 'mtq-aceh-pidie-jaya'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $categories = array(
            'tilawah' => __('Tilawah Al-Quran', 'mtq-aceh-pidie-jaya'),
            'tahfizh' => __('Tahfizh Al-Quran', 'mtq-aceh-pidie-jaya'),
            'tafsir'  => __('Tafsir Al-Quran', 'mtq-aceh-pidie-jaya'),
            'khattil' => __('Khattil Quran', 'mtq-aceh-pidie-jaya')
        );
        ?>
        <ul class="competition-categories">
            <?php foreach ($categories as $slug => $name) : ?>
            <li class="category-item">
                <a href="<?php echo esc_url(get_term_link($slug, 'competition_category')); ?>">
                    <?php echo esc_html($name); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mtq-aceh-pidie-jaya'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * Latest News Widget
 */
class MTQ_Latest_News_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'mtq_latest_news',
            __('MTQ Latest News', 'mtq-aceh-pidie-jaya'),
            array('description' => __('Displays latest MTQ news', 'mtq-aceh-pidie-jaya'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $posts = get_posts(array(
            'post_type'      => 'post',
            'posts_per_page' => $instance['number'],
            'category_name'  => 'mtq-news'
        ));

        if ($posts) :
        ?>
        <ul class="latest-news">
            <?php foreach ($posts as $post) : setup_postdata($post); ?>
            <li class="news-item">
                <?php if (has_post_thumbnail()) : ?>
                <div class="news-thumbnail">
                    <?php the_post_thumbnail('thumbnail'); ?>
                </div>
                <?php endif; ?>
                <div class="news-content">
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <span class="news-date"><?php echo get_the_date(); ?></span>
                </div>
            </li>
            <?php endforeach; wp_reset_postdata(); ?>
        </ul>
        <?php
        endif;
        
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $number = !empty($instance['number']) ? $instance['number'] : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mtq-aceh-pidie-jaya'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'mtq-aceh-pidie-jaya'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        return $instance;
    }
}

/**
 * Social Media Widget
 */
class MTQ_Social_Media_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'mtq_social_media',
            __('MTQ Social Media Links', 'mtq-aceh-pidie-jaya'),
            array('description' => __('Displays social media links', 'mtq-aceh-pidie-jaya'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        ?>
        <div class="social-media-links">
            <?php if (!empty($instance['facebook'])) : ?>
            <a href="<?php echo esc_url($instance['facebook']); ?>" class="social-link facebook" target="_blank">
                <span class="screen-reader-text">Facebook</span>
                <svg class="icon" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <?php endif; ?>
            
            <?php if (!empty($instance['instagram'])) : ?>
            <a href="<?php echo esc_url($instance['instagram']); ?>" class="social-link instagram" target="_blank">
                <span class="screen-reader-text">Instagram</span>
                <svg class="icon" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
            </a>
            <?php endif; ?>
            
            <?php if (!empty($instance['youtube'])) : ?>
            <a href="<?php echo esc_url($instance['youtube']); ?>" class="social-link youtube" target="_blank">
                <span class="screen-reader-text">YouTube</span>
                <svg class="icon" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
            <?php endif; ?>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $facebook = !empty($instance['facebook']) ? $instance['facebook'] : '';
        $instagram = !empty($instance['instagram']) ? $instance['instagram'] : '';
        $youtube = !empty($instance['youtube']) ? $instance['youtube'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mtq-aceh-pidie-jaya'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL:', 'mtq-aceh-pidie-jaya'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="url" value="<?php echo esc_attr($facebook); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram URL:', 'mtq-aceh-pidie-jaya'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="url" value="<?php echo esc_attr($instagram); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube URL:', 'mtq-aceh-pidie-jaya'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="url" value="<?php echo esc_attr($youtube); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['facebook'] = (!empty($new_instance['facebook'])) ? esc_url_raw($new_instance['facebook']) : '';
        $instance['instagram'] = (!empty($new_instance['instagram'])) ? esc_url_raw($new_instance['instagram']) : '';
        $instance['youtube'] = (!empty($new_instance['youtube'])) ? esc_url_raw($new_instance['youtube']) : '';
        return $instance;
    }
}
