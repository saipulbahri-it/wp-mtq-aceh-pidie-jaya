<?php
/**
 * Register dynamic block: Cabang Lomba Grid
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function() {
    $block_dir = get_template_directory() . '/blocks/cabang-grid';
    if (file_exists($block_dir . '/block.json')) {
        register_block_type($block_dir);
    }
});
