<?php
/**
 * Template part for displaying location map
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

?>

<section id="location-map" class="bg-white py-16">
	<div class="container mx-auto px-4">
		<?php if ( get_theme_mod( 'location_title' ) ) : ?>
			<h2 class="text-3xl font-bold text-center text-gray-900 mb-4">
				<?php echo esc_html( get_theme_mod( 'location_title' ) ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'location_description' ) ) : ?>
			<div class="text-center text-gray-600 max-w-2xl mx-auto mb-8">
				<?php echo wp_kses_post( get_theme_mod( 'location_description' ) ); ?>
			</div>
		<?php endif; ?>

		<?php
		$map_url = get_theme_mod( 'location_map_url' );
		if (empty($map_url)) {
			$map_url = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4852.693491674251!2d96.24198147580853!3d5.230074394747693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3040b100162f57eb%3A0xf5697ff0a3aa42fe!2sGEDUNG%20MTQ%20PIDIE%20JAYA!5e1!3m2!1sid!2sid!4v1757497686875!5m2!1sid!2sid';
		}
		?>
		<!-- Debug Info -->
		<?php if (current_user_can('administrator')): ?>
		<div class="bg-yellow-100 p-4 mb-4 rounded">
			<p class="text-sm">Debug Info (hanya terlihat admin):</p>
			<p class="text-xs">Map URL from theme_mod: <?php echo esc_html($map_url); ?></p>
		</div>
		<?php endif; ?>
		
		<div class="rounded-lg overflow-hidden shadow-lg">
			<iframe
				src="<?php echo esc_url($map_url); ?>"
				width="100%"
				height="<?php echo esc_attr( get_theme_mod( 'location_map_height', '400' ) ); ?>"
				style="border:0;"
				allowfullscreen=""
				loading="lazy"
				referrerpolicy="no-referrer-when-downgrade"
				class="w-full">
			</iframe>
		</div>
	</div>
</section>
