<?php
/**
 * Template Name: Berita
 * Description: Menampilkan daftar berita dan detail berita.
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>
<main id="primary" class="site-main">
    <!-- Search Section -->
    <section class="pt-28 py-8 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <!-- Search Box -->
                <div class="search-container relative">
                    <div class="relative">
                        <input type="text" 
                               id="news-search" 
                               placeholder="Cari berita..."
                               class="w-full md:w-80 pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <button id="search-btn" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-4 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <!-- Search Results Dropdown -->
                    <div id="search-results" class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-xl shadow-lg mt-2 max-h-96 overflow-y-auto z-50 hidden">
                        <!-- Search results will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Berita Section -->
    <section class="py-16 bg-slate-50 section-animate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">
                    <span id="section-title">Semua Berita</span>
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    <span id="section-subtitle">Temukan berita terbaru, pengumuman, dan dokumentasi kegiatan MTQ Aceh XXXVII.</span>
                </p>
                
                <!-- Loading Indicator -->
                <div id="loading-indicator" class="hidden mt-4">
                    <div class="inline-flex items-center gap-2 text-gray-600">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Memuat berita...</span>
                    </div>
                </div>
            </div>
            
            <!-- Articles Grid Container -->
            <div id="articles-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 fade-in-delay-2 min-h-[400px]">
                <?php
                // Get featured/recent posts for the slider
                $headline_query = new WP_Query([
                    'post_type' => 'post',
                    'posts_per_page' => 2, // Limited to 2 articles for grid
                    'meta_query' => [
                        'relation' => 'OR',
                        [
                            'key' => '_featured_post',
                            'value' => '1',
                            'compare' => '='
                        ],
                        [
                            'key' => '_featured_post',
                            'compare' => 'NOT EXISTS'
                        ]
                    ],
                    'orderby' => 'date',
                    'order' => 'DESC'
                ]);
                
                // Display featured posts in special grid format first
                if ($headline_query->have_posts()) :
                    while ($headline_query->have_posts()) : $headline_query->the_post();
                ?>
                <article class="news-article featured-article group bg-gradient-to-br from-red-600 to-orange-600 rounded-2xl shadow-xl hover:shadow-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 flex flex-col h-full text-white" 
                         data-categories="<?php echo implode(',', wp_get_post_categories(get_the_ID())); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="relative overflow-hidden h-48">
                            <a href="<?php the_permalink(); ?>" class="block">
                                <?php the_post_thumbnail('medium_large', [
                                    'class' => 'w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 opacity-30',
                                    'loading' => 'lazy'
                                ]); ?>
                            </a>
                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <?php 
                                $categories = get_the_category();
                                if (!empty($categories)) :
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm border border-white/30">
                                    <i class="fas fa-star mr-1"></i>
                                    <?php echo esc_html($categories[0]->name); ?>
                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Featured Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-500 text-white">
                                    <i class="fas fa-trophy mr-1"></i>
                                    UTAMA
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <!-- Date and Author -->
                        <div class="flex items-center gap-4 text-sm text-white/80 mb-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <time datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date('d M Y'); ?>
                                </time>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-white/60" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span><?php the_author(); ?></span>
                            </div>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-xl font-bold text-white mb-3 line-clamp-2 leading-tight">
                            <a href="<?php the_permalink(); ?>" 
                               class="hover:text-yellow-200 transition-colors duration-200"
                               aria-label="Baca artikel: <?php echo esc_attr(get_the_title()); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        
                        <!-- Excerpt -->
                        <div class="text-white/90 mb-6 line-clamp-3 leading-relaxed flex-grow">
                            <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                        </div>
                        
                        <!-- Read More Button -->
                        <div class="mt-auto">
                            <a href="<?php the_permalink(); ?>" 
                               class="inline-flex items-center gap-2 text-white bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-200 group-hover:gap-3 border border-white/30"
                               aria-label="Baca selengkapnya: <?php echo esc_attr(get_the_title()); ?>">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                <?php 
                    endwhile; 
                    wp_reset_postdata();
                endif;
                
                // Get IDs from headline posts to exclude them from main grid
                $headline_post_ids = [];
                if ($headline_query->have_posts()) {
                    foreach ($headline_query->posts as $post) {
                        $headline_post_ids[] = $post->ID;
                    }
                }
                
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $berita_query = new WP_Query([
                    'post_type' => 'post',
                    'posts_per_page' => 7, // Reduced to 7 since we have 2 featured articles
                    'paged' => $paged,
                    'post__not_in' => $headline_post_ids, // Exclude posts shown in featured section
                ]);
                if ($berita_query->have_posts()) :
                    while ($berita_query->have_posts()) : $berita_query->the_post();
                ?>
                <article class="news-article group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 overflow-hidden transition-all duration-300 hover:-translate-y-1 flex flex-col h-full" 
                         data-categories="<?php echo implode(',', wp_get_post_categories(get_the_ID())); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="relative overflow-hidden">
                            <a href="<?php the_permalink(); ?>" class="block">
                                <?php the_post_thumbnail('medium_large', [
                                    'class' => 'w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105',
                                    'loading' => 'lazy'
                                ]); ?>
                            </a>
                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <?php 
                                $categories = get_the_category();
                                if (!empty($categories)) :
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-600 text-white backdrop-blur-sm">
                                    <?php echo esc_html($categories[0]->name); ?>
                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- View Count Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-black/50 text-white backdrop-blur-sm">
                                    <i class="fas fa-eye mr-1"></i>
                                    <?php echo get_post_meta(get_the_ID(), 'post_views_count', true) ?: '0'; ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <!-- Date and Author -->
                        <div class="flex items-center gap-4 text-sm text-slate-500 mb-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <time datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date('d M Y'); ?>
                                </time>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span><?php the_author(); ?></span>
                            </div>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 leading-tight">
                            <a href="<?php the_permalink(); ?>" 
                               class="hover:text-red-600 transition-colors duration-200"
                               aria-label="Baca artikel: <?php echo esc_attr(get_the_title()); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        
                        <!-- Excerpt -->
                        <div class="text-slate-600 mb-6 line-clamp-3 leading-relaxed flex-grow">
                            <?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
                        </div>
                        
                        <!-- Read More Button -->
                        <div class="mt-auto">
                            <a href="<?php the_permalink(); ?>" 
                               class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-semibold text-sm transition-colors duration-200 group-hover:gap-3"
                               aria-label="Baca selengkapnya: <?php echo esc_attr(get_the_title()); ?>">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endwhile; ?>
                <?php else : ?>
                    <div class="col-span-full text-center py-16">
                        <div class="max-w-md mx-auto">
                            <i class="fas fa-newspaper text-gray-300 text-6xl mb-4"></i>
                            <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum Ada Berita</h3>
                            <p class="text-slate-500">Berita akan segera ditambahkan. Silakan kembali lagi nanti.</p>
                        </div>
                    </div>
                <?php endif; wp_reset_postdata(); ?>
            </div>
            
            <!-- Load More Button -->
            <div class="text-center mt-12">
                <button id="load-more-news" 
                        class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-red-600 to-orange-600 text-white font-semibold rounded-xl hover:from-red-700 hover:to-orange-700 transform hover:scale-105 transition-all duration-200 shadow-lg"
                        data-page="1" 
                        data-nonce="<?php echo wp_create_nonce('load_more_news'); ?>">
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
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initSearchFunctionality();
    initLoadMore();
    initAnimations();
    
    // Search Functionality
    function initSearchFunctionality() {
        const searchInput = document.getElementById('news-search');
        const searchBtn = document.getElementById('search-btn');
        const searchResults = document.getElementById('search-results');
        let searchTimeout;
        
        function performSearch(query) {
            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }
            
            // Re-query articles to include newly loaded ones
            const articles = document.querySelectorAll('.news-article');
            const results = [];
            
            articles.forEach(article => {
                const titleElement = article.querySelector('h3 a');
                const excerptElement = article.querySelector('.text-slate-600');
                
                if (titleElement && excerptElement) {
                    const title = titleElement.textContent.toLowerCase();
                    const excerpt = excerptElement.textContent.toLowerCase();
                    
                    if (title.includes(query.toLowerCase()) || excerpt.includes(query.toLowerCase())) {
                        results.push({
                            title: titleElement.textContent,
                            url: titleElement.href,
                            excerpt: excerptElement.textContent
                        });
                    }
                }
            });
            
            // Display results
            if (results.length > 0) {
                const resultsHTML = results.slice(0, 5).map(result => `
                    <a href="${result.url}" class="block p-4 hover:bg-gray-50 border-b border-gray-100">
                        <h4 class="font-semibold text-gray-900 mb-1">${result.title}</h4>
                        <p class="text-sm text-gray-600 line-clamp-2">${result.excerpt}</p>
                    </a>
                `).join('');
                
                searchResults.innerHTML = resultsHTML;
                searchResults.classList.remove('hidden');
            } else {
                searchResults.innerHTML = `
                    <div class="p-4 text-center text-gray-500">
                        <i class="fas fa-search mb-2"></i>
                        <p>Tidak ada hasil untuk "${query}"</p>
                    </div>
                `;
                searchResults.classList.remove('hidden');
            }
        }
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 300);
        });
        
        searchInput.addEventListener('focus', function() {
            if (this.value.length >= 2) {
                searchResults.classList.remove('hidden');
            }
        });
        
        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
        
        searchBtn.addEventListener('click', function() {
            performSearch(searchInput.value);
        });
    }
    
    // Load More Functionality
    function initLoadMore() {
        const loadMoreBtn = document.getElementById('load-more-news');
        if (!loadMoreBtn) return;
        
        loadMoreBtn.addEventListener('click', function() {
            const button = this;
            const currentPage = parseInt(button.dataset.page);
            const nonce = button.dataset.nonce;
            const articlesContainer = document.getElementById('articles-container');
            
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
                    action: 'load_more_news_page',
                    page: currentPage + 1,
                    nonce: nonce
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    articlesContainer.insertAdjacentHTML('beforeend', data.data.html);
                    
                    if (data.data.has_more) {
                        button.dataset.page = currentPage + 1;
                        loadMoreText.textContent = 'Muat Lebih Banyak';
                        loadMoreSpinner.classList.add('hidden');
                        button.disabled = false;
                    } else {
                        button.style.display = 'none';
                    }
                } else {
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
    }
    
    // Animation Observers
    function initAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);
        
        // Observe animated elements
        document.querySelectorAll('.fade-in, .fade-in-delay, .fade-in-delay-2, .fade-in-delay-3').forEach(el => {
            observer.observe(el);
        });
    }
});
</script>

<style>
/* Enhanced animations and styles */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.8s ease-out forwards;
}

