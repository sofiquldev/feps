<?php

namespace FEPS;

/**
 * Class FEPS_main
 *
 * Main class for initializing and running the FEPS plugin functionality.
 * This class is responsible for loading all the necessary components, including admin settings,
 * front-end form, viewer, utility classes, and templates.
 *
 * @package FEPS
 * @since 1.0.0
 */
class FEPS_main {

    /**
     * FEPS_main constructor.
     *
     * The constructor can handle any setup tasks for the plugin if needed.
     * Currently, no specific initialization is required here, but this method is available
     * for any future setup.
     *
     * @since 1.0.0
     */
    public function __construct() {
        // Constructor can handle any setup if needed in the future
    }

    /**
     * Runs the main functionality of the FEPS plugin.
     *
     * This method is responsible for initializing all necessary components of the plugin.
     * It checks whether the request is from the admin area or the front end, and initializes
     * the appropriate functionality accordingly.
     * 
     * - Initializes admin-specific functionality (FEPS_Settings).
     * - Initializes front-end components (FEPS_Form and FEPS_Viewer).
     * - Initializes utility classes (FEPS_Assets).
     * - Initializes template classes (FEPS_LoginTemplate).
     *
     * @since 1.0.0
     */
    public function run() {
        // Check if the current request is for the admin area
        if (is_admin()) {
            // Initialize the admin settings page
            new \FEPS\Admin\FEPS_Settings();
        }

        // Initialize the front-end components: form and viewer
        new \FEPS\Frontend\FEPS_Form();   // Handles the front-end post submission form
        new \FEPS\Frontend\FEPS_Viewer(); // Displays the posts submitted via FEPS

        // Initialize utility classes: handling assets, and any other utilities (e.g., role manager)
        new \FEPS\Utils\FEPS_Assets();  // Manages plugin assets like CSS, JS, etc.
        // new \FEPS\Utils\RoleManager(); // Uncomment if the role manager is needed

        // Initialize template classes: handles login form template rendering
        new \FEPS\Templates\FEPS_LoginTemplate();  // Manages the login form template
    }
}
