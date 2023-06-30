<?php
    include('php/scripts/include_all.php');
    session_start();
    if($_SERVER['REQUEST_METHOD'] !== 'POST')
        return;

    $comments_dao = new comments_dao(database_connection::get_instance()->get_resource());
    $comments_dao->delete_by_id($_POST['comment_id']);

    $ticket_id = $_POST['ticket_id'];
    header("Location: ticket.php?id=$ticket_id");
