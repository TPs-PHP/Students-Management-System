<?php
require_once '../config/db.php';
require_once '../config/config.php';
require_once '../classes/StudentRepository.php';
//$bdd = ConnexionDB::getInstance();
$studentRepo = new StudentRepository();

// Check if ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the student exists
    /*$stmt = $bdd->prepare("SELECT COUNT(*) FROM students WHERE id = ?");
    $stmt->execute([$id]);
    */
    $stmt = $studentRepo->findById($id);
    //$count = $stmt->fetchColumn();

    if (/*$count == 0*/ !$stmt) {
        echo "<script>alert('Student not found.'); window.location.href='listeEtudiants.php';</script>";
        exit;
    }

    // Delete the student
    /*$stmt = $bdd->prepare("DELETE FROM students WHERE id = ?");
    $result = $stmt->execute([$id]);
    */
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
