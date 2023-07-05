<?php
/*
Plugin Name: HIT Cookiemaster
Plugin URI: https://kjell-heinsen.de/
Description: Cookiemaster Kjell Heinsen
Author: Kjell Heinsen
Version: 0.0.0
Author URI: https://kjell-heinsen.de/
*/


require_once  'autoload.php';
require_once 'config.php';
$basename = 'hit-cookiemaster';
$project_id = '';






if(DEBUG)
{
    $plugin_updateurl = "https://dev.wpu.heinsen-it.de/";
}
else
{
    $plugin_updateurl = "https://wpu.heinsen-it.de/";
}

$myupdateoptions = new HIT_COOKIEMASTER_CreateUpdateOption();
$plugin_updateoptions = $myupdateoptions->init();


require HITCOOKIEMASTER_LIB.'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    $plugin_updateurl.'updates/'.$basename.'/'.$project_id.'/'.$plugin_updateoptions,
    $plugin_updateurl.'downloads/'.$basename.'/', //Metadata URL.
    __FILE__, //Full path to the main plugin file.
    $basename //Plugin slug. Usually it's the same as the name of the directory.
);