<?php
/**
 * Custom search form template
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>

<form role="search" method="get" class="search-form relative" action="<?php echo esc_url(home_url('/')); ?>">
	<div class="relative flex">
		<label for="search-field-<?php echo uniqid(); ?>" class="sr-only">
			<?php esc_html_e('Cari artikel...', 'mtq-aceh-pidie-jaya'); ?>
		</label>
		
		<input 
			type="search" 
			id="search-field-<?php echo uniqid(); ?>"
			name="s" 
			value="<?php echo esc_attr(get_search_query()); ?>"
			placeholder="<?php esc_attr_e('Cari artikel, berita, informasi...', 'mtq-aceh-pidie-jaya'); ?>"
			class="w-full px-4 py-3 pl-12 pr-16 text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500 transition-all duration-200"
			required
		>
		
		<!-- Search Icon -->
		<div class="absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
			<svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
			</svg>
		</div>
		
		<!-- Submit Button -->
		<button 
			type="submit" 
			class="absolute right-2 top-1/2 transform -translate-y-1/2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
			aria-label="<?php esc_attr_e('Cari', 'mtq-aceh-pidie-jaya'); ?>"
		>
			<span class="hidden sm:inline">
				<?php esc_html_e('Cari', 'mtq-aceh-pidie-jaya'); ?>
			</span>
			<svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
			</svg>
		</button>
	</div>
</form>
