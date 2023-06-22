<?php
class departments_dao {
    private $db_resource;

    public function __construct($db_resource) {
        $this->db_resource = $db_resource;
    }

    public function get_departments() {
        try {
        $result = $this->db_resource->query('SELECT id, title FROM departments');
        } catch(mysqli_sql_exception $e) {
            return false;
        }
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : false;
    }
    public function add_department($title, $owner_id = null): bool
    {
        if($owner_id = null) {
            $stmt = $this->db_resource->prepare('INSERT INTO departments (title, owner_id) VALUES (?,?)');
            $stmt->bind_param('si', $title, $owner_id);
        }
        else {
            $stmt = $this->db_resource->prepare('INSERT INTO departments (title) VALUES (?)');
            $stmt->bind_param('s', $title);
        }

        return !($stmt->execute() === false);
    }

    public function already_exists($title): bool
    {
        $stmt = $this->db_resource->prepare('SELECT id, title FROM departments WHERE title = ?');
        $stmt->bind_param('s', $title);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}