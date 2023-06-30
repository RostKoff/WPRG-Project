<?php

abstract class db_dao
{
    protected $db_resource;

    public function __construct($db_resource) {
        $this->db_resource = $db_resource;
    }
}