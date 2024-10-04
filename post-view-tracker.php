<?php
/**
 * Plugin Name: Complianz Recently Viewed Posts
 * Description: A plugin to track and display recently viewed posts while ensuring GDPR compliance with Complianz.
 */

// Enqueue JavaScript
function crvp_enqueue_scripts() {
    wp_enqueue_script('crvp-tracking-script', plugin_dir_url(__FILE__) . 'tracking.js', array('jquery'), '1.0', true);

    // Localize post data for pages
    if (is_singular()) {
        global $post;
        wp_localize_script('crvp-tracking-script', 'myPost', array(
            'postId' => intval($post->ID),       // Sanitize post ID
            'postType' => sanitize_text_field($post->post_type) // Sanitize post type
        ));
    }
}
add_action('wp_enqueue_scripts', 'crvp_enqueue_scripts');

// Shortcode to display recently viewed posts
function crvp_display_recently_viewed_posts() {
    if (hasConsentForStatisticsOrMarketing()) {
        $viewedPosts = json_decode(stripslashes($_COOKIE['recently_viewed_posts']), true);

        if (!empty($viewedPosts)) {
            // Sanitize post IDs
            $viewedPostsEscaped = array_map('intval', $viewedPosts);
            
            $postQuery = new WP_Query(array(
                'post_type' => 'any', // This will fetch all post types
                'post__in' => $viewedPostsEscaped,
                'orderby' => 'post__in', // Keep order as per viewing
            ));

            if ($postQuery->have_posts()) {
                echo '<ul class="recently-viewed-posts">';
                while ($postQuery->have_posts()) {
                    $postQuery->the_post();
                    get_template_part('content', get_post_type()); // Use appropriate template based on post type
                }
                echo '</ul>';
                wp_reset_postdata();
            } else {
                echo 'No recently viewed posts available.';
            }
        }
    } else {
        echo 'Consent required to display recently viewed posts.';
    }
}
add_shortcode('recently_viewed_posts', 'crvp_display_recently_viewed_posts');

// Function to check if user has consent for statistics or marketing
function hasConsentForStatisticsOrMarketing() {
    return isset($_COOKIE['cmplz_statistics']) && $_COOKIE['cmplz_statistics'] === 'allow';
}
