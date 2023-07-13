<?php

class ticket_dao extends db_dao
{

    protected static function get_by_id_query(): string
    {
        return 'SELECT id, title, priority, department_id, reporter_id, assignee_id, start_date, due_date, close_date, description 
                FROM tickets 
                WHERE id = ?';
    }
    protected static function add_query(): string
    {
        return 'INSERT INTO tickets (id, title, priority, department_id, reporter_id, assignee_id, start_date, due_date, close_date, description)
                VALUES (?,?,?,?,?,?,?,?,?,?)';
    }
    protected static function get_all_query(): string {
        return 'SELECT id, title, priority, department_id, reporter_id, assignee_id, start_date, due_date, close_date, description 
                FROM tickets';
    }
    protected static function delete_query(): string
    {
        return 'DELETE FROM tickets WHERE id = ?';
    }

    protected static function assign_values($values): ticket
    {
        $ticket = new ticket();
        return $ticket->
        set_id(self::check_key('id', $values))->
        set_title(self::check_key('title', $values))->
        set_priority(self::check_key('priority', $values))->
        set_department_id(self::check_key('department_id', $values))->
        set_reporter_id(self::check_key('reporter_id', $values))->
        set_assignee_id(self::check_key('assignee_id', $values))->
        set_start_date(self::check_key('start_date', $values))->
        set_due_date(self::check_key('due_date', $values))->
        set_close_date(self::check_key('close_date', $values))->
        set_description(self::check_key('description', $values));
    }
    protected static function get_values($entity): array
    {
        if (!($entity instanceof ticket))
            throw new Exception('ticket_dao::get_values($entity): Argument #1 ($entity) must be an instance of the ticket class');
        $values = [];

        $values[] = $entity->get_id();
        $values[] = $entity->get_title();
        $values[] = $entity->get_priority();
        $values[] = $entity->get_department_id();
        $values[] = $entity->get_reporter_id();
        $values[] = $entity->get_assignee_id();
        $values[] = $entity->get_start_date();
        $values[] = $entity->get_due_date();
        $values[] = $entity->get_close_date();
        $values[] = $entity->get_description();
        return $values;
    }
    public function get_next_id() {
        $query = "SHOW TABLE STATUS LIKE 'tickets'";
        $result = $this->db_resource->query($query);
        $row = mysqli_fetch_assoc($result);
        return $row['Auto_increment'];
    }

    public function mark_as_done($id, $due_date_is_set): bool
    {
        try {
            $current_date = date('Y-m-d');
            if($due_date_is_set) {
                $stmt = $this->db_resource->prepare('UPDATE tickets SET close_date = ? WHERE id = ?');
                $stmt->bind_param('si', $current_date, $id);
            }
            else {
                $stmt = $this->db_resource->prepare('UPDATE tickets SET close_date = ?, due_date = ? WHERE id = ?');
                $stmt->bind_param('ssi', $current_date, $current_date, $id);
            }
            $stmt->execute();
            return true;
        } catch(Exception|Error $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function get_by_dep_id($id, $due_date_is_set): ?array
    {
        try {
            $stmt = $this->db_resource->prepare('SELECT id, title, priority, department_id, reporter_id, assignee_id, start_date, due_date, close_date, description 
                                                 FROM tickets 
                                                 WHERE department_id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $results = $stmt->get_result();
            $tickets = [];
            while($result = $results->fetch_assoc()) {
                if($due_date_is_set && is_null($result['due_date'])) continue;
                $ticket = self::assign_values($result);
                $tickets[] = $ticket;
            }
            $results->close();
            $stmt->close();
            return $tickets;
        } catch(Exception|Error $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}