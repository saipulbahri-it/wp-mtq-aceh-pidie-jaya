<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
    <?php while (have_posts()) : the_post(); ?>

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
                        <li class="text-gray-600 truncate max-w-xs">
                            <?php echo wp_trim_words(get_the_title(), 5, '...'); ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Main Content Area -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid lg:grid-cols-4 gap-8">
                
                <!-- Article Content (Left 3 columns) -->
                <div class="lg:col-span-3">
                    
                    <!-- Article Header -->
                    <article class="bg-white rounded-lg shadow-sm overflow-hidden">
                        
                        <!-- Article Title & Meta -->
                        <div class="p-8 pb-4">
                            <!-- Category Badge -->
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) :
                            ?>
                                <div class="mb-4">
                                    <?php foreach ($categories as $category) : ?>
                                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Article Title -->
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-6">
                                <?php the_title(); ?>
                            </h1>

                            <!-- Author & Date Info -->
                            <div class="flex flex-wrap items-center gap-6 text-gray-600 border-b border-gray-200 pb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', ['class' => 'w-10 h-10 rounded-full']) ?: '<i class="fas fa-user text-gray-400"></i>'; ?>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900"><?php the_author(); ?></p>
                                        <p class="text-sm text-gray-500">Penulis</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                    <div>
                                        <time datetime="<?php echo get_the_date('c'); ?>" class="font-medium text-gray-900">
                                            <?php echo get_the_date('d F Y'); ?>
                                        </time>
                                        <p class="text-sm text-gray-500"><?php echo get_the_date('H:i'); ?> WIB</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-eye text-gray-400"></i>
                                    <div>
                                        <span class="font-medium text-gray-900" id="view-count">
                                            <?php echo get_post_meta(get_the_ID(), 'post_views_count', true) ?: '0'; ?>
                                        </span>
                                        <p class="text-sm text-gray-500">Dibaca</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image with Caption -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="px-8 pb-6">
                                <figure>
                                    <div class="rounded-lg overflow-hidden">
                                        <?php the_post_thumbnail('large', [
                                            'class' => 'w-full h-64 md:h-96 object-cover'
                                        ]); ?>
                                    </div>
                                    <?php 
                                    $caption = get_the_post_thumbnail_caption();
                                    if ($caption) : 
                                    ?>
                                        <figcaption class="mt-3 text-sm text-gray-600 italic">
                                            <?php echo esc_html($caption); ?>
                                        </figcaption>
                                    <?php endif; ?>
                                </figure>
                            </div>
                        <?php endif; ?>

                        <!-- Article Content -->
                        <div class="px-8 pb-8">
                            <!-- Article Excerpt -->
                            <?php if (has_excerpt()) : ?>
                                <div class="mb-8 p-4 bg-orange-50 border-l-4 border-orange-400 rounded-r-lg">
                                    <p class="text-lg text-gray-800 leading-relaxed font-medium italic">
                                        <?php echo get_the_excerpt(); ?>
                                    </p>
                                </div>
                            <?php endif; ?>

                            <!-- Main Content -->
                            <div class="prose prose-lg max-w-none">
                                <?php
                                $content = get_the_content();
                                $content = apply_filters('the_content', $content);
                                
                                // Enhanced styling for content
                                $content = str_replace('<p>', '<p class="mb-6 leading-relaxed text-gray-800 text-lg">', $content);
                                $content = str_replace('<h2>', '<h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-10 mb-6 border-b border-gray-200 pb-3">', $content);
                                $content = str_replace('<h3>', '<h3 class="text-xl md:text-2xl font-semibold text-gray-900 mt-8 mb-4">', $content);
                                
                                // Style quotes from sources
                                $content = str_replace('<blockquote>', '<blockquote class="border-l-4 border-red-400 pl-6 italic text-gray-700 my-8 bg-red-50 py-6 rounded-r-lg relative">
                                    <div class="absolute top-2 left-2 text-red-300 text-4xl leading-none">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <div class="pl-8">', $content);
                                $content = str_replace('</blockquote>', '</div></blockquote>', $content);
                                
                                $content = str_replace('<ul>', '<ul class="list-disc list-inside space-y-2 my-6 text-gray-800 ml-4">', $content);
                                $content = str_replace('<ol>', '<ol class="list-decimal list-inside space-y-2 my-6 text-gray-800 ml-4">', $content);
                                
                                echo $content;
                                ?>
                            </div>

                            <!-- Tags Section -->
                            <?php
                            $tags = get_the_tags();
                            if ($tags) :
                            ?>
                                <div class="mt-12 pt-8 border-t border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags:</h3>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach ($tags as $tag) : ?>
                                            <a href="<?php echo get_tag_link($tag->term_id); ?>" 
                                               class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full hover:bg-red-100 hover:text-red-800 transition-colors">
                                                #<?php echo esc_html($tag->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Share Section -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Bagikan:</h3>
                                <div class="flex gap-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
                                       target="_blank" 
                                       class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                        <i class="fab fa-facebook-f"></i>
                                        Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                       target="_blank" 
                                       class="flex items-center gap-2 px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors text-sm">
                                        <i class="fab fa-twitter"></i>
                                        Twitter
                                    </a>
                                    <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>" 
                                       target="_blank" 
                                       class="flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm">
                                        <i class="fab fa-whatsapp"></i>
                                        WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Sidebar (Right 1 column) -->
                <div class="lg:col-span-1">
                    
                    <!-- Popular Articles Widget -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                            <i class="fas fa-fire text-red-500 mr-2"></i>
                            Populer
                        </h3>
                        
                        <?php
                        $popular_posts = get_posts([
                            'numberposts' => 5,
                            'meta_key' => 'post_views_count',
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC',
                            'post__not_in' => [get_the_ID()]
                        ]);

                        if ($popular_posts) :
                            foreach ($popular_posts as $index => $popular_post) : setup_postdata($popular_post);
                        ?>
                            <article class="flex gap-4 pb-4 mb-4 <?php echo $index < 4 ? 'border-b border-gray-100' : ''; ?>">
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 font-bold text-sm rounded-full">
                                        <?php echo $index + 1; ?>
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 leading-tight mb-2 hover:text-red-600 transition-colors">
                                        <a href="<?php echo get_permalink($popular_post->ID); ?>" class="line-clamp-3">
                                            <?php echo get_the_title($popular_post->ID); ?>
                                        </a>
                                    </h4>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <i class="fas fa-calendar"></i>
                                        <time datetime="<?php echo get_the_date('c', $popular_post->ID); ?>">
                                            <?php echo get_the_date('d M Y', $popular_post->ID); ?>
                                        </time>
                                    </div>
                                </div>
                            </article>
                        <?php
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>

                    <!-- Recent Articles Widget -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                            <i class="fas fa-clock text-orange-500 mr-2"></i>
                            Terbaru
                        </h3>
                        
                        <?php
                        $recent_posts = get_posts([
                            'numberposts' => 5,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'post__not_in' => [get_the_ID()]
                        ]);

                        if ($recent_posts) :
                            foreach ($recent_posts as $index => $recent_post) : setup_postdata($recent_post);
                        ?>
                            <article class="pb-4 mb-4 <?php echo $index < 4 ? 'border-b border-gray-100' : ''; ?>">
                                <h4 class="text-sm font-medium text-gray-900 leading-tight mb-2 hover:text-red-600 transition-colors">
                                    <a href="<?php echo get_permalink($recent_post->ID); ?>" class="line-clamp-3">
                                        <?php echo get_the_title($recent_post->ID); ?>
                                    </a>
                                </h4>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <i class="fas fa-calendar"></i>
                                    <time datetime="<?php echo get_the_date('c', $recent_post->ID); ?>">
                                        <?php echo get_the_date('d M Y', $recent_post->ID); ?>
                                    </time>
                                </div>
                            </article>
                        <?php
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        </div>

        <!-- Other News Section -->
        <section class="bg-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Berita Lainnya</h2>
                    <div class="w-20 h-1 bg-red-500 mx-auto"></div>
                </div>

                <!-- News Grid -->
                <div id="news-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <?php
                    $other_posts = get_posts([
                        'numberposts' => 6,
                        'post__not_in' => [get_the_ID()],
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ]);

                    if ($other_posts) :
                        foreach ($other_posts as $other_post) : setup_postdata($other_post);
                    ?>
                        <article class="group relative bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative overflow-hidden">
                                <?php if (has_post_thumbnail($other_post->ID)) : ?>
                                    <div class="aspect-video">
                                        <?php echo get_the_post_thumbnail($other_post->ID, 'medium_large', [
                                            'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300'
                                        ]); ?>
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
                                $post_categories = get_the_category($other_post->ID);
                                if (!empty($post_categories)) :
                                ?>
                                    <span class="absolute top-4 left-4 px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-full">
                                        <?php echo esc_html($post_categories[0]->name); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <!-- Content Overlay -->
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                    <h3 class="text-lg font-bold leading-tight mb-3 group-hover:text-orange-300 transition-colors">
                                        <a href="<?php echo get_permalink($other_post->ID); ?>" class="line-clamp-3">
                                            <?php echo get_the_title($other_post->ID); ?>
                                        </a>
                                    </h3>
                                    
                                    <div class="flex items-center gap-4 text-sm opacity-90">
                                        <div class="flex items-center gap-1">
                                            <i class="fas fa-calendar text-orange-300"></i>
                                            <time datetime="<?php echo get_the_date('c', $other_post->ID); ?>">
                                                <?php echo get_the_date('d M Y', $other_post->ID); ?>
                                            </time>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <i class="fas fa-eye text-orange-300"></i>
                                            <span><?php echo get_post_meta($other_post->ID, 'post_views_count', true) ?: '0'; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php
                        endforeach;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

                <!-- Load More Button -->
                <div class="text-center">
                    <button id="load-more-btn" 
                            class="inline-flex items-center px-8 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors duration-300 transform hover:scale-105"
                            data-page="1" 
                            data-exclude="<?php echo get_the_ID(); ?>">
                        <i class="fas fa-plus mr-2"></i>
                        Muat Lebih Banyak
                    </button>
                    <div id="loading-spinner" class="hidden mt-4">
                        <div class="inline-flex items-center text-gray-600">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-red-600 mr-2"></div>
                            Memuat...
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Comments Section -->
        <?php if (comments_open() || get_comments_number()) : ?>
            <section class="py-12 bg-gray-50">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white rounded-lg shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-comments text-red-600"></i>
                            Komentar
                        </h2>
                        <?php comments_template(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    <?php endwhile; ?>
</main>

<!-- JavaScript for Load More functionality and View Tracking -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load More functionality
    const loadMoreBtn = document.getElementById('load-more-btn');
    const loadingSpinner = document.getElementById('loading-spinner');
    const newsGrid = document.getElementById('news-grid');
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const currentPage = parseInt(this.getAttribute('data-page'));
            const excludeId = this.getAttribute('data-exclude');
            
            // Show loading state
            loadMoreBtn.style.display = 'none';
            loadingSpinner.classList.remove('hidden');
            
            // AJAX request to load more posts
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=load_more_posts&page=${currentPage + 1}&exclude=${excludeId}&nonce=<?php echo wp_create_nonce('load_more_posts'); ?>`
            })
            .then(response => response.json())
            .then(data => {
                loadingSpinner.classList.add('hidden');
                
                if (data.success && data.data.html) {
                    // Add new posts to grid
                    newsGrid.insertAdjacentHTML('beforeend', data.data.html);
                    
                    // Update page number
                    loadMoreBtn.setAttribute('data-page', currentPage + 1);
                    
                    // Show button again if there are more posts
                    if (data.data.has_more) {
                        loadMoreBtn.style.display = 'inline-flex';
                    } else {
                        loadMoreBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Semua Berita Ditampilkan';
                        loadMoreBtn.classList.remove('hover:bg-red-700');
                        loadMoreBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                        loadMoreBtn.disabled = true;
                        loadMoreBtn.style.display = 'inline-flex';
                    }
                } else {
                    loadMoreBtn.style.display = 'inline-flex';
                    loadMoreBtn.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Gagal Memuat';
                    loadMoreBtn.classList.add('bg-gray-400');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loadingSpinner.classList.add('hidden');
                loadMoreBtn.style.display = 'inline-flex';
                loadMoreBtn.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Gagal Memuat';
                loadMoreBtn.classList.add('bg-gray-400');
            });
        });
    }
    
    // Track page view
    const trackView = () => {
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=track_post_view&post_id=<?php echo get_the_ID(); ?>&nonce=<?php echo wp_create_nonce('track_post_view'); ?>'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.views) {
                const viewCountEl = document.getElementById('view-count');
                if (viewCountEl) {
                    viewCountEl.textContent = data.data.views;
                }
            }
        })
        .catch(error => {
            console.log('View tracking error:', error);
        });
    };
    
    // Track view after 10 seconds
    setTimeout(trackView, 10000);
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>

<?php
get_footer();
?>
