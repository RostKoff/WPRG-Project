<?php

class department
{
    private $id;
    private $title;
    private $owner_id;

    public function __construct($id, $title, $owner_id)
    {
        $this->id = $id;
        $this->title = $title;
        $this->owner_id = $owner_id;
    }

    public function get_id() {
        return $this->id;
    }
    public function get_title() {
        return $this->title;
    }
    public function get_owner_id() {
        return $this->owner_id;
    }

    public function set_id($id) {
        $this->id = $id;
        return $this;
    }
    public function set_title($title) {
        $this->title = $title;
        return $this;
    }
    public function set_owner_id($owner_id) {
        $this->owner_id = $owner_id;
        return $this;
    }
}