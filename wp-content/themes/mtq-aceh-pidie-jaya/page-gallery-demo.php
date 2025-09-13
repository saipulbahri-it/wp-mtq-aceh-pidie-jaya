<?php
/**
 * Demo Page Gallery MTQ Aceh Pidie Jaya
 * Halaman untuk demo berbagai shortcode gallery
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

get_header(); ?>

<main class="container mx-auto px-4 py-8">
    
    <!-- Header -->
    <header class="text-center mb-12">
        <h1 class="text-4xl font-bold text-slate-800 mb-4">Demo Gallery MTQ Aceh Pidie Jaya</h1>
        <p class="text-lg text-slate-600 max-w-3xl mx-auto">
            Halaman demo untuk menampilkan berbagai fitur dan layout gallery system MTQ Aceh Pidie Jaya. 
            Lihat berbagai contoh shortcode dan layout yang tersedia.
        </p>
    </header>
    
    <!-- Quick Navigation -->
    <nav class="mb-12 p-6 bg-slate-50 rounded-lg">
        <h2 class="text-xl font-semibold text-slate-800 mb-4">📋 Navigasi Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="#gallery-list" class="flex items-center p-3 bg-white rounded shadow hover:shadow-md transition-shadow">
                <span class="text-2xl mr-2">📚</span>
                <span class="text-sm font-medium">Gallery List</span>
            </a>
            <a href="#single-gallery" class="flex items-center p-3 bg-white rounded shadow hover:shadow-md transition-shadow">
                <span class="text-2xl mr-2">🖼️</span>
                <span class="text-sm font-medium">Single Gallery</span>
            </a>
            <a href="#layouts" class="flex items-center p-3 bg-white rounded shadow hover:shadow-md transition-shadow">
                <span class="text-2xl mr-2">🎨</span>
                <span class="text-sm font-medium">Layouts</span>
            </a>
            <a href="#shortcodes" class="flex items-center p-3 bg-white rounded shadow hover:shadow-md transition-shadow">
                <span class="text-2xl mr-2">⚡</span>
                <span class="text-sm font-medium">Shortcodes</span>
            </a>
        </div>
    </nav>
    
    <!-- Section 1: Gallery List -->
    <section id="gallery-list" class="mb-16">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-800 mb-4">📚 Gallery List - Semua Gallery</h2>
            <p class="text-slate-600 mb-4">
                Menampilkan daftar semua gallery dalam format card layout dengan thumbnail, metadata, dan link ke halaman detail.
            </p>
            <div class="bg-slate-100 p-4 rounded-lg font-mono text-sm mb-6">
                [mtq_gallery_list limit="6" columns="3"]
            </div>
        </div>
        
        <?php echo do_shortcode('[mtq_gallery_list limit="6" columns="3"]'); ?>
    </section>
    
    <!-- Section 2: Gallery by Category -->
    <section id="category-gallery" class="mb-16">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-800 mb-4">📁 Gallery by Category</h2>
            <p class="text-slate-600 mb-4">
                Menampilkan gallery berdasarkan kategori tertentu. Contoh: gallery kategori "Lomba Dewasa".
            </p>
            <div class="bg-slate-100 p-4 rounded-lg font-mono text-sm mb-6">
                [mtq_gallery_list category="lomba-dewasa" limit="4" columns="2"]
            </div>
        </div>
        
        <?php echo do_shortcode('[mtq_gallery_list category="lomba-dewasa" limit="4" columns="2"]'); ?>
    </section>
    
    <!-- Section 3: Single Gallery Examples -->
    <section id="single-gallery" class="mb-16">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-800 mb-4">🖼️ Single Gallery Display</h2>
            <p class="text-slate-600 mb-4">
                Menampilkan isi dari gallery tertentu dengan berbagai layout dan konfigurasi.
            </p>
        </div>
        
        <!-- Get first gallery for demo -->
        <?php 
        $demo_galleries = get_posts(array(
            'post_type' => 'mtq_gallery',
            'posts_per_page' => 3,
            'post_status' => 'publish'
        ));
        ?>
        
        <?php if (!empty($demo_galleries)) : ?>
            
            <!-- Grid Layout -->
            <div class="mb-12">
                <h3 class="text-2xl font-semibold text-slate-800 mb-4">🎯 Grid Layout (Default)</h3>
                <div class="bg-slate-100 p-4 rounded-lg font-mono text-sm mb-6">
                    [mtq_gallery id="<?php echo $demo_galleries[0]->ID; ?>" layout="grid" columns="3"]
                </div>
                <?php echo do_shortcode('[mtq_gallery id="' . $demo_galleries[0]->ID . '" layout="grid" columns="3"]'); ?>
            </div>
            
            <?php if (count($demo_galleries) > 1) : ?>
            <!-- Slider Layout -->
            <div class="mb-12">
                <h3 class="text-2xl font-semibold text-slate-800 mb-4">🎠 Slider Layout</h3>
                <div class="bg-slate-100 p-4 rounded-lg font-mono text-sm mb-6">
                    [mtq_gallery id="<?php echo $demo_galleries[1]->ID; ?>" layout="slider"]
                </div>
                <?php echo do_shortcode('[mtq_gallery id="' . $demo_galleries[1]->ID . '" layout="slider"]'); ?>
            </div>
            <?php endif; ?>
            
            <?php if (count($demo_galleries) > 2) : ?>
            <!-- 4 Columns Grid -->
            <div class="mb-12">
                <h3 class="text-2xl font-semibold text-slate-800 mb-4">🏗️ 4 Columns Grid</h3>
                <div class="bg-slate-100 p-4 rounded-lg font-mono text-sm mb-6">
                    [mtq_gallery id="<?php echo $demo_galleries[2]->ID; ?>" layout="grid" columns="4"]
                </div>
                <?php echo do_shortcode('[mtq_gallery id="' . $demo_galleries[2]->ID . '" layout="grid" columns="4"]'); ?>
            </div>
            <?php endif; ?>
            
        <?php else : ?>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                <h3 class="text-lg font-semibold text-yellow-800 mb-2">⚠️ Belum Ada Gallery</h3>
                <p class="text-yellow-700 mb-4">
                    Untuk melihat demo gallery, silakan buat dummy data terlebih dahulu.
                </p>
                <a href="<?php echo get_template_directory_uri(); ?>/create-dummy-gallery.php" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                    🚀 Generate Dummy Data
                </a>
            </div>
        <?php endif; ?>
    </section>
    
    <!-- Section 4: Layout Variations -->
    <section id="layouts" class="mb-16">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-800 mb-4">🎨 Layout Variations</h2>
            <p class="text-slate-600 mb-4">
                Berbagai variasi layout dan konfigurasi yang tersedia dalam sistem gallery.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Compact List -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold text-slate-800 mb-3">📱 Compact List</h3>
                <div class="bg-slate-100 p-3 rounded font-mono text-xs mb-4">
                    [mtq_gallery_list limit="4" columns="1" show_excerpt="no"]
                </div>
                <p class="text-sm text-slate-600">Layout list kompak tanpa excerpt, cocok untuk sidebar atau space terbatas.</p>
            </div>
            
            <!-- Grid 2 Columns -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold text-slate-800 mb-3">📐 Grid 2 Columns</h3>
                <div class="bg-slate-100 p-3 rounded font-mono text-xs mb-4">
                    [mtq_gallery_list limit="4" columns="2"]
                </div>
                <p class="text-sm text-slate-600">Layout grid 2 kolom, ideal untuk tablet dan desktop kecil.</p>
            </div>
            
            <!-- Category Specific -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold text-slate-800 mb-3">🎯 Category Specific</h3>
                <div class="bg-slate-100 p-3 rounded font-mono text-xs mb-4">
                    [mtq_gallery category="pembukaan-mtq"]
                </div>
                <p class="text-sm text-slate-600">Menampilkan gallery dari kategori tertentu saja.</p>
            </div>
            
            <!-- No Lightbox -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold text-slate-800 mb-3">🔍 No Lightbox</h3>
                <div class="bg-slate-100 p-3 rounded font-mono text-xs mb-4">
                    [mtq_gallery id="123" enable_lightbox="no"]
                </div>
                <p class="text-sm text-slate-600">Gallery tanpa lightbox effect, gambar tidak bisa di-zoom.</p>
            </div>
            
            <!-- No Captions -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold text-slate-800 mb-3">🏷️ No Captions</h3>
                <div class="bg-slate-100 p-3 rounded font-mono text-xs mb-4">
                    [mtq_gallery id="123" show_captions="no"]
                </div>
                <p class="text-sm text-slate-600">Gallery tanpa caption, fokus pada visual saja.</p>
            </div>
            
            <!-- 5 Columns -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold text-slate-800 mb-3">🏗️ 5 Columns Grid</h3>
                <div class="bg-slate-100 p-3 rounded font-mono text-xs mb-4">
                    [mtq_gallery id="123" columns="5"]
                </div>
                <p class="text-sm text-slate-600">Grid dengan 5 kolom untuk desktop besar, memuat lebih banyak gambar.</p>
            </div>
            
        </div>
    </section>
    
    <!-- Section 5: Shortcode Reference -->
    <section id="shortcodes" class="mb-16">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-800 mb-4">⚡ Shortcode Reference</h2>
            <p class="text-slate-600 mb-4">
                Panduan lengkap penggunaan shortcode gallery MTQ dengan semua parameter yang tersedia.
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- mtq_gallery Shortcode -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-slate-800 mb-4">🖼️ [mtq_gallery]</h3>
                
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-slate-700 mb-2">Basic Usage:</h4>
                        <div class="bg-slate-100 p-3 rounded font-mono text-sm">
                            [mtq_gallery id="123"]
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-slate-700 mb-2">With Parameters:</h4>
                        <div class="bg-slate-100 p-3 rounded font-mono text-sm">
                            [mtq_gallery id="123" layout="grid" columns="3" show_captions="yes" enable_lightbox="yes"]
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-slate-700 mb-2">By Category:</h4>
                        <div class="bg-slate-100 p-3 rounded font-mono text-sm">
                            [mtq_gallery category="lomba-dewasa" limit="8"]
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-slate-700 mb-2">Parameters:</h4>
                        <ul class="text-sm text-slate-600 space-y-1">
                            <li><strong>id:</strong> Gallery ID (required jika tidak ada category/tag)</li>
                            <li><strong>layout:</strong> grid, slider, masonry</li>
                            <li><strong>columns:</strong> 3, 4, 5</li>
                            <li><strong>show_captions:</strong> yes, no</li>
                            <li><strong>enable_lightbox:</strong> yes, no</li>
                            <li><strong>category:</strong> category slug</li>
                            <li><strong>tag:</strong> tag slug</li>
                            <li><strong>limit:</strong> number limit</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- mtq_gallery_list Shortcode -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-slate-800 mb-4">📚 [mtq_gallery_list]</h3>
                
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-slate-700 mb-2">Basic Usage:</h4>
                        <div class="bg-slate-100 p-3 rounded font-mono text-sm">
                            [mtq_gallery_list]
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-slate-700 mb-2">With Parameters:</h4>
                        <div class="bg-slate-100 p-3 rounded font-mono text-sm">
                            [mtq_gallery_list limit="6" columns="3" show_excerpt="yes"]
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-slate-700 mb-2">Filtered:</h4>
                        <div class="bg-slate-100 p-3 rounded font-mono text-sm">
                            [mtq_gallery_list category="lomba-dewasa" tag="tilawah"]
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-slate-700 mb-2">Parameters:</h4>
                        <ul class="text-sm text-slate-600 space-y-1">
                            <li><strong>limit:</strong> Number of galleries (default: 12)</li>
                            <li><strong>columns:</strong> 1, 2, 3, 4 (default: 3)</li>
                            <li><strong>category:</strong> Filter by category slug</li>
                            <li><strong>tag:</strong> Filter by tag slug</li>
                            <li><strong>show_excerpt:</strong> yes, no (default: yes)</li>
                            <li><strong>show_meta:</strong> yes, no (default: yes)</li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    
    <!-- Section 6: Implementation Examples -->
    <section id="implementation" class="mb-16">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-800 mb-4">💡 Implementation Examples</h2>
            <p class="text-slate-600 mb-4">
                Contoh implementasi shortcode dalam berbagai skenario penggunaan.
            </p>
        </div>
        
        <div class="space-y-8">
            
            <!-- Homepage -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-slate-800 mb-3">🏠 Homepage - Featured Galleries</h3>
                <p class="text-slate-600 mb-4">Menampilkan highlight gallery di homepage:</p>
                <div class="bg-white p-4 rounded font-mono text-sm">
                    [mtq_gallery_list limit="6" columns="3" show_excerpt="no"]
                </div>
            </div>
            
            <!-- Event Page -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-slate-800 mb-3">🎪 Event Page - Category Specific</h3>
                <p class="text-slate-600 mb-4">Gallery khusus untuk halaman event tertentu:</p>
                <div class="bg-white p-4 rounded font-mono text-sm">
                    [mtq_gallery category="pembukaan-mtq" layout="slider"]<br>
                    [mtq_gallery category="lomba-dewasa" layout="grid" columns="4"]
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-slate-800 mb-3">📝 Sidebar - Recent Galleries</h3>
                <p class="text-slate-600 mb-4">Gallery compact untuk sidebar:</p>
                <div class="bg-white p-4 rounded font-mono text-sm">
                    [mtq_gallery_list limit="4" columns="1" show_excerpt="no" show_meta="no"]
                </div>
            </div>
            
            <!-- Archive Page -->
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-slate-800 mb-3">📋 Archive Page - All Galleries</h3>
                <p class="text-slate-600 mb-4">Halaman archive dengan pagination:</p>
                <div class="bg-white p-4 rounded font-mono text-sm">
                    [mtq_gallery_list limit="12" columns="4"]
                </div>
            </div>
            
        </div>
    </section>
    
    <!-- Section 7: Admin Links -->
    <section id="admin" class="mb-16">
        <div class="bg-slate-800 text-white p-8 rounded-lg">
            <h2 class="text-2xl font-bold mb-4">🛠️ Admin & Management</h2>
            <p class="text-slate-300 mb-6">
                Link-link penting untuk pengelolaan gallery system.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="<?php echo admin_url('edit.php?post_type=mtq_gallery'); ?>" 
                   class="flex items-center p-4 bg-slate-700 rounded-lg hover:bg-slate-600 transition-colors">
                    <span class="text-2xl mr-3">📁</span>
                    <div>
                        <div class="font-semibold">All Galleries</div>
                        <div class="text-sm text-slate-400">Manage galleries</div>
                    </div>
                </a>
                
                <a href="<?php echo admin_url('post-new.php?post_type=mtq_gallery'); ?>" 
                   class="flex items-center p-4 bg-slate-700 rounded-lg hover:bg-slate-600 transition-colors">
                    <span class="text-2xl mr-3">➕</span>
                    <div>
                        <div class="font-semibold">Add Gallery</div>
                        <div class="text-sm text-slate-400">Create new gallery</div>
                    </div>
                </a>
                
                <a href="<?php echo admin_url('edit-tags.php?taxonomy=mtq_gallery_category&post_type=mtq_gallery'); ?>" 
                   class="flex items-center p-4 bg-slate-700 rounded-lg hover:bg-slate-600 transition-colors">
                    <span class="text-2xl mr-3">🏷️</span>
                    <div>
                        <div class="font-semibold">Categories</div>
                        <div class="text-sm text-slate-400">Manage categories</div>
                    </div>
                </a>
                
                <a href="<?php echo get_template_directory_uri(); ?>/create-dummy-gallery.php" 
                   class="flex items-center p-4 bg-blue-600 rounded-lg hover:bg-blue-500 transition-colors">
                    <span class="text-2xl mr-3">🚀</span>
                    <div>
                        <div class="font-semibold">Dummy Data</div>
                        <div class="text-sm text-blue-200">Generate test data</div>
                    </div>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Footer Info -->
    <footer class="text-center py-8 border-t border-slate-200">
        <p class="text-slate-600 mb-2">
            <strong>MTQ Gallery System v1.0</strong> - Dokumentasi & Demo
        </p>
        <p class="text-sm text-slate-500">
            Sistem gallery lengkap untuk dokumentasi MTQ Aceh Pidie Jaya
        </p>
    </footer>
    
</main>

<?php get_footer(); ?>
