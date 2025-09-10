<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

get_header();
?>

<?php get_template_part('template-parts/breadcrumbs'); ?>

<main id="primary" class="site-main">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
		
		<!-- Search Header -->
		<header class="search-header mb-12">
			<div class="relative bg-gradient-to-br from-indigo-600 via-indigo-700 to-indigo-800 rounded-2xl overflow-hidden">
				<!-- Background Pattern -->
				<div class="absolute inset-0 bg-black/20"></div>
				<div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="8"/%3E%3Cpath d="m19 19 22 22"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
				
				<div class="relative px-8 py-16 md:py-20 text-center">
					<div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full mb-6">
						<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
						</svg>
					</div>
					
					<div class="mb-4">
						<span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-indigo-100 text-sm font-medium mb-4">
							<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
							</svg>
							<?php esc_html_e('Hasil Pencarian', 'mtq-aceh-pidie-jaya'); ?>
						</span>
					</div>
					
					<h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
						<?php
						$search_query = get_search_query();
						if ($search_query) :
							printf(
								esc_html__('"%s"', 'mtq-aceh-pidie-jaya'),
								'<span class="text-indigo-200">' . esc_html($search_query) . '</span>'
							);
						else :
							esc_html_e('Pencarian', 'mtq-aceh-pidie-jaya');
						endif;
						?>
					</h1>
					
					<?php if (have_posts()) : ?>
						<div class="flex flex-wrap items-center justify-center gap-4 text-indigo-200">
							<span class="inline-flex items-center gap-2">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
								</svg>
								<?php
								global $wp_query;
								$total_posts = $wp_query->found_posts;
								printf(
									_n('Ditemukan %s hasil', 'Ditemukan %s hasil', $total_posts, 'mtq-aceh-pidie-jaya'),
									'<strong>' . number_format_i18n($total_posts) . '</strong>'
								);
								?>
							</span>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</header>

		<?php if (have_posts()) : ?>
			
			<!-- Search Results -->
			<div class="space-y-8 mb-12">
				<?php
				while (have_posts()) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('group'); ?>>
						<div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 hover:border-gray-200">
							<div class="md:flex">
								
								<!-- Featured Image -->
								<div class="md:w-1/3 lg:w-1/4 aspect-video md:aspect-square overflow-hidden">
									<?php if (has_post_thumbnail()) : ?>
										<a href="<?php the_permalink(); ?>" class="block">
											<?php the_post_thumbnail('medium_large', [
												'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300',
												'alt' => get_the_title()
											]); ?>
										</a>
									<?php else : ?>
										<a href="<?php the_permalink(); ?>" class="block">
											<div class="w-full h-full bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center group-hover:from-indigo-100 group-hover:to-indigo-200 transition-colors duration-300">
												<img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-thumbnail.svg" 
													 alt="<?php echo esc_attr(get_the_title()); ?>" 
													 class="w-20 h-20 opacity-60">
											</div>
										</a>
									<?php endif; ?>
								</div>

								<!-- Content -->
								<div class="md:w-2/3 lg:w-3/4 p-6 md:p-8">
									<!-- Meta Tags -->
									<div class="flex flex-wrap gap-2 mb-4">
										<!-- Post Type -->
										<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
											<?php 
											$post_type_object = get_post_type_object(get_post_type());
											echo esc_html($post_type_object->labels->singular_name);
											?>
										</span>
										
										<!-- Categories -->
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
										
										<!-- Tags -->
										<?php
										$tags = get_the_tags();
										if ($tags) :
											foreach (array_slice($tags, 0, 2) as $tag) : ?>
												<a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
												   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 hover:bg-indigo-200 transition-colors">
													<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
													</svg>
													<?php echo esc_html($tag->name); ?>
												</a>
											<?php endforeach;
										endif; ?>
									</div>

									<!-- Title -->
									<h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors">
										<a href="<?php the_permalink(); ?>" class="hover:underline">
											<?php 
											// Highlight search terms in title
											$title = get_the_title();
											if ($search_query) {
												$title = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<mark class="bg-yellow-200 text-yellow-800 px-1 rounded">$1</mark>', $title);
											}
											echo $title;
											?>
										</a>
									</h2>

									<!-- Excerpt with highlighted search terms -->
									<div class="text-gray-600 leading-relaxed mb-6">
										<?php 
										$excerpt = wp_trim_words(get_the_excerpt(), 40, '...');
										if ($search_query) {
											$excerpt = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<mark class="bg-yellow-200 text-yellow-800 px-1 rounded">$1</mark>', $excerpt);
										}
										echo $excerpt;
										?>
									</div>

									<!-- Meta Info -->
									<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-100">
										<div class="flex items-center gap-4 text-sm text-gray-500">
											<!-- Author -->
											<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="flex items-center gap-2 hover:text-indigo-600 transition-colors">
												<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
												</svg>
												<?php the_author(); ?>
											</a>
											
											<!-- Date -->
											<time datetime="<?php echo esc_attr(get_the_date('c')); ?>" class="flex items-center gap-1">
												<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
												</svg>
												<?php echo get_the_date(); ?>
											</time>
										</div>
										
										<a href="<?php the_permalink(); ?>" 
										   class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium text-sm transition-colors group">
											Baca Selengkapnya
											<svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
											</svg>
										</a>
									</div>
								</div>
							</div>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<!-- Pagination -->
			<div class="flex justify-center mb-12">
				<?php
				$pagination_args = array(
					'mid_size' => 2,
					'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg><span class="ml-2">Sebelumnya</span>',
					'next_text' => '<span class="mr-2">Selanjutnya</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
					'type' => 'array'
				);

				$pages = paginate_links($pagination_args);

				if ($pages) : ?>
					<nav class="pagination flex justify-center" role="navigation" aria-label="<?php esc_attr_e('Search results navigation', 'mtq-aceh-pidie-jaya'); ?>">
						<div class="flex flex-wrap justify-center gap-2">
							<?php 
							foreach ($pages as $page) :
								// Add proper classes for styling
								if (strpos($page, 'current') !== false) {
									$page = str_replace('page-numbers current', 'inline-flex items-center justify-center px-4 py-2 text-sm font-medium bg-indigo-600 text-white border border-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors min-w-[44px] h-11', $page);
								} elseif (strpos($page, 'dots') !== false) {
									$page = str_replace('page-numbers dots', 'inline-flex items-center justify-center px-2 py-2 text-gray-400', $page);
								} else {
									$page = str_replace('page-numbers', 'inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-indigo-600 transition-colors min-w-[44px] h-11 no-underline', $page);
								}
								echo $page;
							endforeach; 
							?>
						</div>
					</nav>
				<?php endif; ?>
			</div>

		<?php else : ?>
			
			<!-- No Results Found -->
			<div class="text-center py-16">
				<div class="max-w-lg mx-auto">
					<div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
						<svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
						</svg>
					</div>
					
					<h2 class="text-2xl font-bold text-gray-900 mb-4">
						<?php esc_html_e('Tidak Ditemukan Hasil', 'mtq-aceh-pidie-jaya'); ?>
					</h2>
					
					<p class="text-gray-600 mb-8">
						<?php 
						if ($search_query) {
							printf(
								esc_html__('Maaf, tidak ada hasil yang ditemukan untuk "%s". Coba gunakan kata kunci yang berbeda atau lebih spesifik.', 'mtq-aceh-pidie-jaya'),
								'<strong>' . esc_html($search_query) . '</strong>'
							);
						} else {
							esc_html_e('Silakan masukkan kata kunci pencarian untuk memulai pencarian.', 'mtq-aceh-pidie-jaya');
						}
						?>
					</p>
					
					<!-- Search Form -->
					<div class="mb-8">
						<?php get_search_form(); ?>
					</div>
					
					<!-- Search Tips -->
					<div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
						<h3 class="font-semibold text-gray-900 mb-3 flex items-center">
							<svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
							<?php esc_html_e('Tips Pencarian:', 'mtq-aceh-pidie-jaya'); ?>
						</h3>
						<ul class="text-gray-600 text-sm space-y-2">
							<li class="flex items-start gap-2">
								<svg class="w-4 h-4 mt-0.5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
								</svg>
								<?php esc_html_e('Gunakan kata kunci yang lebih umum', 'mtq-aceh-pidie-jaya'); ?>
							</li>
							<li class="flex items-start gap-2">
								<svg class="w-4 h-4 mt-0.5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
								</svg>
								<?php esc_html_e('Periksa ejaan kata kunci', 'mtq-aceh-pidie-jaya'); ?>
							</li>
							<li class="flex items-start gap-2">
								<svg class="w-4 h-4 mt-0.5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
								</svg>
								<?php esc_html_e('Coba dengan kata kunci yang berbeda', 'mtq-aceh-pidie-jaya'); ?>
							</li>
							<li class="flex items-start gap-2">
								<svg class="w-4 h-4 mt-0.5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
								</svg>
								<?php esc_html_e('Gunakan sinonim atau kata yang serupa', 'mtq-aceh-pidie-jaya'); ?>
							</li>
						</ul>
					</div>
					
					<div class="flex flex-col sm:flex-row gap-4 justify-center">
						<a href="<?php echo esc_url(home_url('/')); ?>" 
						   class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
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
		
		<!-- New Search Section -->
		<div class="bg-gray-50 rounded-2xl p-8 text-center">
			<h3 class="text-xl font-semibold text-gray-900 mb-4">
				<?php esc_html_e('Cari Artikel Lainnya', 'mtq-aceh-pidie-jaya'); ?>
			</h3>
			<p class="text-gray-600 mb-6">
				<?php esc_html_e('Temukan lebih banyak artikel tentang MTQ Aceh Pidie Jaya', 'mtq-aceh-pidie-jaya'); ?>
			</p>
			<?php get_search_form(); ?>
		</div>
		
	</div>
</main>

<?php
get_footer();
