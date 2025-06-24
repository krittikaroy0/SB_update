<?php
// Start the session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If the user is already logged in, redirect to the welcome page
if (isset($_SESSION["userid"]) && $_SESSION["userid"] === true) {
    header("Location: welcome.php");
    exit;
}
?>
