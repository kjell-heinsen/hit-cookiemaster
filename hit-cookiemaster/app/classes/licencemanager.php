<?php

namespace hitcodeblockelementor\app\classes;
defined('ABSPATH') or die('No Time for Looking for Freedom');

    class licencemanager
    {

        public static function Get()
        {

        $cipher = "aes-256-cfb8";
            if (in_array($cipher, openssl_get_cipher_methods())) {
             $return =   openssl_encrypt(self::GetSiteID().'-xxxx',$cipher,self::GetProjectID(),0,self::GetProjectID());
            }

            return $return;
            /*
            $datasrv = HITWPLIB_DIRPATH;
            $url = $datasrv . 'p.id';
            $ID = file_get_contents($url);
            return $ID; */
        }


        public static function Verify():bool
        {


            return true;
        }


        public static function GetSiteID():string{
            $datasrv = HIT_CODEBLOCK_ELEMENTOR_DIRPATH;
            $url = $datasrv . 'site.id';
            $ID = file_get_contents($url);
            return $ID;
        }

        public static function GetProjectID():string
        {
            $datasrv = HIT_CODEBLOCK_ELEMENTOR_DIRPATH;
            $url = $datasrv . 'p.id';
            $ID = file_get_contents($url);
            return $ID;

        }


    }
