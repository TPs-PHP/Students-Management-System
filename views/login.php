<?php
session_start();
require_once '../config/db.php';  // Adjust the path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['emailorusername'];  // Could be username or email
    $password = $_POST['password'];  // The entered password

    // Get database connection
    $conn = ConnexionDB::getInstance();

    // Prepare the query to check for the username or email
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :emailorusername OR email = :emailorusername");
    $stmt->bindParam(':emailorusername', $username);
    $stmt->execute();
    
    // Fetch the user data
    $user = $stmt->fetch();

    // Debugging: Output the fetched user data
    echo "<pre>";
    print_r($user);
    echo "</pre>";

    // Check if the user exists and the password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Password is correct, start session and redirect to home.php
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];  // Store role for later use if needed

        // Redirect to home.php after successful login
        header('Location: home.php');
        exit;  // Always call exit after redirect
    } else {
        // Invalid username or password
        $error_message = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h3 class="text-center">Login</h3>
            <form action="login.php" method="POST">
                <!-- Username or Email -->
                <div class="mb-3">
                    <label for="emailorusername" class="form-label">Email/Username</label>
                    <input type="text" class="form-control" id="emailorusername" name="emailorusername" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <!-- Remember Me -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-primary w-100">Login</button>

                <!-- Error Message -->
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger mt-3"><?= $error_message ?></div>
                <?php endif; ?>

                <!-- Forgot Password -->
                
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
