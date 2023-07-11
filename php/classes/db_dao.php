<?php

abstract class db_dao
{
    protected $db_resource;

    protected static abstract function get_by_id_query();


    protected static abstract function assign_values($values);
    protected static function check_key($key, $arr) {
        return !array_key_exists($key, $arr) ? null : $arr[$key];
    }

    public function __construct($db_resource) {
        $this->db_resource = $db_resource;
    }

    public function get_by_id($id) {
        try {
            $stmt = $this->db_resource->prepare($this->get_by_id_query());
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result === false || $result->num_rows === 0)
                return null;
            return $this->assign_values($result->fetch_array(MYSQLI_ASSOC));
        } catch (Exception|Error $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}