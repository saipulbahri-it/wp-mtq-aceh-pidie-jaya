<?php

/**
 * The front page template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display the front page of the site.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

get_header();
?>

<main id="primary" class="site-main">

	<!-- Hero Section -->
	<section
		id="beranda"
		class="min-h-screen hero-pattern flex items-center justify-center relative overflow-hidden pt-28 md:pt-24 section-animate">
		<!-- Decorative Elements -->
		<div class="absolute inset-0 opacity-20">
			<div
				class="absolute top-20 left-10 w-32 h-32 border border-blue-400/30 rounded-full"></div>
			<div
				class="absolute bottom-20 right-10 w-24 h-24 bg-amber-400/20 rounded-full"></div>
			<div
				class="absolute top-1/2 left-1/4 w-16 h-16 border-2 border-blue-400/40 rotate-45"></div>
		</div>

		<div class="max-w-7xl mx-auto px-4 relative z-10">
			<div class="grid lg:grid-cols-2 gap-12 items-center">
				<!-- Left Content -->
				<div class="text-center lg:text-left fade-in">
					<h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6">
						<span
							class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-400">
							MTQ ACEH XXXVII
						</span>
					</h1>
					<div
						class="w-32 h-1 bg-gradient-to-r from-blue-600 to-transparent mx-auto lg:mx-0 mb-8"></div>
					<h2
						class="text-2xl md:text-3xl lg:text-4xl font-semibold mb-6 text-slate-700">
						PIDIE JAYA 2025
					</h2>

					<div class="glass-card p-6 mb-8">
						<p
							class="text-lg md:text-xl italic leading-relaxed font-semibold"
							style="background: linear-gradient(90deg, #fbbf24 0%, #f59e42 100%);
                       -webkit-background-clip: text;
                       -webkit-text-fill-color: transparent;
                       background-clip: text;
                       text-fill-color: transparent;">
							"Mari Tingkatkan SDM Qur'ani yang Unggul Menuju Aceh Maju Pidie
							Jaya Meusyuhu"
						</p>
					</div>

					<!-- Countdown Timer -->
					<div class="mb-8">
						<h3
							class="text-xl font-semibold mb-6 text-blue-600"
							style="font-family: 'Playfair Display', serif;">
							Hitung Mundur Menuju MTQ
						</h3>
						<div class="countdown-container justify-center lg:justify-start">
							<div class="countdown-item">
								<div class="countdown-number" id="days">000</div>
								<div class="countdown-label">Hari</div>
							</div>
							<div class="countdown-item">
								<div class="countdown-number" id="hours">00</div>
								<div class="countdown-label">Jam</div>
							</div>
							<div class="countdown-item">
								<div class="countdown-number" id="minutes">00</div>
								<div class="countdown-label">Menit</div>
							</div>
							<div class="countdown-item">
								<div class="countdown-number" id="seconds">00</div>
								<div class="countdown-label">Detik</div>
							</div>
						</div>
					</div>

					<!-- CTA Buttons -->
					<div
						class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
						<a
							href="#tentang"
							class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold rounded-full hover:from-blue-500 hover:to-blue-400 transition-all duration-300 transform hover:scale-105">
							Tentang MTQ
						</a>
						<a
							href="#jadwal"
							class="px-8 py-3 border-2 border-blue-600 text-blue-600 font-semibold rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300">
							Lihat Jadwal
						</a>
					</div>
				</div>

				<!-- Right Content - Leadership Photos -->
				<div class="flex justify-center lg:justify-end fade-in">
					<div class="grid md:grid-cols-2 gap-6 max-w-2xl">
						<!-- Gubernur & Wakil Gubernur Aceh -->
						<div class="relative">
							<div class="glass-card p-4">
								<div class="relative overflow-hidden rounded-xl mb-3">
									<img
										src="<?php echo get_template_directory_uri(); ?>/prototype/images/gub-wagub-aceh.png"
										alt="Gubernur dan Wakil Gubernur Aceh"
										class="w-full h-64 object-cover transition-transform duration-500 hover:scale-110 img-zoom-in"
										decoding="async"
										fetchpriority="high" />
									<!-- Corner accent -->
									<div
										class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-bl from-green-500 to-transparent opacity-80"></div>
									<div
										class="absolute bottom-0 left-0 w-12 h-12 bg-gradient-to-tr from-yellow-500 to-transparent opacity-80"></div>
								</div>
								<!-- Card Content -->
								<div class="text-center">
									<h4 class="text-xs font-bold text-slate-800 mb-1">
										<div>H. Muzakir Manaf</div>
										<div>&</div>
										<div>H. Fadhlullah, SE</div>
									</h4>
									<p class="text-green-600 text-xs font-medium mb-1">
										Gubernur & Wakil Gubernur Aceh
									</p>
								</div>
							</div>
							<!-- Background decoration -->
							<div
								class="absolute -top-2 -right-2 w-12 h-12 bg-green-200 opacity-30 rounded-full -z-10"></div>
							<div
								class="absolute -bottom-2 -left-2 w-10 h-10 bg-yellow-200 opacity-30 rounded-full -z-10"></div>
						</div>

						<!-- Bupati & Wakil Bupati Pidie Jaya -->
						<div class="relative">
							<div class="glass-card p-4">
								<div class="relative overflow-hidden rounded-xl mb-3">
									<img
										src="<?php echo get_template_directory_uri(); ?>/prototype/images/bupati-dan-wakil-2025.png"
										alt="Bupati dan Wakil Bupati Pidie Jaya 2025"
										class="w-full h-64 object-cover transition-transform duration-500 hover:scale-110 img-zoom-in"
										loading="lazy"
										decoding="async" />
									<!-- Corner accent -->
									<div
										class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-bl from-blue-500 to-transparent opacity-80"></div>
									<div
										class="absolute bottom-0 left-0 w-12 h-12 bg-gradient-to-tr from-amber-500 to-transparent opacity-80"></div>
								</div>
								<!-- Card Content -->
								<div class="text-center">
									<h4 class="text-xs font-bold text-slate-800 mb-1">
										<div>H. Sibral Malasyi MA, S.Sos, M.E</div>
										<div>&</div>
										<div>Hasan Basri, S.T., M.M.</div>
									</h4>
									<p class="text-blue-600 text-xs font-medium mb-1">
										Bupati & Wakil Bupati Pidie Jaya
									</p>
								</div>
							</div>
							<!-- Background decoration -->
							<div
								class="absolute -top-2 -right-2 w-12 h-12 bg-blue-200 opacity-30 rounded-full -z-10"></div>
							<div
								class="absolute -bottom-2 -left-2 w-10 h-10 bg-amber-200 opacity-30 rounded-full -z-10"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Tentang Section -->
	<section id="tentang" class="py-20 relative section-animate">
		<div class="max-w-6xl mx-auto px-4">
			<div class="text-center mb-16 fade-in">
				<span
					class="inline-block bg-blue-100/80 text-blue-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
					Tentang Event
				</span>
				<h2 class="text-4xl md:text-5xl font-bold mb-6 text-slate-800">
					MTQ Aceh XXXVII
				</h2>
				<div
					class="w-24 h-1 bg-gradient-to-r from-blue-600 to-transparent mx-auto mb-8"></div>
				<p class="text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
					Musabaqah Tilawatil Qur'an tingkat Provinsi Aceh ke-37 - Ajang
					bergengsi untuk mengukir prestasi dalam seni baca Al-Qur'an
				</p>
			</div>

			<div class="grid md:grid-cols-3 gap-8 mb-16">
				<div class="glass-card p-6 fade-in">
					<div
						class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
						<svg
							class="w-6 h-6 text-blue-600"
							fill="currentColor"
							viewBox="0 0 20 20">
							<path
								fill-rule="evenodd"
								d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
								clip-rule="evenodd" />
						</svg>
					</div>
					<h3 class="text-xl font-semibold mb-3 text-blue-600">
						Waktu & Tempat
					</h3>
					<p class="text-slate-600 mb-2">
						<strong>Tanggal:</strong> 1-8 November 2025
					</p>
					<p class="text-slate-600 mb-2">
						<strong>Lokasi:</strong> Kabupaten Pidie Jaya
					</p>
					<p class="text-slate-600"><strong>Durasi:</strong> 8 Hari</p>
				</div>

				<div class="glass-card p-6 fade-in">
					<div
						class="w-12 h-12 bg-blue-400/20 rounded-lg flex items-center justify-center mb-4">
						<svg
							class="w-6 h-6 text-blue-400"
							fill="currentColor"
							viewBox="0 0 20 20">
							<path
								d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
						</svg>
					</div>
					<h3 class="text-xl font-semibold mb-3 text-amber-600">Tujuan</h3>
					<ul class="text-slate-600 space-y-1">
						<li>• Syiar Islam melalui Al-Qur'an</li>
						<li>• Seleksi Qari/Qariah terbaik</li>
						<li>• Mempererat silaturahmi</li>
						<li>• Peningkatan SDM Qur'ani</li>
					</ul>
				</div>

				<div class="glass-card p-6 fade-in">
					<div
						class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
						<svg
							class="w-6 h-6 text-green-600"
							fill="currentColor"
							viewBox="0 0 20 20">
							<path
								d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
						</svg>
					</div>
					<h3 class="text-xl font-semibold mb-3 text-green-600">Peserta</h3>
					<p class="text-slate-600 mb-2">
						<strong>Kafilah:</strong> 23 Kabupaten/Kota
					</p>
					<p class="text-slate-600 mb-2">
						<strong>Total Peserta:</strong> 1.230+ Orang
					</p>
					<p class="text-slate-600">
						<strong>Kategori:</strong> Berbagai Usia
					</p>
				</div>
			</div>
		</div>
	</section>

	<!-- Cabang Lomba Section -->
	<?php get_template_part('template-parts/cabang-lomba'); ?>
	</div>
	</div>
	</section>

	<!-- Lokasi Section -->
	<section id="lokasi" class="py-20 relative section-animate">
		<div class="max-w-6xl mx-auto px-4">
			<div class="text-center mb-16 fade-in">
				<span
					class="inline-block bg-purple-100/80 text-purple-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
					Arena Perlombaan
				</span>
				<h2 class="text-4xl md:text-5xl font-bold mb-6 text-slate-800">
					Arena MTQ Aceh XXXVII
				</h2>
				<div
					class="w-24 h-1 bg-gradient-to-r from-purple-600 to-transparent mx-auto mb-8"></div>
			</div>

			<div class="grid md:grid-cols-2 gap-12 items-center">
				<!-- Info Arena -->
				<div class="fade-in">
					<h3 class="text-3xl font-bold text-slate-800 mb-6">
						Kabupaten Pidie Jaya
					</h3>
					<div class="space-y-6">
						<div class="flex items-start gap-4">
							<div
								class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
								<svg
									class="w-6 h-6 text-blue-600"
									fill="currentColor"
									viewBox="0 0 20 20">
									<path
										fill-rule="evenodd"
										d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
										clip-rule="evenodd" />
								</svg>
							</div>
							<div>
								<h4 class="font-semibold text-slate-800 text-lg">
									Arena Utama
								</h4>
								<p class="text-slate-600">
									Stadion Cot Trieng & Gedung Serbaguna
								</p>
							</div>
						</div>
						<div class="flex items-start gap-4">
							<div
								class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
								<svg
									class="w-6 h-6 text-green-600"
									fill="currentColor"
									viewBox="0 0 20 20">
									<path
										d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
								</svg>
							</div>
							<div>
								<h4 class="font-semibold text-slate-800 text-lg">
									Lokasi Perlombaan
								</h4>
								<p class="text-slate-600">
									Berbagai arena strategis di seluruh kabupaten
								</p>
							</div>
						</div>
						<div class="flex items-start gap-4">
							<div
								class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
								<svg
									class="w-6 h-6 text-amber-600"
									fill="currentColor"
									viewBox="0 0 20 20">
									<path
										fill-rule="evenodd"
										d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
										clip-rule="evenodd" />
								</svg>
							</div>
							<div>
								<h4 class="font-semibold text-slate-800 text-lg">
									Fasilitas
								</h4>
								<p class="text-slate-600">
									Akomodasi, transportasi, dan fasilitas pendukung
								</p>
							</div>
						</div>
					</div>
				</div>
				<!-- Google Maps -->
				<div class="glass-card p-6 fade-in mt-8">
					<iframe
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.4252051038724!2d96.206!3d5.148!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNcKwMDgnNTIuOCJOIDk2wrAxMicyLjgiRQ!5e0!3m2!1sen!2sid!4v1620000000000"
						width="100%"
						height="300"
						class="border-0 rounded-lg"
						allowfullscreen=""
						loading="lazy"></iframe>
					<p class="text-center text-slate-600 mt-4 text-sm">
						Peta Lokasi Kabupaten Pidie Jaya
					</p>
				</div>
			</div>
		</div>
	</section>

	<!-- Berita Section -->
	<section id="berita" class="py-20 relative section-animate">
		<div class="max-w-6xl mx-auto px-4">
			<div class="text-center mb-16 fade-in">
				<span
					class="inline-block bg-orange-100/80 text-orange-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
					Update Terbaru
				</span>
				<h2 class="text-4xl md:text-5xl font-bold mb-6 text-slate-800">
					Berita & Pengumuman
				</h2>
				<div
					class="w-24 h-1 bg-gradient-to-r from-orange-600 to-transparent mx-auto mb-8"></div>
			</div>

			<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php
				// Display latest posts
				$args = array(
					'posts_per_page' => 3,
					'post_status'    => 'publish',
				);
				$latest_posts = new WP_Query($args);

				if ($latest_posts->have_posts()) :
					while ($latest_posts->have_posts()) :
						$latest_posts->the_post();
				?>
						<article class="glass-card overflow-hidden fade-in hover:scale-105 transition-transform duration-300">
							<!-- Thumbnail -->
							<?php if (has_post_thumbnail()) : ?>
								<div class="h-48 overflow-hidden">
									<?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-300')); ?>
								</div>
							<?php else : ?>
								<div
									class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
									<svg
										class="w-16 h-16 text-white opacity-80"
										fill="none"
										stroke="currentColor"
										viewBox="0 0 24 24">
										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											stroke-width="1.5"
											d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
										<path d="m15 5 4 4" />
									</svg>
								</div>
							<?php endif; ?>
							<div class="p-6">
								<div class="flex items-center gap-2 mb-3">
									<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
										<?php echo get_the_category_list(', '); ?>
									</span>
									<span class="text-slate-500 text-sm"><?php echo get_the_date(); ?></span>
								</div>
								<h3 class="text-lg font-bold text-slate-800 mb-3">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<p class="text-slate-600 text-sm leading-relaxed mb-4">
									<?php echo wp_trim_words(get_the_excerpt(), 20); ?>
								</p>
								<a
									href="<?php the_permalink(); ?>"
									class="text-blue-600 hover:text-blue-700 text-sm font-medium">Baca Selengkapnya →</a>
							</div>
						</article>
					<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<div class="col-span-3 text-center py-12">
						<p class="text-xl text-slate-600">Belum ada berita tersedia.</p>
					</div>
				<?php
				endif;
				?>
			</div>

			<div class="text-center mt-12 fade-in">
				<a
					href="<?php echo get_permalink(get_option('page_for_posts')); ?>"
					class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-full font-medium transition-colors transform hover:scale-105">
					<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
						<path
							fill-rule="evenodd"
							d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z"
							clip-rule="evenodd" />
					</svg>
					Lihat Semua Berita
				</a>
			</div>
		</div>
	</section>


	<!-- Live Section -->
	<section
		id="live"
		class="py-20 bg-gradient-to-br from-yellow-50 to-orange-50 section-animate relative">
		<div class="max-w-6xl mx-auto px-4">
			<div class="text-center mb-10 fade-in">
				<span
					class="inline-block bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
					Live Streaming
				</span>
				<h2 class="text-3xl md:text-4xl font-bold mb-4 text-slate-800">
					Saksikan MTQ Aceh XXXVII Secara Langsung
				</h2>
				<p class="text-slate-600 mb-6">
					Ikuti siaran langsung pelaksanaan MTQ Aceh XXXVII di Pidie Jaya
					melalui kanal YouTube berikut.
				</p>
			</div>
			<div
				class="w-full aspect-w-16 aspect-h-9 rounded-xl overflow-hidden fade-in relative">
				<iframe
					src="https://www.youtube.com/embed/2Gub8-cSH9c"
					title="Live MTQ Aceh XXXVII"
					frameborder="0"
					allow="autoplay; encrypted-media"
					allowfullscreen
					class="w-full h-full min-h-[320px] md:min-h-[480px] rounded-xl"
					loading="lazy"></iframe>
				<!-- Tombol Fullscreen Overlay -->
				<button
					id="open-video-overlay"
					class="absolute bottom-4 right-4 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-full shadow-lg flex items-center gap-2 transition"
					style="z-index:2"
					aria-label="Tampilkan Layar Penuh">
					<svg
						class="w-5 h-5"
						fill="none"
						stroke="currentColor"
						stroke-width="2"
						viewBox="0 0 24 24">
						<path
							stroke-linecap="round"
							stroke-linejoin="round"
							d="M8 3H5a2 2 0 0 0-2 2v3m0 8v3a2 2 0 0 0 2 2h3m8-16h3a2 2 0 0 1 2 2v3m0 8v3a2 2 0 0 1-2 2h-3" />
					</svg>
					Fullscreen
				</button>
			</div>
		</div>

		<!-- Overlay Video Fullscreen -->
		<div
			id="video-overlay"
			class="fixed inset-0 bg-black/90 flex items-center justify-center z-[9999] hidden">
			<button
				id="close-video-overlay"
				class="absolute top-6 right-8 text-white bg-black/40 hover:bg-black/70 rounded-full p-3 transition"
				aria-label="Tutup Video"
				style="z-index:10001">
				<svg
					class="w-7 h-7"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
					viewBox="0 0 24 24">
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M6 18L18 6M6 6l12 12" />
				</svg>
			</button>
			<div class="w-full max-w-6xl aspect-w-16 aspect-h-9">
				<iframe
					src="https://www.youtube.com/embed/2Gub8-cSH9c?autoplay=1"
					title="Live MTQ Aceh XXXVII"
					frameborder="0"
					allow="autoplay; encrypted-media"
					allowfullscreen
					class="w-full h-full rounded-lg shadow-2xl"
					loading="lazy"></iframe>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();
