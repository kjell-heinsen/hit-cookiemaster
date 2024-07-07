<?php

namespace hitcookiemaster\app\classes\core;


defined('ABSPATH') or die('No Time for Looking for Freedom');
    class sites
    {


        public function __construct()
        {
        }

        public static function startseite()
        {
            $myviews = new views();
            $myviews->render('startseite');

        }

        public static function overview()
        {
            $myviews = new views();
            $myviews->render('test');

        }

        public static function settings()
        {
            $myviews = new views();
            $myviews->render('test');

        }

        public static function accounts()
        {
            $myviews = new views();
            $myviews->render('test');

        }
    }
