<?php
require_once "Repository.php";
class SectionRepository extends Repository{
    public $id, $designation, $description;  
    public function __construct($id=null, $designation=null, $description=null){
        parent::__construct("sections");
        $this->id = $id;
        $this->designation = $designation;
        $this->description = $description;
    }

}