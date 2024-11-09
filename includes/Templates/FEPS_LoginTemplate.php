<?php
/**
 * FEPS_LoginTemplate Class
 * 
 * Handles the rendering of the login form for front-end users.
 * This class integrates the WordPress login form and allows customization
 * of its appearance and functionality (e.g., adding a Forgot Password link).
 *
 * @package FEPS
 * @subpackage Templates
 * @since 1.0.0
 */

namespace FEPS\Templates;

class FEPS_LoginTemplate {
    private static $form_rendered = false;

    // Outputs the login form
    public function render_login_form() {
        if (self::$form_rendered) {
            return '';  // Do not render the form again
        }

        // Mark the form as rendered
        self::$form_rendered = true;
        ob_start();
        ?>
        <div class="feps-login-form">
            <?php
            // Display the WordPress login form
            wp_login_form([
                'redirect' => get_permalink(), // Redirect back to the current page after login
                'form_id' => 'loginform',      // Custom form ID
                'label_username' => __('Username', 'feps'),
                'label_password' => __('Password', 'feps'),
                'label_remember' => __('Remember Me', 'feps'),
                'label_log_in' => __('Log In', 'feps'),
            ]);

            // Add Forgot Password link
            ?>
            <div class="feps-forgot-password">
                <a href="<?php echo wp_lostpassword_url(); ?>" class="forgot-password-link"><?php _e('Forgot Password?', 'feps'); ?></a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
