<?php 

namespace htmxer;

// add <meta name="htmx-config" content='{"includeIndicatorStyles": false}'>

add_action('wp_head', function (){
    $config = apply_filters('htmxer/config', []);
    // $config['includeIndicatorStyles'] = false;
    
	echo '<meta name="htmx-config" content=\'' . json_encode($config) . '\'>';

});
