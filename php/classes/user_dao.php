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
                $stmt->bind_param('ssss', $user->get_name(), $user->get_surname(), $user->get_email(), $user->get_password());
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                return false;
            }
            return true;
        }

        function get_user_by_email($email): user|bool {
            $stmt = $this->db_resource->prepare("
                SELECT id, name, surname, email, role_id, password FROM users WHERE email = ?
            ");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($id, $name, $surname, $email, $role_id, $password);
            $user = new user();
            return $stmt->fetch() ?
                $user->id($id)->name($name)->surname($surname)->email($email)->role($role_id)->password($password)
                : false;
        }
    }