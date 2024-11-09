# Front-end Post Submission Plugin

[![Version](https://img.shields.io/github/v/tag/sofiquldev/feps?label=version)](https://github.com/sofiquldev/feps/releases)
[![License](https://img.shields.io/github/license/sofiquldev/feps)](https://opensource.org/licenses/GPL-2.0)
[![WordPress Plugin](https://img.shields.io/wordpress/plugin/v/feps)](https://wordpress.org/plugins/feps)

A WordPress plugin that allows front-end post submissions using either the **Classic Editor** or **Block Editor**. This plugin enables users to submit posts from the front-end, without needing access to the WordPress admin panel.

## Features

- **Front-end Post Submission**: Users can submit posts from the front-end of the site.
- **Editor Options**: Supports both the Classic Editor and the Block Editor (Gutenberg).
- **Customizable Settings**: Configure editor type, post type, and toolbar visibility.
- **Shortcodes**: Includes shortcodes to display the submission form (`[feps_form]`) and view submitted posts (`[feps_viewer]`).
- **Thank You Page**: Redirect users to a custom "Thank You" page after successful submission.

## Installation

1. **Download** the plugin from GitHub or the WordPress plugin repository.
2. **Upload** the plugin files to the `/wp-content/plugins/feps` directory.
3. **Activate** the plugin through the 'Plugins' menu in WordPress.
4. **Configure** the plugin settings via the 'FEPS Settings' page under the 'Tools' menu in the WordPress dashboard.

## Usage

### Shortcodes
- `[feps_form]` - Display the front-end post submission form.
- `[feps_viewer]` - Display posts submitted via the FEPS plugin.

### Settings
Configure the following settings through the plugin's settings page:
- **Editor Type**: Choose between the Classic Editor or Block Editor.
- **Show Toolbar**: Decide whether to display the WordPress admin toolbar on the front-end.
- **Post Type**: Set whether submissions are saved as posts or pages.
- **Thank You Page**: Redirect users to a custom page after post submission.

## Changelog

### 1.0.0
- Initial release of the Front-end Post Submission Plugin.
- Added support for Classic and Block Editor submission forms.
- Includes settings for post type, toolbar visibility, and thank you page.

## License

This plugin is licensed under the **GPL-2.0** License. You can freely modify and redistribute it, as long as you follow the license terms.

- **License**: [GPL-2.0](https://www.gnu.org/licenses/gpl-2.0.html)

## Translations

This plugin is translation-ready. You can contribute translations through tools like **Poedit** or **Loco Translate**.

The `.pot` file is available in the `/languages` directory for creating translation files (`.po` and `.mo`).

## Contributing

Contributions are welcome! If you'd like to contribute to this project, please fork the repository and create a pull request with your changes. Make sure to follow the [WordPress coding standards](https://developer.wordpress.org/coding-standards/).

## Contact

- **Author**: [Sofiqul Islam](https://sofiquldev.github.io/feps)
- **Email**: [sofiquldev@gmail.com](mailto:sofiquldev@gmail.com)

---

Thank you for using the **Front-end Post Submission Plugin**! If you have any questions or need support, feel free to contact me.
