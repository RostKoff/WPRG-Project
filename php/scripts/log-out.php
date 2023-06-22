<?php
    session_start();
    require_once('../classes/page_content_manager.php');
    unset($_SESSION['user']);
    session_destroy();
    $page = page_content_manager::get_last_page();
    header("Location: $page");