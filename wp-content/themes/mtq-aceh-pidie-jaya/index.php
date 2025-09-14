<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

	<main id="primary" class="site-main">

		<?php // Breadcrumbs (auto-hide on front page)
		get_template_part('template-parts/breadcrumbs'); ?>

		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
			<?php $has_sidebar = is_active_sidebar('sidebar-1'); ?>
			<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
				<!-- Main Content -->
				<div class="order-1 lg:order-1 <?php echo $has_sidebar ? 'lg:col-span-8' : 'lg:col-span-12'; ?>">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header class="mb-6">
					<h1 class="text-2xl font-bold text-slate-800"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php if ( is_home() || is_front_page() ) : ?>
				<div class="mb-6">
					<h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Berita Terbaru</h2>
				</div>
			<?php endif; ?>

			<div class="grid gap-6 sm:gap-8 grid-cols-1 sm:grid-cols-2 xl:grid-cols-3">
				<?php /* Start the Loop */
				while ( have_posts() ) :
					the_post();
					if ( get_post_type() === 'post' ) {
						get_template_part( 'template-parts/content', 'archive' );
					} else {
						get_template_part( 'template-parts/content', get_post_type() );
					}
				endwhile; ?>
			</div>

			<?php
			// Accessible, Tailwind-styled pagination
			$links = paginate_links(array(
				'type'      => 'array',
				'mid_size'  => 1,
				'end_size'  => 1,
				'prev_text' => __('←', 'mtq-aceh-pidie-jaya'),
				'next_text' => __('→', 'mtq-aceh-pidie-jaya'),
			));
			if ($links) : ?>
				<nav class="mt-10" aria-label="<?php esc_attr_e('Pagination', 'mtq-aceh-pidie-jaya'); ?>">
					<ul class="flex flex-wrap items-center gap-2
						[&>li>a]:inline-flex [&>li>a]:items-center [&>li>a]:justify-center
						[&>li>a]:px-3 [&>li>a]:h-9 [&>li>a]:rounded-lg [&>li>a]:ring-1 [&>li>a]:ring-slate-200
						[&>li>a]:bg-white [&>li>a]:text-slate-700 hover:[&>li>a]:ring-slate-300 hover:[&>li>a]:bg-slate-50
						[&>li>span.current]:inline-flex [&>li>span.current]:items-center [&>li>span.current]:justify-center
						[&>li>span.current]:px-3 [&>li>span.current]:h-9 [&>li>span.current]:rounded-lg [&>li>span.current]:bg-blue-600 [&>li>span.current]:text-white
						[&>li>span.dots]:px-3 [&>li>span.dots]:h-9 [&>li>span.dots]:inline-flex [&>li>span.dots]:items-center">
						<?php foreach ($links as $link) : ?>
							<li><?php echo $link; ?></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>
				</div>

				<!-- Sidebar -->
				<?php if ( $has_sidebar ) : ?>
					<div class="order-2 lg:order-2 lg:col-span-4">
						<?php get_sidebar(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</main><!-- #main -->

<?php
get_footer();