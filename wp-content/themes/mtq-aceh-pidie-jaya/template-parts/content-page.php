<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
	<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200/50'); ?>>
		
		<!-- Featured Image Hero -->
		<?php if (has_post_thumbnail()) : ?>
			<div class="relative h-72 md:h-80 lg:h-96 overflow-hidden">
				<?php the_post_thumbnail('full', [
					'class' => 'w-full h-full object-cover transition-transform duration-700 hover:scale-105',
					'alt' => get_the_title()
				]); ?>
				
				<!-- Sophisticated Overlay -->
				<div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/40 to-transparent"></div>
				
				<!-- Title Overlay with Enhanced Design -->
				<div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 lg:p-12">
					<header class="entry-header">
						<div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-100 backdrop-blur-sm mb-4">
							<svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
								<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
							Halaman Resmi MTQ
						</div>
						
						<h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
							<?php the_title(); ?>
						</h1>
						
						<!-- Enhanced Page Meta -->
						<div class="flex flex-wrap items-center gap-6 text-white/90">
							<span class="inline-flex items-center gap-2 text-sm font-medium">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
								<?php printf(
									esc_html__('Diperbarui %s', 'mtq-aceh-pidie-jaya'),
									get_the_modified_date('j F Y')
								); ?>
							</span>
							
							<!-- Reading Time Estimate -->
							<span class="inline-flex items-center gap-2 text-sm font-medium">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
								</svg>
								<?php
								$word_count = str_word_count(strip_tags(get_the_content()));
								$reading_time = ceil($word_count / 200);
								printf(esc_html__('%d menit baca', 'mtq-aceh-pidie-jaya'), $reading_time);
								?>
							</span>
						</div>
					</header>
				</div>
			</div>
		<?php else : ?>
			<!-- Enhanced No Featured Image Header -->
			<div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 overflow-hidden">
				<!-- Sophisticated Background Pattern -->
				<div class="absolute inset-0 opacity-10">
					<div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #ffffff 2px, transparent 2px), radial-gradient(circle at 75% 75%, #ffffff 2px, transparent 2px); background-size: 50px 50px; background-position: 0 0, 25px 25px;"></div>
				</div>
				
				<!-- Islamic Pattern Overlay -->
				<div class="absolute inset-0 opacity-5">
					<svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
						<defs>
							<pattern id="islamic-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
								<circle cx="10" cy="10" r="8" fill="none" stroke="white" stroke-width="0.5"/>
								<circle cx="10" cy="10" r="4" fill="none" stroke="white" stroke-width="0.5"/>
								<path d="M10,2 L10,18 M2,10 L18,10" stroke="white" stroke-width="0.5"/>
							</pattern>
						</defs>
						<rect width="100%" height="100%" fill="url(#islamic-pattern)"/>
					</svg>
				</div>
				
				<div class="relative px-6 py-20 md:px-8 md:py-24 lg:px-12 lg:py-28 text-center">
					<header class="entry-header max-w-4xl mx-auto">
						<div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white/20 text-blue-100 backdrop-blur-sm mb-6">
							<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
								<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
							Halaman Resmi MTQ Aceh Pidie Jaya
						</div>
						
						<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
							<?php the_title(); ?>
						</h1>
						
						<!-- Enhanced Page Meta -->
						<div class="flex flex-wrap items-center justify-center gap-8 text-blue-100">
							<span class="inline-flex items-center gap-2 text-sm font-medium">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
								<?php printf(
									esc_html__('Diperbarui %s', 'mtq-aceh-pidie-jaya'),
									get_the_modified_date('j F Y')
								); ?>
							</span>
							
							<span class="inline-flex items-center gap-2 text-sm font-medium">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
								</svg>
								<?php
								$word_count = str_word_count(strip_tags(get_the_content()));
								$reading_time = ceil($word_count / 200);
								printf(esc_html__('%d menit baca', 'mtq-aceh-pidie-jaya'), $reading_time);
								?>
							</span>
						</div>
					</header>
				</div>
			</div>
		<?php endif; ?>

		<!-- Enhanced Content Body -->
		<div class="px-6 py-12 md:px-10 md:py-16 lg:px-16 lg:py-20">
			<div class="max-w-4xl mx-auto">
				<!-- Content with Better Typography -->
				<div class="entry-content prose prose-lg prose-slate max-w-none">
					<div class="text-slate-700 leading-relaxed">
						<?php
						the_content();

						// Enhanced page links with premium styling
						wp_link_pages(array(
							'before' => '<nav class="page-links flex flex-wrap items-center justify-center gap-3 mt-12 pt-8 border-t border-slate-200"><span class="page-links-title text-slate-600 font-semibold mr-6 text-lg">' . esc_html__('Halaman:', 'mtq-aceh-pidie-jaya') . '</span>',
							'after' => '</nav>',
							'link_before' => '<span class="inline-flex items-center justify-center min-w-[44px] h-11 text-sm font-semibold text-blue-600 bg-blue-50 border-2 border-blue-200 rounded-xl hover:bg-blue-100 hover:border-blue-300 hover:scale-105 transition-all duration-200 shadow-sm hover:shadow-md">',
							'link_after' => '</span>',
							'next_or_number' => 'number',
							'separator' => ' ',
						));
						?>
					</div>
				</div>
				
				<!-- Enhanced Content Features -->
				<div class="mt-12 pt-8 border-t border-slate-200">
					<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
						<!-- Page Stats -->
						<div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
							<div class="flex items-center gap-3 mb-3">
								<div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
									<svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
									</svg>
								</div>
								<h3 class="font-semibold text-slate-800">Statistik</h3>
							</div>
							<p class="text-sm text-slate-600">
								<?php printf(esc_html__('%d kata • %d menit baca', 'mtq-aceh-pidie-jaya'), $word_count, $reading_time); ?>
							</p>
						</div>
						
						<!-- Last Updated -->
						<div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
							<div class="flex items-center gap-3 mb-3">
								<div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
									<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
									</svg>
								</div>
								<h3 class="font-semibold text-slate-800">Terakhir Update</h3>
							</div>
							<p class="text-sm text-slate-600">
								<?php echo get_the_modified_date('j F Y, H:i'); ?>
							</p>
						</div>
						
						<!-- Page ID -->
						<div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-2xl p-6 border border-purple-100">
							<div class="flex items-center gap-3 mb-3">
								<div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
									<svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
									</svg>
								</div>
								<h3 class="font-semibold text-slate-800">Referensi</h3>
							</div>
							<p class="text-sm text-slate-600">
								<?php printf(esc_html__('ID: %s', 'mtq-aceh-pidie-jaya'), get_the_ID()); ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		
		<!-- Enhanced Social Sharing & Edit Section -->
		<div class="bg-gradient-to-r from-slate-50 via-gray-50 to-slate-50 border-t border-slate-200">
			<div class="px-6 py-8 md:px-10 md:py-10 lg:px-16 lg:py-12">
				<div class="max-w-4xl mx-auto">
					<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
						<!-- Social Sharing -->
						<div class="flex-1">
							<h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
								<svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
								</svg>
								Bagikan Halaman
							</h3>
							
							<div class="flex flex-wrap gap-3">
								<!-- WhatsApp -->
								<a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>" 
								   target="_blank" rel="noopener"
								   class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-xl font-medium transition-all duration-200 hover:scale-105 shadow-sm hover:shadow-md">
									<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
										<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.63"/>
									</svg>
									WhatsApp
								</a>
								
								<!-- Facebook -->
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
								   target="_blank" rel="noopener"
								   class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-200 hover:scale-105 shadow-sm hover:shadow-md">
									<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
										<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
									</svg>
									Facebook
								</a>
								
								<!-- Twitter -->
								<a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title()); ?>&url=<?php echo urlencode(get_permalink()); ?>" 
								   target="_blank" rel="noopener"
								   class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white rounded-xl font-medium transition-all duration-200 hover:scale-105 shadow-sm hover:shadow-md">
									<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
										<path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
									</svg>
									Twitter
								</a>
								
								<!-- Copy Link -->
								<button onclick="copyToClipboard('<?php echo esc_js(get_permalink()); ?>')" 
								        class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-600 hover:bg-slate-700 text-white rounded-xl font-medium transition-all duration-200 hover:scale-105 shadow-sm hover:shadow-md">
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
									</svg>
									Salin Link
								</button>
							</div>
						</div>
						
						<!-- Edit Link for Administrators -->
						<?php if (current_user_can('edit_post', get_the_ID())): ?>
						<div class="lg:ml-8">
							<div class="flex flex-col items-start lg:items-end gap-4">
								<h4 class="text-sm font-medium text-slate-600 flex items-center gap-2">
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
									</svg>
									Panel Admin
								</h4>
								
								<a href="<?php echo esc_url(get_edit_post_link()); ?>" 
								   class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl group">
									<svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
									</svg>
									Edit Halaman
									<div class="w-2 h-2 bg-white/30 rounded-full group-hover:bg-white/50 transition-colors duration-300"></div>
								</a>
								
								<p class="text-xs text-slate-500 text-center lg:text-right max-w-xs leading-relaxed">
									Akses khusus administrator untuk mengedit konten halaman ini
								</p>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>

