<?php
/**
 * Modern archive card for posts
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!defined('ABSPATH')) { exit; }

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('rounded-xl overflow-hidden bg-white shadow-sm ring-1 ring-slate-200/60 hover:shadow-md transition-shadow'); ?>>
	<a href="<?php the_permalink(); ?>" class="block group">
		<?php if (has_post_thumbnail()) : ?>
			<div class="aspect-[16/9] overflow-hidden bg-slate-100">
				<?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300']); ?>
			</div>
		<?php endif; ?>
		<div class="p-5">
			<div class="flex items-center gap-3 text-xs text-slate-500 mb-2">
				<time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d M Y')); ?></time>
				<?php $cats = get_the_category(); if ($cats) : ?>
					<span>•</span>
					<span class="inline-flex flex-wrap gap-1">
						<?php foreach ($cats as $c) { echo '<span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600">' . esc_html($c->name) . '</span>'; } ?>
					</span>
				<?php endif; ?>
			</div>
			<h2 class="text-lg font-semibold text-slate-800 group-hover:text-blue-600 transition-colors"><?php echo esc_html(get_the_title()); ?></h2>
			<?php if (has_excerpt() || get_the_content()) : ?>
				<p class="mt-2 text-slate-600 line-clamp-3"><?php echo esc_html( get_the_excerpt() ?: wp_trim_words( wp_strip_all_tags(get_the_content()), 24 ) ); ?></p>
			<?php endif; ?>
			<div class="mt-4 inline-flex items-center gap-2 text-sm text-blue-600 font-medium">
				<span><?php esc_html_e('Baca selengkapnya', 'mtq-aceh-pidie-jaya'); ?></span>
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
			</div>
		</div>
	</a>
</article>
