<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area space-y-6">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
    
	<?php // Optional: fallback note for admins when sidebar is empty
	if ( current_user_can('edit_theme_options') && !is_active_sidebar('sidebar-1') ) : ?>
		<div class="rounded-lg bg-yellow-50 text-yellow-800 p-4 text-sm">
			<?php esc_html_e('Tambahkan widget ke Sidebar melalui Appearance → Widgets.', 'mtq-aceh-pidie-jaya'); ?>
		</div>
	<?php endif; ?>
</aside><!-- #secondary -->