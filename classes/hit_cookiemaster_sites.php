<?php
defined( 'ABSPATH' ) or die( 'No Time for Looking for Freedom' );
if(!class_exists('HIT_COOKIEMASTER_Sites')) {
	class HIT_COOKIEMASTER_Sites {



		public function __construct() {
		}

		public static function startseite() {
	      $myviews = new HIT_COOKIEMASTER_VIEWS();
          $myviews->render( 'startseite' );

		}





	}
}