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
		<section class="hero-section">
			<div class="hero-content">
				<h1><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h1>
				<p><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
			</div>
		</section>

		<!-- About Section -->
		<section class="about-section">
			<div class="container">
				<h2>Tentang MTQ Aceh XXXVII - Pidie Jaya 2025</h2>
				<p>MTQ Aceh XXXVII merupakan ajang bergengsi dalam rangka memperingati Hari Lahir Al-Qur'an (HLQ) yang diselenggarakan setiap tahun oleh Pemerintah Provinsi Aceh. MTQ ini bertujuan untuk meningkatkan keimanan dan ketaqwaan umat Islam terhadap Al-Qur'an serta memperkokoh ukhuwah Islamiyah.</p>
			</div>
		</section>

		<!-- Competition Categories Section -->
		<section class="competition-section">
			<div class="container">
				<h2>Cabang Lomba</h2>
				<div class="competition-grid">
					<div class="competition-item">
						<h3>Tilawatil Qur'an</h3>
						<p>Lomba membaca Al-Qur'an dengan tartil</p>
					</div>
					<div class="competition-item">
						<h3>Tahfizh</h3>
						<p>Lomba hafalan Al-Qur'an</p>
					</div>
					<div class="competition-item">
						<h3>Tafsir</h3>
						<p>Lomba penjelasan makna Al-Qur'an</p>
					</div>
				</div>
			</div>
		</section>

		<!-- Schedule Section -->
		<section class="schedule-section">
			<div class="container">
				<h2>Jadwal Kegiatan</h2>
				<p>Jadwal lengkap kegiatan MTQ Aceh XXXVII akan diumumkan secara berkala. Pantau terus halaman ini untuk update terbaru.</p>
			</div>
		</section>

		<!-- News Section -->
		<section class="news-section">
			<div class="container">
				<h2>Berita Terbaru</h2>
				<?php
				// Display latest posts
				$args = array(
					'posts_per_page' => 3,
					'post_status'    => 'publish',
				);
				$latest_posts = new WP_Query( $args );

				if ( $latest_posts->have_posts() ) :
					echo '<div class="news-grid">';
					while ( $latest_posts->have_posts() ) :
						$latest_posts->the_post();
						?>
						<article class="news-item">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="news-meta">
								<span class="news-date"><?php echo get_the_date(); ?></span>
							</div>
							<div class="news-excerpt">
								<?php the_excerpt(); ?>
							</div>
						</article>
						<?php
					endwhile;
					echo '</div>';
					wp_reset_postdata();
				else :
					echo '<p>Belum ada berita tersedia.</p>';
				endif;
				?>
			</div>
		</section>

	</main><!-- #main -->

<?php
get_footer();