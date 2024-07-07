<?php

namespace hitcookiemaster\app\classes\core;
defined('ABSPATH') or die('No Time for Looking for Freedom');
if (!class_exists('app\classes\core\model')) {

    class model
    {
        protected $_db;

        public function __construct()
        {
            global $wpdb;
            $this->_db = $wpdb;
        }

    }
}