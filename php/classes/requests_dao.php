<?php

class requests_dao extends db_dao
{

    protected static function get_by_id_query() {
        return '';
    }
    protected static function add_query(){
        return '';
    }
    protected static function get_all_query() {
        return '';
    }

    protected static function assign_values($values) {
        return null;
    }
    protected static function get_values($entity){
        return null;
    }
    protected static function delete_query(): string
    {
        return '';
    }


    public function already_exists($user_id, $department_id) {
        try {
        $stmt = $this->db_resource->prepare('SELECT * FROM requests_to_join WHERE user_id = ? AND department_id = ? ');
        $stmt->bind_param('ii', $user_id, $department_id);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows();
        $stmt->close();
        return $num > 0;
        } catch (mysqli_sql_exception $e) {
            return true;
        }
    }

//    public function add($user_id, $department_id) {
//        try {
//            $stmt = $this->db_resource->prepare('INSERT INTO requests_to_join (user_id, department_id) VALUES (?,?)');
//            $stmt->bind_param('ii', $user_id, $department_id);
//            $stmt->execute();
//            $stmt->close();
//            return true;
//        } catch (mysqli_sql_exception $e) {
//            return true;
//        }
//    }
}