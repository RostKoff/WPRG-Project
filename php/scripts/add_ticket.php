<?php
    if($_SERVER['REQUEST_METHOD'] !== 'POST')
        return;

    if(!isset($_POST['title'], $_POST['description'], $_POST['priority'], $_POST['department'], $_POST['start_date'])) {
        echo '<p>Make sure all values are entered!</p>';
        return;
    }

    if(!empty($_POST['due_date']) && $_POST['due_date'] < $_POST['start_date']) {
        echo 'Due date cannot be older than start date!';
        return;
    }

    $db_resource = database_connection::get_instance()->get_resource();
    $db_resource->begin_transaction();
    $attachments = $_FILES['attachments'];
    $ticket_dao = new ticket_dao($db_resource);
    $attachments_dao = new attachments_dao($db_resource, 'attachments/');
    $ticket_id = $ticket_dao->get_next_id();
    $ticket = new ticket();

    $due_date = !empty($_POST['due_date']) ? $_POST['due_date'] : null;
    $ticket->set_title($_POST['title'])->set_description($_POST['description'])->set_priority($_POST['priority'])
        ->set_department_id($_POST['department'])->set_start_date($_POST['start_date'])->set_reporter_id($_SESSION['user']->get_id())
        ->set_due_date($due_date)->set_id($ticket_id);

    if(!$ticket_dao->add($ticket)) {
        echo '<p>Unable to add ticket!</p>';
        return;
    }
    if(!empty($attachments['name'][0])) {
        if(!$attachments_dao->check_attachments($attachments)) {
            echo '<p>Unable to add attached files!</p>';
            return;
        }
        if(!$attachments_dao->add_and_save($attachments, $ticket->get_id(), $ticket->get_department_id())) {
            echo '<p>Unable to add attached files!</p>';
            return;
        }
    }

    $db_resource->commit();
    echo '<p>Successfully added!</p>';