.fade-in-animation {
    animation: slideIn 0.5s ease-out forwards;
}

.fade-in {
    opacity: 0;
}

.fade-in-delay {
    opacity: 0;
    animation-delay: 0.2s;
}

.fade-in-delay-2 {
    opacity: 0;
    animation-delay: 0.4s;
}

.fade-in-delay-3 {
    opacity: 0;
    animation-delay: 0.6s;
}

/* Search container enhanced */
.search-container input:focus {
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

/* News articles enhanced hover effects */
.news-article:hover {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.news-article .group-hover\:scale-105:hover {
    transform: scale(1.1);
}

/* Line clamp utilities */
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

/* Load more button enhanced */
#load-more-news:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
}

#load-more-news:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

/* Search results dropdown */
#search-results {
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
}

/* Responsive design enhancements */
@media (max-width: 768px) {
    .search-container {
        width: 100%;
    }
    
    .search-container input {
        width: 100%;
    }
}

/* Smooth transitions for all interactive elements */
* {
    transition: all 0.2s ease-in-out;
}

/* Custom scrollbar for search results */
#search-results::-webkit-scrollbar {
    width: 6px;
}

#search-results::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#search-results::-webkit-scrollbar-thumb {
    background: #dc2626;
    border-radius: 3px;
}

#search-results::-webkit-scrollbar-thumb:hover {
    background: #b91c1c;
}

/* Enhanced card shadows on hover */
.news-article:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

/* Gradient text effect for main titles */
.gradient-text {
    background: linear-gradient(135deg, #dc2626, #ea580c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>

<?php get_footer(); ?>
