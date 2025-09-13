<?php
/**
 * The template for displaying tag archives
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

<?php get_template_part('template-parts/breadcrumbs'); ?>

<main id="primary" class="site-main">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
		
		<?php if (have_posts()) : ?>
			
			<!-- Tag Header -->
			<header class="tag-header mb-12">
				<div class="relative bg-gradient-to-br from-green-600 via-green-700 to-green-800 rounded-2xl overflow-hidden">
					<!-- Background Pattern -->
					<div class="absolute inset-0 bg-black/20"></div>
					<div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 30c0-3.314-2.686-6-6-6s-6 2.686-6 6 2.686 6 6 6 6-2.686 6-6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
					
					<div class="relative px-8 py-16 md:py-20 text-center">
						<div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full mb-6">
							<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
							</svg>
						</div>
						
						<div class="mb-4">
							<span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-green-100 text-sm font-medium mb-4">
								<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
								</svg>
								<?php esc_html_e('Tag', 'mtq-aceh-pidie-jaya'); ?>
							</span>
						</div>
						
						<h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
							#<?php single_tag_title(); ?>
						</h1>
						
						<?php
						$description = tag_description();
						if ($description) : ?>
							<div class="text-lg md:text-xl text-green-100 max-w-3xl mx-auto leading-relaxed mb-6">
								<?php echo $description; ?>
							</div>
						<?php endif; ?>
						
						<div class="flex flex-wrap items-center justify-center gap-4 text-green-200">
							<span class="inline-flex items-center gap-2">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
								</svg>
								<?php
								$tag = get_queried_object();
								printf(
									_n('%s artikel', '%s artikel', $tag->count, 'mtq-aceh-pidie-jaya'),
									number_format_i18n($tag->count)
								);
								?>
							</span>
						</div>
					</div>
				</div>
			</header>

			<!-- Posts Grid -->
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
				<?php
				while (have_posts()) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('group'); ?>>
						<div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-gray-200">
							
							<!-- Featured Image -->
							<div class="aspect-video overflow-hidden">
								<?php if (has_post_thumbnail()) : ?>
									<a href="<?php the_permalink(); ?>" class="block">
										<?php the_post_thumbnail('medium_large', [
											'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300',
											'alt' => get_the_title()
										]); ?>
									</a>
								<?php else : ?>
									<a href="<?php the_permalink(); ?>" class="block">
										<div class="w-full h-full bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center group-hover:from-green-100 group-hover:to-green-200 transition-colors duration-300">
											<img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-thumbnail.svg" 
												 alt="<?php echo esc_attr(get_the_title()); ?>" 
												 class="w-24 h-24 opacity-60">
										</div>
									</a>
								<?php endif; ?>
							</div>

							<!-- Content -->
							<div class="p-6">
								<!-- Tags -->
								<div class="flex flex-wrap gap-2 mb-4">
									<?php
									$tags = get_the_tags();
									if ($tags) :
										foreach (array_slice($tags, 0, 3) as $tag_item) : ?>
											<a href="<?php echo esc_url(get_tag_link($tag_item->term_id)); ?>" 
											   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 hover:bg-green-200 transition-colors">
												<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
												</svg>
												<?php echo esc_html($tag_item->name); ?>
											</a>
										<?php endforeach;
									endif; ?>
								</div>

								<!-- Categories -->
								<div class="flex flex-wrap gap-2 mb-4">
									<?php
									$categories = get_the_category();
									if ($categories) :
										foreach (array_slice($categories, 0, 2) as $cat) : ?>
											<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" 
											   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
												<?php echo esc_html($cat->name); ?>
											</a>
										<?php endforeach;
									endif; ?>
								</div>

								<!-- Title -->
								<h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-green-600 transition-colors">
									<a href="<?php the_permalink(); ?>" class="hover:underline">
										<?php the_title(); ?>
									</a>
								</h2>

								<!-- Excerpt -->
								<div class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
									<?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
								</div>

								<!-- Meta Info -->
								<div class="flex items-center justify-between pt-4 border-t border-gray-100">
									<div class="flex items-center gap-3 text-sm text-gray-500">
										<time datetime="<?php echo esc_attr(get_the_date('c')); ?>" class="flex items-center gap-1">
											<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
											</svg>
											<?php echo get_the_date(); ?>
										</time>
									</div>
									
									<a href="<?php the_permalink(); ?>" 
									   class="inline-flex items-center gap-1 text-green-600 hover:text-green-700 font-medium text-sm transition-colors group">
										Baca Selengkapnya
										<svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
										</svg>
									</a>
								</div>
							</div>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<!-- Pagination -->
			<div class="flex justify-center">
				<?php
				$pagination_args = array(
					'mid_size' => 2,
					'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg><span class="ml-2">Sebelumnya</span>',
					'next_text' => '<span class="mr-2">Selanjutnya</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
					'type' => 'array'
				);

				$pages = paginate_links($pagination_args);

				if ($pages) : ?>
					<nav class="pagination flex justify-center" role="navigation" aria-label="<?php esc_attr_e('Posts navigation', 'mtq-aceh-pidie-jaya'); ?>">
						<div class="flex flex-wrap justify-center gap-2">
							<?php 
							foreach ($pages as $page) :
								// Add proper classes for styling
								if (strpos($page, 'current') !== false) {
									$page = str_replace('page-numbers current', 'inline-flex items-center justify-center px-4 py-2 text-sm font-medium bg-green-600 text-white border border-green-600 rounded-lg hover:bg-green-700 transition-colors min-w-[44px] h-11', $page);
								} elseif (strpos($page, 'dots') !== false) {
									$page = str_replace('page-numbers dots', 'inline-flex items-center justify-center px-2 py-2 text-gray-400', $page);
								} else {
									$page = str_replace('page-numbers', 'inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-green-600 transition-colors min-w-[44px] h-11 no-underline', $page);
								}
								echo $page;
							endforeach; 
							?>
						</div>
					</nav>
				<?php endif; ?>
			</div>

		<?php else : ?>
			
			<!-- No Posts Found -->
			<div class="text-center py-16">
				<div class="max-w-md mx-auto">
					<div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
						<svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
						</svg>
					</div>
					
					<h2 class="text-2xl font-bold text-gray-900 mb-4">
						<?php esc_html_e('Belum Ada Artikel', 'mtq-aceh-pidie-jaya'); ?>
					</h2>
					
					<p class="text-gray-600 mb-8">
						<?php 
						printf(
							esc_html__('Tag "%s" belum memiliki artikel. Silakan kembali ke halaman utama atau coba tag lainnya.', 'mtq-aceh-pidie-jaya'),
							'<strong>' . single_tag_title('', false) . '</strong>'
						);
						?>
					</p>
					
					<div class="flex flex-col sm:flex-row gap-4 justify-center">
						<a href="<?php echo esc_url(home_url('/')); ?>" 
						   class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
							<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
							</svg>
							<?php esc_html_e('Kembali ke Beranda', 'mtq-aceh-pidie-jaya'); ?>
						</a>
						
						<a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" 
						   class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
							<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
							</svg>
							<?php esc_html_e('Lihat Semua Artikel', 'mtq-aceh-pidie-jaya'); ?>
						</a>
					</div>
				</div>
			</div>

		<?php endif; ?>
		
	</div>
</main>

<?php
get_footer();
