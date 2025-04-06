<?php
require_once "Repository.php";
class StudentRepository extends Repository{
    private $query = "SELECT students.id, students.name, students.birthday, students.image, sections.designation AS section, sections.id AS section_id
                        FROM students 
                        JOIN sections ON students.section_id = sections.id";
    public function __construct(){
        parent::__construct("students");
    }

    //redefine the findAll method to JOIN the sections table
    public function findAll() {
        $stmt = $this->query;
        $result = $this->db->query($stmt);
        return $result->fetchAll();
    }
    
}