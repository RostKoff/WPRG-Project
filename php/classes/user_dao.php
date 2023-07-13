<?php
    require_once('php/classes/user.php');
    require_once('php/classes/db_dao.php');
    class user_dao extends db_dao {

        protected static function get_by_id_query(): string
        {
            return 'SELECT id, name, surname, email 
                    FROM users 
                    WHERE id = ?';
        }
        protected static function add_query(): string
        {
            return 'INSERT INTO users (name, surname, email, password) 
                    VALUES (?,?,?,?)';
        }
        protected static function get_all_query(): string
        {
            return 'SELECT id, name, surname, email FROM users';
        }
        protected static function delete_query(): string
        {
            return 'DELETE FROM users WHERE id = ?';
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

        /**
         * @throws Exception
         */
        protected static function get_values($entity): array|false
        {
            if (!($entity instanceof user))
                throw new Exception('user_dao::get_values($entity): Argument #1 ($entity) must be an instance of the user class');
            $values = [];
            if(!is_null($entity->get_id()))
                $values[] = $entity->get_id();
            $values[] = $entity->get_name();
            $values[] = $entity->get_surname();
            $values[] = $entity->get_email();
            if(!is_null($entity->get_role()))
                $values[] = $entity->get_role();
            $values[] = $entity->get_password();
            return $values;
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
    }