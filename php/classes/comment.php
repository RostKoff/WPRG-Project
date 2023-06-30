<?php

class comment {
    private $id;
    private $content;
    private $user_id;
    private $ticket_id;

    public function get_id()
    {
        return $this->id;
    }

    public function set_id($id)
    {
        $this->id = $id;
        return $this;
    }

    public function get_content()
    {
        return $this->content;
    }

    public function set_content($content)
    {
        $this->content = $content;
        return $this;
    }

    public function get_user_id()
    {
        return $this->user_id;
    }

    public function set_user_id($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function get_ticket_id()
    {
        return $this->ticket_id;
    }

    public function set_ticket_id($ticket_id)
    {
        $this->ticket_id = $ticket_id;
        return $this;
    }
}