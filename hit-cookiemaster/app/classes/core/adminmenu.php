<?php

namespace hitcookiemaster\app\classes\core;
use function hitcookiemaster\app\classes\add_menu_page;
use function hitcookiemaster\app\classes\add_submenu_page;

defined('ABSPATH') or die('No Time for Looking for Freedom');

    class adminmenu
    {


        public static function add_menu()
        {

            if (!self::ItemExists('hit_libary', false)) {
                add_menu_page('HIT Libary', 'HIT Libary', 'manage_options', 'hit_libary', 'sites::overview', 'dashicons-plugins-checked', 10000);
            }
            if (!self::ItemExists('hit_libary', true)) {
                add_submenu_page(
                    'hit_libary',               // parent slug
                    'Plugins',                      // page title
                    'Plugins',                      // menu title
                    'manage_options',                   // capability
                    'hit_libary',               // slug
                    'sites::overview' // Funktionsname
                );
            }

            if (!self::ItemExists('hit_libary_settings', true)) {
                add_submenu_page(
                    'hit_libary',               // parent slug
                    'Einstellungen',                // page title
                    'Einstellungen',                // menu title
                    'manage_options',                   // capability
                    'hit_libary_settings',  // slug
                    'sites::settings' // Funktionsname
                );
            }

            if (!self::ItemExists('hit_libary_link', true)) {
                add_submenu_page(
                    'hit_libary',               // parent slug
                    'Account',                // page title
                    'Account',                // menu title
                    'manage_options',                   // capability
                    'hit_libary_link',  // slug
                    'sites::account' // Funktionsname
                );

            }

        }

        public static function CleanupMenu()
        {
            //	remove_submenu_page( 'hit_overview', 'hit_licence');
        }

        private static function ItemExists($handle, $sub = false)
        {
            global $menu, $submenu;
            $check_menu = $sub ? $submenu : $menu;
            if (empty($check_menu)) {
                return false;
            }
            foreach ($check_menu as $k => $item) {
                if ($sub) {
                    foreach ($item as $sm) {
                        if ($handle == $sm[2]) {
                            return true;
                        }
                    }
                } else {
                    if ($handle == $item[2]) {
                        return true;
                    }
                }
            }

            return false;
        }

    }
