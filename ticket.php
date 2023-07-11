<?php include('header.html'); ?>
<title>Ticket</title>
</head>
<body>
<?php

include('php/scripts/include_all.php');
session_start();
page_content_manager::define_user_type();
if($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo '<h1>Ticket not found!</h1>';
    return;
}

$instance = database_connection::get_instance();
if(empty($instance))
    echo '<h1>Error! Unable get information!</h1>';
$db_resource = $instance->get_resource();

$ticket_dao = new ticket_dao($db_resource);
if(!$ticket = $ticket_dao->get_by_id($_GET['id'])) {
    echo '<h1>Ticket not found!</h1>';
    return;
}
$department_dao = new departments_dao($db_resource);
$current_dep = $department_dao->get_by_id($ticket->get_department_id());
?>
    <div class="container-fluid">
        <div class="row">
            <?php include('sidebar.php'); ?>
            <div class="col">
                <div class="container">
                    <h1 class="text-center"><?php echo $ticket->get_title() ?></h1>
                        <div class="row pt-3">
                            <div class="col-8">
                                <?php
                                if(
                                    USER_TYPE !== user_type::GUEST
                                    &&
                                    (
                                        $current_dep->get_owner_id() === $_SESSION['user']->get_id()
                                        ||
                                        USER_TYPE === user_type::ADMIN
                                    )
                                ):
                                    ?>
                                <strong><a href="edit_ticket.php?id=<?php echo $ticket->get_id() ?>">Edit ticket</a></strong>
                                <?php endif; ?>
                                <h5 class="pb-0"><label for="description">Description</label></h5>
                                <div><?php echo $ticket->get_description() ?></div>
                                <h5 class="mt-4">Comments</h5>
                                <?php if(USER_TYPE !== user_type::GUEST): ?>
                                <form action="add_comment.php" method="POST">
                                    <div class="w-100 d-flex align-items-center">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <image height="25" width="25" xlink:href="https://ui-avatars.com/api/?&name=<?php echo $_SESSION['user']->get_name().'+'.$_SESSION['user']->get_surname()?>&background=random&length=2&rounded=true&format=svg"></image>
                                        </svg>
                                        <textarea name="content" class="w-100 ms-3" cols="30" rows="1"></textarea>
                                    </div>
                                    <input type="hidden" name="ticket_id" value="<?php echo $ticket->get_id() ?>">
                                    <div class="w-100 d-flex">
                                        <button type="submit" class="ms-auto mt-2 py-1 px-3 action-button">Comment</button>
                                    </div>
                                </form>
                                <?php
                                    endif;

                                    $comments_dao = new comments_dao($db_resource);
                                    $comments = $comments_dao->get_by_ticket_id($ticket->get_id());
                                    $user_dao = new user_dao($db_resource);
                                    if($comments !== false) {
                                        foreach($comments as $comment):
                                            $user = $user_dao->get_by_id($comment->get_user_id());
                                ?>
                                <div class="w-100 mt-2">
                                    <div class="w-100 d-flex">
                                        <div class="">
                                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <image height="25" width="25" xlink:href="https://ui-avatars.com/api/?&name=<?php echo $user->get_name().'+'.$user->get_surname()?>&background=random&length=2&rounded=true&format=svg"></image>
                                            </svg>
                                        </div>
                                        <div class="w-100 mt-1 ms-2">
                                            <strong class=""><?php echo $user->get_name() . " " . $user->get_surname() ?></strong> <br>
                                            <?php echo $comment->get_content() ?>
                                        </div>
                                    </div>
                                    <?php

                                    if(
                                        USER_TYPE !== user_type::GUEST
                                        &&
                                        (
                                            $current_dep->get_owner_id() === $_SESSION['user']->get_id()
                                            ||
                                            $comment->get_user_id() === $_SESSION['user']->get_id()
                                            ||
                                            USER_TYPE === user_type::ADMIN
                                        )
                                    ):
                                    ?>
                                    <div class="w-100 d-flex">
                                        <div class="ms-auto">
                                            <form action="delete-comment.php" method="POST">
                                                <input type="hidden" name="comment_id" value="<?php echo $comment->get_id() ?>">
                                                <input type="hidden" name="ticket_id" value="<?php echo $ticket->get_id() ?>">
                                                <button type="submit" class="d-flex align-items-center">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <use xlink:href="images/icons/trash.svg#id"></use>
                                                    </svg>
                                                    <strong>Delete comment</strong>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; }?>
                            </div>

                            <div class="container col-4 green-block">
                                <div class="row py-3">
                                    <div class="col-6">
                                        <label for="priority">Priority</label>
                                    </div>
                                    <div class="col-6">
                                        <?php echo $ticket->get_priority() ?>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="department">Department</label>
                                    </div>
                                    <?php  ?>
                                    <div class="col-6 mt-3">
                                        <?php
                                            echo $current_dep->get_title();
                                        ?>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="start-date">Start date</label>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <?php
                                        echo $ticket->get_start_date();
                                        ?>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label class="">Due date</label>
                                    </div>

                                    <div class="col-6 mt-3">
                                        <?php echo empty($ticket->get_due_date()) ? "None" : $ticket->get_start_date(); ?>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label>Close date</label>
                                    </div>

                                    <div class="col-6 mt-3">
                                        <?php echo empty($ticket->get_close_date()) ? "None" : $ticket->get_close_date(); ?>
                                    </div>

                                    <div class="col-6 mt-3">
                                        <label>Assignee</label>
                                    </div>

                                    <div class="col-6 mt-3">
                                        <?php
                                        $user_dao = new user_dao($db_resource);
                                        if(empty($ticket->get_assignee_id()))
                                            echo "None";
                                        else {
                                            $user = $user_dao->get_by_id($ticket->get_assignee_id());
                                            echo $user->get_name() . " " . $user->get_surname();
                                        }
                                        ?>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label>Reporter</label>
                                    </div>

                                    <div class="col-6 mt-3">
                                        <?php
                                        $user_dao = new user_dao($db_resource);
                                        $user = $user_dao->get_by_id($ticket->get_reporter_id());
                                        echo $user->get_name() . " " . $user->get_surname();
                                        ?>
                                    </div>
                                    <div class="col-12">
                                        <label for="attachments">Attachments</label>
                                    </div>
                                    <div class="text-center col-12">
                                        <?php
                                        $attachments_dao = new attachments_dao($db_resource, 'attachments/');
                                        $attachment_paths = $attachments_dao->get_by_ticket_id($ticket->get_id());
                                        if($attachment_paths !== false) {
                                            foreach($attachment_paths as $path):
                                        $elems = explode('/',$path[0]);
                                        $attachment_name = $elems[count($elems)-1];
                                        ?>
                                                <div class="readonly-input d-flex p-0 my-2"><a class="w-100" href="<?php echo $path[0] ?>" download><?php echo $attachment_name ?></a></div>
                                        <?php endforeach; }
                                            else echo '<p class="readonly">No attachments</p>';?>
                                    </div>
                                    <?php
                                        if(
                                            USER_TYPE !== user_type::GUEST
                                            &&
                                            (
                                                (
                                                    $current_dep->get_owner_id() === $_SESSION['user']->get_id()
                                                    ||
                                                    $ticket->get_assignee_id() === $_SESSION['user']->get_id()
                                                    ||
                                                    USER_TYPE === user_type::ADMIN
                                                )
                                                &&
                                                empty($ticket->get_close_date())
                                            )
                                        ):
                                    ?>
                                    <form class="d-flex" action="mark_as_done.php" method="POST">
                                        <input type="hidden" name="ticket_id" value="<?php echo $ticket->get_id() ?>">
                                        <input type="hidden" name="due_date" value="<?php echo $ticket->get_due_date() ?>">
                                        <button class="action-button w-75 mx-auto mt-3 py-2" type="submit">Mark as done</button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/sidebar.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
<!--    <script-->
<!--        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"-->
<!--        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="-->
<!--        crossorigin="anonymous"-->
<!--        referrerpolicy="no-referrer"-->
<!--    ></script>-->
<!--    <script src="js/select.js"></script>-->
</body>
</html>
