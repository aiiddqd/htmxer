<?php 

add_filter('blocksy:general:body-attr', function ($attrs) {

    $attrs['hx-boost'] = "true";
    $attrs['hx-ext'] = "preload";
    
    return $attrs;
});

add_filter('nav_menu_link_attributes', function($attr, $item, $args, $depth){

    $attr['preload'] = 'mouseover';


    return $attr;
}, 10, 4);