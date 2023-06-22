<?php
    require_once('user_type.php');
    require_once('user.php');

    class page_content_manager {
        public static function define_user_type(): void
        {
            $user_type = user_type::GUEST;
            if(isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
                switch($user->get_role()) {
                    case 'user':
                        $user_type = user_type::USER;
                        break;
                    case 'admin':
                        $user_type = user_type::ADMIN;
                        break;
                    case 'owner':
                        $user_type = user_type::OWNER;
                        break;
                }
            }
            define('USER_TYPE', $user_type);
        }
        public static function set_last_page(): void
        {
            $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
        }
        public static function get_last_page() {
            if(!isset($_SESSION['last_page']))
                return '/departments.php';
            return $_SESSION['last_page'];
        }
    }