<?php
class user {
    private $id;
    private $name;
    private $surname;
    private $email;
    private $role;
    private $password;

    public function __construct() {}

    /**
     * @return mixed
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function get_role()
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function get_surname()
    {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function get_email()
    {
        return $this->email;
    }

    /**
     * @param mixed $id
     */
    public function id($id): user
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param mixed $name
     */
    public function name($name): user
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $surname
     */
    public function surname($surname): user
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @param mixed $email
     */
    public function email($email): user
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_password()
    {
        return $this->password;
    }


    /**
     * @param mixed $role
     */
    public function role($role): user
    {
        $this->role = $role;
        return $this;
    }
    public function password($password): user {
        $this->password = $password;
        return $this;
    }
}

