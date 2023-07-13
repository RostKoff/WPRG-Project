<?php

abstract class db_dao
{
    protected $db_resource;

     protected static abstract function get_by_id_query();
     protected static abstract function add_query();
     protected static abstract function get_all_query();
     protected static abstract function delete_query();

    protected static abstract function assign_values($values);
    protected static abstract function get_values($entity);
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
    public function add($entity): bool
    {
        try {
            $stmt = $this->db_resource->prepare($this::add_query());
            $stmt->execute($this->get_values($entity));
            return true;
        } catch (Exception|Error $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function get_all(): ?array {
        try {
            $results = $this->db_resource->query($this->get_all_query());
            $arr = [];
            while($result = $results->fetch_assoc()) {
                $arr[] = $this->assign_values($result);
            }
            return $arr;
        } catch (Exception|Error $e) {
            error_log($e->getMessage());
            return null;
        }
    }
    public function delete($id): bool
    {
        try {
            $stmt = $this->db_resource->prepare($this->delete_query());
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return true;
        } catch (Exception|Error $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}