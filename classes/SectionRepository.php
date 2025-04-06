<?php
require_once "Repository.php";
class SectionRepository extends Repository{
    public function __construct(){
        parent::__construct("sections");
    }

}