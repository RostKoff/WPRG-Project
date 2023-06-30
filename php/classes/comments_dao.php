<?php

class comments_dao extends db_dao
{
    public function add($comment) {
        try {
            $stmt = $this->db_resource->prepare('INSERT INTO comments (content, ticket_id, user_id) VALUES (?,?,?)');
            $content = $comment->get_content();
            $ticket_id =  $comment->get_ticket_id();
            $user_id = $comment->get_user_id();
            $stmt->bind_param('sii', $content, $ticket_id, $user_id);
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            return false;
        }
        return true;
    }

    public function get_by_ticket_id($id) {
        try {
            $stmt = $this->db_resource->prepare('SELECT id, content, user_id FROM comments WHERE ticket_id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($id, $content, $user_id);

            $comments=[];
            while($stmt->fetch()) {
                $comment = new comment();
                $comment->set_id($id)->set_content($content)->set_user_id($user_id);
                $comments[] = $comment;
            }
            return count($comments) > 0 ? $comments : false;
        } catch(mysqli_sql_exception $e) {
            return false;
        }
    }

    public function delete_by_id($id) {
        try {
            $stmt = $this->db_resource->prepare('DELETE FROM comments WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return true;
        } catch(mysqli_sql_exception $e) {
            return false;
        }
    }
}