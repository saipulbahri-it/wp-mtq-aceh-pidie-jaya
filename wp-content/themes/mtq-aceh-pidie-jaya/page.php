<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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

<!-- Breadcrumbs -->
<?php get_template_part('template-parts/breadcrumbs'); ?>

<!-- Main Content -->
<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white">
	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				?>
				<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
					<div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
						<?php comments_template(); ?>
					</div>
				</div>
				<?php
			endif;

		endwhile; // End of the loop.
		?>
	</main><!-- #main -->
</div>

<?php
get_footer();