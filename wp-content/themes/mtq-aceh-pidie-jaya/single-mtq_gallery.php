<?php
/**
 * Template untuk menampilkan single gallery
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<main class="container mx-auto px-4 py-8">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('mtq-single-gallery'); ?>>
                
                <!-- Gallery Header -->
                <header class="mtq-gallery-header mb-8">
                    <div class="text-center">
                        <!-- Breadcrumb -->
                        <nav class="text-sm text-slate-500 mb-4">
                            <a href="<?php echo home_url(); ?>" class="hover:text-blue-600">Beranda</a>
                            <span class="mx-2">/</span>
                            <a href="<?php echo get_post_type_archive_link('mtq_gallery'); ?>" class="hover:text-blue-600">Gallery</a>
                            <span class="mx-2">/</span>
                            <span class="text-slate-700"><?php the_title(); ?></span>
                        </nav>
                        
                        <!-- Title -->
                        <h1 class="text-4xl font-bold text-slate-800 mb-4"><?php the_title(); ?></h1>
                        
                        <!-- Meta Information -->
                        <div class="flex items-center justify-center space-x-6 text-slate-600 mb-6">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <?php echo get_the_date('d F Y'); ?>
                            </span>
                            
                            <?php 
                            $images = get_post_meta(get_the_ID(), '_mtq_gallery_images', true);
                            $videos = get_post_meta(get_the_ID(), '_mtq_gallery_videos', true);
                            $image_count = !empty($images) ? count($images) : 0;
                            $video_count = !empty($videos) ? count($videos) : 0;
                            ?>
                            
                            <?php if ($image_count > 0) : ?>
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                                <?php echo $image_count; ?> Foto
                            </span>
                            <?php endif; ?>
                            
                            <?php if ($video_count > 0) : ?>
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                </svg>
                                <?php echo $video_count; ?> Video
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Categories and Tags -->
                        <?php 
                        $categories = get_the_terms(get_the_ID(), 'mtq_gallery_category');
                        $tags = get_the_terms(get_the_ID(), 'mtq_gallery_tag');
                        ?>
                        
                        <?php if ($categories || $tags) : ?>
                        <div class="flex flex-wrap items-center justify-center gap-2 mb-6">
                            <?php if ($categories) : ?>
                                <?php foreach ($categories as $category) : ?>
                                    <a href="<?php echo get_term_link($category); ?>" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                        </svg>
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <?php if ($tags) : ?>
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo get_term_link($tag); ?>" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 hover:bg-green-200 transition-colors">
                                        #<?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Description -->
                        <?php if (get_the_excerpt()) : ?>
                        <div class="max-w-2xl mx-auto">
                            <p class="text-lg text-slate-600 leading-relaxed"><?php echo get_the_excerpt(); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </header>
                
                <!-- Gallery Content -->
                <div class="mtq-gallery-content">
                    <?php
                    // Use the shortcode to display the gallery
                    echo do_shortcode('[mtq_gallery id="' . get_the_ID() . '"]');
                    ?>
                </div>
                
                <!-- Full Description -->
                <?php if (get_the_content()) : ?>
                <div class="mtq-gallery-description mt-12 max-w-4xl mx-auto">
                    <div class="prose prose-lg prose-slate max-w-none">
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Social Sharing -->
                <div class="mt-12">
                    <h3 class="text-xl font-semibold text-slate-800 mb-4 text-center">Bagikan Gallery Ini</h3>
                    <?php get_template_part('template-parts/social-sharing'); ?>
                </div>
                
                <!-- Navigation -->
                <div class="mt-12 pt-8 border-t border-slate-200">
                    <div class="flex justify-between items-center">
                        <?php
                        $prev_post = get_previous_post(false, '', 'mtq_gallery');
                        $next_post = get_next_post(false, '', 'mtq_gallery');
                        ?>
                        
                        <div class="w-1/3">
                            <?php if ($prev_post) : ?>
                            <a href="<?php echo get_permalink($prev_post->ID); ?>" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                <div>
                                    <div class="text-sm text-slate-500">Gallery Sebelumnya</div>
                                    <div class="font-medium"><?php echo esc_html($prev_post->post_title); ?></div>
                                </div>
                            </a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="w-1/3 text-center">
                            <a href="<?php echo get_post_type_archive_link('mtq_gallery'); ?>" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0l-4-4m4 4l-4 4"></path>
                                </svg>
                                Semua Gallery
                            </a>
                        </div>
                        
                        <div class="w-1/3 text-right">
                            <?php if ($next_post) : ?>
                            <a href="<?php echo get_permalink($next_post->ID); ?>" class="flex items-center justify-end text-blue-600 hover:text-blue-800 transition-colors">
                                <div class="text-right">
                                    <div class="text-sm text-slate-500">Gallery Selanjutnya</div>
                                    <div class="font-medium"><?php echo esc_html($next_post->post_title); ?></div>
                                </div>
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <div class="text-center py-16">
            <h1 class="text-2xl font-bold text-slate-800 mb-4">Gallery Tidak Ditemukan</h1>
            <p class="text-slate-600 mb-8">Maaf, gallery yang Anda cari tidak dapat ditemukan.</p>
            <a href="<?php echo get_post_type_archive_link('mtq_gallery'); ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Gallery
            </a>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
