<?php
defined( 'ABSPATH' ) or die( 'No Time for Looking for Freedom' );
if(!class_exists('HIT_SUPPORT_AdminMenu')) {
	class HIT_COOKIEMASTER_AdminMenu {


		public static function add_cookiemaster_menu() {

			if ( ! HIT_COOKIEMASTER_AdminMenu::ItemExists( 'hit_overview', false ) ) {
				add_menu_page( 'HIT Plugins', 'HIT Plugins', 'manage_options', 'hit_overview', 'HIT_COOKIEMASTER_Sites::startseite', 'dashicons-plugins-checked', 60000 );
			}
			if ( ! HIT_COOKIEMASTER_AdminMenu::ItemExists( 'hit_overview', true ) ) {
				add_submenu_page(
					'hit_overview',               // parent slug
					'Cookiemaster',                      // page title
					'Cookiemaster',                      // menu title
					'manage_options',                   // capability
					'hit_overview',               // slug
					'HIT_SUPPORT_Sites::cookiemaster' // Funktionsname
				);
			}
		}

		public static function CleanupMenu()
		{
			remove_submenu_page( 'hit_overview');
		}

		private static function ItemExists( $handle, $sub = false ) {
			global $menu, $submenu;
			$check_menu = $sub ? $submenu : $menu;
			if ( empty( $check_menu ) ) {
				return false;
			}
			foreach ( $check_menu as $k => $item ) {
				if ( $sub ) {
					foreach ( $item as $sm ) {
						if ( $handle == $sm[2] ) {
							return true;
						}
					}
				} else {
					if ( $handle == $item[2] ) {
						return true;
					}
				}
			}

			return false;
		}

	}
}