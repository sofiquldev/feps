<?php

namespace FEPS\Admin;

/**
 * Class FEPS_Settings
 *
 * Handles the settings page for the Front-End Post Submission (FEPS) plugin.
 * Provides options for managing editor types, toolbar visibility, post type selection,
 * and other settings related to FEPS functionality.
 *
 * @package FEPS
 * @since 1.0.0
 */
class FEPS_Settings {

    /**
     * FEPS_Settings constructor.
     *
     * Registers the settings page and settings fields using WordPress hooks.
     * - Registers the settings page under the "Tools" menu.
     * - Initializes and registers settings fields with their corresponding options.
     *
     * @since 1.0.0
     */
    public function __construct() {
        // Hook into WordPress to add a settings page and register settings fields
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    /**
     * Adds the FEPS settings page under the "Tools" menu in the WordPress admin panel.
     *
     * @since 1.0.0
     */
    public function add_settings_page() {
        add_submenu_page(
            'tools.php',  // Parent menu (Tools)
            __('Front-End Post Submission', 'feps'),  // Page title
            __('FEPS Settings', 'feps'),  // Menu title
            'manage_options',  // Capability required to access the page
            'feps-settings',  // Menu slug
            [$this, 'settings_page_html']  // Function to render the settings page
        );
    }

    /**
     * Outputs the HTML for the FEPS settings page.
     * This page includes the settings form and a list of available shortcodes.
     *
     * @since 1.0.0
     */
    public function settings_page_html() {
        ?>
        <div class="wrap">
            <h1><?php _e('FEPS Settings', 'feps'); ?></h1>
            <form method="post" action="options.php">
                <?php
                // Output settings fields and the submit button
                settings_fields('feps_settings'); // Security field for settings
                do_settings_sections('feps-settings'); // Output sections and fields
                submit_button(); // Render submit button
                ?>
            </form>

            <!-- Shortcodes Section -->
            <h2><?php _e('Available Shortcodes', 'feps'); ?></h2>
            <div class="feps-shortcodes-list">
                <?php echo $this->get_shortcodes_list(); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Registers the settings, sections, and fields for the FEPS plugin settings page.
     *
     * @since 1.0.0
     */
    public function register_settings() {
        // Register settings options
        register_setting('feps_settings', 'feps_editor_type');
        register_setting('feps_settings', 'feps_show_toolbar');
        register_setting('feps_settings', 'feps_post_type');
        register_setting('feps_settings', 'feps_thank_you_page');  // Thank you page option
        register_setting('feps_settings', 'feps_post_submitter_role');  // Post submitter role option

        // Add settings section
        add_settings_section(
            'feps_section',  // Section ID
            __('FEPS Options', 'feps'),  // Section title
            null,  // Callback function (null means no description)
            'feps-settings'  // Settings page slug
        );

        // Add settings fields for each option
        add_settings_field(
            'feps_editor_type',
            __('Editor Type', 'feps'),
            [$this, 'editor_type_field'],
            'feps-settings',
            'feps_section'
        );

        add_settings_field(
            'feps_show_toolbar',
            __('Show Toolbar', 'feps'),
            [$this, 'show_toolbar_field'],
            'feps-settings',
            'feps_section'
        );

        add_settings_field(
            'feps_post_type',
            __('Post Type', 'feps'),
            [$this, 'post_type_field'],
            'feps-settings',
            'feps_section'
        );

        // Add field for "Thank You" page selection
        add_settings_field(
            'feps_thank_you_page',
            __('Thank You Page', 'feps'),
            [$this, 'thank_you_page_field'],
            'feps-settings',
            'feps_section'
        );
    }

    /**
     * Outputs the HTML for the editor type field in the settings form.
     * Provides a dropdown to select between Classic Editor and Block Editor.
     *
     * @since 1.0.0
     */
    public function editor_type_field() {
        $value = get_option('feps_editor_type', 'classic');  // Default value is 'classic'
        ?>
        <select name="feps_editor_type">
            <option value="classic" <?php selected($value, 'classic'); ?>>Classic Editor</option>
            <option value="block" <?php selected($value, 'block'); ?>>Block Editor</option>
        </select>
        <?php
    }

    /**
     * Outputs the HTML for the "Show Toolbar" checkbox in the settings form.
     *
     * @since 1.0.0
     */
    public function show_toolbar_field() {
        $checked = get_option('feps_show_toolbar') ? 'checked' : '';  // Check if the option is set
        ?>
        <input type="checkbox" name="feps_show_toolbar" <?php echo $checked; ?> />
        <?php
    }

    /**
     * Outputs the HTML for the post type field in the settings form.
     * Provides a dropdown to select the post type for front-end submissions (e.g., Post or Page).
     *
     * @since 1.0.0
     */
    public function post_type_field() {
        $value = get_option('feps_post_type', 'post');  // Default value is 'post'
        ?>
        <select name="feps_post_type">
            <option value="post" <?php selected($value, 'post'); ?>>Post</option>
            <option value="page" <?php selected($value, 'page'); ?>>Page</option>
        </select>
        <?php
    }

    /**
     * Outputs the HTML for the "Thank You Page" field in the settings form.
     * Provides a dropdown to select a page that users will be redirected to after post submission.
     *
     * @since 1.0.0
     */
    public function thank_you_page_field() {
        $pages = get_pages();  // Get all available pages
        $selected_page = get_option('feps_thank_you_page', '');  // Get the saved value
        echo '<select name="feps_thank_you_page">';
        echo '<option value="">' . __('Select a Thank You Page', 'feps') . '</option>';
        foreach ($pages as $page) {
            echo '<option value="' . esc_attr($page->ID) . '" ' . selected($selected_page, $page->ID, false) . '>' . esc_html($page->post_title) . '</option>';
        }
        echo '</select>';
    }

    /**
     * Generates a list of available shortcodes for use in the plugin.
     * The shortcodes are displayed in the settings page to provide users with easy access to them.
     *
     * @return string The HTML for the list of shortcodes.
     * @since 1.0.0
     */
    public function get_shortcodes_list() {
        // Define available shortcodes and their descriptions
        $shortcodes = [
            '[feps_form]' => __('Front-end post submission form', 'feps'),
            '[feps_viewer]' => __('Display the latest posts submitted via FEPS', 'feps'),
        ];

        // Generate the HTML output for the shortcodes list
        $output = '<ul>';
        foreach ($shortcodes as $shortcode => $description) {
            $output .= '<li><strong>' . esc_html($shortcode) . '</strong>: ' . esc_html($description) . '</li>';
        }
        $output .= '</ul>';

        return $output;
    }
}
