<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

?>

	</div><!-- #content -->

	<?php get_template_part('template-parts/footer/content', 'footer'); ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>