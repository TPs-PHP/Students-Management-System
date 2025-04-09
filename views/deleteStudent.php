<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION = []; // Clear session data
    session_destroy(); // Destroy the session
    header('Location: login.php');
    exit;
}
?>
<?php

require_once '../classes/StudentRepository.php';

$studentRepo = new StudentRepository();

// Check if ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the student exists
    
    $stmt = $studentRepo->findById($id);

    if (!$stmt) {
        echo "<script>alert('Student not found.'); window.location.href='listeEtudiants.php';</script>";
        exit;
    }

    // Delete the student
    $result = $studentRepo->delete($id);
    if ($result) {
        echo "<script>alert('Student deleted successfully!'); window.location.href='listeEtudiants.php';</script>";
    } else {
        echo "<script>alert('Failed to delete student.'); window.location.href='listeEtudiants.php';</script>";
        var_dump($stmt->errorInfo());
    }
} else {
    echo "<script>alert('Invalid student ID.'); window.location.href='listeEtudiants.php';</script>";
}
