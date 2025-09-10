<?php
/**
 * Social Media Analytics Dashboard Widget
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

/**
 * Add Social Media Analytics Dashboard Widget
 */
function mtq_add_social_analytics_dashboard_widget() {
    wp_add_dashboard_widget(
        'mtq_social_analytics_dashboard',
        'Social Media Sharing Analytics',
        'mtq_social_analytics_dashboard_content'
    );
}
add_action('wp_dashboard_setup', 'mtq_add_social_analytics_dashboard_widget');

/**
 * Social Media Analytics Dashboard Widget Content
 */
function mtq_social_analytics_dashboard_content() {
    // Get overall statistics
    $total_posts = wp_count_posts()->publish;
    $posts_with_shares = mtq_get_posts_with_social_shares();
    $engagement_rate = $total_posts > 0 ? round(($posts_with_shares / $total_posts) * 100, 1) : 0;
    
    // Get today's stats
    $today_stats = mtq_get_daily_social_stats();
    $today_total = array_sum($today_stats);
    
    // Get top shared posts (last 30 days)
    $top_posts = mtq_get_top_shared_posts(5);
    
    // Get trending platforms (last 7 days)
    $platform_trends = mtq_get_platform_trends();
    
    echo '<div class="mtq-social-dashboard">';
    
    // Summary Cards
    echo '<div class="mtq-summary-cards" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">';
    
    // Total Shares Today
    echo '<div class="summary-card" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 20px; border-radius: 12px; text-align: center; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);">';
    echo '<div style="font-size: 28px; font-weight: bold; margin-bottom: 5px;">' . $today_total . '</div>';
    echo '<div style="font-size: 14px; opacity: 0.9;">Shares Today</div>';
    echo '</div>';
    
    // Engagement Rate
    echo '<div class="summary-card" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 20px; border-radius: 12px; text-align: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">';
    echo '<div style="font-size: 28px; font-weight: bold; margin-bottom: 5px;">' . $engagement_rate . '%</div>';
    echo '<div style="font-size: 14px; opacity: 0.9;">Posts Shared</div>';
    echo '</div>';
    
    // Active Posts
    echo '<div class="summary-card" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 20px; border-radius: 12px; text-align: center; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);">';
    echo '<div style="font-size: 28px; font-weight: bold; margin-bottom: 5px;">' . $posts_with_shares . '</div>';
    echo '<div style="font-size: 14px; opacity: 0.9;">Active Posts</div>';
    echo '</div>';
    
    echo '</div>';
    
    // Main Content Grid
    echo '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">';
    
    // Top Shared Posts
    echo '<div class="top-posts">';
    echo '<h3 style="margin-top: 0; color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">🏆 Top Shared Posts</h3>';
    
    if (!empty($top_posts)) {
        echo '<div style="space-y: 10px;">';
        foreach ($top_posts as $index => $post_data) {
            $post = get_post($post_data['post_id']);
            if ($post) {
                $rank_colors = ['#ffd700', '#c0c0c0', '#cd7f32', '#4f46e5', '#059669'];
                $rank_color = $rank_colors[$index] ?? '#6b7280';
                
                echo '<div style="display: flex; align-items: center; padding: 12px; background: #f9fafb; border-radius: 8px; border-left: 4px solid ' . $rank_color . ';">';
                echo '<div style="background: ' . $rank_color . '; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; margin-right: 12px;">' . ($index + 1) . '</div>';
                echo '<div style="flex: 1; min-width: 0;">';
                echo '<div style="font-weight: 600; color: #1f2937; font-size: 14px; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . esc_html($post->post_title) . '</div>';
                echo '<div style="color: #6b7280; font-size: 12px;">' . $post_data['total_shares'] . ' shares • ' . date('M j', strtotime($post->post_date)) . '</div>';
                echo '</div>';
                echo '<a href="' . get_edit_post_link($post->ID) . '" style="color: #3b82f6; text-decoration: none; font-size: 12px;">Edit</a>';
                echo '</div>';
            }
        }
        echo '</div>';
    } else {
        echo '<p style="color: #6b7280; font-style: italic;">No shared posts yet. Start creating engaging content!</p>';
    }
    
    echo '</div>';
    
    // Platform Performance
    echo '<div class="platform-trends">';
    echo '<h3 style="margin-top: 0; color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">📊 Platform Performance</h3>';
    
    if (!empty($platform_trends)) {
        $platform_icons = [
            'Facebook' => '📘',
            'Twitter' => '🐦',
            'WhatsApp' => '💬',
            'Telegram' => '✈️',
            'LinkedIn' => '💼',
            'Pinterest' => '📌',
            'Email' => '📧',
            'Copy_Link' => '🔗'
        ];
        
        $max_shares = max($platform_trends);
        
        foreach ($platform_trends as $platform => $shares) {
            if ($shares > 0) {
                $percentage = $max_shares > 0 ? ($shares / $max_shares) * 100 : 0;
                $icon = $platform_icons[$platform] ?? '📱';
                
                echo '<div style="margin-bottom: 15px;">';
                echo '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">';
                echo '<span style="font-weight: 500; color: #374151; font-size: 14px;">' . $icon . ' ' . $platform . '</span>';
                echo '<span style="font-weight: 600; color: #1f2937; font-size: 14px;">' . $shares . '</span>';
                echo '</div>';
                echo '<div style="background: #e5e7eb; height: 8px; border-radius: 4px; overflow: hidden;">';
                echo '<div style="background: linear-gradient(90deg, #3b82f6, #1d4ed8); height: 100%; width: ' . $percentage . '%; border-radius: 4px; transition: width 0.3s ease;"></div>';
                echo '</div>';
                echo '</div>';
            }
        }
    } else {
        echo '<p style="color: #6b7280; font-style: italic;">No platform data available yet.</p>';
    }
    
    echo '</div>';
    
    echo '</div>'; // End main content grid
    
    // Quick Actions
    echo '<div style="margin-top: 20px; padding: 15px; background: #f3f4f6; border-radius: 8px;">';
    echo '<h4 style="margin-top: 0; color: #1f2937;">⚡ Quick Actions</h4>';
    echo '<div style="display: flex; flex-wrap: wrap; gap: 10px;">';
    echo '<a href="' . admin_url('edit.php') . '" class="button">View All Posts</a>';
    echo '<a href="' . admin_url('post-new.php') . '" class="button button-primary">Create New Post</a>';
    echo '<a href="' . admin_url('widgets.php') . '" class="button">Manage Widgets</a>';
    echo '</div>';
    echo '</div>';
    
    echo '</div>'; // End mtq-social-dashboard
}

