<?php
require_once "Repository.php";
class StudentRepository extends Repository{
    public function __construct(){
        parent::__construct("students");
    }

}