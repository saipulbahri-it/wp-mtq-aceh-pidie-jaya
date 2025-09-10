<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
	<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-2xl shadow-lg overflow-hidden'); ?>>
		
		<!-- Featured Image Hero -->
		<?php if (has_post_thumbnail()) : ?>
			<div class="relative h-64 md:h-80 lg:h-96 overflow-hidden">
				<?php the_post_thumbnail('full', [
					'class' => 'w-full h-full object-cover',
					'alt' => get_the_title()
				]); ?>
				
				<!-- Overlay for better text readability -->
				<div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
				
				<!-- Title Overlay -->
				<div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 lg:p-12">
					<header class="entry-header">
						<h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
							<?php the_title(); ?>
						</h1>
						
						<!-- Page Meta -->
						<div class="flex flex-wrap items-center gap-4 mt-4 text-white/90">
							<!-- Last Modified -->
							<span class="inline-flex items-center gap-2 text-sm">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
								<?php printf(
									esc_html__('Diperbarui %s', 'mtq-aceh-pidie-jaya'),
									get_the_modified_date()
								); ?>
							</span>
						</div>
					</header>
				</div>
			</div>
		<?php else : ?>
			<!-- No Featured Image Header -->
			<div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 px-6 py-16 md:px-8 md:py-20 lg:px-12 lg:py-24">
				<!-- Background Pattern -->
				<div class="absolute inset-0 bg-black/10"></div>
				<div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
				
				<div class="relative text-center">
					<header class="entry-header">
						<h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
							<?php the_title(); ?>
						</h1>
						
						<!-- Page Meta -->
						<div class="flex flex-wrap items-center justify-center gap-4 text-blue-100">
							<!-- Last Modified -->
							<span class="inline-flex items-center gap-2 text-sm">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
								<?php printf(
									esc_html__('Diperbarui %s', 'mtq-aceh-pidie-jaya'),
									get_the_modified_date()
								); ?>
							</span>
						</div>
					</header>
				</div>
			</div>
		<?php endif; ?>

		<!-- Content Body -->
		<div class="px-6 py-8 md:px-8 md:py-12 lg:px-12 lg:py-16">
			<div class="prose prose-lg max-w-none">
				<div class="entry-content text-gray-700 leading-relaxed">
					<?php
					the_content();

					// Custom page links with modern styling
					wp_link_pages(array(
						'before' => '<nav class="page-links flex flex-wrap items-center justify-center gap-2 mt-8 pt-8 border-t border-gray-200"><span class="page-links-title text-gray-600 font-medium mr-4">' . esc_html__('Halaman:', 'mtq-aceh-pidie-jaya') . '</span>',
						'after' => '</nav>',
						'link_before' => '<span class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 hover:border-blue-300 transition-colors">',
						'link_after' => '</span>',
						'next_or_number' => 'number',
						'separator' => ' ',
					));
					?>
				</div>
			</div>
		</div>

		<!-- Edit Link Footer -->
		<?php if (get_edit_post_link()) : ?>
			<footer class="entry-footer bg-gray-50 px-6 py-4 md:px-8 lg:px-12 border-t border-gray-200">
				<div class="flex items-center justify-between">
					<div class="text-sm text-gray-500">
						<?php printf(
							esc_html__('Halaman ID: %s', 'mtq-aceh-pidie-jaya'),
							get_the_ID()
						); ?>
					</div>
					
					<?php
					edit_post_link(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__('Edit <span class="screen-reader-text">%s</span>', 'mtq-aceh-pidie-jaya'),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							wp_kses_post(get_the_title())
						),
						'<span class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">',
						'</span>'
					);
					?>
				</div>
			</footer>
		<?php endif; ?>
		
	</article><!-- #post-<?php the_ID(); ?> -->
</div>