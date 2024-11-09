<?php

namespace FEPS\Utils;

/**
 * Class FEPS_RoleManager
 *
 * Manages role-based restrictions, toolbar visibility, and dashboard access for users.
 *
 * @package FEPS
 * @since 1.0.0
 */
class FEPS_RoleManager {

    /**
     * FEPS_RoleManager constructor.
     *
     * Initializes the hooks to manage role-based restrictions and toolbar settings.
     *
     * @since 1.0.0
     */
    public function __construct() {
        // Restrict posts on frontend to the current user
        add_action('pre_get_posts', [$this, 'feps_restrict_posts_to_user']);

        // Apply toolbar visibility setting
        add_action('init', [$this, 'apply_toolbar_setting']);

        // Restrict access to the Dashboard
        add_action('admin_init', [$this, 'restrict_dashboard_access']);
    }
    

    /**
     * Restrict posts to only the current user for all queries on the front-end.
     * This restricts the posts in archive, home, and single views to only the logged-in user.
     *
     * @param \WP_Query $query The WordPress query object.
     * @since 1.0.0
     */
    public function feps_restrict_posts_to_user($query)
    {
        if (!is_admin() && $query->is_main_query()) {
            // Restrict posts to logged-in user on the front-end
            if (is_home() || is_archive() || is_single()) {
                $current_user_id = get_current_user_id();
                if ($current_user_id != 0) {
                    // Restrict the query to the current user's posts
                    $query->set('author', $current_user_id);
                }
            }
        }
    }

    /**
     * Apply the "Show Toolbar" setting to control visibility based on user roles.
     * Disables the WordPress admin bar for users who are not administrators or editors.
     *
     * @since 1.0.0
     */
    public function apply_toolbar_setting()
    {
        // Get the toolbar visibility option (it should return a boolean)
        $show_toolbar = get_option('feps_show_toolbar', true);

        if (!$show_toolbar) {
            // Disable the admin toolbar for users who are not administrators or editors
            if (!current_user_can('administrator') && !current_user_can('editor')) {
                add_filter('show_admin_bar', '__return_false');
            }
        }
    }

    /**
     * Restrict access to the Dashboard for non-admins and non-editors.
     * Redirects non-admin users to the homepage if they attempt to access the admin dashboard.
     *
     * @since 1.0.0
     */
    public function restrict_dashboard_access()
    {
        // Get the toolbar visibility setting
        $show_toolbar = get_option('feps_show_toolbar', true);

        // If the toolbar is disabled, restrict Dashboard access
        if (!$show_toolbar) {
            // Check if the current user is not an administrator or editor
            if (is_admin() && !current_user_can('administrator') && !current_user_can('editor')) {
                // Redirect to the homepage
                wp_redirect(home_url());
                exit;
            }
        }
    }
}
