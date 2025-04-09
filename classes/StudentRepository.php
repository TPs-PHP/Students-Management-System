<?php
require_once "Repository.php";
class StudentRepository extends Repository{
    private $query = "SELECT students.id, students.name, students.birthday, students.image, sections.designation AS section, sections.id AS section_id
                        FROM students 
                        JOIN sections ON students.section_id = sections.id";
    public $id, $name, $birthday, $image, $section_id, $section;
    public function __construct($id=null, $name=null, $birthday=null, $image=null, $section_id=null, $section=null){
        parent::__construct("students");
        $this->id = $id;
        $this->name = $name;
        $this->birthday = $birthday;
        $this->image = $image;
        $this->section_id = $section_id;
        $this->section = $section;
    }

    //redefine the findAll method to JOIN the sections table
    public function findAll() {
        $stmt = $this->query;
        $result = $this->db->query($stmt);
        return $result->fetchAll();
    }

    public function findByName($name) {
        $stmt = $this->query . " WHERE students.name LIKE :name";
        $response = $this->db->prepare($stmt);
        $response->execute(['name' => '%' . $name . '%']);
        return $response->fetchAll();
    }
}