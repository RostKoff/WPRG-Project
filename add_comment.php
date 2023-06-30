<?php

    include('php/scripts/include_all.php');
    session_start();
    if($_SERVER['REQUEST_METHOD'] !== 'POST')
        return;

    if(!isset($_POST['content']))
        return;

    $comment = new comment();
    $comment->set_content($_POST['content'])->set_ticket_id($_POST['ticket_id'])->set_user_id($_SESSION['user']->get_id());

    $comment_dao = new comments_dao(database_connection::get_instance()->get_resource());
    $comment_dao->add($comment);
    $ticket_id = $_POST['ticket_id'];
    header("Location: ticket.php?id=$ticket_id");