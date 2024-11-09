<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Only run when the plugin is uninstalled
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete plugin options or any data created by the plugin
delete_option('feps_editor_type');
delete_option('feps_show_admin_bar');
delete_option('feps_post_type');
