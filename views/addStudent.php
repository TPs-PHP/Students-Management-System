<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <!-- Toggler Button for Mobile -->
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Students Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="listeEtudiants.php">Liste des étudiants</a></li>
                    <li class="nav-item"><a class="nav-link" href="listeSections.php">Liste des sections</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="login-container">
            <h3 class="text-center">Add Student</h3>
            <form action="addStudent.php" method="POST" enctype="multipart/form-data">
                <!-- First Name -->
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                </div>

                <!-- Last Name -->
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                </div>

                <!-- Birthday -->
                <div class="mb-3">
                    <label for="birthday" class="form-label">Birthday</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" required>
                </div>

                <!-- Image Upload -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>

                <!-- Section -->
                <div class="mb-3">
                    <label for="section" class="form-label">Section</label>
                    <select class="form-select" id="section" name="section" required>
                        <option value="" disabled selected>Select a section</option>
                        <option value="1">Génie Logiciel</option>
                        <option value="2">Réseaux Informatiques et Télécommunications</option>
                        <option value="3">Informatique Industrielle et Automatique</option>
                        <option value="4">Instrumentation et Maintenance Industrielle</option>
                        <option value="5">Chimie Industrielle</option>
                        <option value="6">Biologie Industrielle</option>
                    </select>
                </div>

                <!-- Add Button -->
                <button type="submit" name="submit" class="btn btn-primary w-100">Add</button>

            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php
require_once '../config/db.php';
require_once '../config/config.php';
require_once '../classes/StudentRepository.php';
//$bdd = ConnexionDB::getInstance();
$student_repo = new StudentRepository();
if (isset($_POST['submit'])) {
    $params= [
    'name' => $_POST['firstName'] . ' ' . $_POST['lastName'],
    "birthday" => $_POST['birthday'],
    "section_id" => $_POST['section'],
    'image' => $_FILES['image']['name']
    ];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    // Validate image
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['image']['type'], $allowed_types)) {
        echo "<script>alert('Invalid image format. Only JPG, PNG, and GIF allowed.');</script>";
    } elseif (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        /*$stmt = $bdd->prepare("INSERT INTO students (name, birthday, section_id, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $birthday, $section, $image]);*/
        $student_repo->create($params);
        echo "<script>alert('Student added successfully!'); window.location.href='listeEtudiants.php';</script>";
    } else {
        echo "<script>alert('Failed to upload image.');</script>";
    }
}
?>

</html>