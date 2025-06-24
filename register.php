<?php
require_once __DIR__ . '/includes/session.php';
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Todo App</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <form id="registerForm" class="auth-form">
            <h2>Register</h2>
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Register</button>
            <p>Already have an account? <a href="index.php">Login here</a></p>
        </form>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>