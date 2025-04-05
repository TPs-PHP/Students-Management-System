<?php
class User
{
    public $id, $username, $email, $role;
    public function __construct($id, $username, $email, $role)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
    }
}