<!-- Enhanced JavaScript for Copy to Clipboard -->
<script>
function copyToClipboard(text) {
	if (navigator.clipboard) {
		navigator.clipboard.writeText(text).then(function() {
			// Success feedback
			const button = event.target.closest('button');
			const originalText = button.innerHTML;
			button.innerHTML = `
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
				</svg>
				Tersalin!
			`;
			button.classList.remove('bg-slate-600', 'hover:bg-slate-700');
			button.classList.add('bg-green-600', 'hover:bg-green-700');
			
			setTimeout(() => {
				button.innerHTML = originalText;
				button.classList.remove('bg-green-600', 'hover:bg-green-700');
				button.classList.add('bg-slate-600', 'hover:bg-slate-700');
			}, 2000);
		}).catch(function() {
			// Fallback
			copyToClipboardFallback(text);
		});
	} else {
		copyToClipboardFallback(text);
	}
}

function copyToClipboardFallback(text) {
	const textArea = document.createElement('textarea');
	textArea.value = text;
	textArea.style.position = 'fixed';
	textArea.style.opacity = '0';
	document.body.appendChild(textArea);
	textArea.focus();
	textArea.select();
	
	try {
		document.execCommand('copy');
		// Success feedback for fallback
		const button = event.target.closest('button');
		const originalText = button.innerHTML;
		button.innerHTML = `
			<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
			</svg>
			Tersalin!
		`;
		setTimeout(() => {
			button.innerHTML = originalText;
		}, 2000);
	} catch (err) {
		console.log('Copy failed');
	}
	
	document.body.removeChild(textArea);
}
</script>
