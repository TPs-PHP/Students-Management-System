<?php
class Section
{
    public $id, $designation, $description;    
    public function __construct($id, $designation, $description)
    {
        $this->id = $id;
        $this->designation = $designation;
        $this->description = $description;
    }
    public function create()
    {
        // Code to create a new section record in the database
        // Example: INSERT INTO sections (designation, description) VALUES ($this->designation, $this->description)
        // Return true on success, false on failure
    }
    public function read()
    {
        // Code to read a section record from the database
        // Example: SELECT * FROM sections WHERE id = $this->id
        // Return the section record as an associative array
    }
    
    public function update()
    {
        // Code to update a section record in the database
        // Example: UPDATE sections SET designation = $this->designation, description = $this->description WHERE id = $this->id
        // Return true on success, false on failure
    }
    
    public function delete()
    {
        // Code to delete a section record from the database
        // Example: DELETE FROM sections WHERE id = $this->id
        // Return true on success, false on failure
    }
    public function getAllSections()
    {
        // Code to get all section records from the database
        // Example: SELECT * FROM sections
        // Return an array of section records as associative arrays
    }
    public function getStudents()
    {
        // Code to get all students in this section from the database
        // Example: SELECT * FROM students WHERE section_id = $this->id
        // Return an array of student records as associative arrays
    }
}