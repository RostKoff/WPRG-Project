<?php

class ticket_dao extends db_dao {

    public function add($ticket): bool
    {
        try {
            $stmt = $this->db_resource->prepare('
                INSERT INTO tickets 
                (id, title, priority, department_id, reporter_id, assignee_id, start_date, due_date, description)
                VALUES (?,?,?,?,?,?,?,?,?);
                ');

            $id = $ticket->get_id();
            $title = $ticket->get_title();
            $priority = $ticket->get_priority();
            $department_id = $ticket->get_department_id();
            $reporter_id = $ticket->get_reporter_id();
            $assignee_id = $ticket->get_assignee_id();
            $start_date = $ticket->get_start_date();
            $due_date = $ticket->get_due_date();
            $description = $ticket->get_description();

            $stmt->bind_param('issiiisss', $id, $title, $priority, $department_id, $reporter_id, $assignee_id, $start_date, $due_date, $description);
            if(!$stmt->execute()) return false;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        $stmt->close();
        return true;

    }

    public function get_by_id($id) {
        try {
            $stmt = $this->db_resource->prepare('SELECT id, title, priority, department_id, reporter_id, assignee_id, start_date, due_date, close_date, description FROM tickets WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($id, $title, $priority, $department_id, $reporter_id, $assignee_id, $start_date, $due_date, $close_date, $description);
            $stmt->store_result();
            $ticket = new ticket();
            $stmt->fetch();
            $num_rows = $stmt->num_rows();
            $stmt->close();
            return $num_rows ? $ticket->set_id($id)->set_title($title)->set_priority($priority)->set_department_id($department_id)
                ->set_reporter_id($reporter_id)->set_assignee_id($assignee_id)->set_start_date($start_date)->set_due_date($due_date)
                ->set_close_date($close_date)->set_description($description) : false;

        } catch(mysqli_sql_exception $e) {
            return false;
        }
    }
    public function get_next_id() {
        $query = "SHOW TABLE STATUS LIKE 'tickets'";
        $result = $this->db_resource->query($query);
        $row = mysqli_fetch_assoc($result);
        return $row['Auto_increment'];
    }

    public function mark_as_done($id, $due_date_is_set) {
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
        } catch(mysqli_sql_exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function get_by_dep_id($id, $due_date_is_set) {
        try {
            $stmt = $this->db_resource->prepare('SELECT id, title, priority, department_id, reporter_id, assignee_id, start_date, due_date, close_date, description FROM tickets WHERE department_id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($id, $title, $priority, $department_id, $reporter_id, $assignee_id, $start_date, $due_date, $close_date, $description);
            $tickets = [];
            while($stmt->fetch()) {
                if($due_date_is_set && empty($due_date)) continue;
                $ticket = new ticket();
                $tickets[] = $ticket->set_id($id)->set_title($title)->set_priority($priority)->set_department_id($department_id)
                    ->set_reporter_id($reporter_id)->set_assignee_id($assignee_id)->set_start_date($start_date)->set_due_date($due_date)
                    ->set_close_date($close_date)->set_description($description);
            }
            $stmt->close();
            return $tickets;
        } catch(mysqli_sql_exception $e) {
            return false;
        }
    }

    public function get_backlog($id) {
        $stmt = $this->db_resource->prepare('SELECT id, title, priority, department_id, reporter_id, assignee_id, start_date, due_date, close_date, description FROM tickets
                                               WHERE department_id = ? AND ( assignee_id = NULL OR due_date = NULL )');

    }
}