<?php
class departments_dao extends db_dao {

    public static function get_by_id_query(): string
    {
        return 'SELECT id, title, owner_id 
                FROM departments 
                WHERE id = ?';
    }

    public static function assign_values($values): department
    {
        $id = self::check_key('id', $values);
        $title = self::check_key('title', $values);
        $owner_id = self::check_key('owner_id', $values);
        return new department($id, $title, $owner_id);
    }

    public function get_departments() {
        try {
        $result = $this->db_resource->query('SELECT id, title FROM departments');
        } catch(mysqli_sql_exception $e) {
            return false;
        }
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : false;
    }


    public function get_specific_department($user_id) {
        $query = "SELECT d.owner_id, departments_id, d.title FROM departments_users
                             JOIN departments AS d ON departments_id = d.id
                             WHERE users_id = $user_id";
        $result = $this->db_resource->query($query);
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : false;
    }

    public function add_department($title, $owner_id = null): bool
    {
        if($owner_id != null) {
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