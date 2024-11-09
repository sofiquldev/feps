<?php

namespace FEPS\Frontend;

use FEPS\Templates\FEPS_LoginTemplate;

/**
 * Class FEPS_Form
 *
 * Handles the front-end post submission form and the processing of form submissions.
 * This class:
 * - Displays a form to logged-in users for submitting posts.
 * - Displays a login form to users who are not logged in.
 * - Processes the form submission and creates a new post in WordPress.
 *
 * @package FEPS
 * @since 1.0.0
 */
class FEPS_Form {

    /**
     * FEPS_Form constructor.
     *
     * Registers the shortcode [feps_form] to render the form and hooks the post submission handling.
     *
     * @since 1.0.0
     */
    public function __construct() {
        // Register the shortcode to display the post submission form
        add_shortcode('feps_form', [$this, 'render_form']);
        
        // Hook into template redirect to handle the post submission process
        add_action('template_redirect', [$this, 'handle_post_submission']);
    }

    /**
     * Renders the front-end form for post submission.
     *
     * - Displays a login form if the user is not logged in.
     * - Displays the post submission form if the user is logged in.
     * - Renders the post editor based on the selected editor type (Classic or Block Editor).
     *
     * @return string The HTML output of the form.
     * @since 1.0.0
     */
    public function render_form() {
        $current_user_id = get_current_user_id();  // Get current user ID
        $login_template = new FEPS_LoginTemplate(); // Initialize the login template class

        // If the user is not logged in, show the login form
        if ($current_user_id == 0) {
            echo $login_template->render_login_form();
            return;
        }

        // Start capturing the form HTML output
        ob_start();
        ?>
        <form method="post">
            <label for="title"><?php _e('Post Title', 'feps'); ?>:</label>
            <input type="text" name="title" required>

            <label for="content"><?php _e('Post Content', 'feps'); ?>:</label>

            <?php
            // Render the post editor based on the selected editor type
            $editor_type = get_option('feps_editor_type', 'classic');  // Get the selected editor type (default: classic)
            if ($editor_type === 'classic') {
                // Render the Classic Editor
                wp_editor('', 'content', [
                    'textarea_name' => 'content',
                    'editor_class'  => 'wp-editor-area',
                    'textarea_rows' => 10,
                    'media_buttons' => true, // Enable media buttons for image uploads
                ]);
            } else {
                // Render the Block Editor (Gutenberg)
                ?>
                <div id="feps-block-editor"></div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const { BlockEditorProvider, Editor } = wp.blockEditor || wp.editor;
                        const { render } = wp.element;

                        let editorContent = '';  // Initial empty content for the editor

                        // Render the Block Editor component into the page
                        render(
                            React.createElement(BlockEditorProvider, {
                                    value: editorContent,
                                    onInput: function(newContent) {
                                        editorContent = newContent;  // Update content when the editor is changed
                                    }
                                },
                                React.createElement(Editor)),
                            document.getElementById('feps-block-editor')
                        );
                    });
                </script>
                <?php
            }
            ?>

            <button type="submit" name="submit_post" style="margin-top: 16px;"><?php _e('Submit Post', 'feps'); ?></button>
        </form>
        <?php
        return ob_get_clean();  // Return the captured HTML
    }

    /**
     * Handles the post submission logic when the form is submitted.
     *
     * - Validates and sanitizes the form inputs (title and content).
     * - Creates a new post with the submitted data.
     * - Redirects the user to a "Thank You" page or the newly created post.
     *
     * @since 1.0.0
     */
    public function handle_post_submission() {
        // Check if the form is submitted and the required fields are available
        if (isset($_POST['submit_post'], $_POST['title'], $_POST['content'])) {
            // Sanitize the form inputs
            $title = sanitize_text_field($_POST['title']);
            $content = wp_kses_post($_POST['content']);  // Allow specific HTML tags in content

            // Prepare the post data
            $post_data = [
                'post_title'   => $title,
                'post_content' => $content,
                'post_status'  => 'publish',  // Set the post status to 'publish'
                'post_author'  => get_current_user_id(),  // Assign the current user as the author
                'post_type'    => get_option('feps_post_type', 'post'),  // Use the configured post type (default: 'post')
            ];

            // Insert the post into WordPress
            $post_id = wp_insert_post($post_data);

            // If the post was successfully created, redirect
            if (!is_wp_error($post_id)) {
                // Get the "Thank You" page URL, if set
                $thank_you_page_id = get_option('feps_thank_you_page', '');
                if ($thank_you_page_id) {
                    // Redirect to the "Thank You" page
                    wp_redirect(get_permalink($thank_you_page_id));
                } else {
                    // Redirect to the newly created post
                    wp_redirect(get_permalink($post_id));
                }
                exit;  // Stop further execution after the redirect
            }
        }
    }
}
