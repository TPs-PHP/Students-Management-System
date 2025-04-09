<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
require_once '../config/db.php';
require_once '../config/config.php';
require_once '../classes/StudentRepository.php';
//$bdd = ConnexionDB::getInstance();
$studentRepo = new StudentRepository();
$section_filter = $_GET['section_filter'];
if (filter_var($section_filter, FILTER_VALIDATE_INT) === false) {
    header("Location:listeSections.php");
}
/*
$query = $bdd->query("SELECT students.id, students.name, students.birthday, students.image, sections.designation AS section, sections.id AS section_id
                      FROM students 
                      JOIN sections ON students.section_id = sections.id");
$students = $query->fetchAll();
*/
// Check if a name filter is applied
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $name = $_GET['name'];
    $students = $studentRepo->findByName($name);
} else {
    $students = $studentRepo->findAll();
}
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
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

    <!-- Filter Section -->
    <div class="container mt-4">
        <div class="container p-2 my-3
         border rounded bg-light">
            <h4>Liste des étudiants d<?php
                                        if ($section_filter == 1) {
                                            echo "e Génie Logiciel";
                                        } elseif ($section_filter == 2) {
                                            echo "e Réseaux Informatiques et Télécommunications";
                                        } elseif ($section_filter == 3) {
                                            echo "'Informatique Industrielle et Automatique";
                                        } elseif ($section_filter == 4) {
                                            echo "'Instrumentation et Maintenance Industrielle";
                                        } elseif ($section_filter == 5) {
                                            echo "e Chimie Industrielle";
                                        } elseif ($section_filter == 6) {
                                            echo "e Biologie Industrielle";
                                        }
                                        ?>
            </h4>
        </div>
        <div class="mb-3">
            <input id="filterName" type="text" class="form-control d-inline-block w-50" placeholder="Veuillez renseigner votre nom">
            <button class="btn btn-danger" id="filterButton">Filtrer</button>
            <script>
                function filterResult() {
                    let name = document.getElementById('filterName').value;
                    // valeur vide
                    let url = "listeEtudiantsSection.php?section_filter=" + "<?php echo $section_filter; ?>";
                    if (name.trim()) {
                        url += "&name=" + encodeURIComponent(name);
                    }
                    window.location.href = url;
                }
                document.getElementById('filterButton').addEventListener('click', filterResult);
                document.getElementById('filterName').addEventListener('keypress', function(event) {
                    if (event.key === 'Enter') {
                        filterResult();
                    }
                });
            </script>
            <?php if ($isAdmin): ?>
                <a class="btn btn-primary" href="addStudent.php"><i class="fas fa-user-plus"></i></a>
            <?php endif; ?>        
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
                    <th>Image</th>
                    <th>Name</th>
                    <th>Birthday</th>
                    <th>Section</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student):
                    if ($student['section_id'] == $section_filter) { ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><img src="<?php echo "../uploads/" . $student['image']; ?>" class="rounded-circle" width="50" height="50"></td>
                            <td><?php echo $student['name']; ?></td>
                            <td><?php echo $student['birthday']; ?></td>
                            <td><?php echo $student['section']; ?></td>
                            <td>
                                <a class="btn btn-info btn-sm" href="profile.php?id=<?php echo $student['id']; ?>&name=<?php echo urlencode($student['name']); ?>&birthday=<?php echo $student['birthday']; ?>&section=<?php echo $student['section_id']; ?>&image=<?php echo $student['image']; ?>"><i class="fas fa-eye"></i></a>
                                <?php if ($isAdmin): ?>
                                <a class="btn btn-warning btn-sm" href="editStudent.php?id=<?php echo $student['id']; ?>&name=<?php echo urlencode($student['name']); ?>&birthday=<?php echo $student['birthday']; ?>&section=<?php echo $student['section_id']; ?>"><i class="fas fa-edit"></i></a>                                
                                <a class="btn btn-danger btn-sm" href="deleteStudent.php?id=<?php echo $student['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?');"><i class="fas fa-trash"></i></a>
                                <?php endif; ?>    
                            </td>
                        </tr>
                <?php }
                endforeach; ?>
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
            buttons: [{
                    extend: 'copy',
                    className: "btn btn-secondary",
                    text: '<i class="fas fa-copy"></i> Copy',
                    action: function(e, dt, node, config) {
                        alert('Data has been copied to the clipboard!');
                    }
                },
                {
                    extend: 'excel',
                    className: "btn btn-secondary",
                    text: '<i class="fas fa-file-excel"></i> Excel'
                },
                {
                    extend: 'csv',
                    className: "btn btn-secondary",
                    text: '<i class="fas fa-file-csv"></i> CSV'
                },
                {
                    extend: 'pdf',
                    className: "btn btn-secondary",
                    text: '<i class="fas fa-file-pdf"></i> PDF'
                },
            ]
        });
    });
</script>


</html>