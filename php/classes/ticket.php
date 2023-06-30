<?php

class ticket
{
    private string $title;
    private int $department_id;
    private int $reporter_id;
    private ?int $assignee_id = null;
    private string $start_date;
    private ?string $due_date = null;
    private ?string $close_date = null;
    private $id;

    /**
     * @return mixed
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ticket
     */
    public function set_id($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return string|null
     */
    public function get_close_date(): ?string
    {
        return $this->close_date;
    }

    /**
     * @param string|null $close_date
     * @return ticket
     */
    public function set_close_date(?string $close_date): ticket
    {
        $this->close_date = $close_date;
        return $this;
    }
    private ?string $attachment_urls;
    private string $description;
    private string $priority;

    /**
     * @return string
     */
    public function get_priority(): string
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     * @return ticket
     */
    public function set_priority(string $priority): ticket
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return string
     */
    public function get_description(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ticket
     */
    public function set_description(string $description): ticket
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function get_title(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ticket
     */
    public function set_title(string $title): ticket
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function get_department_id(): int
    {
        return $this->department_id;
    }

    /**
     * @param int $department_id
     * @return ticket
     */
    public function set_department_id(int $department_id): ticket
    {
        $this->department_id = $department_id;
        return $this;
    }

    /**
     * @return int
     */
    public function get_reporter_id(): int
    {
        return $this->reporter_id;
    }

    /**
     * @param int $reporter_id
     * @return ticket
     */
    public function set_reporter_id(int $reporter_id): ticket
    {
        $this->reporter_id = $reporter_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function get_assignee_id(): int|null
    {
        return $this->assignee_id;
    }

    /**
     * @param int|null $assignee_id
     * @return ticket
     */
    public function set_assignee_id(?int $assignee_id): ticket
    {
        $this->assignee_id = $assignee_id;
        return $this;
    }

    /**
     * @return string
     */
    public function get_start_date(): string
    {
        return $this->start_date;
    }

    /**
     * @param string $start_date
     * @return ticket
     */
    public function set_start_date(string $start_date): ticket
    {
        $this->start_date = $start_date;
        return $this;
    }

    /**
     * @return string|null
     */
    public function get_due_date(): string|null
    {
        return $this->due_date;
    }

    /**
     * @param string|null $due_date
     * @return ticket
     */
    public function set_due_date(?string $due_date): ticket
    {
        $this->due_date = $due_date;
        return $this;
    }

    /**
     * @return string
     */
    public function get_attachment_urls(): string
    {
        return $this->attachment_urls;
    }

    /**
     * @param string $attachment_urls
     * @return ticket
     */
    public function set_attachment_urls(string $attachment_urls): ticket
    {
        $this->attachment_urls = $attachment_urls;
        return $this;
    }

}