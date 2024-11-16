<?php 
/**
 * Plugin Name:       @ HTMXer
 * Plugin URI:        https://github.com/aiiddqd/htmxer
 * Description:       Add HTMX to WordPress
 * Version:           0.1.0
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       htmxer
 * Domain Path:       /languages
 */


add_action('wp_enqueue_scripts', function(){
    // wp_enqueue_script('htmx', plugins_url('htmx.min.js', __FILE__), [], null);
    wp_enqueue_script('htmx', 'https://unpkg.com/htmx.org@2.0.3', [], '2.0.3');
    wp_script_add_data('htmx', 'integrity', 'sha384-0895/pl2MU10Hqc6jd4RvrthNlDiE9U1tWmX7WRESftEDRosgxNsQG/Ze9YMRzHq');
    wp_enqueue_script('htmx-preload', 'https://unpkg.com/htmx-ext-preload@2.0.1/preload.js', ['htmx']);
});

foreach (glob(__DIR__ . '/includes/*.php') as $file) {
    require_once $file;
}