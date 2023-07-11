<?php

class attachment
{
    private $id;
    private $path;
    private $ticket_id;

    public function get_id() {
        return $this->id;
    }
    public function get_path() {
        return $this->path;
    }
    public function get_ticket_id() {
        return $this->ticket_id;
    }

    public function set_id($id) {
        $this->id = $id;
        return $this;
    }
    public function set_path($path) {
        $this->path = $path;
        return $this;
    }
    public function set_ticket_id($ticket_id) {
        $this->ticket_id = $ticket_id;
        return $this;
    }
}