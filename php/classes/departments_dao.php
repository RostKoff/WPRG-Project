<?php
class departments_dao extends db_dao {

    protected static function get_by_id_query(): string
    {
        return 'SELECT id, title, owner_id 
                FROM departments 
                WHERE id = ?';
    }
    protected static function add_query(): string
    {
        return 'INSERT INTO departments (title, owner_id)
                VALUES (?,?)';
    }
    protected static function get_all_query(): string {
        return 'SELECT id, title, owner_id 
                FROM departments ';
    }
    protected static function delete_query(): string
    {
        return 'DELETE FROM departments WHERE id = ?';
    }

    protected static function assign_values($values): department
    {
        $id = self::check_key('id', $values);
        $title = self::check_key('title', $values);
        $owner_id = self::check_key('owner_id', $values);
        return new department($id, $title, $owner_id);
    }

    /**
     * @throws Exception
     */
    protected static function get_values($entity): array
    {
        if (!($entity instanceof department))
            throw new Exception('departments_dao::get_values($entity): Argument #1 ($entity) must be an instance of the department class');
        $values = [];

        $values[] = $entity->get_title();
        $values[] = $entity->get_owner_id();
        return $values;
    }

    public function get_specific_department($user_id) {
        $query = "SELECT d.owner_id, departments_id, d.title FROM departments_users
                             JOIN departments AS d ON departments_id = d.id
                             WHERE users_id = $user_id";
        $result = $this->db_resource->query($query);
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : false;
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