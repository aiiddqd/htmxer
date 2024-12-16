<?php
/**
 * Plugin Name:       @ HTMXer
 * Plugin URI:        https://github.com/aiiddqd/htmxer
 * Description:       Add HTMX to WordPress
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       htmxer
 * Domain Path:       /languages
 * Version:           0.1.241216
 */

use WP_REST_Request, WP_REST_Server;

require_once __DIR__ . '/includes/Settings.php';

foreach (glob(__DIR__ . '/includes/*.php') as $file) {
    require_once $file;
}

foreach (glob(__DIR__ . '/includes/*/config.php') as $file) {
    require_once $file;
}

/**
 * Example
 * url https://example.site/wp-json/htmxer/some_template
 * hook add_action('htmxer/some_template', 'callback');
 */
function htmxer_actions(WP_REST_Request $request)
{
    $hook = $request->get_param('hook');
    $context = $request->get_header('context') ?? [];
    if ($context) {
        $context = json_decode($context, true);
    } else {
        $context = [];
    }

    header('Content-Type: text/html');
    do_action('htmxer/' . $hook, $context, $request);
    exit;
}

add_action('rest_api_init', function () {

    global $wp;

    //hack to fix authentication
    if (wp_is_serving_rest_request()) {
        if (strpos($wp->request, 'wp-json/htmxer/') === 0) {
            remove_filter('rest_authentication_errors', 'rest_cookie_check_errors', 100);
        }
    }

    register_rest_route('htmxer', '/(?P<hook>[a-zA-Z0-9\-_]+)', [
        'methods' => WP_REST_Server::ALLMETHODS,
        'callback' => 'htmxer_actions',
        'permission_callback' => '__return_true',
    ]);
});

add_action('wp_footer', function () {
    $context = apply_filters('htmxer/context', []);
    if (empty($context)) {
        return;
    }
    ?>
    <script>
        document.body.addEventListener('htmx:configRequest', function (event) {
            event.detail.headers['context'] = '<?= json_encode($context) ?>';
        });
    </script>

    <?php
}, 555);