<?php
    require_once('php/classes/database_connection.php');
    require_once('php/classes/user_dao.php');
    require_once('php/classes/user.php');
    if($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['registration']))
        return;

    if(!isset($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password'], $_POST['password_repeated'])) {
        echo 'Make sure all values are entered!';
        return;
    }
    if($_POST['password'] !== $_POST['password_repeated'] ) {
        echo 'Password didn\'t match!';
        return;
    }


    $db_instance = database_connection::get_instance();
    if(!$db_instance) {
        echo("Error!");
        return;
    }

    $user_dao = new user_dao($db_instance->get_resource());

    if($user = $user_dao->get_user_by_email($_POST['email'])) {
        echo 'This email address is already registered!';
        return;
    }
    $user = new user();
    $hashed_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user->name($_POST['name'])->surname($_POST['surname'])->email($_POST['email'])->password($hashed_pass);
    $user_dao->add_user($user);
