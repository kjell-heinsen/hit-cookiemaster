<?php


function hit_cookiemaster_autoloader($class)
{
    $myfilename = HITCOOKIEMASTER_CLASSES . strtolower($class) . ".php";

    if (file_exists($myfilename))
    {
        require_once $myfilename;
    }

    $myfilename = HITCOOKIEMASTER_LIB . strtolower($class) . ".php";

    if (file_exists($myfilename))
    {
        require_once $myfilename;
    }

}


spl_autoload_register("hit_cookiemaster_autoloader");
