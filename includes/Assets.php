<?php 

namespace htmxer;

Assets::init();

/**
 * @todo - add assets options
 */
class Assets {
    public static function init(){
        add_action('wp_enqueue_scripts', function(){
            // wp_enqueue_script('htmx', plugins_url('htmx.min.js', __FILE__), [], null);
            wp_enqueue_script('htmx', 'https://unpkg.com/htmx.org@2.0.3', [], '2.0.3', true);
            wp_script_add_data('htmx', 'integrity', 'sha384-0895/pl2MU10Hqc6jd4RvrthNlDiE9U1tWmX7WRESftEDRosgxNsQG/Ze9YMRzHq');
        });
        
    }
}