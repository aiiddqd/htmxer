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

use WP_REST_Request;

require_once __DIR__ . '/includes/Settings.php';

foreach (glob(__DIR__ . '/includes/*.php') as $file) {
    require_once $file;
}

foreach (glob(__DIR__ . '/includes/*/config.php') as $file) {
    require_once $file;
}

add_action('rest_api_init', function () {

    global $wp;

    //hack to fix authentication
    if (wp_is_serving_rest_request()) {
        if (strpos($wp->request, 'wp-json/htmxer/v1/') === 0) {
            remove_filter('rest_authentication_errors', 'rest_cookie_check_errors', 100);
        }
    }

    // /wp-json/app/v1/toolbar
    register_rest_route('htmxer', '/v1/(?P<template>[a-zA-Z0-9\-_]+)', [
        'methods' => 'GET',
        'callback' => function (WP_REST_Request $request) {
            $value = $request->get_param( 'template' );

            header('Content-Type: text/html');

            /**
             * Example
             * url https://example.site/wp-json/htmxer/v1/some_template
             * hook add_action('htmxer_action_some_template', 'callback');
             */
            do_action('htmxer_action_' . $value, $request);
            exit;
        },
        'permission_callback' => '__return_true',
    ]);
});