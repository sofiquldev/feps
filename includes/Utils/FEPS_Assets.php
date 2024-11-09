<?php

namespace FEPS\Utils;

/**
 * Class FEPS_Assets
 *
 * Handles the enqueuing of styles and scripts for the FEPS plugin.
 *
 * @package FEPS
 * @since 1.0.0
 */
class FEPS_Assets {

    /**
     * FEPS_Assets constructor.
     *
     * Registers the `wp_enqueue_scripts` action hook to enqueue the plugin's assets.
     *
     * @since 1.0.0
     */
    public function __construct() {
        // Hook into the 'wp_enqueue_scripts' action to enqueue styles and scripts
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    /**
     * Enqueues the necessary styles and scripts for the FEPS plugin.
     *
     * - Enqueues the plugin's custom CSS file.
     * - Optionally enqueues the plugin's JS file (uncomment when needed).
     * - Enqueues WordPress editor styles for consistent styling in editors.
     *
     * @since 1.0.0
     */
    public function enqueue_assets() {
        // Get the correct plugin URL
        $plugin_url = plugin_dir_url(__FILE__);

        // Enqueue the plugin's custom CSS
        wp_enqueue_style('feps-style', $plugin_url . 'assets/style.css');

        // Optionally enqueue JavaScript file for frontend interactions (uncomment when needed)
        // wp_enqueue_script('feps-script', $plugin_url . 'assets/scripts.js', ['jquery'], null, true);

        // Enqueue WordPress editor styles for consistent styling in the editor
        wp_enqueue_script('wp-editor');
        wp_enqueue_style('wp-edit-blocks');
        wp_enqueue_style('wp-block-library');
    }
}
