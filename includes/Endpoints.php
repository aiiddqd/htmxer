<?php

function htmxer_url($route)
{
    $route = sanitize_text_field($route);
    return home_url(user_trailingslashit('htmxer/'.ltrim($route, '/')));
}

function htmxer_hook($route)
{
    return 'htmxer/ep/'.esc_url($route);
}

add_action('init', 'add_htmx_endpoint');
function add_htmx_endpoint()
{
    // Add rewrite endpoint for 'htmxer' at the root
    add_rewrite_endpoint('htmxer', EP_ROOT);

    // Optional: Flush rewrite rules to ensure the endpoint is registered
    // Note: This should only run once, e.g., on plugin activation
    // Remove this in production after initial setup to avoid performance issues
    // flush_rewrite_rules();
}

// Add the endpoint to query vars
add_filter('query_vars', 'add_htmx_query_vars');
function add_htmx_query_vars($vars)
{
    $vars[] = 'htmxer';
    return $vars;
}

// Handle the HTMX endpoint request
add_action('template_redirect', 'handle_htmx_endpoint');
function handle_htmx_endpoint()
{
    // Check if this is an HTMX request
    if (get_query_var('htmxer', false) !== false) {
        $route = get_query_var('htmxer');
        $route = esc_html($route);
        $route = esc_attr($route);
        $route = sanitize_text_field($route);

        header('Content-Type: text/html; charset=UTF-8');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');

        try {
            // $user = wp_get_current_user();
            // var_dump($route);
            do_action('htmxer/ep/'.$route);
            http_response_code(200);
        } catch (Exception $e) {
            echo '<p>Произошла ошибка: '.esc_html($e->getMessage()).'</p>';
            http_response_code(500);
        }


        exit;

    }
}

