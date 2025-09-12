<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

get_header();
?>

<?php get_template_part('template-parts/breadcrumbs'); ?>

<main id="primary" class="site-main min-h-screen">
	<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-16">
		
		<!-- 404 Error Section -->
		<div class="text-center">
			
			<!-- Animated 404 Number -->
			<div class="relative mb-8">
				<div class="inline-block">
					<!-- Background Glow -->
					<div class="absolute inset-0 bg-gradient-to-r from-red-400 via-pink-500 to-purple-600 rounded-3xl blur-3xl opacity-30 animate-pulse"></div>
					
					<!-- Main 404 Text -->
					<div class="relative bg-gradient-to-br from-red-50 to-purple-50 rounded-3xl p-8 md:p-12 border border-red-100/50 backdrop-blur-sm">
						<h1 class="text-8xl md:text-9xl lg:text-[12rem] font-black bg-gradient-to-br from-red-500 via-pink-600 to-purple-700 bg-clip-text text-transparent leading-none select-none">
							404
						</h1>
					</div>
				</div>
			</div>

			<!-- Error Message -->
			<div class="max-w-2xl mx-auto mb-12">
				<h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
					<?php esc_html_e('Halaman Tidak Ditemukan', 'mtq-aceh-pidie-jaya'); ?>
				</h2>
				
				<p class="text-lg md:text-xl text-gray-600 leading-relaxed mb-8">
					<?php esc_html_e('Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman telah dipindahkan, dihapus, atau URL yang dimasukkan salah.', 'mtq-aceh-pidie-jaya'); ?>
				</p>
			</div>

			<!-- Search Form -->
			<div class="max-w-md mx-auto mb-12">
				<div class="relative">
					<h3 class="text-lg font-semibold text-gray-900 mb-4">
						<?php esc_html_e('Coba Cari Artikel:', 'mtq-aceh-pidie-jaya'); ?>
					</h3>
					
					<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative group">
						<div class="relative">
							<input type="search" 
								   id="search-field-404" 
								   name="s" 
								   value="<?php echo get_search_query(); ?>" 
								   placeholder="<?php esc_attr_e('Masukkan kata kunci...', 'mtq-aceh-pidie-jaya'); ?>"
								   class="w-full pl-12 pr-4 py-4 text-gray-900 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
								   required>
							
							<!-- Search Icon -->
							<div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
								<svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
								</svg>
							</div>
						</div>
						
						<button type="submit" 
								class="mt-4 w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium py-3 px-6 rounded-xl hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-200 transition-all duration-200 shadow-lg hover:shadow-xl">
							<span class="flex items-center justify-center gap-2">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
								</svg>
								<?php esc_html_e('Cari Sekarang', 'mtq-aceh-pidie-jaya'); ?>
							</span>
						</button>
					</form>
				</div>
			</div>

			<!-- Quick Actions -->
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
				<!-- Home -->
				<a href="<?php echo esc_url(home_url('/')); ?>" 
				   class="group flex flex-col items-center p-6 bg-white border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-lg transition-all duration-200">
					<div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
						<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
						</svg>
					</div>
					<h3 class="font-semibold text-gray-900 mb-2"><?php esc_html_e('Beranda', 'mtq-aceh-pidie-jaya'); ?></h3>
					<p class="text-sm text-gray-600 text-center"><?php esc_html_e('Kembali ke halaman utama', 'mtq-aceh-pidie-jaya'); ?></p>
				</a>

				<!-- Blog -->
				<?php $blog_page = get_option('page_for_posts'); ?>
				<?php if ($blog_page) : ?>
					<a href="<?php echo esc_url(get_permalink($blog_page)); ?>" 
					   class="group flex flex-col items-center p-6 bg-white border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-lg transition-all duration-200">
						<div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors">
							<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
							</svg>
						</div>
						<h3 class="font-semibold text-gray-900 mb-2"><?php esc_html_e('Artikel', 'mtq-aceh-pidie-jaya'); ?></h3>
						<p class="text-sm text-gray-600 text-center"><?php esc_html_e('Lihat semua artikel', 'mtq-aceh-pidie-jaya'); ?></p>
					</a>
				<?php endif; ?>

				<!-- About -->
				<?php 
				$about_page = get_page_by_path('tentang');
				if (!$about_page) {
					$about_page = get_page_by_path('about');
				}
				if ($about_page) : ?>
					<a href="<?php echo esc_url(get_permalink($about_page)); ?>" 
					   class="group flex flex-col items-center p-6 bg-white border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-lg transition-all duration-200">
						<div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-purple-200 transition-colors">
							<svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
						</div>
						<h3 class="font-semibold text-gray-900 mb-2"><?php esc_html_e('Tentang', 'mtq-aceh-pidie-jaya'); ?></h3>
						<p class="text-sm text-gray-600 text-center"><?php esc_html_e('Pelajari lebih lanjut', 'mtq-aceh-pidie-jaya'); ?></p>
					</a>
				<?php endif; ?>

				<!-- Contact -->
				<?php 
				$contact_page = get_page_by_path('kontak');
				if (!$contact_page) {
					$contact_page = get_page_by_path('contact');
				}
				if ($contact_page) : ?>
					<a href="<?php echo esc_url(get_permalink($contact_page)); ?>" 
					   class="group flex flex-col items-center p-6 bg-white border border-gray-200 rounded-xl hover:border-orange-300 hover:shadow-lg transition-all duration-200">
						<div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-200 transition-colors">
							<svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
							</svg>
						</div>
						<h3 class="font-semibold text-gray-900 mb-2"><?php esc_html_e('Kontak', 'mtq-aceh-pidie-jaya'); ?></h3>
						<p class="text-sm text-gray-600 text-center"><?php esc_html_e('Hubungi kami', 'mtq-aceh-pidie-jaya'); ?></p>
					</a>
				<?php endif; ?>
			</div>

			<!-- Recent Posts -->
			<?php
			$recent_posts = new WP_Query([
				'posts_per_page' => 6,
				'post_status' => 'publish',
				'ignore_sticky_posts' => true
			]);

			if ($recent_posts->have_posts()) : ?>
				<section class="text-left mb-12">
					<div class="text-center mb-8">
						<h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
							<?php esc_html_e('Atau Coba Artikel Terbaru Ini', 'mtq-aceh-pidie-jaya'); ?>
						</h3>
						<div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-purple-600 mx-auto rounded-full"></div>
					</div>

					<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
						<?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
							<article class="group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl hover:border-gray-300 transition-all duration-300">
								
								<!-- Featured Image -->
								<div class="aspect-video overflow-hidden">
									<?php if (has_post_thumbnail()) : ?>
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail('medium_large', [
												'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300',
												'alt' => get_the_title()
											]); ?>
										</a>
									<?php else : ?>
										<a href="<?php the_permalink(); ?>">
											<div class="w-full h-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center group-hover:from-gray-100 group-hover:to-gray-200 transition-colors duration-300">
												<img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-thumbnail.svg" 
													 alt="<?php echo esc_attr(get_the_title()); ?>" 
													 class="w-16 h-16 opacity-40">
											</div>
										</a>
									<?php endif; ?>
								</div>

								<!-- Content -->
								<div class="p-5">
									<!-- Category -->
									<?php
									$categories = get_the_category();
									if ($categories) : ?>
										<div class="mb-3">
											<a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" 
											   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
												<?php echo esc_html($categories[0]->name); ?>
											</a>
										</div>
									<?php endif; ?>

									<!-- Title -->
									<h4 class="font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
										<a href="<?php the_permalink(); ?>" class="hover:underline">
											<?php the_title(); ?>
										</a>
									</h4>

									<!-- Excerpt -->
									<p class="text-gray-600 text-sm mb-4 line-clamp-2">
										<?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
									</p>

									<!-- Meta -->
									<div class="flex items-center justify-between pt-3 border-t border-gray-100">
										<time datetime="<?php echo esc_attr(get_the_date('c')); ?>" class="text-xs text-gray-500">
											<?php echo get_the_date(); ?>
										</time>
										
										<a href="<?php the_permalink(); ?>" 
										   class="text-blue-600 hover:text-blue-700 text-sm font-medium group-hover:underline transition-colors">
											<?php esc_html_e('Baca', 'mtq-aceh-pidie-jaya'); ?>
											<svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
											</svg>
										</a>
									</div>
								</div>
							</article>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				</section>
			<?php endif; ?>

			<!-- Help Section -->
			<div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-8 text-center">
				<div class="max-w-2xl mx-auto">
					<h3 class="text-xl font-bold text-gray-900 mb-4">
						<?php esc_html_e('Masih Butuh Bantuan?', 'mtq-aceh-pidie-jaya'); ?>
					</h3>
					
					<p class="text-gray-600 mb-6">
						<?php esc_html_e('Jika Anda yakin halaman ini seharusnya ada, atau mengalami masalah teknis lainnya, silakan laporkan kepada kami.', 'mtq-aceh-pidie-jaya'); ?>
					</p>
					
					<div class="flex flex-col sm:flex-row gap-4 justify-center">
						<a href="<?php echo esc_url(home_url('/kontak')); ?>" 
						   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
							<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
							</svg>
							<?php esc_html_e('Laporkan Masalah', 'mtq-aceh-pidie-jaya'); ?>
						</a>
						
						<button onclick="window.history.back()" 
								class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
							<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
							</svg>
							<?php esc_html_e('Kembali', 'mtq-aceh-pidie-jaya'); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</main>

<?php
get_footer();