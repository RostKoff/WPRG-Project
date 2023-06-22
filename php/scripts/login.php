<?php
    require_once('php/classes/database_connection.php');
    require_once('php/classes/user_dao.php');
    require_once('php/classes/user.php');

    if($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['login']))
        return;

    if(!isset($_POST['email-l'], $_POST['password-l'])) {
        echo 'Make sure all values are entered!';
        return;
    }

    $db_instance = database_connection::get_instance();
    if(!$db_instance) {
        echo("Error!");
        return;
    }

    $user_dao = new user_dao($db_instance->get_resource());

    if(!$user = $user_dao->get_user_by_email($_POST['email-l'])) {
        echo 'This email address is not registered!';
        return;
    }

    if(!$aa = password_verify($_POST['password-l'], $user->get_password())) {
        echo 'Wrong password!';
        return;
    }

    $_SESSION['user'] = $user;
    header('Location: departments.php');
