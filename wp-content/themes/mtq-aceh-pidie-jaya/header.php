<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
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
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'mtq-aceh-pidie-jaya' ); ?></a>

	<!-- Loading Screen -->
	<div id="loading-screen" class="loading-screen">
		<div class="loading-logo"></div>
		<div class="loading-text">
			<h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6">
				<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-400">
					MTQ ACEH <br />
					XXXVII
				</span>
			</h1>
			<h2 class="loading-text text-xl md:text-2xl lg:text-3xl font-semibold mb-6 text-slate-700">
				PIDIE JAYA 2025
			</h2>
		</div>

		<div class="loading-progress">
			<div class="loading-bar"></div>
		</div>
	</div>

	<script>
		// Loading Screen
		window.addEventListener('load', () => {
			setTimeout(() => {
				document.getElementById('loading-screen').classList.add('hidden');
			}, 300);
		});
	</script>

	

	<!-- Header -->
	<header id="main-header" class="sticky top-0 w-full bg-white/95 backdrop-blur-md border-b border-slate-200/50 z-50 transition-all duration-300 shadow-sm">
		<div class="max-w-7xl mx-auto header-padding px-4 py-4">
			<div class="flex justify-between items-center">
				<div class="flex items-center space-x-3">
					<?php if (function_exists('the_custom_logo') && has_custom_logo()) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>" alt="Logo MTQ Aceh XXXVII" class="logo-img h-16 transition-all duration-300" decoding="async" fetchpriority="high">
					<?php endif; ?>
					<div class="hidden sm:block">
						<h1 class="text-xl font-bold text-blue-600"><?php bloginfo( 'name' ); ?></h1>
						<p class="text-sm text-slate-600"><?php bloginfo( 'description' ); ?></p>
					</div>
				</div>

				<!-- Desktop Navigation (Dynamic) -->
				<nav class="hidden md:flex space-x-2">
					<?php
					wp_nav_menu([
						'theme_location' => 'top-header-menu',
						'container' => false,
						'menu_class' => 'nav-list flex space-x-2',
						'fallback_cb' => function() {
							echo '<a href="' . esc_url( get_home_url() ) . '" class="nav-link">Beranda</a>';
							echo '<a href="' . esc_url( get_home_url() ) . '#tentang" class="nav-link">Tentang</a>';
							echo '<a href="' . esc_url( get_home_url() ) . '#cabang" class="nav-link">Cabang Lomba</a>';
							$arena_page = get_page_by_path( 'arena-dan-lokasi' );
							$arena_url = $arena_page ? get_permalink( $arena_page ) : home_url('/arena-dan-lokasi/');
							$gallery_url = get_post_type_archive_link('mtq_gallery');
							$berita_page = get_page_by_path( 'berita' );
							$berita_url = $berita_page ? get_permalink( $berita_page ) : home_url('/berita/');
							echo '<a href="' . esc_url( $arena_url ) . '" class="nav-link">Arena & Lokasi</a>';
							echo '<a href="' . esc_url( $gallery_url ) . '" class="nav-link">Galeri</a>';
							echo '<a href="' . esc_url( $berita_url ) . '" class="nav-link">Berita</a>';
							echo '<a href="' . esc_url( get_home_url() ) . '#live-stream" class="nav-link text-orange-600 font-bold flex items-center gap-1"><span class="relative flex items-center"><span class="live-dot animate-pulse"></span><svg class="w-4 h-4 ml-1 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="6" fill="currentColor"></circle></svg></span>Live</a>';
						},
						'link_before' => '<span class="nav-link">',
						'link_after' => '</span>',
					]);
					?>
				</nav>

				<!-- Mobile Menu Button -->
				<button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
					</svg>
				</button>
			</div>

			<!-- Mobile Navigation -->
			<nav id="mobile-menu" class="hidden md:hidden mt-4 pb-4 border-t border-slate-200">
				<div class="flex flex-col space-y-2 pt-4">
					<?php
					wp_nav_menu([
						'theme_location' => 'top-header-menu',
						'container' => false,
						'menu_class' => 'nav-list-mobile flex flex-col space-y-2',
						'fallback_cb' => function() {
							echo '<a href="' . esc_url( get_home_url() ) . '" class="nav-link">Beranda</a>';
							echo '<a href="' . esc_url( get_home_url() ) . '#tentang" class="nav-link">Tentang</a>';
							echo '<a href="' . esc_url( get_home_url() ) . '#cabang" class="nav-link">Cabang Lomba</a>';
							$arena_page = get_page_by_path( 'arena-dan-lokasi' );
							$arena_url = $arena_page ? get_permalink( $arena_page ) : home_url('/arena-dan-lokasi/');
							$gallery_url = get_post_type_archive_link('mtq_gallery');
							$berita_page = get_page_by_path( 'berita' );
							$berita_url = $berita_page ? get_permalink( $berita_page ) : home_url('/berita/');
							echo '<a href="' . esc_url( $arena_url ) . '" class="nav-link">Arena & Lokasi</a>';
							echo '<a href="' . esc_url( $gallery_url ) . '" class="nav-link">Galeri</a>';
							echo '<a href="' . esc_url( $berita_url ) . '" class="nav-link">Berita</a>';
							echo '<a href="' . esc_url( get_home_url() ) . '#live-stream" class="nav-link text-orange-600 font-bold flex items-center gap-1"><span class="relative flex items-center"><span class="live-dot animate-pulse"></span><svg class="w-4 h-4 ml-1 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="6" fill="currentColor"></circle></svg></span>Live</a>';
						},
						'link_before' => '<span class="nav-link">',
						'link_after' => '</span>',
					]);
					?>
				</div>
			</nav>
		</div>
	</header>

	<div id="content" class="site-content">