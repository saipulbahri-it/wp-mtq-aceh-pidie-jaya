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

	<!-- Share Modal -->
	<div id="share-modal" class="share-modal">
		<div class="share-content">
			<div class="flex justify-between items-center mb-6">
				<h3 class="text-xl font-bold">Bagikan Website</h3>
				<button id="close-share" class="text-gray-500 hover:text-gray-700">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
					</svg>
				</button>
			</div>
			<div class="grid grid-cols-2 gap-4">
				<button onclick="shareToFacebook()" class="flex items-center gap-3 p-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
					<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
						<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
					</svg>
					Facebook
				</button>
				<button onclick="shareToTwitter()" class="flex items-center gap-3 p-3 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition">
					<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
						<path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path>
					</svg>
					Twitter
				</button>
				<button onclick="shareToWhatsApp()" class="flex items-center gap-3 p-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
					<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
						<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"></path>
					</svg>
					WhatsApp
				</button>
				<button onclick="copyToClipboard()" class="flex items-center gap-3 p-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
					</svg>
					Copy Link
				</button>
			</div>
		</div>
	</div>

	<!-- Header -->
	<header id="main-header" class="fixed top-0 w-full bg-white/90 backdrop-blur-sm border-b border-slate-200/50 z-50 transition-all duration-300">
		<div class="max-w-7xl mx-auto header-padding px-4 py-4">
			<div class="flex justify-between items-center">
				<div class="flex items-center space-x-3">
					<img src="<?php echo get_template_directory_uri(); ?>/prototype/images/logo.png" alt="Logo MTQ Aceh XXXVII" class="logo-img h-16 transition-all duration-300" decoding="async" fetchpriority="high">
					<div class="hidden sm:block">
						<h1 class="text-xl font-bold text-blue-600"><?php bloginfo( 'name' ); ?></h1>
						<p class="text-sm text-slate-600"><?php bloginfo( 'description' ); ?></p>
					</div>
				</div>

				<!-- Desktop Navigation -->
				<nav class="hidden md:flex space-x-2">
					<a href="#beranda" class="nav-link">Beranda</a>
					<a href="#tentang" class="nav-link">Tentang</a>
					<a href="#cabang" class="nav-link">Cabang Lomba</a>
					<a href="<?php echo get_permalink( get_page_by_path( 'lokasi' ) ); ?>" class="nav-link">Arena & Lokasi</a>
					<a href="#jadwal" class="nav-link">Jadwal</a>
					<a href="#berita" class="nav-link">Berita</a>
					<a href="#live" class="nav-link text-orange-600 font-bold flex items-center gap-1">
						<span class="relative flex items-center">
							<span class="live-dot animate-pulse"></span>
							<svg class="w-4 h-4 ml-1 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
								<circle cx="10" cy="10" r="6" fill="currentColor"></circle>
							</svg>
						</span>
						Live
					</a>
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
					<a href="#beranda" class="nav-link">Beranda</a>
					<a href="#tentang" class="nav-link">Tentang</a>
					<a href="#cabang" class="nav-link">Cabang Lomba</a>
					<a href="<?php echo get_permalink( get_page_by_path( 'lokasi' ) ); ?>" class="nav-link">Arena & Lokasi</a>
					<a href="#jadwal" class="nav-link">Jadwal</a>
					<a href="#berita" class="nav-link">Berita</a>
					<a href="#live" class="nav-link text-orange-600 font-bold flex items-center gap-1">
						<span class="relative flex items-center">
							<span class="live-dot animate-pulse"></span>
							<svg class="w-4 h-4 ml-1 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
								<circle cx="10" cy="10" r="6" fill="currentColor"></circle>
							</svg>
						</span>
						Live
					</a>
				</div>
			</nav>
		</div>
	</header>

	<div id="content" class="site-content">