<?php 

namespace htmxer;

add_action('wp_head', function (){
    $config = apply_filters('htmxer/config', []);
    ?>
	<meta name="htmx-config" content="<?= json_encode($config) ?>">
    <?php 
});

Settings::init();

class Settings {

    public static $settings_group = 'htmxer';

    public static $option_key = 'htmxer_config';

    public static function init(){
        add_action('admin_init', function(){
            register_setting( self::$settings_group, self::$option_key ); 
        }, 5);
        
        add_action('admin_menu', function() {
            add_options_page(
                $page_title = 'HTMX',
                $menu_title = 'HTMX',
                $capability = 'administrator',
                $menu_slug = 'htmxer',
                $callback = [__CLASS__, 'render_settings']
            );
        }, 5);
    }

    public static function get_settings_group(){
        return self::$settings_group;
    }

    public static function get_option_key(){
        return self::$option_key;
    }

    public static function get_form_field_name($key){
        return sprintf('%s[%s]', self::$option_key, $key);
    }
    
    public static function get($key = null){
        if(empty($key)){
            return get_option(self::$option_key) ?? [];
        } else {
            return get_option(self::$option_key)[$key] ?? null;
        }
    }

    /**
     * Add settings
     */
    public static function render_settings(){
        ?>
        <div class="wrap">
            <h1><?= __('HTMX', 'htmxer') ?></h1>

            <form method="post" action="options.php">
                <?php settings_fields( self::$settings_group ); ?>
                <?php do_settings_sections( self::$settings_group ); ?>
                <?php submit_button(); ?>

            </form>
        </div>
        <?php
    }

}
