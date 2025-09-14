<?php
/**
 * Template untuk archive gallery (daftar semua gallery)
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<main class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50">
    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-r from-blue-600 via-blue-700 to-purple-700 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #ffffff 2px, transparent 2px), radial-gradient(circle at 75% 75%, #ffffff 2px, transparent 2px); background-size: 50px 50px;"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm text-white rounded-full text-sm font-medium mb-6">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                </svg>
                Gallery MTQ
            </div>
            
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Dokumentasi 
                <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                    Visual
                </span>
            </h1>
            
            <p class="text-xl text-blue-100 max-w-3xl mx-auto mb-8 leading-relaxed">
                Koleksi lengkap foto dan video dokumentasi kegiatan Musabaqah Tilawatil Quran (MTQ) 
                Aceh XXXVII di Kabupaten Pidie Jaya
            </p>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-2xl mx-auto">
                <?php
                global $wp_query;
                $total_galleries = wp_count_posts('mtq_gallery')->publish;
                
                // Get total images and videos count quickly
                $all_galleries = get_posts(array(
                    'post_type' => 'mtq_gallery',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'fields' => 'ids'
                ));
                
                $total_images = 0;
                $total_videos = 0;
                
                foreach ($all_galleries as $gallery_id) {
                    $images = get_post_meta($gallery_id, '_mtq_gallery_images', true);
                    $videos = get_post_meta($gallery_id, '_mtq_gallery_videos', true);
                    
                    if (!empty($images)) $total_images += count($images);
                    if (!empty($videos)) $total_videos += count($videos);
                }
                ?>
                
                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-bold text-white mb-2"><?php echo $total_galleries; ?></div>
                    <div class="text-blue-200 text-sm">Total Gallery</div>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-bold text-white mb-2"><?php echo $total_images; ?></div>
                    <div class="text-blue-200 text-sm">Foto</div>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-bold text-white mb-2"><?php echo $total_videos; ?></div>
                    <div class="text-blue-200 text-sm">Video</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <!-- Enhanced Filter Section -->
    <div class="mb-12">
        <!-- Enhanced Filter Bar -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                
                <!-- Categories Filter -->
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Filter Kategori</label>
                    <div class="flex flex-wrap gap-2">
                        <?php
                        $current_term = get_queried_object();
                        $categories = get_terms(array(
                            'taxonomy' => 'mtq_gallery_category',
                            'hide_empty' => true,
                        ));
                        ?>
                        
                        <button class="filter-btn inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 <?php echo !is_tax() ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>" 
                                data-filter="all">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Semua
                        </button>
                        
                        <?php if ($categories && !is_wp_error($categories)) : ?>
                            <?php foreach ($categories as $category) : ?>
                                <?php $is_current = is_tax('mtq_gallery_category', $category->slug); ?>
                                <a href="<?php echo get_term_link($category); ?>" 
                                   class="filter-btn inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 <?php echo $is_current ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-blue-50 hover:text-blue-700'; ?>"
                                   data-filter="<?php echo esc_attr($category->slug); ?>">
                                    <span class="w-2 h-2 bg-current rounded-full mr-2 opacity-60"></span>
                                    <?php echo esc_html($category->name); ?>
                                    <span class="ml-2 bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full">
                                        <?php echo $category->count; ?>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Sort Options only -->
                <div class="flex items-center">
                    <select class="sort-select px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="date-desc">Terbaru</option>
                        <option value="date-asc">Terlama</option>
                        <option value="title-asc">A-Z</option>
                        <option value="title-desc">Z-A</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Current Filter Display -->
        <div class="current-filter-display hidden bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-blue-800">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="filter-text font-medium"></span>
                </div>
                <button class="clear-filter text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Hapus Filter
                </button>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-4">
        
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
            <?php endif; ?>
        </div>
        <!-- Gallery Grid -->
        <div class="mtq-gallery-container">
            <?php if (have_posts()) : ?>
            
            <!-- Enhanced Gallery Grid -->
            <div class="gallery-grid-container" id="gallery-container">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8" id="gallery-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    $images = get_post_meta(get_the_ID(), '_mtq_gallery_images', true);
                    $videos = get_post_meta(get_the_ID(), '_mtq_gallery_videos', true);
                    $image_count = !empty($images) ? count($images) : 0;
                    $video_count = !empty($videos) ? count($videos) : 0;
                    
                    // Get featured image or first gallery image
                    $thumbnail = '';
                    if (has_post_thumbnail()) {
                        $thumbnail = get_the_post_thumbnail(
                            get_the_ID(),
                            'large',
                            array(
                                'class' => 'w-full aspect-video object-cover rounded-t-3xl',
                                'loading' => 'lazy',
                                'decoding' => 'async'
                            )
                        );
                    } elseif (!empty($images)) {
                        $thumbnail = wp_get_attachment_image(
                            $images[0],
                            'large',
                            false,
                            array(
                                'class' => 'w-full aspect-video object-cover rounded-t-3xl',
                                'loading' => 'lazy',
                                'decoding' => 'async'
                            )
                        );
                    }
                    
                    // Get categories
                    $categories = get_the_terms(get_the_ID(), 'mtq_gallery_category');
                    ?>
                    
                    <article class="gallery-item group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-blue-200 transform hover:-translate-y-2" 
                             data-category="<?php echo $categories ? esc_attr($categories[0]->slug) : 'uncategorized'; ?>"
                             data-title="<?php echo esc_attr(get_the_title()); ?>"
                             data-date="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
                        
                        <!-- Enhanced Thumbnail -->
                        <div class="relative overflow-hidden rounded-t-3xl">
                            <?php if ($thumbnail) : ?>
                                <?php
                                // Get high resolution image for modal
                                $full_image_id = get_post_thumbnail_id();
                                if (!$full_image_id && !empty($images)) {
                                    $full_image_id = $images[0];
                                }
                                $full_image_url = $full_image_id ? wp_get_attachment_url($full_image_id) : '';
                                ?>
                                
                                <div class="block relative group cursor-pointer gallery-thumbnail" 
                                     data-image-src="<?php echo esc_url($full_image_url); ?>"
                                     data-image-title="<?php echo esc_attr(get_the_title()); ?>">
                                    <?php echo $thumbnail; ?>
                                    
                                    <!-- Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                                    
                                    <!-- Hover Icon -->
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-75 group-hover:scale-100">
                                        <div class="bg-white/20 backdrop-blur-sm rounded-full p-4">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <!-- View Gallery Link -->
                                    <div class="absolute bottom-4 right-4">
                                        <a href="<?php the_permalink(); ?>" 
                                           class="inline-flex items-center px-3 py-2 bg-blue-600/90 backdrop-blur-sm text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-all duration-300 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0"
                                           onclick="event.stopPropagation();">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="w-full h-72 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-sm text-gray-500">No Image</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Enhanced Media Count Badge -->
                            <?php if ($image_count > 0 || $video_count > 0) : ?>
                            <div class="absolute top-4 right-4">
                                <div class="flex space-x-2">
                                    <?php if ($image_count > 0) : ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500 text-white shadow-lg">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <?php echo $image_count; ?>
                                    </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($video_count > 0) : ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-500 text-white shadow-lg">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                        </svg>
                                        <?php echo $video_count; ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Category Badge -->
                            <?php if ($categories) : ?>
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/90 backdrop-blur-sm text-gray-800 shadow-lg">
                                    <?php echo esc_html($categories[0]->name); ?>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Enhanced Content -->
                        <div class="p-6">
                            <!-- Title -->
                            <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-300">
                                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <!-- Excerpt -->
                            <?php if (get_the_excerpt()) : ?>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3 leading-relaxed">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                            <?php endif; ?>
                            
                            <!-- Meta Info -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo get_the_date('d M Y'); ?>
                                    </time>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-all duration-300 group-hover:shadow-lg">
                                    Lihat
                                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                    
                <?php endwhile; ?>
            </div>
        </div>
        
        <!-- Enhanced Pagination -->
        <?php
        $pagination_args = array(
            'mid_size' => 2,
            'prev_text' => '<span class="sr-only">Previous</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
            'next_text' => '<span class="sr-only">Next</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
            'type' => 'array'
        );
        $pagination = paginate_links($pagination_args);
        ?>
        
        <?php if ($pagination) : ?>
        <nav class="flex justify-center mt-16 mb-8" aria-label="Gallery pagination">
            <div class="flex items-center space-x-2 bg-white rounded-xl shadow-lg p-2 border border-gray-100">
                <?php foreach ($pagination as $page) : ?>
                    <div class="pagination-item">
                        <?php 
                        $page = str_replace(
                            array('page-numbers', 'current', 'prev', 'next', 'dots'),
                            array(
                                'flex items-center justify-center min-w-[44px] h-11 px-3 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:text-blue-600 hover:border-blue-300 transition-all duration-200',
                                'flex items-center justify-center min-w-[44px] h-11 px-3 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg shadow-sm',
                                'flex items-center justify-center min-w-[44px] h-11 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-all duration-200',
                                'flex items-center justify-center min-w-[44px] h-11 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-all duration-200',
                                'flex items-center justify-center min-w-[44px] h-11 px-3 text-gray-400'
                            ),
                            $page
                        );
                        echo $page;
                        ?>
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
            
            <?php if (is_tax()) : ?>
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

<!-- Inline modal removed; using global mtq-lightbox from gallery.js -->

<script>
// Enhance View toggle and Sort behavior for gallery archive
(function() {
    function ready(fn){ if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',fn);} else { fn(); } }

    ready(function() {
        const grid = document.getElementById('gallery-grid');
        if (!grid) return;

        const sortSelect = document.querySelector('.sort-select');

        function sortItems(mode) {
            const items = Array.from(grid.querySelectorAll('article.gallery-item'));
            const getDate = el => new Date(el.getAttribute('data-date') || '1970-01-01');
            const getTitle = el => (el.getAttribute('data-title') || '').toLowerCase();

            items.sort((a,b)=>{
                switch (mode) {
                    case 'date-asc': return getDate(a) - getDate(b);
                    case 'title-asc': return getTitle(a).localeCompare(getTitle(b));
                    case 'title-desc': return getTitle(b).localeCompare(getTitle(a));
                    case 'date-desc':
                    default: return getDate(b) - getDate(a);
                }
            });

            // Re-append in sorted order
            const frag = document.createDocumentFragment();
            items.forEach(el => frag.appendChild(el));
            grid.appendChild(frag);
        }


        // Bind events
        if (sortSelect) {
            sortSelect.addEventListener('change', () => sortItems(sortSelect.value));
            // Initial sort to reflect default selection
            sortItems(sortSelect.value);
        }

        // No view toggle, grid remains as designed
    });
})();
</script>

<?php get_footer(); ?>
