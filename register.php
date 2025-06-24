<?php
require_once "config.php";
require_once "session.php";

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $fullname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST["confirm_password"]);

    // Image upload
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_dir = "uploads/";
    $image_path = $upload_dir . basename($image_name);

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    if ($query = $db->prepare("SELECT id FROM users WHERE email = ?")) {
        $query->bind_param('s', $email);
        $query->execute();
        $query->store_result();

        if ($query->num_rows > 0) {
            $error .= '<p class="error">The email address is already registered!</p>';
        } else {
            // Validate password length
            if (strlen($password) < 6) {
                $error .= '<p class="error">Password must have at least 6 characters.</p>';
            }

            // Validate confirm password
            if (empty($confirm_password)) {
                $error .= '<p class="error">Please enter confirm password.</p>';
            } elseif ($password !== $confirm_password) {
                $error .= '<p class="error">Passwords do not match.</p>';
            }

            // Proceed if no errors
            if (empty($error)) {
                if (move_uploaded_file($image_tmp, $image_path)) {
                    $insertQuery = $db->prepare("INSERT INTO users (name, email, password, image) VALUES (?, ?, ?, ?)");
                    $insertQuery->bind_param("ssss", $fullname, $email, $password_hash, $image_name);
                    $result = $insertQuery->execute();

                    if ($result) {
                        $success = "Your registration was successful!";
                    } else {
                        $error .= '<p class="error">Something went wrong while saving to database!</p>';
                    }

                    $insertQuery->close();
                } else {
                    $error .= '<p class="error">Image upload failed.</p>';
                }
            }
        }
        $query->close();
    }
    $db->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - ShasthoBondhu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container pt-5">
        <div class="row pt-5">
            <div class="col-md-8 card py-5 shadow-lg mx-auto">
                <h2 class="text-center text-success h1" style="font-family: 'Times New Roman', Times, serif;">
                    <img src="assets/img/logo_bg.png" style="width: 40px;" class="me-2 d-inline-block" alt="ShasthoBondhu Logo">
                    Register
                </h2>
                <p class="text-center text-info">Please fill this form to create an account.</p>

                <?php if (!empty($success)) { echo "<div class='alert alert-success'>$success</div>"; } ?>
                <?php if (!empty($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Upload Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <img id="preview" src="#" alt="Image Preview" class="img-thumbnail mt-2" style="display: none; max-height: 200px;">
                    </div>
                    <div class="form-group mt-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <div class="form-group mt-4">
                        <input type="submit" name="submit" class="btn btn-primary w-100" value="Submit">
                    </div>
                    <p class="mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
                </form>
            </div>
        </div>
    </div>

    <script>
    // Live preview of uploaded image
    document.querySelector("input[name='image']").addEventListener("change", function (e) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById("preview");
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(e.target.files[0]);
    });
    </script>
</body>
</html>
