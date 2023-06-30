<?php
    require_once('php/classes/db_dao.php');
    $files = glob( 'php/classes/*.php');
    foreach ($files as $file) {
        require_once($file);
    }