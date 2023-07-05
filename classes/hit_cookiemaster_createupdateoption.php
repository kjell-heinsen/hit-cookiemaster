<?php
defined( 'ABSPATH' ) or die( 'No Time for Looking for Freedom' );
if(!class_exists('HIT_COOKIEMASTER_CreateUpdateOption')) {
	class HIT_COOKIEMASTER_CreateUpdateOption {


		public function __construct() {
			$this->init();
		}


		public function init() {
			$optionlist = '';
		//	$optionlist .= '&licence='.$this->AddLicence;
			return $optionlist;
		}

		private function AddLicence()
        {

        }

	}
}