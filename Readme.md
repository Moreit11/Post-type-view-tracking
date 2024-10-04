# Recently Viewed Posts tracker + Complianz Integration

## Description
This WordPress plugin tracks and displays recently viewed posts while ensuring GDPR compliance with the Complianz plugin. It securely stores the post IDs in local storage and cookies, allowing users to see their recently viewed posts.

## Author
Moritz Reitz  
Email: [plugins@moritzreitz.com](mailto:plugins@moritzreitz.com)  
GitHub: [Moreit11](https://github.com/Moreit11)

## Features
- Tracks recently viewed posts.
- Complies with GDPR using Complianz for user consent.
- Securely stores post information in local storage and cookies.
- Supports multiple post types.

## Installation
1. Download the plugin files and unzip them.
2. Upload the `complianz-recently-viewed-posts` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Ensure that the Complianz plugin is also installed and configured to manage cookie consent.

## Usage
To display recently viewed posts on your site, use the following shortcode in any post or page:
```
[recently_viewed_posts]
```

## Adding Your Own Post Type
To track and display your own custom post types:
1. Open the `your-plugin.php` file.
2. Locate the `WP_Query` section inside the `crvp_display_recently_viewed_posts` function.
3. Change the `'post_type' => 'any'` line to include your custom post type(s), for example:
   ```php
   'post_type' => array('your_custom_post_type', 'another_post_type')
   ```
4. Save the changes and refresh your site.

## Integration with Other Cookie Tracking Plugins/Services
This plugin checks for user consent using the Complianz plugin. If you are using other cookie consent management plugins or services, you may need to modify the `hasConsentForStatisticsOrMarketing` function to align with their consent checks.

### Example Integration
If using a different plugin, update the consent checking function as follows:
```php
function hasConsentForStatisticsOrMarketing() {
    // Example for a different plugin
    return isset($_COOKIE['another_plugin_cookie']) && $_COOKIE['another_plugin_cookie'] === 'allow';
}
```

## Security Considerations
- The plugin ensures all user data is sanitized and validated.
- Cookies are set with the `Secure`, `HttpOnly`, and `SameSite=Strict` attributes for enhanced security.

## License
This plugin is licensed under the [MIT License](LICENSE).

## Support
For support, please contact: [plugins@moritzreitz.com](mailto:plugins@moritzreitz.com)
