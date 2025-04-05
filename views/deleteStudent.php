<?php
require_once '../config/db.php';
require_once '../config/config.php';
$bdd = ConnexionDB::getInstance();

// Check if ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the student exists
    $stmt = $bdd->prepare("SELECT COUNT(*) FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        echo "<script>alert('Student not found.'); window.location.href='listeEtudiants.php';</script>";
        exit;
    }

    // Delete the student
    $stmt = $bdd->prepare("DELETE FROM students WHERE id = ?");
    $result = $stmt->execute([$id]);

    if ($result) {
        echo "<script>alert('Student deleted successfully!'); window.location.href='listeEtudiants.php';</script>";
    } else {
        echo "<script>alert('Failed to delete student.'); window.location.href='listeEtudiants.php';</script>";
        var_dump($stmt->errorInfo());
    }
} else {
    echo "<script>alert('Invalid student ID.'); window.location.href='listeEtudiants.php';</script>";
}
