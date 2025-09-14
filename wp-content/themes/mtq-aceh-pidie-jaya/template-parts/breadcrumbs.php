<?php
/**
 * Breadcrumbs navigation component
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('mtq_get_breadcrumbs')) {
    function mtq_get_breadcrumbs() {
        // Don't display on front page
        if (is_front_page()) {
            return '';
        }

        $breadcrumbs = [];
        $separator = '<svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
        
        // Home link
        $breadcrumbs[] = '<a href="' . esc_url(home_url('/')) . '" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            ' . esc_html__('Beranda', 'mtq-aceh-pidie-jaya') . '
        </a>';

        if (is_category()) {
            // Category archive
            $category = get_queried_object();
            
            // Parent categories
            if ($category->parent != 0) {
                $parent_cats = [];
                $parent = get_category($category->parent);
                
                while ($parent) {
                    $parent_cats[] = '<a href="' . esc_url(get_category_link($parent->term_id)) . '" class="text-blue-600 hover:text-blue-800 transition-colors">' . esc_html($parent->name) . '</a>';
                    $parent = ($parent->parent != 0) ? get_category($parent->parent) : false;
                }
                
                $breadcrumbs = array_merge($breadcrumbs, array_reverse($parent_cats));
            }
            
            $breadcrumbs[] = '<span class="text-gray-700 font-medium">' . esc_html($category->name) . '</span>';
            
        } elseif (is_tag()) {
            // Tag archive
            $tag = get_queried_object();
            $breadcrumbs[] = '<a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '" class="text-blue-600 hover:text-blue-800 transition-colors">' . esc_html__('Berita', 'mtq-aceh-pidie-jaya') . '</a>';
            $breadcrumbs[] = '<span class="text-gray-700 font-medium">Tag: ' . esc_html($tag->name) . '</span>';
            
        } elseif (is_author()) {
            // Author archive
            $author = get_queried_object();
            $breadcrumbs[] = '<a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '" class="text-blue-600 hover:text-blue-800 transition-colors">' . esc_html__('Berita', 'mtq-aceh-pidie-jaya') . '</a>';
            $breadcrumbs[] = '<span class="text-gray-700 font-medium">Penulis: ' . esc_html($author->display_name) . '</span>';
            
        } elseif (is_date()) {
            // Date archive
            $breadcrumbs[] = '<a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '" class="text-blue-600 hover:text-blue-800 transition-colors">' . esc_html__('Berita', 'mtq-aceh-pidie-jaya') . '</a>';
            
            if (is_year()) {
                $breadcrumbs[] = '<span class="text-gray-700 font-medium">Arsip ' . get_the_date('Y') . '</span>';
            } elseif (is_month()) {
                $breadcrumbs[] = '<a href="' . esc_url(get_year_link(get_the_date('Y'))) . '" class="text-blue-600 hover:text-blue-800 transition-colors">' . get_the_date('Y') . '</a>';
                $breadcrumbs[] = '<span class="text-gray-700 font-medium">' . get_the_date('F Y') . '</span>';
            } elseif (is_day()) {
                $breadcrumbs[] = '<a href="' . esc_url(get_year_link(get_the_date('Y'))) . '" class="text-blue-600 hover:text-blue-800 transition-colors">' . get_the_date('Y') . '</a>';
                $breadcrumbs[] = '<a href="' . esc_url(get_month_link(get_the_date('Y'), get_the_date('m'))) . '" class="text-blue-600 hover:text-blue-800 transition-colors">' . get_the_date('F Y') . '</a>';
                $breadcrumbs[] = '<span class="text-gray-700 font-medium">' . get_the_date('j F Y') . '</span>';
            }
            
        } elseif (is_search()) {
            // Search results
            $breadcrumbs[] = '<span class="text-gray-700 font-medium">Hasil Pencarian: "' . esc_html(get_search_query()) . '"</span>';
            
        } elseif (is_404()) {
            // 404 page
            $breadcrumbs[] = '<span class="text-gray-700 font-medium">' . esc_html__('Halaman Tidak Ditemukan', 'mtq-aceh-pidie-jaya') . '</span>';
            
        } elseif (is_single()) {
            // Single post
            if (get_post_type() == 'post') {
                $breadcrumbs[] = '<a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '" class="text-blue-600 hover:text-blue-800 transition-colors">' . esc_html__('Berita', 'mtq-aceh-pidie-jaya') . '</a>';
                
                // Post categories
                $categories = get_the_category();
                if ($categories) {
                    $main_category = $categories[0];
                    
                    // Parent categories
                    if ($main_category->parent != 0) {
                        $parent_cats = [];
                        $parent = get_category($main_category->parent);
                        
                        while ($parent) {
                            $parent_cats[] = '<a href="' . esc_url(get_category_link($parent->term_id)) . '" class="text-blue-600 hover:text-blue-800 transition-colors">' . esc_html($parent->name) . '</a>';
                            $parent = ($parent->parent != 0) ? get_category($parent->parent) : false;
                        }
                        
                        $breadcrumbs = array_merge($breadcrumbs, array_reverse($parent_cats));
                    }
                    
                    $breadcrumbs[] = '<a href="' . esc_url(get_category_link($main_category->term_id)) . '" class="text-blue-600 hover:text-blue-800 transition-colors">' . esc_html($main_category->name) . '</a>';
                }
            }
            
            $breadcrumbs[] = '<span class="text-gray-700 font-medium">' . esc_html(get_the_title()) . '</span>';
            
        } elseif (is_page()) {
            // Static page
            $post = get_queried_object();
            
            // Parent pages
            if ($post->post_parent) {
                $parent_id = $post->post_parent;
                $parent_pages = [];
                
                while ($parent_id) {
                    $parent = get_post($parent_id);
                    $parent_pages[] = '<a href="' . esc_url(get_permalink($parent_id)) . '" class="text-blue-600 hover:text-blue-800 transition-colors">' . esc_html($parent->post_title) . '</a>';
                    $parent_id = $parent->post_parent;
                }
                
                $breadcrumbs = array_merge($breadcrumbs, array_reverse($parent_pages));
            }
            
            $breadcrumbs[] = '<span class="text-gray-700 font-medium">' . esc_html($post->post_title) . '</span>';
            
        } elseif (is_archive()) {
            // Other archives
            $breadcrumbs[] = '<span class="text-gray-700 font-medium">' . esc_html__('Arsip', 'mtq-aceh-pidie-jaya') . '</span>';
        }

        return $breadcrumbs;
    }
}
?>

<nav class="breadcrumbs bg-gray-50/80 backdrop-blur-sm border-b border-gray-200/50" aria-label="<?php esc_attr_e('Breadcrumb', 'mtq-aceh-pidie-jaya'); ?>">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <?php 
            $breadcrumbs = mtq_get_breadcrumbs();
            if (!empty($breadcrumbs)) {
                echo implode(' ', array_map(function($crumb, $index) use ($breadcrumbs) {
                    $separator = '<svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
                    return $crumb . ($index < count($breadcrumbs) - 1 ? $separator : '');
                }, $breadcrumbs, array_keys($breadcrumbs)));
            }
            ?>
        </div>
    </div>
</nav>
