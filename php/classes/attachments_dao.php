<?php

class attachments_dao
{
    private $db_resource;
    private $target_directory;

    public function __construct($db_resource, $target_directory) {
        $this->db_resource = $db_resource;
        $this->target_directory = $target_directory;
    }

    public static function check_attachments($attachments) {
        $num_of_attachments = count($attachments['name']);
        if($num_of_attachments > 10 ) {
            echo '<p>More than 10 files are not allowed!</p>';
            return false;
        }

        for($i = 0; $i < $num_of_attachments; $i++) {
            if ($attachments["size"][$i] > 500000) {
                $name = $attachments["name"][$i];
                echo "Error! File $name is too large.";
                return false;
            }
        }
        return true;
    }

    public function add($attachments, $ticket_id, $department_id)
    {
        try {
            $path = '';
            $stmt = $this->db_resource->prepare('INSERT INTO attachments (path, ticket_id) VALUES (?,?)');
            $stmt->bind_param('si', $path, $ticket_id);

            foreach ($attachments['name'] as $attachment) {
                $path = $this->target_directory . "$department_id/$ticket_id/" . $attachment;
                $stmt->execute();
            }
        } catch (Exception $e) {
            return false;
        }
        $stmt->close();
        return true;
    }

    public function save_attachments($attachments, $ticket_id, $department_id) {
        $file_paths = [];
        $folder = $this->target_directory."$department_id/$ticket_id/";
        try {
            foreach ($attachments['tmp_name'] as $index => $tmp_file_path) {
                $file_name = $attachments['name'][$index];
                $this->create_path($folder);
                $target_file_path = $folder . $file_name;
                if (!move_uploaded_file($tmp_file_path, $target_file_path)) {
                    throw new Exception("Failed to save the file: $file_name");
                }
                $file_paths[] = $target_file_path;
            }
        } catch (Exception $e) {
            foreach($file_paths as $file_path)
                unlink($file_path);
            return false;
        }
        return true;
    }

    public function add_and_save($attachments, $ticket_id, $department_id) {
        if(!$this->add($attachments, $ticket_id, $department_id))
            return false;
        if(!$this->save_attachments($attachments, $ticket_id, $department_id))
            return false;
        return true;
    }

    private function create_path($path) {
        $curr_path = "";
        $elems = explode('/', $path);
        foreach($elems as $elem) {
            $curr_path .= $elem.'/';
            if(!is_dir($curr_path))
                mkdir($curr_path, 0777  );
        }
    }

    public function get_by_ticket_id($id) {
        try {
            $stmt = $this->db_resource->prepare('SELECT path FROM attachments WHERE ticket_id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result->num_rows > 0 ? $result->fetch_all() : false;
        } catch(mysqli_sql_exception $e) {
            return false;
        }
    }
}