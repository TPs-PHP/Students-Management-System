<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION = []; // Clear session data
    session_destroy(); // Destroy the session
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once '../config/db.php';
require_once '../config/config.php';

//$bdd = ConnexionDB::getInstance();

// Get values from URL
$id = $_GET['id'] ?? null;
$name = $_GET['name'] ?? '';
$birthday = $_GET['birthday'] ?? '';
$section = $_GET['section'] ?? '';
$image = $_GET['image'] ?? '';

// Split the name into first and last name if needed
$nameParts = explode(' ', $name, 2);
$firstName = $nameParts[0] ?? '';
$lastName = $nameParts[1] ?? '';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Students Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="listeEtudiants.php">Liste des étudiants</a></li>
                    <li class="nav-item"><a class="nav-link" href="listeSections.php">Liste des sections</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="login-container">
            <h3 class="text-center">Edit Student</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Hidden field to preserve the student ID -->
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <!-- First Name -->
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>" required>
                </div>

                <!-- Last Name -->
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>" required>
                </div>

                <!-- Birthday -->
                <div class="mb-3">
                    <label for="birthday" class="form-label">Birthday</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($birthday); ?>" required>
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
                        <option value="" disabled <?php echo empty($section) ? 'selected' : ''; ?>>Select a section</option>
                        <option value="1" <?php echo $section == '1' ? 'selected' : ''; ?>>Génie Logiciel</option>
                        <option value="2" <?php echo $section == '2' ? 'selected' : ''; ?>>Réseaux Informatiques et Télécommunications</option>
                        <option value="3" <?php echo $section == '3' ? 'selected' : ''; ?>>Informatique Industrielle et Automatique</option>
                        <option value="4" <?php echo $section == '4' ? 'selected' : ''; ?>>Instrumentation et Maintenance Industrielle</option>
                        <option value="5" <?php echo $section == '5' ? 'selected' : ''; ?>>Chimie Industrielle</option>
                        <option value="6" <?php echo $section == '6' ? 'selected' : ''; ?>>Biologie Industrielle</option>
                    </select>
                </div>

                <!-- Update Button -->
                <button type="submit" name="submit" class="btn btn-primary w-100">Update</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
require_once '../classes/StudentRepository.php';
$studentRepo = new StudentRepository();
if (isset($_POST['submit'])) {
    // Use the ID from the hidden field instead of $_GET
    $id = $_POST['id'] ?? null;

    $name = $_POST['firstName'] . ' ' . $_POST['lastName'];
    $birthday = $_POST['birthday'];
    $section = $_POST['section'];
    $image = $_FILES['image']['name'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Validate image
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['image']['type'], $allowed_types)) {
        echo "<script>alert('Invalid image format. Only JPG, PNG, and GIF allowed.');</script>";
    } elseif (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Check if the student exists
        /*$stmt = $bdd->prepare("SELECT COUNT(*) FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();
        */
        $stmt = $studentRepo->findById($id);
        if (/*$count == 0*/ !$stmt) {
            echo "<script>alert('Student not found.'); window.location.href='listeEtudiants.php';</script>";
            exit;
        }

        // Prepare the update query
        $params = [
            'name' => $name,
            'birthday' => $birthday,
            'section_id' => $section,
            'image' => $image,
            'id' => $id
        ];
        /*
        $stmt = $bdd->prepare("UPDATE students SET name = ?, birthday = ?, section_id = ?, image = ? WHERE id = ?");
        $result = $stmt->execute([$name, $birthday, $section, $image, $id]);
        */
        $result = $studentRepo->update($params);
        if (!$result) {
            var_dump($stmt->errorInfo());
        } else {
            echo "<script>alert('Student updated successfully!'); window.location.href='listeEtudiants.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Failed to upload image.');</script>";
    }
}
?>

</html>