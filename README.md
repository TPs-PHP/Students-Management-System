# Students Management System

## Description

This project is a Students Management System built with PHP and MySQL. It allows administrators to manage student data, including adding, editing, and deleting student records. Regular users can view and filter the list of students. 

The system includes role-based access control where only admins have the permission to modify student data.

## Features

- **Admin**:
  - View, add, edit, and delete student records.
  - Manage student details like name, birthday, section, etc.
  
- **Regular User**:
  - View student records.
  - Apply name-based filters to search for students.

## Users

The following users are pre-configured and ready to use:

1. **Admin User**:
   - **Username**: `admin`
   - **Password**: `ladmin123`
   - **Role**: `admin`
   
   The admin user has full access to all features, including adding, editing, and deleting student records.

2. **Regular User**:
   - **Username**: `student1`
   - **Password**: `luser123`
   - **Role**: `user`
   
   The regular user can view the student list and apply filters but cannot modify the data.

## Requirements

- PHP 7.4 or higher
- MySQL
- Apache (or any other web server with PHP support)

## Installation

1. Clone or download the project.
2. Import the database schema (`students_management_system.sql`) into your MySQL database.
3. Copy the `config/config.example.php` and rename it to `config/config.php`
4. Configure your database connection in `config/config.php` with the correct credentials.
5. Start your web server (e.g., XAMPP) and navigate to the project directory.
6. Access the application in your browser (e.g., `http://localhost/Students-Management-System`).