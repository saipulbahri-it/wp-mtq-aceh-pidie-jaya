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
    <!-- Hero Section -->
    <section class="pt-28 pb-16 bg-gradient-to-br from-blue-50 via-white to-slate-50 section-animate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="fade-in-delay">
                <h1 class="text-4xl md:text-6xl font-bold text-slate-800 mb-6">
                    Berita Terbaru
                </h1>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto mb-8">
                    Informasi, update, dan kabar terbaru seputar MTQ Aceh XXXVII di Kabupaten Pidie Jaya.
                </p>
            </div>
        </div>
    </section>

    <!-- Headlines Slider Section -->
    <section class="py-8 bg-white border-b border-gray-100 section-animate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 fade-in">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">
                    Berita Utama
                </h2>
                <p class="text-gray-600">
                    Sorotan berita terkini dan terpenting seputar MTQ Aceh XXXVII
                </p>
            </div>
            
            <!-- Slider Container -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-gray-900 to-gray-800 shadow-2xl fade-in-delay">
                <div class="headlines-slider relative">
                    <div class="headlines-track flex transition-transform duration-500 ease-in-out">
                        <?php
                        // Get featured/recent posts for the slider
                        $headline_query = new WP_Query([
                            'post_type' => 'post',
                            'posts_per_page' => 5,
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
                        
                        if ($headline_query->have_posts()) :
                            $slide_index = 0;
                            while ($headline_query->have_posts()) : $headline_query->the_post();
                                $slide_index++;
                        ?>
                            <div class="headlines-slide min-w-full relative">
                                <div class="grid lg:grid-cols-2 gap-8 items-center p-8 lg:p-12">
                                    <!-- Content Side -->
                                    <div class="order-2 lg:order-1 space-y-6">
                                        <!-- Category Badge -->
                                        <?php 
                                        $categories = get_the_category();
                                        if (!empty($categories)) :
                                        ?>
                                        <div class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-full">
                                            <i class="fas fa-newspaper mr-2"></i>
                                            <?php echo esc_html($categories[0]->name); ?>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <!-- Title -->
                                        <h3 class="text-2xl lg:text-4xl font-bold text-white leading-tight">
                                            <a href="<?php the_permalink(); ?>" class="hover:text-orange-300 transition-colors duration-200">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        
                                        <!-- Excerpt -->
                                        <p class="text-gray-300 text-lg leading-relaxed">
                                            <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
                                        </p>
                                        
                                        <!-- Meta Info -->
                                        <div class="flex items-center gap-6 text-gray-400 text-sm">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-calendar text-orange-400"></i>
                                                <time datetime="<?php echo get_the_date('c'); ?>">
                                                    <?php echo get_the_date('d M Y'); ?>
                                                </time>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-user text-orange-400"></i>
                                                <span><?php the_author(); ?></span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-eye text-orange-400"></i>
                                                <span><?php echo get_post_meta(get_the_ID(), 'post_views_count', true) ?: '0'; ?></span>
                                            </div>
                                        </div>
                                        
                                        <!-- Read More Button -->
                                        <div class="pt-4">
                                            <a href="<?php the_permalink(); ?>" 
                                               class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 text-white font-semibold rounded-xl hover:from-red-700 hover:to-orange-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                                Baca Selengkapnya
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Image Side -->
                                    <div class="order-1 lg:order-2 relative">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="relative overflow-hidden rounded-xl shadow-2xl">
                                                <?php the_post_thumbnail('large', [
                                                    'class' => 'w-full h-64 lg:h-80 object-cover transition-transform duration-700 hover:scale-105',
                                                    'loading' => 'lazy'
                                                ]); ?>
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                            </div>
                                        <?php else : ?>
                                            <div class="w-full h-64 lg:h-80 bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-newspaper text-gray-500 text-6xl"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            endwhile;
                        else :
                        ?>
                            <div class="headlines-slide min-w-full relative">
                                <div class="text-center py-16 text-white">
                                    <i class="fas fa-newspaper text-6xl text-gray-600 mb-4"></i>
                                    <h3 class="text-2xl font-bold mb-2">Belum Ada Berita Utama</h3>
                                    <p class="text-gray-400">Berita utama akan segera ditambahkan</p>
                                </div>
                            </div>
                        <?php endif; wp_reset_postdata(); ?>
                    </div>
                </div>
                
                <!-- Navigation Arrows -->
                <?php if ($headline_query->have_posts() && $headline_query->found_posts > 1) : ?>
                <button class="headlines-prev absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/50 hover:bg-black/70 text-white rounded-full flex items-center justify-center transition-all duration-200 hover:scale-110 z-10">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="headlines-next absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/50 hover:bg-black/70 text-white rounded-full flex items-center justify-center transition-all duration-200 hover:scale-110 z-10">
                    <i class="fas fa-chevron-right"></i>
                </button>
                
                <!-- Dots Indicator -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <?php for ($i = 0; $i < $headline_query->found_posts; $i++) : ?>
                    <button class="headlines-dot w-3 h-3 rounded-full bg-white/30 hover:bg-white/70 transition-all duration-200 <?php echo $i === 0 ? 'bg-white' : ''; ?>" data-slide="<?php echo $i; ?>"></button>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Daftar Berita Section -->
    <section class="py-16 bg-slate-50 section-animate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">
                    Semua Berita
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Temukan berita terbaru, pengumuman, dan dokumentasi kegiatan MTQ Aceh XXXVII.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 fade-in-delay-2">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $berita_query = new WP_Query([
                    'post_type' => 'post',
                    'posts_per_page' => 9,
                    'paged' => $paged,
                ]);
                if ($berita_query->have_posts()) :
                    while ($berita_query->have_posts()) : $berita_query->the_post();
                ?>
                <article class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 overflow-hidden transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">
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
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 backdrop-blur-sm">
                                    <?php echo esc_html($categories[0]->name); ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <!-- Date and Author -->
                        <div class="flex items-center gap-4 text-sm text-slate-500 mb-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
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
                               class="hover:text-blue-600 transition-colors duration-200"
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
                               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm transition-colors duration-200 group-hover:gap-3"
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
            </div>
            <!-- Pagination -->
            <?php if ($berita_query->max_num_pages > 1) : ?>
            <div class="mt-16 fade-in-delay-3">
                <nav aria-label="Navigasi Halaman Berita" role="navigation">
                    <div class="max-w-lg mx-auto px-0 sm:px-1">
                        <div>
                            <div class="flex items-center justify-center gap-1 sm:gap-2 flex-wrap">
                                
                                <!-- Previous Button -->
                                <?php if ($paged > 1) : ?>
                                <a href="<?php echo get_pagenum_link($paged - 1); ?>" 
                                   class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 sm:py-2.5 text-xs sm:text-sm font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded-lg sm:rounded-xl hover:bg-blue-500 hover:text-white hover:border-blue-500 hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                   aria-label="Halaman sebelumnya">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Sebelumnya</span>
                                </a>
                                <?php endif; ?>
                                
                                <!-- Page Numbers -->
                                <?php
                                $start_page = max(1, $paged - 2);
                                $end_page = min($berita_query->max_num_pages, $paged + 2);
                                
                                // Show first page if we're not near the beginning
                                if ($start_page > 1) {
                                    echo '<a href="' . get_pagenum_link(1) . '" class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-xs sm:text-sm font-medium text-slate-600 bg-slate-50 border border-slate-200 rounded-lg sm:rounded-xl hover:bg-blue-500 hover:text-white hover:border-blue-500 hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">1</a>';
                                    if ($start_page > 2) {
                                        echo '<span class="flex items-center px-1 sm:px-2 text-slate-400 font-medium text-xs sm:text-sm">...</span>';
                                    }
                                }
                                
                                // Show page numbers around current page
                                for ($i = $start_page; $i <= $end_page; $i++) {
                                    if ($i == $paged) {
                                        echo '<span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-500 rounded-lg sm:rounded-xl shadow-md animate-pulse" aria-current="page">' . $i . '</span>';
                                    } else {
                                        echo '<a href="' . get_pagenum_link($i) . '" class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-xs sm:text-sm font-medium text-slate-600 bg-slate-50 border border-slate-200 rounded-lg sm:rounded-xl hover:bg-blue-500 hover:text-white hover:border-blue-500 hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">' . $i . '</a>';
                                    }
                                }
                                
                                // Show last page if we're not near the end
                                if ($end_page < $berita_query->max_num_pages) {
                                    if ($end_page < $berita_query->max_num_pages - 1) {
                                        echo '<span class="flex items-center px-1 sm:px-2 text-slate-400 font-medium text-xs sm:text-sm">...</span>';
                                    }
                                    echo '<a href="' . get_pagenum_link($berita_query->max_num_pages) . '" class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-xs sm:text-sm font-medium text-slate-600 bg-slate-50 border border-slate-200 rounded-lg sm:rounded-xl hover:bg-blue-500 hover:text-white hover:border-blue-500 hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">' . $berita_query->max_num_pages . '</a>';
                                }
                                ?>
                                
                                <!-- Next Button -->
                                <?php if ($paged < $berita_query->max_num_pages) : ?>
                                <a href="<?php echo get_pagenum_link($paged + 1); ?>" 
                                   class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 sm:py-2.5 text-xs sm:text-sm font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded-lg sm:rounded-xl hover:bg-blue-500 hover:text-white hover:border-blue-500 hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                   aria-label="Halaman berikutnya">
                                    <span class="hidden sm:inline">Berikutnya</span>
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                <?php endif; ?>
                                
                            </div>
                            
                            <!-- Pagination Info -->
                            <div class="mt-4 sm:mt-5 pt-4 sm:pt-5 border-t border-slate-100 text-center text-xs sm:text-sm text-slate-500 space-x-1">
                                <span class="block sm:inline">Halaman <span class="font-semibold text-slate-700"><?php echo $paged; ?></span> dari <span class="font-semibold text-slate-700"><?php echo $berita_query->max_num_pages; ?></span></span>
                                <span class="hidden sm:inline text-slate-300">•</span>
                                <span class="block sm:inline mt-1 sm:mt-0"><span class="font-semibold text-slate-700"><?php echo $berita_query->found_posts; ?></span> artikel total</span>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <?php endif; ?>
            <?php else : ?>
                <div class="text-center py-16 fade-in">
                    <div class="max-w-md mx-auto">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum Ada Berita</h3>
                        <p class="text-slate-500">Berita akan segera ditambahkan. Silakan kembali lagi nanti.</p>
                    </div>
                </div>
            <?php endif; wp_reset_postdata(); ?>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.headlines-slider');
    const track = document.querySelector('.headlines-track');
    const slides = document.querySelectorAll('.headlines-slide');
    const prevBtn = document.querySelector('.headlines-prev');
    const nextBtn = document.querySelector('.headlines-next');
    const dots = document.querySelectorAll('.headlines-dot');
    
    if (!track || slides.length === 0) return;
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    
    // Auto-play settings
    let autoPlayInterval;
    const autoPlayDelay = 5000; // 5 seconds
    
    function updateSlider() {
        const translateX = -currentSlide * 100;
        track.style.transform = `translateX(${translateX}%)`;
        
        // Update dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('bg-white', index === currentSlide);
            dot.classList.toggle('bg-white/30', index !== currentSlide);
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
    
    function goToSlide(index) {
        currentSlide = index;
        updateSlider();
    }
    
    // Auto-play functionality
    function startAutoPlay() {
        if (totalSlides > 1) {
            autoPlayInterval = setInterval(nextSlide, autoPlayDelay);
        }
    }
    
    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }
    
    // Event listeners
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            stopAutoPlay();
            startAutoPlay(); // Restart auto-play
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            stopAutoPlay();
            startAutoPlay(); // Restart auto-play
        });
    }
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToSlide(index);
            stopAutoPlay();
            startAutoPlay(); // Restart auto-play
        });
    });
    
    // Pause auto-play on hover
    slider.addEventListener('mouseenter', stopAutoPlay);
    slider.addEventListener('mouseleave', startAutoPlay);
    
    // Touch/swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoPlay();
    });
    
    slider.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        const swipeThreshold = 50;
        
        if (touchStartX - touchEndX > swipeThreshold) {
            nextSlide(); // Swipe left - next slide
        } else if (touchEndX - touchStartX > swipeThreshold) {
            prevSlide(); // Swipe right - previous slide
        }
        
        startAutoPlay(); // Restart auto-play
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            prevSlide();
            stopAutoPlay();
            startAutoPlay();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
            stopAutoPlay();
            startAutoPlay();
        }
    });
    
    // Initialize
    updateSlider();
    startAutoPlay();
    
    // Intersection Observer for animations
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
});
</script>

<style>
/* Custom animations for the headline slider */
.headlines-slider {
    position: relative;
}

.headlines-track {
    will-change: transform;
}

.headlines-slide {
    opacity: 1;
    transition: opacity 0.5s ease-in-out;
}

/* Fade in animations */
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

.animate-fade-in {
    animation: fadeIn 0.8s ease-out forwards;
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

/* Hover effects for slider navigation */
.headlines-prev:hover,
.headlines-next:hover {
    transform: translateY(-50%) scale(1.1);
}

.headlines-dot:hover {
    transform: scale(1.2);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .headlines-prev,
    .headlines-next {
        width: 40px;
        height: 40px;
    }
    
    .headlines-dot {
        width: 8px;
        height: 8px;
    }
}

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
</style>

<?php get_footer(); ?>
