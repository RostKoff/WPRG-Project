<?php
    include('php/scripts/include_all.php');

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
        return;

    $due_date_is_set = !empty($_POST['due_date']);

    $ticket_dao = new ticket_dao(database_connection::get_instance()->get_resource());

    $ticket_dao->mark_as_done($_POST['ticket_id'], $due_date_is_set);
    $ticket_id = $_POST['ticket_id'];
    header("Location: ticket.php?id=$ticket_id");