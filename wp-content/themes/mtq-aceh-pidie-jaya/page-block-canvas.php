<?php
/**
 * Template Name: Block Canvas (Block-Only)
 * Description: Halaman minimal yang hanya menampilkan konten blok tanpa wrapper tambahan dari theme.
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!defined('ABSPATH')) { exit; }

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) : the_post();
        // Render Gutenberg blocks exactly as authored.
        the_content();
    endwhile;
    ?>
    
</main>

<?php get_footer();
