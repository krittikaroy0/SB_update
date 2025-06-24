<?php
session_start();
require_once "config.php"; // Your DB connection

$error = '';
$max_attempts = 5;
$lockout_time = 60; // seconds

// Fetch current DB time as UNIX timestamp for synchronization
$result = $db->query("SELECT UNIX_TIMESTAMP(NOW()) as dbtime");
$row = $result->fetch_assoc();
$current_time = $row['dbtime'] ?? time(); // fallback to PHP time if DB query fails

$remaining_seconds = 0;
$show_lock_alert = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) $error .= '<p>Please enter your email.</p>';
    if (empty($password)) $error .= '<p>Please enter your password.</p>';

    if (empty($error)) {
        $stmt = $db->prepare("SELECT id, name, email, password, login_attempts, last_attempt FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $name, $email_db, $hashed_password, $attempts, $last_attempt);
            $stmt->fetch();

            $last_attempt_time = $last_attempt ? strtotime($last_attempt) : 0;
            // Use DB time, so adjust last_attempt_time to UNIX timestamp from DB as well:
            // We'll replace last_attempt_time with DB timestamp (UNIX_TIMESTAMP(last_attempt)) below

            // Get UNIX_TIMESTAMP of last_attempt from DB to avoid mismatch
            $last_attempt_unix = 0;
            if ($last_attempt) {
                $lastAttemptStmt = $db->prepare("SELECT UNIX_TIMESTAMP(?) as last_attempt_unix");
                $lastAttemptStmt->bind_param("s", $last_attempt);
                $lastAttemptStmt->execute();
                $lastAttemptStmt->bind_result($last_attempt_unix);
                $lastAttemptStmt->fetch();
                $lastAttemptStmt->close();
            }

            $last_attempt_time = $last_attempt_unix ?: 0;

            $time_since_last = $current_time - $last_attempt_time;

            // Reset lockout if expired
            if ($attempts >= $max_attempts && $time_since_last >= $lockout_time) {
                $reset = $db->prepare("UPDATE users SET login_attempts = 0, last_attempt = NULL WHERE email = ?");
                $reset->bind_param("s", $email);
                $reset->execute();
                $reset->close();
                $attempts = 0;
                $last_attempt_time = 0;
                $time_since_last = 0;
            }

            // Check lock status
            if ($attempts >= $max_attempts && $time_since_last < $lockout_time) {
                $remaining_seconds = $lockout_time - $time_since_last;
                $show_lock_alert = true;
            }

            // Proceed to login if not locked
            if (!$show_lock_alert) {
                if (password_verify($password, $hashed_password)) {
                    // Successful login
                    $_SESSION["userid"] = $id;
                    $_SESSION["user"] = [
                        'id' => $id,
                        'name' => $name,
                        'email' => $email_db
                    ];

                    // Reset attempts on success
                    $reset = $db->prepare("UPDATE users SET login_attempts = 0, last_attempt = NULL WHERE email = ?");
                    $reset->bind_param("s", $email);
                    $reset->execute();
                    $reset->close();

                    header("Location: index.html");
                    exit;
                } else {
                    // Failed password
                    $attempts++;
                    if ($attempts >= $max_attempts) {
                        $update = $db->prepare("UPDATE users SET login_attempts = ?, last_attempt = NOW() WHERE email = ?");
                        $update->bind_param("is", $attempts, $email);
                        $update->execute();
                        $update->close();

                        $remaining_seconds = $lockout_time;
                        $show_lock_alert = true;
                    } else {
                        $update = $db->prepare("UPDATE users SET login_attempts = ? WHERE email = ?");
                        $update->bind_param("is", $attempts, $email);
                        $update->execute();
                        $update->close();

                        $error .= "<p>Incorrect password.</p>";
                    }
                }
            }
        } else {
            $error .= "<p>No user found with that email address.</p>";
        }
        $stmt->close();
    }
    $db->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Login - ShasthoBondhu</title>
    <link rel="icon" href="assets/img/logo.png">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
    <!-- default css -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body id="login">
    <section class="container mt-5 pt-5">
        <div class="col-6  mx-auto pt-5 py-5 card bg-body-tertiary">
            <h2 class="text-center text-success h1 font-times text-uppercase fw-bold"> <img src="assets/img/logo_bg.png"
                    class="w-15 d-inline-block" alt="ShasthoBondhu Logo">Login</h2>
            <p class="text-center text-info">Please enter your email and password to log in.</p>

            <?php if (!empty($error) && !$show_lock_alert): ?>
            <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <?php if ($show_lock_alert): ?>
            <div class="alert alert-warning">
                <strong>Your account is locked!</strong><br>
                Try again in <span id="countdown"><?= (int)$remaining_seconds ?></span> seconds.
            </div>
            <script>
            let seconds = <?= (int)$remaining_seconds ?>;
            const countdownEl = document.getElementById("countdown");
            const interval = setInterval(() => {
                seconds--;
                if (seconds <= 0) {
                    clearInterval(interval);
                    countdownEl.innerText = "Unlocked! Please refresh the page.";
                    document.querySelector("form").style.pointerEvents = 'auto';
                    document.querySelector("form").style.opacity = 1;
                } else {
                    countdownEl.innerText = seconds + " seconds";
                }
            }, 1000);
            </script>
            <?php endif; ?>
            <div class="col-12 ">
                <form action="" method="post"
                    <?= $show_lock_alert ? 'style="pointer-events: none; opacity: 0.5;"' : '' ?>>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Login" />
                    </div>
                    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
                </form>
            </div>

    </section>


</body>

</html>