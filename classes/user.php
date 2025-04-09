<?php
require_once "Repository.php";
class User extends Repository
{
    public $id, $username, $email, $role;
    public function __construct($id, $username, $email, $role)
    {
        parent::__construct("users");
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
    }
}
