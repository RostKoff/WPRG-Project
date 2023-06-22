<?php
    require_once('php/classes/user.php');
    class user_dao {
        private $db_resource;

        public function __construct($db_resource) {
            $this->db_resource = $db_resource;
        }
        function add_user($user) {
            try {
                $stmt = $this->db_resource->prepare("
                INSERT INTO users(name, surname, email, password) VALUES (?,?,?,?)
            ");
                $name = $user->get_name();
                $surname = $user->get_surname();
                $email = $user->get_email();
                $password = $user->get_password();
                $stmt->bind_param('ssss', $name, $surname, $email, $password);
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                return false;
            }
            return true;
        }

        function get_user_by_email($email): user|bool {
            $stmt = $this->db_resource->prepare("
                SELECT id, name, surname, email, role, password FROM users WHERE email = ?
            ");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($id, $name, $surname, $email, $role, $password);
            $user = new user();
            return $stmt->fetch() ?
                $user->id($id)->name($name)->surname($surname)->email($email)->role($role)->password($password)
                : false;
        }

        function get_all_users() {
            $result = $this->db_resource->query('SELECT name, surname, email FROM users');
            return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : false;
        }
    }