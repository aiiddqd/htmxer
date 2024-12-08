<?php 
/**
 * Plugin Name:       @ HTMXer
 * Plugin URI:        https://github.com/aiiddqd/htmxer
 * Description:       Add HTMX to WordPress
 * Version:           0.1.241208
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       htmxer
 * Domain Path:       /languages
 */



require_once __DIR__ . '/includes/Settings.php';

foreach (glob(__DIR__ . '/includes/*.php') as $file) {
    require_once $file;
}