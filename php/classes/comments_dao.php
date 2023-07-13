<?php

class comments_dao extends db_dao
{

    protected static function get_by_id_query(): string
    {
        return 'SELECT id, content, user_id, ticket_id
                FROM comments
                WHERE id=?';
    }
    protected static function add_query(): string
    {
        return 'INSERT INTO comments (content, user_id, ticket_id) 
                VALUES (?,?,?)';
    }
    protected static function get_all_query() {
        return 'SELECT id, content, user_id, ticket_id
                FROM comments';
    }
    protected static function delete_query(): string
    {
        return 'DELETE FROM comments WHERE id = ?';
    }

    protected static function assign_values($values): comment
    {
        $comment = new comment();
        return $comment->
        set_id(self::check_key('id', $values))->
        set_content(self::check_key('content', $values))->
        set_user_id(self::check_key('user_id', $values))->
        set_ticket_id(self::check_key('ticket_id', $values));
    }

    /**
     * @throws Exception
     */
    protected static function get_values($entity): array
    {
        if (!($entity instanceof comment))
            throw new Exception('comments_dao::get_values($entity): Argument #1 ($entity) must be an instance of the comment class');
        $values = [];

        $values[] = $entity->get_content();
        $values[] = $entity->get_user_id();
        $values[] = $entity->get_ticket_id();
        return $values;
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
}