<?php
/**
 * Template untuk archive gallery (daftar semua gallery)
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

get_header(); ?>

<main class="container mx-auto px-4 py-8">
    
    <!-- Page Header -->
    <header class="text-center mb-12">
        <h1 class="text-4xl font-bold text-slate-800 mb-4">Gallery MTQ Aceh Pidie Jaya</h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">
            Koleksi foto dan video dokumentasi kegiatan Musabaqah Tilawatil Quran (MTQ) 
            di Kabupaten Aceh Pidie Jaya
        </p>
    </header>
    
    <!-- Filter dan Search -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            
            <!-- Categories Filter -->
            <div class="flex flex-wrap gap-2">
                <?php
                $current_term = get_queried_object();
                $categories = get_terms(array(
                    'taxonomy' => 'mtq_gallery_category',
                    'hide_empty' => true,
                ));
                ?>
                
                <a href="<?php echo get_post_type_archive_link('mtq_gallery'); ?>" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?php echo !is_tax() ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'; ?>">
                    Semua
                </a>
                
                <?php if (!empty($categories)) : ?>
                    <?php foreach ($categories as $category) : ?>
                        <?php 
                        $is_current = is_tax('mtq_gallery_category') && $current_term->term_id === $category->term_id;
                        $class = $is_current ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200';
                        ?>
                        <a href="<?php echo get_term_link($category); ?>" 
                           class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?php echo $class; ?>">
                            <?php echo esc_html($category->name); ?>
                            <span class="ml-1 text-xs opacity-75">(<?php echo $category->count; ?>)</span>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Search Form -->
            <div class="relative">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex">
                    <input type="hidden" name="post_type" value="mtq_gallery">
                    <input type="search" 
                           name="s" 
                           placeholder="Cari gallery..." 
                           value="<?php echo get_search_query(); ?>"
                           class="px-4 py-2 border border-slate-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Results Info -->
    <div class="mb-6">
        <?php if (is_tax()) : ?>
            <?php $term = get_queried_object(); ?>
            <p class="text-slate-600">
                Menampilkan gallery dalam kategori: <strong><?php echo esc_html($term->name); ?></strong>
                <?php if ($term->description) : ?>
                    <span class="block text-sm mt-1"><?php echo esc_html($term->description); ?></span>
                <?php endif; ?>
            </p>
        <?php elseif (is_search()) : ?>
            <p class="text-slate-600">
                Hasil pencarian untuk: <strong>"<?php echo get_search_query(); ?>"</strong>
            </p>
        <?php endif; ?>
    </div>
    
    <!-- Gallery Grid -->
    <?php if (have_posts()) : ?>
        
        <!-- Stats -->
        <div class="mb-8 p-4 bg-slate-50 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                <?php
                global $wp_query;
                $total_galleries = $wp_query->found_posts;
                
                // Get total images and videos count
                $all_galleries = get_posts(array(
                    'post_type' => 'mtq_gallery',
                    'posts_per_page' => -1,
                    'post_status' => 'publish'
                ));
                
                $total_images = 0;
                $total_videos = 0;
                
                foreach ($all_galleries as $gallery) {
                    $images = get_post_meta($gallery->ID, '_mtq_gallery_images', true);
                    $videos = get_post_meta($gallery->ID, '_mtq_gallery_videos', true);
                    
                    if (!empty($images)) $total_images += count($images);
                    if (!empty($videos)) $total_videos += count($videos);
                }
                ?>
                
                <div>
                    <div class="text-2xl font-bold text-blue-600"><?php echo $total_galleries; ?></div>
                    <div class="text-sm text-slate-600">Total Gallery</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600"><?php echo $total_images; ?></div>
                    <div class="text-sm text-slate-600">Total Foto</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-purple-600"><?php echo $total_videos; ?></div>
                    <div class="text-sm text-slate-600">Total Video</div>
                </div>
            </div>
        </div>
        
        <!-- Gallery Items -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <?php while (have_posts()) : the_post(); ?>
                <?php
                $images = get_post_meta(get_the_ID(), '_mtq_gallery_images', true);
                $videos = get_post_meta(get_the_ID(), '_mtq_gallery_videos', true);
                $image_count = !empty($images) ? count($images) : 0;
                $video_count = !empty($videos) ? count($videos) : 0;
                
                // Get featured image or first gallery image
                $thumbnail = '';
                if (has_post_thumbnail()) {
                    $thumbnail = get_the_post_thumbnail(get_the_ID(), 'large', array('class' => 'w-full h-64 object-cover'));
                } elseif (!empty($images)) {
                    $thumbnail = wp_get_attachment_image($images[0], 'large', false, array('class' => 'w-full h-64 object-cover'));
                }
                
                // Get categories
                $categories = get_the_terms(get_the_ID(), 'mtq_gallery_category');
                ?>
                
                <article class="mtq-gallery-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    
                    <!-- Thumbnail -->
                    <div class="relative overflow-hidden">
                        <?php if ($thumbnail) : ?>
                            <a href="<?php the_permalink(); ?>" class="block">
                                <?php echo $thumbnail; ?>
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                            </a>
                        <?php else : ?>
                            <div class="w-full h-64 bg-slate-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Media Count Badge -->
                        <?php if ($image_count > 0 || $video_count > 0) : ?>
                        <div class="absolute top-3 right-3">
                            <div class="flex space-x-1">
                                <?php if ($image_count > 0) : ?>
                                <span class="bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded-full flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <?php echo $image_count; ?>
                                </span>
                                <?php endif; ?>
                                
                                <?php if ($video_count > 0) : ?>
                                <span class="bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded-full flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                    </svg>
                                    <?php echo $video_count; ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6">
                        <!-- Categories -->
                        <?php if ($categories) : ?>
                        <div class="mb-3">
                            <?php foreach ($categories as $category) : ?>
                                <a href="<?php echo get_term_link($category); ?>" 
                                   class="inline-block text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full mr-2 hover:bg-blue-200 transition-colors">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Title -->
                        <h2 class="text-xl font-semibold text-slate-800 mb-3 group-hover:text-blue-600 transition-colors">
                            <a href="<?php the_permalink(); ?>" class="block">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        
                        <!-- Excerpt -->
                        <?php if (get_the_excerpt()) : ?>
                        <p class="text-slate-600 text-sm mb-4 line-clamp-3">
                            <?php echo get_the_excerpt(); ?>
                        </p>
                        <?php endif; ?>
                        
                        <!-- Meta -->
                        <div class="flex items-center justify-between text-xs text-slate-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <?php echo get_the_date('d M Y'); ?>
                            </span>
                            
                            <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                Lihat Gallery →
                            </a>
                        </div>
                    </div>
                </article>
                
            <?php endwhile; ?>
        </div>
        
        <!-- Pagination -->
        <?php
        $pagination = paginate_links(array(
            'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
            'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
            'type' => 'array'
        ));
        ?>
        
        <?php if ($pagination) : ?>
        <nav class="flex justify-center">
            <div class="flex space-x-1">
                <?php foreach ($pagination as $page) : ?>
                    <div class="pagination-item">
                        <?php echo str_replace(array('page-numbers', 'current'), array('px-3 py-2 text-sm border rounded transition-colors', 'bg-blue-600 text-white border-blue-600'), $page); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </nav>
        <?php endif; ?>
        
    <?php else : ?>
        
        <!-- No Results -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 text-slate-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.291-1.002-5.824-2.651M15 17H9m6 0a3 3 0 01-3 3H9a3 3 0 01-3-3m6 0a3 3 0 003-3V9a3 3 0 00-3-3H9a3 3 0 00-3 3v5a3 3 0 003 3m6 0a3 3 0 003-3V9a3 3 0 00-3-3"></path>
            </svg>
            
            <?php if (is_search()) : ?>
                <h2 class="text-2xl font-bold text-slate-800 mb-4">Tidak Ada Hasil</h2>
                <p class="text-slate-600 mb-8">
                    Tidak ditemukan gallery untuk pencarian "<strong><?php echo get_search_query(); ?></strong>".
                    <br>Coba kata kunci yang berbeda atau jelajahi semua gallery.
                </p>
            <?php elseif (is_tax()) : ?>
                <?php $term = get_queried_object(); ?>
                <h2 class="text-2xl font-bold text-slate-800 mb-4">Belum Ada Gallery</h2>
                <p class="text-slate-600 mb-8">
                    Belum ada gallery dalam kategori "<strong><?php echo esc_html($term->name); ?></strong>".
                    <br>Silakan cek kategori lain atau kembali ke halaman utama.
                </p>
            <?php else : ?>
                <h2 class="text-2xl font-bold text-slate-800 mb-4">Belum Ada Gallery</h2>
                <p class="text-slate-600 mb-8">
                    Gallery sedang dalam proses pembuatan.
                    <br>Silakan kembali lagi nanti untuk melihat dokumentasi kegiatan MTQ.
                </p>
            <?php endif; ?>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="<?php echo get_post_type_archive_link('mtq_gallery'); ?>" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Semua Gallery
                </a>
                
                <a href="<?php echo home_url(); ?>" 
                   class="inline-flex items-center px-6 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m0 0h5m0 0h3a1 1 0 001-1V10M9 21h6"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
        
    <?php endif; ?>
    
</main>

<style>
/* Custom styles for pagination */
.pagination-item a,
.pagination-item span {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.pagination-item a {
    color: #475569;
    border-color: #cbd5e1;
}

.pagination-item a:hover {
    background-color: #f8fafc;
}

.pagination-item .current {
    background-color: #2563eb;
    color: white;
    border-color: #2563eb;
}

/* Line clamp utility */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<?php get_footer(); ?>
