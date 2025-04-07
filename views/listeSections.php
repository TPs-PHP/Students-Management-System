<!DOCTYPE html>
<html lang="fr">
<?php
require_once '../config/db.php';
require_once '../config/config.php';
require_once '../classes/SectionRepository.php';
//$bdd = ConnexionDB::getInstance();
/*$query = $bdd->query("SELECT *
                      FROM sections");
$sections = $query->fetchAll();*/
$sectionRepo = new SectionRepository();
$sections = $sectionRepo->findAll();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sections List</title>

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

    <!-- Table Section -->
    <div class="container mt-4">
        <div class="container p-2 my-3
         border rounded bg-light">
            <h4>Liste des séctions</h4>
        </div>
        <!-- Buttons -->
        <!--
        <div class="mb-3 p-2">
            <button class="btn btn-secondary"><i class="fas fa-copy"></i> Copy</button>
            <button class="btn btn-secondary"><i class="fas fa-file-excel"></i> Excel</button>
            <button class="btn btn-secondary"><i class="fas fa-file-csv"></i> CSV</button>
            <button class="btn btn-secondary"><i class="fas fa-file-pdf"></i> PDF</button>
        </div>
        -->
        <!-- Table -->
        <table id="studentsTable" class="table pt-3 table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Designation</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sections as $section) : ?>
                    <tr>
                        <td><?= $section['id'] ?></td>
                        <td><?= $section['designation'] ?></td>
                        <td><?= $section['description'] ?></td>
                        <td>
                            <button class="btn btn-info btn-sm" id="<?php echo $section['id'];?>" onclick="filtrer(<?php echo $section['id'];?>)"><i class="fas fa-bars"></i></button>
                            <script>
                                function filtrer(id){
                                    url = "listeEtudiantsSection.php?section_filter=" + id;
                                    window.location.href = url;
                                }
                            </script>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS & DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    
    <!-- JSZip (pour Excel) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!-- pdfmake (pour PDF) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

</body>
<script>
    $(document).ready(function() {
        $('#studentsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {extend : 'copy', className : "btn btn-secondary", text: '<i class="fas fa-copy"></i> Copy', action: function (e, dt, node, config) {alert('Data has been copied to the clipboard!');}},
                {extend : 'excel', className : "btn btn-secondary", text : '<i class="fas fa-file-excel"></i> Excel'},
                {extend : 'csv', className : "btn btn-secondary", text : '<i class="fas fa-file-csv"></i> CSV'},
                {extend : 'pdf', className : "btn btn-secondary", text : '<i class="fas fa-file-pdf"></i> PDF'}, 
            ]
        });
    });
</script>

</html>