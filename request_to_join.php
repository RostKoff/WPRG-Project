
<?php
    include('php/scripts/include_all.php');
    session_start();
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    $requests_dao = new requests_dao(database_connection::get_instance()->get_resource());
    if($requests_dao->already_exists($_SESSION['user']->get_id(), $_POST['department_id'])) {
        echo '<p>The request has already been sent</p>';
        return;
    }

    if(!$requests_dao->add($_SESSION['user']->get_id(), $_POST['department_id'])) {
        echo '<p>Unable to send request</p>';
    }

    $page = page_content_manager::get_last_page();
    header("Location: $page");
