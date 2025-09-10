<?php
require_once 'wp-config.php';

$posts = get_posts(['numberposts' => 1]);
if (!empty($posts)) {
    echo get_permalink($posts[0]->ID) . "\n";
    echo $posts[0]->post_title . "\n";
}
?>
