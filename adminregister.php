<?php
require 'db.php';

// Check if admin already exists
$stmt = $pdo->query("SELECT COUNT(*) FROM admin");
if ($stmt->fetchColumn() > 0) {
    die("Admin already registered. <a href='adminlogin.php'>Login here</a>.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
    $stmt->execute([$email, $password]);
    echo "Admin registered successfully. <a href='adminlogin.php'>Login here</a>.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h3 class="text-center">Admin Registration</h3>
        <form method="POST">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Register</button>
        </form>
    </div>
</body>
</html>
