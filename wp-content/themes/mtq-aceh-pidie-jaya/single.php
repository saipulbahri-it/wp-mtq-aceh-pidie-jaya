<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

get_header();
?>

<?php get_template_part('template-parts/breadcrumbs'); ?>

<main id="primary" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
    
    <!-- Hero Section with Featured Image -->
        <!-- Hero Section with Optimized Layout -->
    <section class="relative pt-24 pb-20 sm:pb-24 md:pb-32 bg-gradient-to-br from-blue-50 via-white to-slate-50 overflow-hidden">
        <?php if (has_post_thumbnail()) : ?>
        <!-- Background Image with Blur Effect -->
        <div class="absolute inset-0">
            <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover blur-sm']); ?>
            <!-- Subtle Dark Overlay for Better Text Contrast -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/20 to-black/40"></div>
        </div>
        <?php else : ?>
        <!-- Fallback Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-slate-800"></div>
        <?php endif; ?>
        
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center fade-in-delay">
                <!-- Breadcrumb -->
                <nav class="mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                        <li class="inline-flex items-center">
                            <a href="<?php echo home_url(); ?>" class="text-white/80 hover:text-blue-300 transition-colors flex">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-white/60" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="<?php echo home_url('/berita'); ?>" class="ml-1 text-white/80 hover:text-blue-300 transition-colors md:ml-2">Berita</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-white/60" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-white font-medium md:ml-2"><?php echo wp_trim_words(get_the_title(), 8, '...'); ?></span>
                            </div>
                        </li>
                    </ol>
                </nav>
                
                <!-- Category Badge -->
                <?php 
                $categories = get_the_category();
                if (!empty($categories)) :
                ?>
                <div class="mb-6">
                    <span class="inline-flex items-center px-6 py-3 rounded-full text-sm font-bold bg-white/95 text-slate-800 backdrop-blur-md">
                        <?php echo esc_html($categories[0]->name); ?>
                    </span>
                </div>
                <?php endif; ?>
                
                <!-- Title with Clean Background -->
                <div class="mb-8">
                    <div class="bg-black/30 backdrop-blur-md rounded-2xl px-8 py-6">
                        <h1 class="text-3xl md:text-5xl font-black text-white mb-4 leading-tight">
                            <?php the_title(); ?>
                        </h1>
                        <p class="text-lg md:text-xl text-white/95 leading-relaxed font-medium">
                            <?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 25, '...'); ?>
                        </p>
                    </div>
                </div>
                
                <!-- Meta Info with Clean Blur -->
                <div class="flex flex-wrap items-center justify-center gap-4 text-white">
                    <div class="flex items-center gap-2 bg-white/20 backdrop-blur-md rounded-xl px-4 py-3">
                        <svg class="w-5 h-5 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        <time datetime="<?php echo get_the_date('c'); ?>" class="font-semibold">
                            <?php echo get_the_date('d F Y'); ?>
                        </time>
                    </div>
                    <div class="flex items-center gap-2 bg-white/20 backdrop-blur-md rounded-xl px-4 py-3">
                        <svg class="w-5 h-5 text-white/80" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-semibold"><?php the_author(); ?></span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/20 backdrop-blur-md rounded-xl px-4 py-3">
                        <svg class="w-5 h-5 text-white/70" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0v-.5A1.5 1.5 0 0114.5 6c.526 0 .988-.27 1.256-.679a6.012 6.012 0 011.912 2.706A8.1 8.1 0 0118 10a8.1 8.1 0 01-.332 1.973 6.012 6.012 0 01-1.912 2.706c-.268.409-.73.679-1.256.679A1.5 1.5 0 0113 13.5V13a2 2 0 00-4 0v.5A1.5 1.5 0 017.5 15c-.526 0-.988.27-1.256.679a6.012 6.012 0 01-1.912-2.706A8.1 8.1 0 014 10c0-.691.108-1.355.332-1.973z" clip-rule="evenodd"></path>
                        </svg>
                        <span><?php echo do_shortcode('[reading_time]'); ?> menit baca</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content -->
    <article class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Featured Image -->
                    <div class="mb-12 fade-in">
                        <figure class="relative overflow-hidden rounded-2xl shadow-xl">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('full', ['class' => 'w-full h-auto object-cover']); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-thumbnail.svg" 
                                     alt="<?php echo esc_attr(get_the_title()); ?>"
                                     class="w-full h-64 object-cover bg-slate-100">
                            <?php endif; ?>
                            <?php if (get_the_post_thumbnail_caption()) : ?>
                            <figcaption class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                                <p class="text-white text-sm"><?php echo get_the_post_thumbnail_caption(); ?></p>
                            </figcaption>
                            <?php endif; ?>
                        </figure>
                    </div>
                    
                    <!-- Article Body -->
                    <div class="prose prose-lg prose-slate max-w-none fade-in-delay-2">
                <?php
                the_content(
                    sprintf(
                        wp_kses(
                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'mtq-aceh-pidie-jaya'),
                            array('span' => array('class' => array()))
                        ),
                        wp_kses_post(get_the_title())
                    )
                );
                
                wp_link_pages(array(
                    'before' => '<div class="page-links mt-8 p-6 bg-slate-50 rounded-xl">' . esc_html__('Pages:', 'mtq-aceh-pidie-jaya'),
                    'after'  => '</div>',
                ));
                ?>
            </div>
            
                    <!-- Tags -->
                    <?php 
                    $tags = get_the_tags();
                    if ($tags) :
                    ?>
                    <div class="mt-12 pt-8 border-t border-slate-200 fade-in-delay-3">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Tags:</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($tags as $tag) : ?>
                            <a href="<?php echo get_tag_link($tag->term_id); ?>" 
                               class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-600 bg-slate-100 rounded-full hover:bg-slate-200 transition-colors">
                                #<?php echo $tag->name; ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Social Sharing Buttons -->
                    <div class="mt-12 fade-in-delay-4">
                        <?php get_template_part('template-parts/social-sharing'); ?>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24">
                        <!-- Popular Posts -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 mb-8">
                            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                                <svg class="w-6 h-6 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Berita Populer
                            </h3>
                            
                            <?php
                            // Get popular posts based on comments count
                            $popular_posts = get_posts(array(
                                'numberposts' => 5,
                                'orderby' => 'comment_count',
                                'order' => 'DESC',
                                'post_status' => 'publish',
                                'post__not_in' => array(get_the_ID())
                            ));
                            
                            if ($popular_posts) :
                                foreach ($popular_posts as $index => $popular_post) :
                                    setup_postdata($popular_post);
                                    $thumbnail = get_the_post_thumbnail_url($popular_post->ID, 'thumbnail');
                                    // Default thumbnail jika tidak ada featured image
                                    if (!$thumbnail) {
                                        $thumbnail = get_template_directory_uri() . '/assets/images/default-thumbnail.svg';
                                    }
                            ?>
                            <article class="flex gap-4 mb-6 last:mb-0 group">
                                <div class="flex-1 min-w-0">
                                    <div class="mb-3 relative overflow-hidden rounded-lg">
                                        <img src="<?php echo esc_url($thumbnail); ?>" 
                                             alt="<?php echo esc_attr(get_the_title($popular_post->ID)); ?>"
                                             class="w-full h-20 object-cover bg-slate-100 transition-transform duration-300 group-hover:scale-105"
                                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQwIiBoZWlnaHQ9IjgwIiB2aWV3Qm94PSIwIDAgMjQwIDgwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8cmVjdCB3aWR0aD0iMjQwIiBoZWlnaHQ9IjgwIiBmaWxsPSIjRjFGNUY5Ii8+CjxwYXRoIGQ9Ik05NiA0MEgxNDRWNDRIOTZWNDBaTTEwNCA0NEgxMzZWNDhIMTA0VjQ0WiIgZmlsbD0iIzk0QTNCOCIvPgo8cGF0aCBkPSJNMTA4IDMyQzEwOCAzMC44OTU0IDEwOC44OTUgMzAgMTEwIDMwSDE0MkMxNDMuMTA1IDMwIDE0NCAzMC44OTU0IDE0NCAzMlYzNkMxNDQgMzcuMTA0NiAxNDMuMTA1IDM4IDE0MiAzOEgxMTBDMTA4Ljg5NSAzOCAxMDggMzcuMTA0NiAxMDggMzZWMzJaIiBmaWxsPSIjOTRBM0I4Ii8+Cjwvc3ZnPg=='">
                                        <!-- Premium Number Badge -->
                                        <div class="absolute top-2 left-2">
                                            <div class="relative">
                                                <!-- Background with gradient -->
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full shadow-xl border-2 border-white"></div>
                                                <!-- Number -->
                                                <span class="absolute inset-0 flex items-center justify-center text-white font-black text-xs tracking-tight">
                                                    <?php echo $index + 1; ?>
                                                </span>
                                                <!-- Shine effect -->
                                                <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-white/30 to-transparent opacity-60"></div>
                                            </div>
                                        </div>
                                        <!-- Hover overlay -->
                                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>
                                    <h4 class="font-semibold text-slate-800 group-hover:text-blue-600 transition-colors leading-tight mb-2">
                                        <a href="<?php echo get_permalink($popular_post->ID); ?>" class="hover:underline">
                                            <?php echo wp_trim_words(get_the_title($popular_post->ID), 8, '...'); ?>
                                        </a>
                                    </h4>
                                    <div class="flex items-center gap-3 text-xs text-slate-500">
                                        <time datetime="<?php echo get_the_date('c', $popular_post->ID); ?>">
                                            <?php echo get_the_date('d M Y', $popular_post->ID); ?>
                                        </time>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                                            </svg>
                                            <?php echo get_comments_number($popular_post->ID); ?>
                                        </span>
                                    </div>
                                </div>
                            </article>
                            <?php
                                endforeach;
                                wp_reset_postdata();
                            else :
                            ?>
                            <p class="text-slate-600 text-center py-8">Belum ada berita populer.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </article>

    <!-- Related Posts -->
    <?php
    // Get related posts from same category
    $categories = get_the_category();
    if ($categories) {
        $category_ids = array();
        foreach($categories as $category) {
            $category_ids[] = $category->term_id;
        }
        
        $related_posts = get_posts(array(
            'category__in' => $category_ids,
            'post__not_in' => array($post->ID),
            'numberposts' => 3,
            'orderby' => 'rand'
        ));
        
        if ($related_posts) :
    ?>
    <section class="py-16 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-3xl font-bold text-slate-800 mb-4">
                    Artikel Terkait
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Baca juga artikel lainnya yang mungkin menarik untuk Anda.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 fade-in-delay-2">
                <?php foreach ($related_posts as $related_post) : ?>
                <article class="group bg-slate-50 rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                    <?php if (has_post_thumbnail($related_post->ID)) : ?>
                    <div class="relative overflow-hidden">
                        <a href="<?php echo get_permalink($related_post->ID); ?>" class="block">
                            <?php echo get_the_post_thumbnail($related_post->ID, 'medium', [
                                'class' => 'w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105'
                            ]); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <div class="flex items-center gap-2 text-sm text-slate-500 mb-3">
                            <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <time><?php echo get_the_date('d M Y', $related_post->ID); ?></time>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 leading-tight">
                            <a href="<?php echo get_permalink($related_post->ID); ?>" 
                               class="hover:text-blue-600 transition-colors duration-200">
                                <?php echo $related_post->post_title; ?>
                            </a>
                        </h3>
                        
                        <div class="text-slate-600 mb-4 line-clamp-3 leading-relaxed">
                            <?php echo wp_trim_words($related_post->post_content, 18, '...'); ?>
                        </div>
                        
                        <a href="<?php echo get_permalink($related_post->ID); ?>" 
                           class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm transition-colors duration-200">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php 
        endif;
    }
    ?>

    <!-- Navigation & Back Button -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Post Navigation -->
            <nav class="mb-16 fade-in" aria-label="Post navigation">
                <div class="grid md:grid-cols-2 gap-6">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    
                    if ($prev_post) :
                    ?>
                    <a href="<?php echo get_permalink($prev_post->ID); ?>" 
                       class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center gap-3 mb-3">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span class="text-sm font-medium text-slate-500">Artikel Sebelumnya</span>
                        </div>
                        <h3 class="font-semibold text-slate-800 group-hover:text-blue-600 transition-colors">
                            <?php echo wp_trim_words($prev_post->post_title, 10); ?>
                        </h3>
                    </a>
                    <?php else : ?>
                    <div></div>
                    <?php endif; ?>
                    
                    <?php if ($next_post) : ?>
                    <a href="<?php echo get_permalink($next_post->ID); ?>" 
                       class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 text-right">
                        <div class="flex items-center justify-end gap-3 mb-3">
                            <span class="text-sm font-medium text-slate-500">Artikel Berikutnya</span>
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-slate-800 group-hover:text-blue-600 transition-colors">
                            <?php echo wp_trim_words($next_post->post_title, 10); ?>
                        </h3>
                    </a>
                    <?php endif; ?>
                </div>
            </nav>
            
            <!-- Back to News Button -->
            <div class="text-center fade-in-delay-2">
                <a href="<?php echo home_url('/berita'); ?>" 
                   class="inline-flex items-center gap-3 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Kembali ke Semua Berita
                </a>
            </div>
            
        </div>
    </section>

    <!-- Related Posts Section -->
    <section class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php get_template_part('template-parts/related-posts'); ?>
        </div>
    </section>

    <?php endwhile; ?>
</main>

<?php get_footer();