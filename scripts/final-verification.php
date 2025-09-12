<?php
/**
 * Final verification of categories, tags and post assignments
 */

require_once dirname(__FILE__) . '/../wp-config.php';
require_once dirname(__FILE__) . '/../wp-load.php';

echo "=== FINAL VERIFICATION: Categories, Tags & Post Assignments ===\n\n";

// 1. List all categories
echo "📂 CATEGORIES:\n";
$categories = get_categories(['hide_empty' => false]);
foreach ($categories as $cat) {
    $post_count = wp_count_posts();//get_category($cat->term_id);
    echo sprintf(
        "  • %s (ID: %d, Slug: %s) - %d posts\n",
        $cat->name,
        $cat->term_id,
        $cat->slug,
        $cat->count
    );
}

// 2. List all tags
echo "\n🏷️  TAGS:\n";
$tags = get_tags(['hide_empty' => false]);
if (empty($tags)) {
    echo "  No tags found\n";
} else {
    foreach ($tags as $tag) {
        echo sprintf(
            "  • %s (ID: %d, Slug: %s) - %d posts\n",
            $tag->name,
            $tag->term_id,
            $tag->slug,
            $tag->count
        );
    }
}

// 3. Check recent posts with their categories and tags
echo "\n📰 RECENT POSTS WITH CATEGORIES & TAGS:\n";
$posts = get_posts(['numberposts' => 10, 'post_status' => 'publish']);

foreach ($posts as $post) {
    echo "  📄 {$post->post_title}\n";
    
    // Get categories
    $post_categories = get_the_category($post->ID);
    if (!empty($post_categories)) {
        $cat_names = array_map(function($cat) { return $cat->name; }, $post_categories);
        echo "     Categories: " . implode(', ', $cat_names) . "\n";
    } else {
        echo "     Categories: None\n";
    }
    
    // Get tags
    $post_tags = get_the_tags($post->ID);
    if (!empty($post_tags)) {
        $tag_names = array_map(function($tag) { return $tag->name; }, $post_tags);
        echo "     Tags: " . implode(', ', $tag_names) . "\n";
    } else {
        echo "     Tags: None\n";
    }
    
    echo "\n";
}

// 4. Summary
echo "📊 SUMMARY:\n";
echo "  Total Categories: " . count($categories) . "\n";
echo "  Total Tags: " . count($tags) . "\n";
echo "  Total Posts: " . count($posts) . "\n";

// 5. Category distribution
echo "\n📈 CATEGORY DISTRIBUTION:\n";
foreach ($categories as $cat) {
    if ($cat->count > 0) {
        echo "  {$cat->name}: {$cat->count} posts\n";
    }
}

echo "\n✅ Verification completed!\n";
?>
