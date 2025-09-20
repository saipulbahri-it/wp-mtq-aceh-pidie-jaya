<?php
/**
 * Template Name: Blank Canvas (No Header/Footer)
 * Description: Halaman full-bleed yang hanya menampilkan blok, tanpa header dan footer tema. Cocok untuk landing page custom.
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!defined('ABSPATH')) { exit; }

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
    <style>
      html,body{margin:0;padding:0}
    </style>
  </head>
  <body <?php body_class('blank-canvas'); ?>>
    <?php
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
    ?>
    <?php wp_footer(); ?>
  </body>
</html>
