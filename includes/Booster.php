<?php

namespace htmxer;

Booster::init();
class Booster
{

    public static $key = 'boost';

    public static function init()
    {
        if (self::is_enabled()) {
            add_filter('blocksy:general:body-attr', function ($attrs) {

                $attrs['hx-boost'] = "true";
                $attrs['hx-ext'] = "preload";

                return $attrs;
            });

            add_filter('nav_menu_link_attributes', function ($attr, $item, $args, $depth) {

                $attr['preload'] = 'mouseover';


                return $attr;
            }, 10, 4);
            add_action('wp_enqueue_scripts', [__CLASS__, 'assets'], 11);
        }

        add_action('admin_init', [__CLASS__, 'add_settings'], 22);
    }


    public static function assets()
    {
        wp_enqueue_script('htmx-preload', 'https://unpkg.com/htmx-ext-preload@2.0.1/preload.js', ['htmx']);
    }

    public static function add_setting_enable()
    {
        add_settings_field(
            self::$key . '_enable',
            __('Enable', 'htmxer'),
            function ($args) {
                printf(
                    '<input type="checkbox" name="%s" value="1" %s>',
                    $args['name'],
                    checked(1, $args['value'], false)
                );
            },
            Settings::$settings_group,
            self::get_section_id(),
            [
                'name' => Settings::get_form_field_name('boost_enable'),
                'value' => Settings::get('boost_enable') ?? null,
            ]
        );
    }

    public static function is_enabled()
    {
        return Settings::get('boost_enable') ? true : false;
    }

    public static function add_settings()
    {
        add_settings_section(
            self::get_section_id(),
            __('Boost', 'htmxer'),
            function () { ?>

                
            <?php
            },
            Settings::$settings_group
        );


        self::add_setting_enable();
        // self::add_setting_id();
        // self::add_setting_secret();
        // self::add_setting_show_button();
    }

    public static function get_section_id()
    {
        return self::$key . '_section';
    }
}
