<?php
/*
Plugin Name: HIT Cookiemaster
Plugin URI: https://kjell-heinsen.de/
Description: Cookiemaster Kjell Heinsen
Author: Kjell Heinsen
Version: 0.0.0
Author URI: https://kjell-heinsen.de/
*/

define( 'HITCOOKIEMASTER_VERSION', '0.0.0' );
define( 'HITCOOKIEMASTER_MIN_PHP',   '7.4.0' );
define( 'HITCOOKIEMASTER_MIN_WP',    '6.0.0' );
define( 'HITCOOKIEMASTER_TESTED_WP',    '6.2.2' );
define( 'HITCOOKIEMASTER_DIRPATH', plugin_dir_path( __FILE__ ) );
define( 'HITCOOKIEMASTER_LIB', plugin_dir_path( __FILE__ ) . 'lib/' );
define( 'HITCOOKIEMASTER_CLASSES', plugin_dir_path( __FILE__ ) . 'classes/' );




function hit_cookiemaster_autoloader($class)
{
    $myfilename = HITCOOKIEMASTER_CLASSES . strtolower($class) . ".php";

    if (file_exists($myfilename))
    {
        require_once $myfilename;
    }

    $myfilename = HITCOOKIEMASTER_LIB . strtolower($class) . ".php";

    if (file_exists($myfilename))
    {
        require_once $myfilename;
    }

}


spl_autoload_register("hit_cookiemaster_autoloader");





require HITCOOKIEMASTER_LIB.'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://wpu.heinsen-it.de/updates/hit-cookiemaster/info.json',
    __FILE__, //Full path to the main plugin file or functions.php.
    'hit-cookiemaster'
);