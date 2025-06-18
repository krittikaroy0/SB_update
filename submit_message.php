<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader or include manually
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// DB connection
$conn = new mysqli("localhost", "root", "", "sb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data safely
$full_name = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$comment = $_POST['comment'] ?? '';

// Validation
if (empty($full_name) || empty($email)) {
    echo "<script>alert('Full name and email are required.'); window.history.back();</script>";
    exit();
}

if (!preg_match("/^[\w\.-]+@gmail\.com$/", $email)) {
    echo "<script>alert('Please enter a valid Gmail address.'); window.history.back();</script>";
    exit();
}

// Save to database
$sql = "INSERT INTO messages (full_name, email, address, comment) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $full_name, $email, $address, $comment);
$stmt->execute();
$stmt->close();

// Email sending
$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'krittikaroy2020@gmail.com';            // Replace with your Gmail
    $mail->Password   = '123';         // Replace with Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Email to admin
    $mail->setFrom('krittikaroy2020@gmail.com', 'ShasthoBondhu');
    $mail->addAddress('krittikaroy2020@gmail.com', 'Admin');  // Admin email
    $mail->Subject = 'New Contact Message from ShasthoBondhu';
    $mail->Body    = "New message received:\n\n"
                   . "Name: $full_name\nEmail: $email\nAddress: $address\n\nComment:\n$comment";

    $mail->send();

    // Email to user
    $mail->clearAllRecipients();
    $mail->addAddress($email, $full_name);
    $mail->Subject = 'Thank You for Contacting ShasthoBondhu';
    $mail->Body    = "Dear $full_name,\n\nThank you for your message. We have received it successfully and will contact you shortly.\n\nRegards,\nShasthoBondhu Team";

    $mail->send();

    echo "<script>alert('Thank you for your message! Confirmation sent to your email.'); window.location.href='index.html';</script>";
} catch (Exception $e) {
    echo "<script>alert('Message saved, but email sending failed: {$mail->ErrorInfo}'); window.location.href='index.html';</script>";
}

$conn->close();
?>
