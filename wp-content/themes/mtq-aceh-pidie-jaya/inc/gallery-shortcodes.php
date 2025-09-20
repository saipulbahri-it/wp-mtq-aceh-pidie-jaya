<?php
/**
 * MTQ Gallery Shortcodes
 * Shortcode untuk menampilkan gallery di post/page
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!defined('ABSPATH')) {
    exit;
}

class MTQ_Gallery_Shortcodes {
    
    public function __construct() {
        add_shortcode('mtq_gallery', array($this, 'gallery_shortcode'));
        add_shortcode('mtq_gallery_list', array($this, 'gallery_list_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_gallery_scripts'));
    }
    
    /**
     * Main Gallery Shortcode
     * 
     * Usage: [mtq_gallery id="123" layout="grid" columns="3" show_captions="yes"]
     */
    public function gallery_shortcode($atts) {
        $atts = shortcode_atts(array(
            'id' => '',
            'layout' => '',
            'columns' => '',
            'show_captions' => '',
            'enable_lightbox' => '',
            'show_header' => '',
            'limit' => '',
            'category' => '',
            'tag' => '',
        ), $atts, 'mtq_gallery');
        
        if (empty($atts['id']) && empty($atts['category']) && empty($atts['tag'])) {
            return '<p class="mtq-gallery-error">Error: Gallery ID, category, or tag is required.</p>';
        }
        
        $galleries = array();
        
        // Get specific gallery by ID
        if (!empty($atts['id'])) {
            $gallery_post = get_post($atts['id']);
            if ($gallery_post && $gallery_post->post_type === 'mtq_gallery') {
                $galleries[] = $gallery_post;
            }
        }
        // Get galleries by category or tag
        else {
            $query_args = array(
                'post_type' => 'mtq_gallery',
                'post_status' => 'publish',
                'posts_per_page' => !empty($atts['limit']) ? intval($atts['limit']) : -1,
            );
            
            if (!empty($atts['category'])) {
                $query_args['tax_query'][] = array(
                    'taxonomy' => 'mtq_gallery_category',
                    'field' => 'slug',
                    'terms' => $atts['category']
                );
            }
            
            if (!empty($atts['tag'])) {
                $query_args['tax_query'][] = array(
                    'taxonomy' => 'mtq_gallery_tag',
                    'field' => 'slug',
                    'terms' => $atts['tag']
                );
            }
            
            $galleries = get_posts($query_args);
        }
        
        if (empty($galleries)) {
            return '<p class="mtq-gallery-error">Gallery tidak ditemukan.</p>';
        }
        
        $output = '';
        foreach ($galleries as $gallery_post) {
            $output .= $this->render_single_gallery($gallery_post, $atts);
        }
        
        return $output;
    }
    
    /**
     * Gallery List Shortcode
     * Menampilkan daftar semua gallery
     * 
     * Usage: [mtq_gallery_list category="kegiatan" limit="6" columns="3"]
     */
    public function gallery_list_shortcode($atts) {
        $atts = shortcode_atts(array(
            'category' => '',
            'tag' => '',
            'limit' => '12',
            'columns' => '3',
            'show_excerpt' => 'yes',
            'show_meta' => 'yes',
        ), $atts, 'mtq_gallery_list');
        
        $query_args = array(
            'post_type' => 'mtq_gallery',
            'post_status' => 'publish',
            'posts_per_page' => intval($atts['limit']),
        );
        
        if (!empty($atts['category'])) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'mtq_gallery_category',
                'field' => 'slug',
                'terms' => $atts['category']
            );
        }
        
        if (!empty($atts['tag'])) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'mtq_gallery_tag',
                'field' => 'slug',
                'terms' => $atts['tag']
            );
        }
        
        $galleries = get_posts($query_args);
        
        if (empty($galleries)) {
            return '<p class="mtq-gallery-error">Tidak ada gallery yang ditemukan.</p>';
        }
        
        $columns_class = 'grid-cols-1 sm:grid-cols-2 md:grid-cols-' . $atts['columns'];
        
        $output = '<div class="mtq-gallery-list grid ' . $columns_class . ' gap-6 mb-8">';
        
        foreach ($galleries as $gallery_post) {
            $output .= $this->render_gallery_card($gallery_post, $atts);
        }
        
        $output .= '</div>';
        
        return $output;
    }
    
    /**
     * Render Single Gallery
     */
    private function render_single_gallery($gallery_post, $atts) {
        // Get gallery data
        $images = get_post_meta($gallery_post->ID, '_mtq_gallery_images', true);
        $videos = get_post_meta($gallery_post->ID, '_mtq_gallery_videos', true);
        
    // Get settings (use shortcode atts or saved meta)
        $layout = !empty($atts['layout']) ? $atts['layout'] : get_post_meta($gallery_post->ID, '_mtq_gallery_layout', true);
        $columns = !empty($atts['columns']) ? $atts['columns'] : get_post_meta($gallery_post->ID, '_mtq_gallery_columns', true);
        $show_captions = !empty($atts['show_captions']) ? $atts['show_captions'] : get_post_meta($gallery_post->ID, '_mtq_gallery_show_captions', true);
        $enable_lightbox = !empty($atts['enable_lightbox']) ? $atts['enable_lightbox'] : get_post_meta($gallery_post->ID, '_mtq_gallery_enable_lightbox', true);
    $show_header = isset($atts['show_header']) ? $atts['show_header'] : '';
        
        // Set defaults
        $layout = !empty($layout) ? $layout : 'grid';
        $columns = !empty($columns) ? $columns : '3';
    $show_captions = $show_captions === 'no' ? false : true;
        $enable_lightbox = $enable_lightbox === 'no' ? false : true; // Default to true
    $show_header = $show_header === 'no' ? false : true; // Default to true
        
        // Debug logging (only when WP_DEBUG is enabled)
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('Gallery shortcode settings: ' . json_encode([
                'layout' => $layout,
                'columns' => $columns,
                'show_captions' => $show_captions,
                'enable_lightbox' => $enable_lightbox,
                'gallery_id' => $gallery_post->ID,
                'show_header' => $show_header
            ]));
        }
        
        $output = '<div class="mtq-gallery-container" data-gallery-id="' . $gallery_post->ID . '">';
        
        // Gallery title and description (optional)
        if ($show_header) {
            $output .= '<div class="mtq-gallery-header mb-6">';
            $output .= '<h3 class="mtq-gallery-title text-2xl font-bold text-slate-800 mb-2">' . esc_html($gallery_post->post_title) . '</h3>';
            
            if (!empty($gallery_post->post_excerpt)) {
                $output .= '<p class="mtq-gallery-description text-slate-600">' . esc_html($gallery_post->post_excerpt) . '</p>';
            }
            $output .= '</div>';
        }
        
        // Render based on layout
        switch ($layout) {
            case 'slider':
                $output .= $this->render_slider_layout($images, $videos, $gallery_post->ID, $show_captions, $enable_lightbox);
                break;
            case 'masonry':
                $output .= $this->render_masonry_layout($images, $videos, $gallery_post->ID, $columns, $show_captions, $enable_lightbox);
                break;
            default:
                $output .= $this->render_grid_layout($images, $videos, $gallery_post->ID, $columns, $show_captions, $enable_lightbox);
                break;
        }
        
        $output .= '</div>';
        
        return $output;
    }
    
    /**
     * Render Gallery Card (for list view)
     */
    private function render_gallery_card($gallery_post, $atts) {
        $images = get_post_meta($gallery_post->ID, '_mtq_gallery_images', true);
        $videos = get_post_meta($gallery_post->ID, '_mtq_gallery_videos', true);
        
        $thumbnail = '';
        if (!empty($images)) {
            $thumbnail = wp_get_attachment_image($images[0], 'medium', false, array('class' => 'w-full h-48 object-cover'));
        } elseif (has_post_thumbnail($gallery_post->ID)) {
            $thumbnail = get_the_post_thumbnail($gallery_post->ID, 'medium', array('class' => 'w-full h-48 object-cover'));
        }
        
        $image_count = !empty($images) ? count($images) : 0;
        $video_count = !empty($videos) ? count($videos) : 0;
        
        $output = '<div class="mtq-gallery-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">';
        
        if ($thumbnail) {
            $output .= '<div class="mtq-gallery-card-image">' . $thumbnail . '</div>';
        }
        
        $output .= '<div class="p-4">';
        $output .= '<h3 class="text-lg font-semibold text-slate-800 mb-2">';
        $output .= '<a href="' . get_permalink($gallery_post->ID) . '" class="hover:text-blue-600">' . esc_html($gallery_post->post_title) . '</a>';
        $output .= '</h3>';
        
        if ($atts['show_excerpt'] === 'yes' && !empty($gallery_post->post_excerpt)) {
            $output .= '<p class="text-slate-600 text-sm mb-3">' . esc_html($gallery_post->post_excerpt) . '</p>';
        }
        
        if ($atts['show_meta'] === 'yes') {
            $output .= '<div class="flex items-center justify-between text-xs text-slate-500">';
            $output .= '<div class="flex items-center space-x-2">';
            
            if ($image_count > 0) {
                $output .= '<span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>' . $image_count . ' foto</span>';
            }
            
            if ($video_count > 0) {
                $output .= '<span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>' . $video_count . ' video</span>';
            }
            
            $output .= '</div>';
            $output .= '<span>' . get_the_date('d M Y', $gallery_post->ID) . '</span>';
            $output .= '</div>';
        }
        
        $output .= '</div>';
        $output .= '</div>';
        
        return $output;
    }
    
    /**
     * Render Grid Layout
     */
    private function render_grid_layout($images, $videos, $gallery_id, $columns, $show_captions, $enable_lightbox) {
        $all_items = array();
        
        // Add images
        if (!empty($images)) {
            foreach ($images as $image_id) {
                $all_items[] = array(
                    'type' => 'image',
                    'id' => $image_id,
                    'url' => wp_get_attachment_url($image_id),
                    'thumbnail' => wp_get_attachment_image_url($image_id, 'medium'),
                    'caption' => get_post_meta($gallery_id, '_mtq_gallery_image_caption_' . $image_id, true)
                );
            }
        }
        
        // Add videos
        if (!empty($videos)) {
            foreach ($videos as $video) {
                $all_items[] = array(
                    'type' => 'video',
                    'url' => $video['url'],
                    'video_type' => $video['type'],
                    'caption' => $video['caption']
                );
            }
        }
        
        if (empty($all_items)) {
            return '<p class="text-slate-500">Gallery ini belum memiliki konten.</p>';
        }
        
        $columns_class = 'grid-cols-1 sm:grid-cols-2';
        if ($columns == '3') $columns_class = 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3';
        if ($columns == '4') $columns_class = 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4';
        if ($columns == '5') $columns_class = 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5';
        
        $output = '<div class="mtq-gallery-grid grid ' . $columns_class . ' gap-4">';
        
        foreach ($all_items as $index => $item) {
            $output .= '<div class="mtq-gallery-item-wrapper">';
            
            if ($item['type'] === 'image') {
                $output .= $this->render_image_item($item, $index, $show_captions, $enable_lightbox);
            } else {
                $output .= $this->render_video_item($item, $index, $show_captions);
            }
            
            $output .= '</div>';
        }
        
        $output .= '</div>';
        
        return $output;
    }
    
    /**
     * Render Masonry Layout
     */
    private function render_masonry_layout($images, $videos, $gallery_id, $columns, $show_captions, $enable_lightbox) {
        // For now, render as grid (masonry requires additional JS library)
        return $this->render_grid_layout($images, $videos, $gallery_id, $columns, $show_captions, $enable_lightbox);
    }
    
    /**
     * Render Slider Layout
     */
    private function render_slider_layout($images, $videos, $gallery_id, $show_captions, $enable_lightbox) {
        $all_items = array();
        
        // Add images
        if (!empty($images)) {
            foreach ($images as $image_id) {
                $all_items[] = array(
                    'type' => 'image',
                    'id' => $image_id,
                    'url' => wp_get_attachment_url($image_id),
                    'thumbnail' => wp_get_attachment_image_url($image_id, 'large'),
                    'caption' => get_post_meta($gallery_id, '_mtq_gallery_image_caption_' . $image_id, true)
                );
            }
        }
        
        // Add videos
        if (!empty($videos)) {
            foreach ($videos as $video) {
                $all_items[] = array(
                    'type' => 'video',
                    'url' => $video['url'],
                    'video_type' => $video['type'],
                    'caption' => $video['caption']
                );
            }
        }
        
        if (empty($all_items)) {
            return '<p class="text-slate-500">Gallery ini belum memiliki konten.</p>';
        }
        
        $slider_id = 'mtq-slider-' . $gallery_id . '-' . uniqid();
        
        $output = '<div class="mtq-gallery-slider" id="' . $slider_id . '">';
        $output .= '<div class="mtq-slider-container relative overflow-hidden rounded-lg">';
        $output .= '<div class="mtq-slider-wrapper flex transition-transform duration-300 ease-in-out">';
        
        foreach ($all_items as $index => $item) {
            $output .= '<div class="mtq-slider-slide w-full flex-shrink-0">';
            
            if ($item['type'] === 'image') {
                $output .= '<img src="' . esc_url($item['thumbnail']) . '" alt="' . esc_attr($item['caption']) . '" class="w-full h-96 object-cover">';
            } else {
                if ($item['video_type'] === 'youtube') {
                    $output .= '<iframe src="' . esc_url($item['url']) . '" class="w-full h-96" frameborder="0" allowfullscreen></iframe>';
                } else {
                    $output .= '<video src="' . esc_url($item['url']) . '" class="w-full h-96 object-cover" controls></video>';
                }
            }
            
            if ($show_captions && !empty($item['caption'])) {
                $output .= '<div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4">';
                $output .= '<p class="text-sm">' . esc_html($item['caption']) . '</p>';
                $output .= '</div>';
            }
            
            $output .= '</div>';
        }
        
        $output .= '</div>';
        
        // Navigation arrows
        if (count($all_items) > 1) {
            $output .= '<button class="mtq-slider-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-opacity">';
            $output .= '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>';
            $output .= '</button>';
            
            $output .= '<button class="mtq-slider-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-opacity">';
            $output .= '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>';
            $output .= '</button>';
        }
        
        $output .= '</div>';
        
        // Dots indicator
        if (count($all_items) > 1) {
            $output .= '<div class="mtq-slider-dots flex justify-center mt-4 space-x-2">';
            for ($i = 0; $i < count($all_items); $i++) {
                $active_class = $i === 0 ? 'bg-blue-600' : 'bg-gray-300';
                $output .= '<button class="mtq-slider-dot w-3 h-3 rounded-full ' . $active_class . ' transition-colors" data-slide="' . $i . '"></button>';
            }
            $output .= '</div>';
        }
        
        $output .= '</div>';
        
        // Add slider JavaScript
        $output .= $this->get_slider_javascript($slider_id, count($all_items));
        
        return $output;
    }
    
    /**
     * Render Image Item with Lazy Loading
     */
    private function render_image_item($item, $index, $show_captions, $enable_lightbox) {
        $lightbox_attrs = '';
        if ($enable_lightbox) {
            $lightbox_attrs = 'data-image-src="' . esc_attr($item['url']) . '" data-image-title="' . esc_attr($item['caption']) . '"';
        }
        
        // Lazy loading attributes
        $lazy_attrs = '';
        $img_src = '';
        
        // First few images load immediately, rest use lazy loading
        if ($index < 3) {
            $img_src = 'src="' . esc_url($item['thumbnail']) . '" fetchpriority="high"';
        } else {
            $img_src = 'src="data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 400 300\'><rect width=\'400\' height=\'300\' fill=\'%23f3f4f6\'/><text x=\'50%\' y=\'50%\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-size=\'14\'>Loading...</text></svg>"';
            $lazy_attrs = 'data-src="' . esc_url($item['thumbnail']) . '" loading="lazy"';
        }
        
        $output = '<div class="mtq-gallery-image-item relative group overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow">';
        
        if ($enable_lightbox) {
            $output .= '<div class="image-gallery-item cursor-pointer" ' . $lightbox_attrs . '>';
        }
        
    $output .= '<img ' . $img_src . ' ' . $lazy_attrs . ' decoding="async" alt="' . esc_attr($item['caption']) . '" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">';
        
        // Overlay icon
        if ($enable_lightbox) {
            $output .= '<div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 flex items-center justify-center transition-all duration-300">';
            $output .= '<svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>';
            $output .= '</div>';
        }
        
        if ($enable_lightbox) {
            $output .= '</div>';
        }
        
        if ($show_captions && !empty($item['caption'])) {
            $output .= '<div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">';
            $output .= '<p class="text-white text-sm">' . esc_html($item['caption']) . '</p>';
            $output .= '</div>';
        }
        
        $output .= '</div>';
        
        return $output;
    }
    
    /**
     * Render Video Item
     */
    private function render_video_item($item, $index, $show_captions) {
        $output = '<div class="mtq-gallery-video-item relative overflow-hidden rounded-lg shadow-md">';
        
        if ($item['video_type'] === 'youtube') {
            $output .= '<iframe src="' . esc_url($item['url']) . '" class="w-full h-64" frameborder="0" allowfullscreen></iframe>';
        } else {
            $output .= '<video src="' . esc_url($item['url']) . '" class="w-full h-64 object-cover" controls></video>';
        }
        
        if ($show_captions && !empty($item['caption'])) {
            $output .= '<div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">';
            $output .= '<p class="text-white text-sm">' . esc_html($item['caption']) . '</p>';
            $output .= '</div>';
        }
        
        $output .= '</div>';
        
        return $output;
    }
    
    /**
     * Get Slider JavaScript
     */
    private function get_slider_javascript($slider_id, $total_slides) {
        return "
        <script>
        (function() {
            const slider = document.getElementById('{$slider_id}');
            if (!slider) return;
            
            const wrapper = slider.querySelector('.mtq-slider-wrapper');
            const prevBtn = slider.querySelector('.mtq-slider-prev');
            const nextBtn = slider.querySelector('.mtq-slider-next');
            const dots = slider.querySelectorAll('.mtq-slider-dot');
            
            let currentSlide = 0;
            const totalSlides = {$total_slides};
            
            function updateSlider() {
                wrapper.style.transform = `translateX(-\${currentSlide * 100}%)`;
                
                dots.forEach((dot, index) => {
                    dot.classList.toggle('bg-blue-600', index === currentSlide);
                    dot.classList.toggle('bg-gray-300', index !== currentSlide);
                });
            }
            
            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }
            
            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSlider();
            }
            
            if (nextBtn) nextBtn.addEventListener('click', nextSlide);
            if (prevBtn) prevBtn.addEventListener('click', prevSlide);
            
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentSlide = index;
                    updateSlider();
                });
            });
            
            // Auto-play (optional)
            // setInterval(nextSlide, 5000);
        })();
        </script>
        ";
    }
    
    /**
     * Enqueue Gallery Scripts
     */
    public function enqueue_gallery_scripts() {
        // The image modal scripts are already included in the main theme
        // We just need to make sure Tailwind CSS is available
    }
}
