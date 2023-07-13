<?php include('header.html'); ?>
<?php

    include('php/scripts/include_all.php');
    session_start();
    page_content_manager::define_user_type();

    if($_SERVER['REQUEST_METHOD'] !== 'GET') {
        echo '<h1>Department not found!</h1>';
        return;
    }
    $instance = database_connection::get_instance();
    if(empty($instance))
        echo '<h1>Error! Unable get information!</h1>';
    $db_resource = $instance->get_resource();

    $departments_dao = new departments_dao($db_resource);
    $current_dep = $departments_dao->get_by_id($_GET['id']);
    if(is_null($current_dep)) {
        echo '<h1>Department not found!</h1>';
        return;
    }
    $ticket_dao = new ticket_dao($db_resource);
    $tickets = $ticket_dao->get_by_dep_id($_GET['id'], true);
    if(is_null($tickets)) {
        echo '<h1>Unable to retrieve information</h1>';
        return;
    }
    $json_data = json_helper::tickets2json($tickets);
?>
<title>Calendar</title>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var jsonData = <?php echo $json_data; ?>;
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: jsonData,
            eventLimit: true, // Enable event limiting
            views: {
                dayGridMonth: {
                    eventLimit: 3 // Maximum number of events to display in month view
                }
            },
            eventLimitClick: 'popover'
            }

        )
        calendar.render();
    });

</script>
</head>
<body>
<?php


?>

    <div class="container-fluid">
        <div class="row">
            <?php include('sidebar.php'); ?>
            <div class="col">
                <div class="container">
                    <h1 class="text-center">Calendar</h1>
                    <div class="row pt-3">
                        <div id='calendar'></div>
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
