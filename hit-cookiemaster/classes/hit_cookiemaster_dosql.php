<?php
defined( 'ABSPATH' ) or die( 'No Time for Looking for Freedom' );
if(!class_exists('HIT_COOKIEMASTER_DoSql')) {


class HIT_COOKIEMASTER_DoSql {

	private function __construct() {

	}

	public function DoSomething()
    {
        global $wpdb;
        $myrows = $wpdb->get_results( "SELECT id, name FROM mytable" );
    }


}

}