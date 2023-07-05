<?php
defined( 'ABSPATH' ) or die( 'No Time for Looking for Freedom' );
if(!class_exists('HIT_COOKIEMASTER_Tables')) {


    class HIT_COOKIEMASTER_Tables
    {
        private $_tablelist = array();



        public function Add($key,$table){
            $this->_tablelist[$key] = $table;
        }


        public function Get(){
            return $this->_tablelist;
        }

    }


}