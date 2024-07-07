<?php

namespace hitcookiemaster\app\classes\models;

use app\classes\core\model;

class license extends model
{

    private $_table;
    private $_settingfixed;

    public function __construct()
    {
        parent::__construct();
        $this->_table = $this->_db->prefix . 'options';
        global $wpdb;
        $this->_db = $wpdb;
        /* $this->_table = $this->_db->prefix . 'options'; */

        $this->_settingfixed = 'HITSECURITY_lizenz_2983';

    }


    public function SetLicense($key)
    {
        $num = $this->_db->get_var(
            $this->_db->prepare("SELECT option_value FROM $this->_table	WHERE option_name = %s",
                $this->_settingfixed,
            )
        );


        if ($num <> NULL) {
            $update = array(
                'option_value' => $key,
            );
            $format = array('%s');
            $where = array(
                'option_name' => $this->_settingfixed,
            );
            $where_format = array('%s');
            $return = $this->_db->update($this->_table, $update, $where, $format, $where_format);

        } else {
            $insert = array(
                'option_name' => $this->_settingfixed,
                'option_value' => $key,
                'autoload' => 'no'
            );
            $format = array('%s', '%s', '%s');
            $return = $this->_db->insert($this->_table, $insert, $format);
        }
        return $return;
    }


    public function GetLicense()
    {
        $sql = 'SELECT option_value FROM ' . $this->_table . ' WHERE option_name="' . $this->_settingfixed . '"';
        $obj = $this->_db->get_results($sql, $this->_db->OBJECT);

        return $obj->option_value;
    }
}
