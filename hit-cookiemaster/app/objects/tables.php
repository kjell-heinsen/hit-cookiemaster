<?php
namespace hitcookiemaster\app\objects;
defined( 'ABSPATH' ) or die( 'No Time for Looking for Freedom' );



    class Tables
    {
        private $_tablelist = array();



        public function Add($key,$table){
            $this->_tablelist[$key] = $table;
        }


        public function Get(){
            return $this->_tablelist;
        }




}