<?php
/**
 * Related Posts Widget
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

class MTQ_Related_Posts_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mtq_related_posts_widget',
            esc_html__('MTQ Related Posts', 'mtq-aceh-pidie-jaya'),
            array(
                'description' => esc_html__('Display related posts in sidebar', 'mtq-aceh-pidie-jaya'),
                'classname' => 'mtq-related-posts-widget'
            )
        );
    }

    public function widget($args, $instance) {
        // Only show on single posts
        if (!is_single() || get_post_type() != 'post') {
            return;
        }

        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Artikel Terkait', 'mtq-aceh-pidie-jaya');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        
        $related_posts = mtq_get_related_posts(get_the_ID(), $number);
        
        if (empty($related_posts)) {
            return;
        }

        echo $args['before_widget'];
        
        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        ?>

        <div class="mtq-related-posts-widget-content">
            <?php foreach ($related_posts as $post) : 
                setup_postdata($post); ?>
                
                <article class="related-post-item flex gap-3 mb-4 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors group">
                    <!-- Thumbnail -->
                    <div class="flex-shrink-0 w-16 h-16 overflow-hidden rounded-lg">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail', [
                                    'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform',
                                    'alt' => get_the_title()
                                ]); ?>
                            <?php else : ?>
                                <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors mb-1">
                            <a href="<?php the_permalink(); ?>" class="hover:underline">
                                <?php the_title(); ?>
                            </a>
                        </h4>
                        
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                            
                            <span>•</span>
                            
                            <span>
                                <?php 
                                $reading_time = mtq_get_reading_time(get_the_ID());
                                printf(esc_html__('%d menit', 'mtq-aceh-pidie-jaya'), $reading_time);
                                ?>
                            </span>
                        </div>
                    </div>
                </article>
                
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>

        <style>
        .mtq-related-posts-widget .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        </style>

        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Artikel Terkait', 'mtq-aceh-pidie-jaya');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title:', 'mtq-aceh-pidie-jaya'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>">
                <?php esc_html_e('Number of posts to show:', 'mtq-aceh-pidie-jaya'); ?>
            </label>
            <input class="tiny-text" 
                   id="<?php echo esc_attr($this->get_field_id('number')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('number')); ?>" 
                   type="number" 
                   step="1" 
                   min="1" 
                   max="10" 
                   value="<?php echo esc_attr($number); ?>" 
                   size="3">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;

        return $instance;
    }
}

// Register the widget
function mtq_register_related_posts_widget() {
    register_widget('MTQ_Related_Posts_Widget');
}
add_action('widgets_init', 'mtq_register_related_posts_widget');
