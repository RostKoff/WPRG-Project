<?php include('header.html'); ?>
<title>Add Ticket</title>
</head>
<body>
<?php

include('php/scripts/include_all.php');
session_start();
page_content_manager::define_user_type();
$tickets_dao = new ticket_dao(database_connection::get_instance()->get_resource());
$department_dao = new departments_dao(database_connection::get_instance()->get_resource());
$ticket = $tickets_dao->get_by_id($_GET['id']);
$department = $department_dao->get_by_id($ticket->get_department_id());
if(
    USER_TYPE === user_type::GUEST
    ||
    (
        $department->get_owner_id() !== $_SESSION['user']->get_id() &&
        USER_TYPE !== user_type::ADMIN
    )
):
    ?>
    <h1>Access denied!</h1>
<?php else: ?>
    <div class="container-fluid">
        <div class="row">
            <?php include('sidebar.php'); ?>
            <div class="col">
                <div class="container">
                    <h1 class="text-center">Edit ticket</h1>
                    <form class="w-100" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="row pt-3">
                            <div class="col-8">
                                <label for="title">Title</label> <br>
                                <input id="title" name="title" class="w-100" type="text" maxlength="255" value="<?php echo $ticket->get_title() ?>" required>
                                <label for="description">Description</label> <br>
                                <textarea class="w-100" name="description" id="description" cols="30" rows="10" maxlength="1000" required><?php echo $ticket->get_description() ?></textarea>
                                <?php include('php/scripts/add_ticket.php') ?>
                            </div>

                            <div class="container col-4 green-block">
                                <div class="row py-3">
                                    <div class="col-6">
                                        <label for="priority">Priority *</label>
                                    </div>
                                    <div class="col-6">
                                        <select name="priority" id="priority" required>
                                            <option <?php if($ticket->get_priority()) ?> value="high">High</option>
                                            <option value="medium">Medium</option>
                                            <option value="low">Low</option>
                                        </select>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="department">Department *</label>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <select name="department" id="department" required>
                                            <?php
                                            $departments_dao = new departments_dao(database_connection::get_instance()->get_resource());
                                            $deps = $departments_dao->get_specific_department($_SESSION['user']->get_id());
                                            foreach($deps as $dep):
                                                ?>
                                                <option value="<?php echo $dep['departments_id'] ?>"><?php echo $dep['title'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="start-date">Start date *</label>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <input type="date" id="start-date" value="<?php echo $ticket->get_start_date() ?>" name="start_date" required>
                                    </div>
                                    <?php if(USER_TYPE === user_type::USER): ?>
                                        <div class="col-6 mt-3">
                                            <label class="readonly">Due date</label>
                                        </div>

                                        <div class="col-6 mt-3">
                                            <div class="readonly-input"></div>
                                        </div>
                                    <?php else: ?>
                                        <div class="col-6 mt-3">
                                            <label for="due-date">Due date</label>
                                        </div>

                                        <div class="col-6 mt-3">
                                            <input type="date" id="due-date" name="due_date" >
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-12">
                                        <label for="attachments">Attachments</label>
                                    </div>
                                    <div class="text-center col-12">
                                        <input name="attachments[]" id="attachments" type="file" multiple>
                                    </div>
                                    <button class="action-button w-75 mx-auto mt-3 py-2" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
<?php endif; ?>
</body>
</html>
