<?php include('header.html'); ?>
<title>Backlog</title>

</head>
<body>
<?php

    include('php/scripts/include_all.php');
    session_start();
    page_content_manager::define_user_type();

    if($_SERVER['REQUEST_METHOD'] !== 'GET') {
        echo '<h1>Department not found!</h1>';
        return;
    }

    $departments_dao = new departments_dao(database_connection::get_instance()->get_resource());
    if(!$department = $departments_dao->get_by_id($_GET['id'])) {
        echo '<h1>Department not found!</h1>';
        return;
    }
    $ticket_dao = new ticket_dao(database_connection::get_instance()->get_resource());
    $tickets = $ticket_dao->get_by_dep_id($_GET['id'], false);
?>

<div class="container-fluid">
    <div class="row">
        <?php include('sidebar.php'); ?>
        <div class="col">
            <div class="container">
                <h1 class="text-center">Backlog</h1>
                <div class="row pt-3">
                    <table>
                        <tr>
                            <th>title</th>
                            <th>Priority</th>
                            <th>Department</th>
                            <th>Reporter</th>
                            <th>Assignee</th>
                            <th>Start date</th>
                            <th>Due date</th>
                            <th>Close date</th>
                            <th>View</th>
                        </tr>
                        <?php foreach($tickets as $ticket): ?>
                        <tr>
                            <td><?php echo $ticket->get_title() ?></td>
                            <td><?php echo $ticket->get_priority() ?></td>
                            <td><?php
                                    $departments_dao = new departments_dao(database_connection::get_instance()->get_resource());
                                    $department = $departments_dao->get_by_id($ticket->get_department_id());
                                    echo $department['title'];
                                ?> </td>
                            <td><?php
                                    $user_dao = new user_dao(database_connection::get_instance()->get_resource());
                                    $user = $user_dao->get_by_id($ticket->get_reporter_id());
                                    echo $user->get_name()." ".$user->get_surname();
                                ?></td>
                            <td>
                                <?php
                                    if(!empty($ticket->get_assignee_id())) {
                                        $user_dao = new user_dao(database_connection::get_instance()->get_resource());
                                        $user = $user_dao->get_by_id($ticket->get_assignee_id());
                                        echo $user->get_name()." ".$user->get_surname();
                                    }
                                    else
                                        echo 'None';
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $ticket->get_start_date();
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo !empty($ticket->get_due_date()) ? $ticket->get_due_date() : 'None';
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo !empty($ticket->get_close_date()) ? $ticket->get_close_date() : 'None';
                                ?>
                            </td>
                            <td>
                                <button onclick="location.href = 'ticket.php?id=<?php echo $ticket->get_id() ?>'" class="action-button">
                                    View
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <script src="js/sidebar.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
            integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
        <script src="js/select.js"></script>
</body>
</html>
