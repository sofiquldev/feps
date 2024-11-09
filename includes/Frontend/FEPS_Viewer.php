<?php

namespace FEPS\Frontend;

use FEPS\Templates\FEPS_LoginTemplate;

/**
 * Class FEPS_Viewer
 *
 * Handles the frontend display of posts submitted by the current user.
 * - Displays a login form if the user is not logged in.
 * - Displays the posts submitted by the current user, with pagination.
 * - Provides links to edit and view the posts.
 *
 * @package FEPS
 * @since 1.0.0
 */
class FEPS_Viewer {

    /**
     * FEPS_Viewer constructor.
     *
     * Registers the `[feps_viewer]` shortcode to render the user's posts.
     * 
     * @since 1.0.0
     */
    public function __construct() {
        // Register the shortcode [feps_viewer] to render the user's posts
        add_shortcode('feps_viewer', [$this, 'render_posts']);
    }

    /**
     * Renders the posts submitted by the current user.
     *
     * - Displays a login form if the user is not logged in.
     * - Displays the posts with a brief preview and options to edit or view.
     * - Includes pagination for navigating through the posts.
     *
     * @return string HTML output of the user's posts or login form.
     * @since 1.0.0
     */
    public function render_posts() {
        // Get the current user's ID
        $current_user_id = get_current_user_id();
        $login_template = new FEPS_LoginTemplate();

        // If the user is not logged in, show the login form
        if ($current_user_id == 0) {
            echo $login_template->render_login_form();
            return;
        }

        // Get the current page number for pagination
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        // Query posts submitted by the current user, with pagination
        $args = [
            'author'         => $current_user_id,  // Filter posts by current user
            'post_status'    => 'any',  // Include all post statuses (e.g., draft, pending, published)
            'posts_per_page' => get_option('posts_per_page', 10),  // Use WordPress option for posts per page (defaults to 10)
            'paged'          => $paged,  // Current page number for pagination
        ];

        // Get the posts based on the query
        $posts = get_posts($args);

        // Check if the user has any posts
        if (empty($posts)) {
            return '<p>' . __('You have no posts yet.', 'feps') . '</p>';
        }

        // Start output buffering to capture the HTML
        ob_start();

        // Loop through the posts and display them
        foreach ($posts as $post) {
            setup_postdata($post);  // Set up post data to use WordPress functions
            ?>
            <div class="feps-post-item">
                <div class="content">
                    <h2><?php echo esc_html($post->post_title); ?></h2>
                    <p><?php echo esc_html(wp_trim_words($post->post_content, 15)); ?></p> <!-- Display a short preview (15 words) -->
                </div>
                <!-- Add links to edit or view the post -->
                <div class="actions">
                     <a href="<?php echo get_edit_post_link($post->ID); ?>"><?php _e('Edit', 'feps'); ?></a> 
                     <a href="<?php echo get_permalink($post->ID); ?>"><?php _e('View', 'feps'); ?></a>
                </div>
            </div>
            <?php
        }

        // Pagination: Display page links if there are more posts
        $pagination = paginate_links([
            'total'        => $GLOBALS['wp_query']->max_num_pages,  // Correct the pagination to use WordPress' global query max pages
            'current'      => $paged,
            'format'       => '?paged=%#%',  // Format of the pagination URL
            'prev_text'    => __('&laquo; Previous', 'feps'),
            'next_text'    => __('Next &raquo;', 'feps'),
        ]);

        // Display pagination if available
        if ($pagination) {
            echo '<div class="pagination">' . $pagination . '</div>';
        }

        // Return the captured output
        return ob_get_clean();
    }

}
