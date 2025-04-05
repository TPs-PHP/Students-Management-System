<?php
class Student
{
    public $id, $name, $birthday, $image, $section_id;
    public function __construct($id, $name, $birthday, $image, $section_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthday = $birthday;
        $this->image = $image;
        $this->section_id = $section_id;
    }
    public function create()
    {
        // Code to create a new student record in the database
        // Example: INSERT INTO students (name, birthday, image, section_id) VALUES ($this->name, $this->birthday, $this->image, $this->section_id)
        // Return true on success, false on failure
    }
    public function read()
    {
        // Code to read a student record from the database
        // Example: SELECT * FROM students WHERE id = $this->id
        // Return the student record as an associative array
    }
    public function update()
    {
        // Code to update a student record in the database
        // Example: UPDATE students SET name = $this->name, birthday = $this->birthday, image = $this->image, section_id = $this->section_id WHERE id = $this->id
        // Return true on success, false on failure
    }
    public function delete()
    {
        // Code to delete a student record from the database
        // Example: DELETE FROM students WHERE id = $this->id
        // Return true on success, false on failure
    }
    public function getAllStudents()
    {
        // Code to get all student records from the database
        // Example: SELECT * FROM students
        // Return an array of student records as associative arrays
    }
}
