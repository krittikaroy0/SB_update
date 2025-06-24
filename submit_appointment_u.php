<?php
session_start();
require_once "config.php";
require_once "session.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);
    $city = trim($_POST["city"]);
    $state = trim($_POST["state"]);
    $zip = trim($_POST["zip"]);
    $department = trim($_POST["department"]);
    $doctor = trim($_POST["doctor"]);
    $service = trim($_POST["service"]);
    $appointment_datetime = trim($_POST["appointment_datetime"]); // corrected to match input name
    $message = trim($_POST["message"]);

    // Validate required fields
    if (
        empty($first_name) || empty($last_name) || empty($email) || empty($service) ||
        empty($appointment_datetime) || empty($doctor) || empty($department)
    ) {
        $_SESSION['error_msg'] = "All required fields must be filled out.";
        header("Location: dashboard.php");
        exit();
    }

    // Handle image upload
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target_path = "uploads/" . $image_name;

        if (!move_uploaded_file($image_tmp, $target_path)) {
            $_SESSION['error_msg'] = "Failed to upload image.";
            header("Location: dashboard.php");
            exit();
        }
    }

    // Check for duplicate appointment (same email + service + date)
    $check_stmt = $db->prepare("SELECT COUNT(*) FROM appointments WHERE email = ? AND service = ? AND DATE(appointment_datetime) = DATE(?)");
    $check_stmt->bind_param("sss", $email, $service, $appointment_datetime);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        $_SESSION['error_msg'] = "You have already booked this service on the selected date.";
        header("Location: dashboard.php");
        exit();
    }

    // Insert appointment into database
    $stmt = $db->prepare("INSERT INTO appointments (first_name, last_name, email, image, address, city, state, zip, department, doctor, service, appointment_datetime, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $first_name, $last_name, $email, $image_name, $address, $city, $state, $zip, $department, $doctor, $service, $appointment_datetime, $message);

    if ($stmt->execute()) {
        // Save success message in session for dashboard display
        $_SESSION['success_msg'] = "Thank you, " . htmlspecialchars($first_name) . " " . htmlspecialchars($last_name) . ". Your appointment for <strong>" . htmlspecialchars($service) . "</strong> with Dr. " . htmlspecialchars($doctor) . " on <strong>" . date("d M Y, h:i A", strtotime($appointment_datetime)) . "</strong> has been received.";
    } else {
        $_SESSION['error_msg'] = "Error saving appointment: " . $stmt->error;
    }

    $stmt->close();
    $db->close();

    header("Location: dashboard.php");
    exit();
} else {
    // If accessed directly, redirect to dashboard
    header("Location: dashboard.php");
    exit();
}