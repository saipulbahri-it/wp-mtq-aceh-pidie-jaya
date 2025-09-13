<?php
/**
 * The template for displaying category archives with modern news layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main bg-gray-50 min-h-screen">
    <?php if (have_posts()) : ?>
        
        <!-- Breadcrumb Section -->
        <section class="bg-white border-b border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="text-sm" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-gray-500">
                        <li>
                            <a href="<?php echo home_url(); ?>" class="hover:text-red-600 transition-colors">
                                <i class="fas fa-home mr-1"></i>
                                Beranda
                            </a>
                        </li>
                        <li class="text-gray-300">/</li>
                        <li>
                            <a href="<?php echo home_url('/berita'); ?>" class="hover:text-red-600 transition-colors">
                                Berita
                            </a>
                        </li>
                        <li class="text-gray-300">/</li>
                        <li class="text-gray-600">
                            <?php single_cat_title(); ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Category Header -->
        <section class="bg-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-4">
                    <?php single_cat_title(); ?>
                </h1>
                
                <?php
                $description = category_description();
                if ($description) : ?>
                    <p class="text-xl text-slate-600 max-w-3xl mx-auto mb-6">
                        <?php echo strip_tags($description); ?>
                    </p>
                <?php endif; ?>
                
                <div class="flex items-center justify-center gap-4 text-gray-500">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-newspaper text-red-500"></i>
                        <span>
                            <?php
                            $category = get_queried_object();
                            printf(
                                _n('%s artikel', '%s artikel', $category->count, 'mtq-aceh-pidie-jaya'),
                                number_format_i18n($category->count)
                            );
                            ?>
                        </span>
                    </div>
                    <span class="text-gray-300">•</span>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-tag text-orange-500"></i>
                        <span>Kategori: <?php single_cat_title(); ?></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content Area -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid lg:grid-cols-4 gap-8">
                
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    
                    <!-- Articles Grid -->
                    <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-8 mb-12" id="articles-grid">
                        <?php
                        while (have_posts()) : the_post();
                        ?>
                            <article class="group bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <div class="relative overflow-hidden">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="aspect-video">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium_large', [
                                                    'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300'
                                                ]); ?>
                                            </a>
                                        </div>
                                    <?php else : ?>
                                        <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <i class="fas fa-newspaper text-gray-400 text-3xl"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Dark Overlay -->
                                    <div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-50 transition-all duration-300"></div>
                                    
                                    <!-- Category Badge -->
                                    <?php
                                    $post_categories = get_the_category();
                                    if (!empty($post_categories)) :
                                    ?>
                                        <span class="absolute top-4 left-4 px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-full">
                                            <?php echo esc_html($post_categories[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <!-- Content Overlay -->
                                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                        <h3 class="text-lg font-bold leading-tight mb-3 group-hover:text-orange-300 transition-colors">
                                            <a href="<?php the_permalink(); ?>" class="line-clamp-3">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        
                                        <div class="flex items-center gap-4 text-sm opacity-90">
                                            <div class="flex items-center gap-1">
                                                <i class="fas fa-calendar text-orange-300"></i>
                                                <time datetime="<?php echo get_the_date('c'); ?>">
                                                    <?php echo get_the_date('d M Y'); ?>
                                                </time>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <i class="fas fa-user text-orange-300"></i>
                                                <span><?php the_author(); ?></span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <i class="fas fa-eye text-orange-300"></i>
                                                <span><?php echo get_post_meta(get_the_ID(), 'post_views_count', true) ?: '0'; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php
                        endwhile;
                        ?>
                    </div>

                    <!-- Load More Button -->
                    <?php
                    global $wp_query;
                    if ($wp_query->max_num_pages > 1) :
                    ?>
                    <div class="text-center mb-12">
                        <button id="load-more-category" 
                                class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-red-600 to-orange-600 text-white font-semibold rounded-xl hover:from-red-700 hover:to-orange-700 transform hover:scale-105 transition-all duration-200 shadow-lg"
                                data-page="1" 
                                data-category="<?php echo get_queried_object_id(); ?>"
                                data-nonce="<?php echo wp_create_nonce('load_more_category'); ?>">
                            <span class="load-more-text">Muat Lebih Banyak</span>
                            <div class="load-more-spinner hidden">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <?php endif; ?>

                    <!-- Traditional Pagination (fallback) -->
                    <div class="pagination-wrapper">
                        <?php
                        $pagination_args = array(
                            'mid_size' => 2,
                            'prev_text' => '<i class="fas fa-chevron-left mr-2"></i>Sebelumnya',
                            'next_text' => 'Selanjutnya<i class="fas fa-chevron-right ml-2"></i>',
                            'type' => 'array'
                        );

                        $pages = paginate_links($pagination_args);

                        if ($pages && $wp_query->max_num_pages > 1) : ?>
                            <nav class="flex justify-center" role="navigation" aria-label="Posts navigation">
                                <div class="flex flex-wrap justify-center gap-2">
                                    <?php 
                                    foreach ($pages as $page) :
                                        if (strpos($page, 'current') !== false) {
                                            $page = str_replace('page-numbers current', 'inline-flex items-center justify-center px-4 py-2 text-sm font-medium bg-red-600 text-white border border-red-600 rounded-lg', $page);
                                        } elseif (strpos($page, 'dots') !== false) {
                                            $page = str_replace('page-numbers dots', 'inline-flex items-center justify-center px-2 py-2 text-gray-400', $page);
                                        } else {
                                            $page = str_replace('page-numbers', 'inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-red-600 transition-colors', $page);
                                        }
                                        echo $page;
                                    endforeach; 
                                    ?>
                                </div>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="space-y-8">
                        
                        <!-- Popular Articles Widget -->
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i class="fas fa-fire text-red-500"></i>
                                Artikel Populer
                            </h3>
                            
                            <?php
                            $popular_posts = new WP_Query([
                                'post_type' => 'post',
                                'posts_per_page' => 5,
                                'meta_key' => 'post_views_count',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'ignore_sticky_posts' => true
                            ]);
                            
                            if ($popular_posts->have_posts()) :
                                while ($popular_posts->have_posts()) : $popular_posts->the_post();
                            ?>
                                <article class="flex gap-4 p-4 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="flex-shrink-0">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('thumbnail', [
                                                    'class' => 'w-16 h-16 object-cover rounded-lg group-hover:scale-105 transition-transform duration-200'
                                                ]); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 text-sm leading-tight mb-2 line-clamp-2 group-hover:text-red-600 transition-colors">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h4>
                                        <div class="flex items-center gap-3 text-xs text-gray-500">
                                            <time datetime="<?php echo get_the_date('c'); ?>">
                                                <i class="fas fa-calendar mr-1"></i>
                                                <?php echo get_the_date('d M Y'); ?>
                                            </time>
                                            <span>
                                                <i class="fas fa-eye mr-1"></i>
                                                <?php echo get_post_meta(get_the_ID(), 'post_views_count', true) ?: '0'; ?>
                                            </span>
                                        </div>
                                    </div>
                                </article>
                            <?php 
                                endwhile;
                                wp_reset_postdata();
                            endif; 
                            ?>
                        </div>

                        <!-- Recent Articles Widget -->
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i class="fas fa-clock text-blue-500"></i>
                                Artikel Terbaru
                            </h3>
                            
                            <?php
                            $recent_posts = new WP_Query([
                                'post_type' => 'post',
                                'posts_per_page' => 5,
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'ignore_sticky_posts' => true
                            ]);
                            
                            if ($recent_posts->have_posts()) :
                                while ($recent_posts->have_posts()) : $recent_posts->the_post();
                            ?>
                                <article class="flex gap-4 p-4 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="flex-shrink-0">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('thumbnail', [
                                                    'class' => 'w-16 h-16 object-cover rounded-lg group-hover:scale-105 transition-transform duration-200'
                                                ]); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 text-sm leading-tight mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h4>
                                        <div class="flex items-center gap-3 text-xs text-gray-500">
                                            <time datetime="<?php echo get_the_date('c'); ?>">
                                                <i class="fas fa-calendar mr-1"></i>
                                                <?php echo get_the_date('d M Y'); ?>
                                            </time>
                                            <span>
                                                <i class="fas fa-user mr-1"></i>
                                                <?php the_author(); ?>
                                            </span>
                                        </div>
                                    </div>
                                </article>
                            <?php 
                                endwhile;
                                wp_reset_postdata();
                            endif; 
                            ?>
                        </div>

                        <!-- Categories Widget -->
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i class="fas fa-tags text-green-500"></i>
                                Kategori
                            </h3>
                            
                            <?php
                            $categories = get_categories([
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'number' => 8,
                                'hide_empty' => true
                            ]);
                            
                            if ($categories) :
                                foreach ($categories as $cat) :
                            ?>
                                <a href="<?php echo get_category_link($cat->term_id); ?>" 
                                   class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <span class="font-medium text-gray-700 group-hover:text-green-600">
                                        <?php echo esc_html($cat->name); ?>
                                    </span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-medium group-hover:bg-green-100 group-hover:text-green-700">
                                        <?php echo $cat->count; ?>
                                    </span>
                                </a>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else : ?>
        
        <!-- No Posts Found -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="max-w-md mx-auto">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                        <i class="fas fa-newspaper text-gray-400 text-4xl"></i>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        Belum Ada Artikel
                    </h2>
                    
                    <p class="text-gray-600 mb-8">
                        Kategori "<?php single_cat_title(); ?>" belum memiliki artikel. Silakan kembali ke halaman utama atau coba kategori lainnya.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?php echo esc_url(home_url('/')); ?>" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-home mr-2"></i>
                            Kembali ke Beranda
                        </a>
                        
                        <a href="<?php echo esc_url(home_url('/berita')); ?>" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-newspaper mr-2"></i>
                            Lihat Semua Berita
                        </a>
                    </div>
                </div>
            </div>
        </section>

    <?php endif; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more-category');
    
    if (!loadMoreBtn) return;
    
    loadMoreBtn.addEventListener('click', function() {
        const button = this;
        const currentPage = parseInt(button.dataset.page);
        const categoryId = button.dataset.category;
        const nonce = button.dataset.nonce;
        const articlesGrid = document.getElementById('articles-grid');
        
        // Show loading state
        const loadMoreText = button.querySelector('.load-more-text');
        const loadMoreSpinner = button.querySelector('.load-more-spinner');
        
        loadMoreText.textContent = 'Memuat...';
        loadMoreSpinner.classList.remove('hidden');
        button.disabled = true;
        
        // AJAX request
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'load_more_category',
                page: currentPage + 1,
                category: categoryId,
                nonce: nonce
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add new articles to grid
                articlesGrid.insertAdjacentHTML('beforeend', data.data.html);
                
                // Update button state
                if (data.data.has_more) {
                    button.dataset.page = currentPage + 1;
                    loadMoreText.textContent = 'Muat Lebih Banyak';
                    loadMoreSpinner.classList.add('hidden');
                    button.disabled = false;
                } else {
                    button.style.display = 'none';
                }
            } else {
                console.error('Error loading more posts:', data.data);
                loadMoreText.textContent = 'Gagal memuat';
                loadMoreSpinner.classList.add('hidden');
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loadMoreText.textContent = 'Gagal memuat';
            loadMoreSpinner.classList.add('hidden');
            button.disabled = false;
        });
    });
});
</script>

<style>
/* Line clamp utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive grid adjustments */
@media (max-width: 768px) {
    #articles-grid {
        grid-template-columns: 1fr;
    }
}

@media (min-width: 769px) and (max-width: 1023px) {
    #articles-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    #articles-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Hover animations */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

.group:hover .group-hover\:text-orange-300 {
    color: #fed7aa;
}

.group:hover .group-hover\:text-red-600 {
    color: #dc2626;
}

.group:hover .group-hover\:text-blue-600 {
    color: #2563eb;
}

.group:hover .group-hover\:text-green-600 {
    color: #16a34a;
}

.group:hover .group-hover\:bg-opacity-50 {
    background-opacity: 0.5;
}

/* Load more button animation */
#load-more-category:hover {
    transform: scale(1.05);
}

#load-more-category:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}
</style>

<?php get_footer(); ?>
