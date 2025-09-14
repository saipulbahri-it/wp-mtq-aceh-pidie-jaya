<?php
// CLI helper to print first post URL and title
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("CLI only.\n");
}

require_once dirname(__DIR__) . '/wp-load.php';

$posts = get_posts(['numberposts' => 1]);
if (!empty($posts)) {
    echo get_permalink($posts[0]->ID) . "\n";
    echo $posts[0]->post_title . "\n";
}

