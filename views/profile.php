<!DOCTYPE html>
<html lang="fr">
<?php
require_once '../config/db.php';
require_once '../config/config.php';
require_once '../classes/SectionRepository.php';
//$bdd = ConnexionDB::getInstance();
$sectionRepo = new SectionRepository();
$id = $_GET['id'] ?? null;
$name = $_GET['name'] ?? null;
$birthday = $_GET['birthday'] ?? null;
$section_id = $_GET['section'] ?? null;
$image = $_GET['image'] ?? null;
$section = $sectionRepo->findById($section_id);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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

    <div class="container mt-4 p-2">
        <div class="container p-2 my-3
         border rounded bg-light">
            <h4>Profile de <?php echo $name ?></h4>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3 d-flex justify-content-center">
                <img src="<?php echo "../uploads/" . $image ?>" alt="Student Image" class="rounded-circle" width="250" height="250">
            </div>
            <div class="col-md-9 d-flex flex-column justify-content-center ps-4">
                <h5><strong>Nom: </strong><?php echo $name ?></h5>
                <br>
                <h5><strong>ID: </strong><?php echo $id ?></h5>
                <br>
                <h5><strong>Date de naissance: </strong><?php echo $birthday ?></h5>
                <br>
                <h5><strong>Section: </strong><?php echo $section['description'] ?></h5>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

</body>

</html>