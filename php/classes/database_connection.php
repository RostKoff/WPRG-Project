<?php
    class database_connection {
        private static $host = 'localhost';
        private static $username = 'root';
        private static $password = 'toor';
        private static $dbname = 'WPRG_Project';

        private static $connection_resource;

        private static $instance;
        private function __constructor() {}
        private static function connect() {
            try {
                $connection_resource = new mysqli(self::$host, self::$username, self::$password, self::$dbname);
            } catch(mysqli_sql_exception $e) {
                return false;
            }
            return true;
        }
        private function __clone() {}

        static function getInstance() {
            if (is_null(self::$instance)) {
                self::$instance = new database_connection();
                if(!self::$instance->connect()) {
                    return false;
                }
            }
            return self::$instance;
        }
    }