<?php
    if($_SERVER['REQUEST_METHOD'] !== 'POST')
        return;

    if(!isset($_POST['dep_name'], $_POST['owner'])) {
        echo '<p>Make sure all values are entered!</p>';
        return;
    }

    $departments_dao = new departments_dao(database_connection::get_instance()->get_resource());

    if($departments_dao->already_exists($_POST['dep_name'])) {
        echo '<p>This department name was already taken!</p>';
        return;
    }
    $departments_dao->add_department($_POST['dep_name'], $_POST['owner'] !== 'none' ? $_POST['owner'] : null);

    if($departments_dao === false) {
        echo '<p>Error! Unable to create the department!</p>';
        return;
    }