<?php
    require_once('php/classes/user.php');
    require_once('php/classes/db_dao.php');
    class user_dao extends db_dao {

        protected static function get_by_id_query() {
            return 'SELECT id, name, surname, email 
                    FROM users 
                    WHERE id = ?';
        }

        protected static function assign_values($values) {
            $user = new user();
            return $user->
            id(self::check_key('id', $values))->
            name(self::check_key('name', $values))->
            surname(self::check_key('surname', $values))->
            email(self::check_key('email', $values))->
            role(self::check_key('role', $values))->
            password(self::check_key('password', $values));
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

        public function get_all_users() {
            $result = $this->db_resource->query('SELECT id, name, surname, email FROM users');
            $users = [];
            while($fetched = $result->fetch_assoc()) {
                $user = new user();
                $users[] = $user->name($fetched['name'])->id($fetched['id'])->surname($fetched['surname'])->email($fetched['email']);
            }
            return count($users) > 0 ? $users : false;
        }

        public function get_users_from_departments($departments_list) {
            $str = implode(',',$departments_list);
            try {
                $query = "SELECT u.id, u.name, u.surname FROM departments_users
                                JOIN users AS u ON users_id = u.id 
                                WHERE departments_id IN ($str)";
                $result = $this->db_resource()->query($query);
                $users = [];
                while($row = $result->fetch_assoc()) {
                    $user = new user();
                    $users = $user->id($row['u.id'])->name($row['u.name']->surname($row['u.surname']));
                }
                return $users;
            } catch (Exception $e) {
                return false;
            }
        }

//        public function get_by_id($id) {
//            try {
//                $stmt = $this->db_resource->prepare('SELECT id, name, surname, email FROM users WHERE id = ?');
//                $stmt->bind_param('i', $id);
//                $stmt->execute();
//                $stmt->bind_result($id, $name, $surname, $email);
//                $stmt->store_result();
//                $stmt->fetch();
//                $num_rows = $stmt->num_rows();
//                $stmt->close();
//
//                $user = new user();
//                return $num_rows > 0 ? $user->id($id)->name($name)->surname($surname)->email($email) : null;
//            } catch(Exception|Error $e) {
//                error_log($e->getMessage());
//                return null;
//            }
//        }
    }