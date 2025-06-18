<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "sb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data safely
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$zip = $_POST['zip'] ?? '';
$service = $_POST['service'] ?? '';
$datetime = $_POST['datetime'] ?? '';
$message = $_POST['message'] ?? '';
$terms = isset($_POST['terms']) ? 1 : 0;

// Check for duplicate booking
$check_sql = "SELECT * FROM appointments WHERE email = ? AND appointment_datetime = ? AND service = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("sss", $email, $datetime, $service);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo "<script>alert('You already have an appointment for this service at the same date and time.'); window.history.back();</script>";
    $check_stmt->close();
    $conn->close();
    exit();
}
$check_stmt->close();

// Image upload
$imagePath = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $imageName = basename($_FILES['image']['name']);
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $imagePath = $targetDir . time() . "_" . $imageName;
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
} else {
    echo "<script>alert('Please upload your image.'); window.history.back();</script>";
    $conn->close();
    exit();
}

// Insert appointment
$sql = "INSERT INTO appointments 
    (first_name, last_name, email, address, city, state, zip, service, appointment_datetime, message, image_path, agreed_terms)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<script>alert('Prepare failed: " . addslashes($conn->error) . "'); window.history.back();</script>";
    $conn->close();
    exit();
}

$stmt->bind_param(
    "sssssssssssi",
    $first_name,
    $last_name,
    $email,
    $address,
    $city,
    $state,
    $zip,
    $service,
    $datetime,
    $message,
    $imagePath,
    $terms
);

if ($stmt->execute()) {
    echo "<script>alert('Appointment booked successfully!'); window.location.href='index.html';</script>";
} else {
    $error = addslashes($stmt->error);
    echo "<script>alert('Error: $error'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
