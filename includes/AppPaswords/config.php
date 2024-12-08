<?php

namespace htmxer;

use WP_Application_Passwords;

add_action('init', function () {
    //TDD
    if (isset($_GET['web-app-session-id'])) {
        // $pass = get_password_by_app_name($user_id);
        // setcookie('web-app-session-id', '', time() - 3600);
        // exit;
    }

    $user_id = get_current_user_id();
    if (empty($user_id)) {
        return;
    }

    $app_pwd = $_COOKIE['web-app-session-id'] ?? null;

    if (empty($app_pwd)) {
        $session_id = get_session_id($user_id);
        $domain = parse_url(get_site_url(), PHP_URL_HOST);
        setcookie('web-app-session-id', $session_id, strtotime('+1 year'), '/', $domain, true);
    }

});

function get_session_id($user_id)
{
    $pass = get_password_by_app_name($user_id);

    $pass = WP_Application_Passwords::chunk_password($pass);

    $user_login = get_userdata($user_id)->user_login;

    return base64_encode($user_login . ':' . $pass);
}

function get_password_by_app_name($user_id)
{
    $items = WP_Application_Passwords::get_user_application_passwords($user_id);
    foreach ($items as $item) {
        if ($item['name'] === 'web') {
            WP_Application_Passwords::delete_application_password($user_id, $item['uuid']);
        }
    }

    $data = ['name' => 'web'];
    $created = WP_Application_Passwords::create_new_application_password($user_id, wp_slash((array) $data));
    return $created[0] ?? null;
}


add_action('1rest_api_init', function(){

    // if ( wp_is_serving_rest_request() ) {
    //     global $wp;
    //     if('wp-json/app/v1/toolbar' == $wp->request) {
    //         remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );
    //     }

    // }
    
});



add_action('wp_enqueue_scripts', function(){
    $path = 'app.js';
    $url = plugins_url($path, __FILE__);
    $path_absolute = __DIR__ . '/' . $path;
    wp_enqueue_script('app-toolbar', $url, array('htmx'), filemtime($path_absolute), true);
});

