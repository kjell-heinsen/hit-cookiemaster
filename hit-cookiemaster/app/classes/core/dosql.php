<?php

namespace hitcookiemaster\app\classes\core;


defined('ABSPATH') or die('No Time for Looking for Freedom');

    class dosql
    {

        public static $counter = 0;
        private $_db;

        private function __construct()
        {
            global $wpdb;
            $this->_db = $wpdb;

        }

        /**
         * @param $error
         * @param $query
         */
        public function log_db_errors($error, $query)
        {
            $message = '<p>Error at ' . date('Y-m-d H:i:s') . ':</p>';
            $message .= '<p>Query: ' . htmlentities($query) . '<br />';
            $message .= 'Error: ' . $error;
            $message .= '</p>';
            if (defined('SEND_ERRORS_TO')) {
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'To: Admin <' . SEND_ERRORS_TO . '>' . "\r\n";
                $headers .= 'From: Yoursite <system@' . $_SERVER['SERVER_NAME'] . '.com>' . "\r\n";
                mail(SEND_ERRORS_TO, 'Database Error', $message, $headers);
            } else {
                trigger_error($message);
            }
            if (!defined('DISPLAY_DEBUG') || (defined('DISPLAY_DEBUG') && DISPLAY_DEBUG)) {
                echo $message;
            }
        }


        /**
         * @param $table_name
         * @return bool
         */
        public function table_exists($table_name)
        {
            $table_name_with_prefix = $this->_db->prefix . $table_name;
            if ($this->_db->get_var("SHOW TABLES LIKE '$table_name_with_prefix'") != $table_name_with_prefix) {
                return false;
            } else {
                return true;
            }
        }

        /**
         * @param $data
         * @return string
         */
        public function clean($data)
        {
            $data = stripslashes($data);
            $data = html_entity_decode($data, ENT_QUOTES, 'UTF-8');
            $data = nl2br($data);
            $data = urldecode($data);
            return $data;
        }

        /**
         * @param string $value
         * @return bool|void
         */
        public function db_common($value = '')
        {
            if (is_array($value)) {
                foreach ($value as $v) {
                    if (preg_match('/AES_DECRYPT/i', $v) || preg_match('/AES_ENCRYPT/i', $v) || preg_match('/now()/i', $v)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                if (preg_match('/AES_DECRYPT/i', $value) || preg_match('/AES_ENCRYPT/i', $value) || preg_match('/now()/i', $value)) {
                    return true;
                }
            }
        }

        /**
         * @param string $table
         * @param string $check_val
         * @param array $params
         * @return bool
         */
        public function exists($table = '', $check_val = '', $params = array())
        {
            self::$counter++;
            if (empty($table) || empty($check_val) || empty($params)) {
                return false;
            }
            $check = array();
            foreach ($params as $field => $value) {
                if (!empty($field) && !empty($value)) {
                    //Check for frequently used mysql commands and prevent encapsulation of them
                    if ($this->db_common($value)) {
                        $check[] = "$field = $value";
                    } else {
                        $check[] = "$field = '$value'";
                    }
                }
            }
            $check = implode(' AND ', $check);
            $rs_check = "SELECT $check_val FROM " . $table . " WHERE $check";
            $number = $this->num_rows($rs_check);
            if ($number === 0) {
                return false;
            } else {
                return true;
            }
        }

        /**
         * @param $query
         * @return mixed
         */
        public function num_rows($query)
        {
            self::$counter++;
            $num_rows = $this->_db->query($query);
            if ($this->_db->error) {
                $this->log_db_errors($this->_db->error, $query);
                return $this->_db->error;
            } else {
                return $num_rows->num_rows;
            }
        }


        /**
         * @param $query
         * @param false $object
         * @return array|false
         */
        public function get_results($query, $object = false)
        {
            self::$counter++;
            //Overwrite the $row var to null
            $row = null;

            $results = $this->_db->query($query);
            if ($this->link->error) {
                $this->log_db_errors($this->link->error, $query);
                return false;
            } else {
                $row = array();
                while ($r = (!$object) ? $results->fetch_assoc() : $results->fetch_object()) {
                    $row[] = $r;
                }
                return $row;
            }
        }


        /**
         * @param $query
         * @param false $object
         * @return false
         */
        public function get_row($query, $object = false)
        {
            self::$counter++;
            $row = $this->_db->query($query);
            if ($this->link->error) {
                $this->log_db_errors($this->_db->error, $query);
                return false;
            } else {
                $r = (!$object) ? $row->fetch_row() : $row->fetch_object();
                return $r;
            }
        }

        /**
         * @param $table
         * @param array $columns
         * @param array $records
         * @return false|int
         */
        public function insert($table, $columns = array(), $records = array())
        {
            self::$counter++;
            //Make sure the arrays aren't empty
            if (empty($columns) || empty($records)) {
                return false;
            }
            //Count the number of fields to ensure insertion statements do not exceed the same num
            $number_columns = count($columns);
            //Start a counter for the rows
            $added = 0;
            //Start the query
            $sql = "INSERT INTO " . $table;
            $fields = array();
            //Loop through the columns for insertion preparation
            foreach ($columns as $field) {
                $fields[] = '`' . $field . '`';
            }
            $fields = ' (' . implode(', ', $fields) . ')';
            //Loop through the records to insert
            $values = array();
            foreach ($records as $record) {
                //Only add a record if the values match the number of columns
                if (count($record) == $number_columns) {
                    $values[] = '(\'' . implode('\', \'', array_values($record)) . '\')';
                    $added++;
                }
            }
            $values = implode(', ', $values);
            $sql .= $fields . ' VALUES ' . $values;
            $query = $this->_db->query($sql);
            if ($this->link->error) {
                $this->log_db_errors($this->_db->error, $sql);
                return false;
            } else {
                return $added;
            }
        }

        /**
         * @param $table
         * @param array $variables
         * @param array $where
         * @param string $limit
         * @return bool
         */
        public function update($table, $variables = array(), $where = array(), $limit = '')
        {
            self::$counter++;
            //Make sure the required data is passed before continuing
            //This does not include the $where variable as (though infrequently)
            //queries are designated to update entire tables
            if (empty($variables)) {
                return false;
            }
            $sql = "UPDATE " . $table . " SET ";
            foreach ($variables as $field => $value) {

                $updates[] = "`$field` = '$value'";
            }
            $sql .= implode(', ', $updates);

            //Add the $where clauses as needed
            if (!empty($where)) {
                foreach ($where as $field => $value) {
                    $value = $value;
                    $clause[] = "$field = '$value'";
                }
                $sql .= ' WHERE ' . implode(' AND ', $clause);
            }

            if (!empty($limit)) {
                $sql .= ' LIMIT ' . $limit;
            }
            $query = $this->_db->query($sql);
            echo $sql;
            if ($this->link->error) {
                $this->log_db_errors($this->_db->error, $sql);
                return false;
            } else {
                return true;
            }
        }

        /**
         * @param $table
         * @param array $where
         * @param string $limit
         * @return bool
         */
        public function delete($table, $where = array(), $limit = '')
        {
            self::$counter++;
            //Delete clauses require a where param, otherwise use "truncate"
            if (empty($where)) {
                return false;
            }

            $sql = "DELETE FROM " . $table;
            foreach ($where as $field => $value) {
                $value = $value;
                $clause[] = "$field = '$value'";
            }
            $sql .= " WHERE " . implode(' AND ', $clause);

            if (!empty($limit)) {
                $sql .= " LIMIT " . $limit;
            }
            echo $sql;
            $query = $this->_db->query($sql);
            if ($this->_db->error) {
                //return false; //
                $this->log_db_errors($this->_db->error, $sql);
                return false;
            } else {
                return true;
            }
        }

        /**
         * @return mixed
         */
        public function lastid()
        {
            self::$counter++;
            return $this->_db->insert_id;
        }

        /**
         * @param $query
         * @return mixed
         */
        public function num_fields($query)
        {
            self::$counter++;
            $query = $this->link->query($query);
            $fields = $query->field_count;
            return $fields;
        }

        /**
         * @param $query
         * @return mixed
         */
        public function list_fields($query)
        {
            self::$counter++;
            $query = $this->_db->query($query);
            $listed_fields = $query->fetch_fields();
            return $listed_fields;
        }

        /**
         * @param array $tables
         * @return int|void
         */
        public function truncate($tables = array())
        {
            if (!empty($tables)) {
                $truncated = 0;
                foreach ($tables as $table) {
                    $truncate = "TRUNCATE TABLE `" . trim($table) . "`";
                    $this->_db->query($truncate);
                    if (!$this->link->error) {
                        $truncated++;
                        self::$counter++;
                    }
                }
                return $truncated;
            }
        }

        /**
         * @param $variable
         * @param bool $echo
         * @return string|void
         */
        public function display($variable, $echo = true)
        {
            $out = '';
            if (!is_array($variable)) {
                $out .= $variable;
            } else {
                $out .= '<pre>';
                $out .= print_r($variable, TRUE);
                $out .= '</pre>';
            }
            if ($echo === true) {
                echo $out;
            } else {
                return $out;
            }
        }

        /**
         * @return int
         */
        public function total_queries()
        {
            return self::$counter;
        }


    }