/**
 * Get number of posts that have social shares
 */
function mtq_get_posts_with_social_shares() {
    global $wpdb;
    
    $count = $wpdb->get_var("
        SELECT COUNT(DISTINCT post_id) 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = '_social_shares_count' 
        AND meta_value > 0
    ");
    
    return intval($count);
}

/**
 * Get top shared posts
 */
function mtq_get_top_shared_posts($limit = 5) {
    global $wpdb;
    
    $results = $wpdb->get_results($wpdb->prepare("
        SELECT post_id, meta_value as total_shares
        FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        WHERE pm.meta_key = '_social_shares_count' 
        AND pm.meta_value > 0
        AND p.post_status = 'publish'
        AND p.post_type = 'post'
        ORDER BY CAST(pm.meta_value AS UNSIGNED) DESC
        LIMIT %d
    ", $limit), ARRAY_A);
    
    return $results;
}

/**
 * Get platform trends (last 7 days)
 */
function mtq_get_platform_trends($days = 7) {
    $trends = array(
        'Facebook' => 0,
        'Twitter' => 0,
        'WhatsApp' => 0,
        'Telegram' => 0,
        'LinkedIn' => 0,
        'Pinterest' => 0,
        'Email' => 0,
        'Copy_Link' => 0
    );
    
    for ($i = 0; $i < $days; $i++) {
        $date = date('Y-m-d', strtotime("-{$i} days"));
        $daily_stats = mtq_get_daily_social_stats($date);
        
        foreach ($daily_stats as $platform => $count) {
            if (isset($trends[$platform])) {
                $trends[$platform] += $count;
            }
        }
    }
    
    // Sort by count descending
    arsort($trends);
    
    return $trends;
}
