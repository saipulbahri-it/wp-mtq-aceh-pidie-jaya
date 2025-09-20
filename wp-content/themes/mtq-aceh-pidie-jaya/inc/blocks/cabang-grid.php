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
    $block_uri = get_template_directory_uri() . '/blocks/cabang-grid';

    if (file_exists($block_dir . '/block.json') && function_exists('register_block_type')) {
        // Register editor script handle with deps referenced by block.json
        wp_register_script(
            'mtq-cabang-grid-editor',
            $block_uri . '/index.js',
            array('wp-blocks', 'wp-element', 'wp-i18n', 'wp-editor', 'wp-components', 'wp-block-editor', 'wp-server-side-render'),
            defined('_S_VERSION') ? _S_VERSION : '1.0.0',
            true
        );
        // Register from metadata and override render_callback to support callable or string
        register_block_type($block_dir, array(
            'editor_script' => 'mtq-cabang-grid-editor',
            'render_callback' => function($attributes = array(), $content = '', $block = null) use ($block_dir) {
                $attributes = wp_parse_args($attributes, array('columns' => 3, 'gap' => 'gap-6'));
                $result = include $block_dir . '/render.php';
                if (is_callable($result)) {
                    return call_user_func($result, $attributes, $content, $block);
                }
                // If render.php returns string markup, just return it
                if (is_string($result)) {
                    return $result;
                }
                return '';
            },
        ));
        return;
    }

    // Fallback: manual registration (older WP or metadata issue)
    if (function_exists('register_block_type')) {
        // Register editor script with proper deps
        wp_register_script(
            'mtq-cabang-grid-editor',
            $block_uri . '/index.js',
            array('wp-blocks', 'wp-element', 'wp-i18n', 'wp-editor', 'wp-components', 'wp-block-editor', 'wp-server-side-render'),
            defined('_S_VERSION') ? _S_VERSION : '1.0.0',
            true
        );

        register_block_type('mtq/cabang-grid', array(
            'api_version'    => 2,
            'editor_script'  => 'mtq-cabang-grid-editor',
            'attributes'     => array(
                'columns' => array('type' => 'number', 'default' => 3),
                'gap'     => array('type' => 'string', 'default' => 'gap-6'),
            ),
            'render_callback' => function($attributes = array(), $content = '', $block = null) use ($block_dir) {
                $attributes = wp_parse_args($attributes, array('columns' => 3, 'gap' => 'gap-6'));
                $cb = include $block_dir . '/render.php';
                if (is_callable($cb)) {
                    return call_user_func($cb, $attributes, $content, $block);
                }
                return '';
            },
        ));
    }
});
