<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Debug Digger
 *
 * @package           Debug Digger
 * @author            Rafi Ahmed
 * @copyright         2023 Rafi Ahmed
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Debug Digger
 * Plugin URI:        https://github.com/debug-digger
 * Description:       A plugin to speed up development proccess.
 * Version:           1.0.0
 * Requires at least: 5.9
 * Requires PHP:      7.4
 * Author:            Rafi Ahmed
 * Author URI:        https://devrafi.com
 * Text Domain:       debug-digger
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://github.com/debug-digger
 */

 const DD_TEXT_DOMAIN = 'debug-digger';

 // Autoload the plugin classes.
spl_autoload_register(function ($class) {
    $match = 'DebugDigger';
    if (!preg_match("/\b{$match}\b/", $class)) {
        return;
    }

    $path = plugin_dir_path(__FILE__);
    $file = str_replace(
        ['DebugDigger', '\\', '/App/'],
        ['', DIRECTORY_SEPARATOR, 'app/'],
        $class
    );
    require(trailingslashit($path) . trim($file, '/') . '.php');
});

// Boot the application.
 call_user_func(function ($bootstrap) {
	$bootstrap(__FILE__);
}, require(__DIR__ . '/boot/app.php'));