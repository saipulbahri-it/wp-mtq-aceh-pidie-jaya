<?php
/**
 * Template Name: Berita
 * Description: Menampilkan daftar berita dan detail berita.
 * @package MTQ_Aceh_Pidie_Jaya
 */
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
<?php get_footer(); ?>
