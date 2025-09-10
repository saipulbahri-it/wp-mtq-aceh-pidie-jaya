<?php
/**
 * Related Posts Component with Smart Algorithm
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!function_exists('mtq_get_related_posts')) {
    function mtq_get_related_posts($post_id = null, $limit = 6) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        if (!$post_id) {
            return [];
        }
        
        // Get current post data
        $current_post = get_post($post_id);
        $categories = wp_get_post_categories($post_id);
        $tags = wp_get_post_tags($post_id);
        
        $related_posts = [];
        $args_base = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $limit * 2, // Get more posts to filter duplicates
            'post__not_in' => [$post_id],
            'meta_query' => [
                [
                    'key' => '_thumbnail_id',
                    'compare' => 'EXISTS'
                ]
            ]
        ];
        
        // Priority 1: Posts with same categories AND tags
        if (!empty($categories) && !empty($tags)) {
            $args = array_merge($args_base, [
                'category__in' => $categories,
                'tag__in' => wp_list_pluck($tags, 'term_id'),
                'posts_per_page' => $limit
            ]);
            
            $query = new WP_Query($args);
            $related_posts = array_merge($related_posts, $query->posts);
            wp_reset_postdata();
        }
        
        // Priority 2: Posts with same categories (if we need more posts)
        if (count($related_posts) < $limit && !empty($categories)) {
            $exclude_ids = array_merge([$post_id], wp_list_pluck($related_posts, 'ID'));
            $needed = $limit - count($related_posts);
            
            $args = array_merge($args_base, [
                'category__in' => $categories,
                'post__not_in' => $exclude_ids,
                'posts_per_page' => $needed
            ]);
            
            $query = new WP_Query($args);
            $related_posts = array_merge($related_posts, $query->posts);
            wp_reset_postdata();
        }
        
        // Priority 3: Posts with same tags (if we need more posts)
        if (count($related_posts) < $limit && !empty($tags)) {
            $exclude_ids = array_merge([$post_id], wp_list_pluck($related_posts, 'ID'));
            $needed = $limit - count($related_posts);
            
            $args = array_merge($args_base, [
                'tag__in' => wp_list_pluck($tags, 'term_id'),
                'post__not_in' => $exclude_ids,
                'posts_per_page' => $needed
            ]);
            
            $query = new WP_Query($args);
            $related_posts = array_merge($related_posts, $query->posts);
            wp_reset_postdata();
        }
        
        // Priority 4: Recent posts from same author (if we need more posts)
        if (count($related_posts) < $limit) {
            $exclude_ids = array_merge([$post_id], wp_list_pluck($related_posts, 'ID'));
            $needed = $limit - count($related_posts);
            
            $args = array_merge($args_base, [
                'author' => $current_post->post_author,
                'post__not_in' => $exclude_ids,
                'posts_per_page' => $needed
            ]);
            
            $query = new WP_Query($args);
            $related_posts = array_merge($related_posts, $query->posts);
            wp_reset_postdata();
        }
        
        // Priority 5: Latest posts (if we still need more)
        if (count($related_posts) < $limit) {
            $exclude_ids = array_merge([$post_id], wp_list_pluck($related_posts, 'ID'));
            $needed = $limit - count($related_posts);
            
            $args = array_merge($args_base, [
                'post__not_in' => $exclude_ids,
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => $needed
            ]);
            
            $query = new WP_Query($args);
            $related_posts = array_merge($related_posts, $query->posts);
            wp_reset_postdata();
        }
        
        // Remove duplicates and limit results
        $unique_posts = [];
        $ids_seen = [];
        
        foreach ($related_posts as $post) {
            if (!in_array($post->ID, $ids_seen)) {
                $unique_posts[] = $post;
                $ids_seen[] = $post->ID;
                
                if (count($unique_posts) >= $limit) {
                    break;
                }
            }
        }
        
        return $unique_posts;
    }
}

// Get current post ID
$current_post_id = get_the_ID();
$related_posts = mtq_get_related_posts($current_post_id, 6);

if (empty($related_posts)) {
    return; // Don't display if no related posts found
}
?>

<section class="related-posts bg-gradient-to-br from-gray-50 to-blue-50/30 rounded-2xl p-6 md:p-8 lg:p-12 mt-12">
    <div class="mb-8">
        <!-- Section Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4l2 2m-2 2l2 2M9 7h1a2 2 0 012 2v1m0 0V9a2 2 0 012-2h1m0 0h1a2 2 0 012 2v1M9 17h1a2 2 0 002-2v-1m0 0v1a2 2 0 002 2h1m0 0h1a2 2 0 002 2v1"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900">
                        <?php esc_html_e('Artikel Terkait', 'mtq-aceh-pidie-jaya'); ?>
                    </h3>
                    <p class="text-gray-600 text-sm mt-1">
                        <?php esc_html_e('Baca juga artikel menarik lainnya', 'mtq-aceh-pidie-jaya'); ?>
                    </p>
                </div>
            </div>
            
            <!-- Algorithm Indicator -->
            <div class="hidden md:flex items-center gap-2 px-3 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                <?php esc_html_e('Dipilih Cerdas', 'mtq-aceh-pidie-jaya'); ?>
            </div>
        </div>
        
        <!-- Separator -->
        <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"></div>
    </div>

    <!-- Related Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($related_posts as $index => $post) : 
            setup_postdata($post);
            
            // Get post categories for relevance indicator
            $post_categories = get_the_category($post->ID);
            $current_categories = get_the_category($current_post_id);
            $shared_categories = array_intersect(
                wp_list_pluck($post_categories, 'term_id'),
                wp_list_pluck($current_categories, 'term_id')
            );
            
            // Get post tags for relevance indicator
            $post_tags = get_the_tags($post->ID);
            $current_tags = get_the_tags($current_post_id);
            $shared_tags = [];
            if ($post_tags && $current_tags) {
                $shared_tags = array_intersect(
                    wp_list_pluck($post_tags, 'term_id'),
                    wp_list_pluck($current_tags, 'term_id')
                );
            }
            
            // Calculate relevance score
            $relevance_score = count($shared_categories) * 2 + count($shared_tags);
            ?>
            
            <article class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-200">
                
                <!-- Featured Image -->
                <div class="relative aspect-video overflow-hidden">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium_large', [
                                'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300',
                                'alt' => get_the_title()
                            ]); ?>
                        <?php else : ?>
                            <div class="w-full h-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center group-hover:from-blue-100 group-hover:to-blue-200 transition-colors duration-300">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-thumbnail.svg" 
                                     alt="<?php echo esc_attr(get_the_title()); ?>" 
                                     class="w-20 h-20 opacity-60">
                            </div>
                        <?php endif; ?>
                    </a>
                    
                    <!-- Relevance Badge -->
                    <?php if ($relevance_score > 0) : ?>
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-500 text-white text-xs font-medium rounded-full">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <?php if ($relevance_score >= 3) : ?>
                                    <?php esc_html_e('Sangat Relevan', 'mtq-aceh-pidie-jaya'); ?>
                                <?php else : ?>
                                    <?php esc_html_e('Relevan', 'mtq-aceh-pidie-jaya'); ?>
                                <?php endif; ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Reading Time -->
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-black/70 text-white text-xs rounded-full backdrop-blur-sm">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <?php 
                            $reading_time = mtq_get_reading_time($post->ID);
                            printf(esc_html__('%d menit', 'mtq-aceh-pidie-jaya'), $reading_time);
                            ?>
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5">
                    <!-- Category -->
                    <?php if ($post_categories) : ?>
                        <div class="mb-3">
                            <a href="<?php echo esc_url(get_category_link($post_categories[0]->term_id)); ?>" 
                               class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
                                <?php echo esc_html($post_categories[0]->name); ?>
                                <?php if (in_array($post_categories[0]->term_id, wp_list_pluck($current_categories, 'term_id'))) : ?>
                                    <svg class="w-3 h-3 ml-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Title -->
                    <h4 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors leading-tight">
                        <a href="<?php the_permalink(); ?>" class="hover:underline">
                            <?php the_title(); ?>
                        </a>
                    </h4>

                    <!-- Excerpt -->
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                        <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                    </p>

                    <!-- Meta Info -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-3 text-xs text-gray-500">
                            <!-- Author -->
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <?php echo esc_html(get_the_author()); ?>
                            </span>
                            
                            <!-- Date -->
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <?php echo get_the_date(); ?>
                            </time>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" 
                           class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors group-hover:gap-2">
                            <?php esc_html_e('Baca', 'mtq-aceh-pidie-jaya'); ?>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            
        <?php endforeach; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    
    <!-- View More Button -->
    <?php 
    $blog_page_id = get_option('page_for_posts');
    if ($blog_page_id) : ?>
        <div class="text-center mt-8">
            <a href="<?php echo esc_url(get_permalink($blog_page_id)); ?>" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4l2 2m-2 2l2 2M9 7h1a2 2 0 012 2v1m0 0V9a2 2 0 012-2h1m0 0h1a2 2 0 012 2v1M9 17h1a2 2 0 002-2v-1m0 0v1a2 2 0 002 2h1m0 0h1a2 2 0 002 2v1"></path>
                </svg>
                <?php esc_html_e('Lihat Semua Artikel', 'mtq-aceh-pidie-jaya'); ?>
            </a>
        </div>
    <?php endif; ?>
</section>
