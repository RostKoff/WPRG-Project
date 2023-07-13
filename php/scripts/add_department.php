<?php
    include('php/scripts/include_all.php');
    if($_SERVER['REQUEST_METHOD'] !== 'POST')
        return;

    if(!isset($_POST['dep_name'], $_POST['owner'])) {
        echo '<p>Make sure all values are entered!</p>';
        return;
    }
    $dep_name = $_POST['dep_name'];
    $dep_owner = $_POST['owner'] === 'none' ? null : $_POST['owner'];

    $departments_dao = new departments_dao(database_connection::get_instance()->get_resource());
    $department = new department(null, $dep_name, $dep_owner);
    if($departments_dao->already_exists($_POST['dep_name'])) {
        echo '<p>This department name was already taken!</p>';
        return;
    }

    if($departments_dao->add($department) === false) {
        echo '<p>Error! Unable to create the department!</p>';
        return;
    }