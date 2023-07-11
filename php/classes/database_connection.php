<?php
    class database_connection {
        private static $host = 'localhost';
        private static $username = 'root';
        private static $password = 'toor';
        private static $dbname = 'WPRG_Project';

        private $connection_resource;

        private static $instance;
        private function __construct() {}
        private function __clone() {}
        private function connect() {
            try {
                $this->connection_resource = new mysqli(self::$host, self::$username, self::$password, self::$dbname);
            } catch(mysqli_sql_exception $e) {
                return false;
            }
            return true;
        }

        public static function get_instance() {
            if (is_null(self::$instance)) {
                self::$instance = new database_connection();
                if(!self::$instance->connect()) {
                    return false;
                }
            }
            return self::$instance;
        }

        public function get_resource() {
            return $this->connection_resource;
        }
    }