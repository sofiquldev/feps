<?php
/**
 * Plugin Name: Front-end Post Submission
 * Plugin URI: https://sofiquldev.github.io/feps
 * Description: Allows front-end post submission using the Classic Editor or Block Editor.
 * Version: 1.0.0
 * Author: Sofiqul Islam
 * Author URI: https://sofiqul.dev/
 * Text Domain: feps
 * Domain Path: /languages
 * Requires PHP: 7.4
 * Requires at least: 5.0
 * Tested up to: 6.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Autoload dependencies using Composer if available
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

// Register activation and deactivation hooks
register_activation_hook(__FILE__, 'feps_activate');
register_deactivation_hook(__FILE__, 'feps_deactivate');

/**
 * Loads the plugin's text domain for translations
 * 
 * This allows the plugin to be translated using .po and .mo files.
 * Text domain is set to 'feps', and language files are expected
 * to be in the /languages directory.
 */
function feps_load_textdomain() {
    load_plugin_textdomain('feps', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'feps_load_textdomain');

/**
 * Activation callback for the plugin.
 * 
 * This function is called when the plugin is activated. It sets the default options
 * for the plugin, including the default editor type and the post type.
 */
function feps_activate() {
    // Set default options on activation
    add_option('feps_editor_type', 'classic');           // Default editor: Classic Editor
    add_option('feps_show_admin_bar', true);              // Show the admin bar by default
    add_option('feps_post_type', 'post');                 // Default post type: post
}
register_activation_hook(__FILE__, 'feps_activate');

/**
 * Deactivation callback for the plugin.
 * 
 * This function is called when the plugin is deactivated. It deletes the options
 * set during the activation process.
 */
function feps_deactivate() {
    // Delete options on deactivation to clean up
    delete_option('feps_editor_type');
    delete_option('feps_show_admin_bar');
    delete_option('feps_post_type');
}
register_deactivation_hook(__FILE__, 'feps_deactivate');

/**
 * Initialize the plugin.
 * 
 * This is the main entry point for the plugin. It loads the core functionality of the plugin
 * by initializing the main class. The plugin's functionality will be handled by the FEPS_main class.
 */
add_action('plugins_loaded', function() {
    // Initialize the plugin's main functionality
    $plugin = new \FEPS\FEPS_main();
    $plugin->run();
});

