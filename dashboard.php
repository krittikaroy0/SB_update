<?php
session_start();
require_once "config.php";
require_once "session.php";

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$userEmail = $user['email'];
$imagePath = !empty($user['image']) ? 'uploads/' . htmlspecialchars($user['image']) : 'assets/img/default-profile.png';

// Sample departments and doctors
$departments = [
    "Cardiology" => ["Dr. Arif Rahman", "Dr. Maya Das"],
    "Neurology" => ["Dr. Hossain Kabir"],
    "Pediatrics" => ["Dr. Rita Sultana", "Dr. Noman Akter"]
];

// Fetch user's appointments
$appointments = [];
$stmt = $db->prepare("SELECT service, doctor, department, appointment_datetime, created_at FROM appointments WHERE email = ? ORDER BY appointment_datetime DESC");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>User Dashboard - ShasthoBondhu</title>
    <link rel="icon" href="assets/img/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar img {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
        .accordion-button:focus {
            box-shadow: none;
        }
        .alert {
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-info px-4">
     <a class="navbar-brand ms-5" href="index.html">
                <img src="assets/img/logo_bg.png" class="w-35 d-block img-fluid" alt="ShasthoBondhu Logo"></a>
    <div class="ms-auto d-flex align-items-center gap-3">
        <img src="<?= $imagePath ?>" class="rounded-circle" alt="Profile" />
        <div class="text-success">
            <div><strong><?= htmlspecialchars($user['name']) ?></strong></div>
            <div class="small"><?= htmlspecialchars($user['email']) ?></div>
        </div>
        <a href="appointments.php" class="btn btn-light btn-sm">Appointment</a>
        <a href="https://meet.google.com/" target="_blank" class="btn btn-warning btn-sm">Google Meet</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-4">

    <!-- Flash Messages -->
    <?php if (!empty($_SESSION['success_msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success_msg'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_msg']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error_msg'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error_msg'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_msg']); ?>
    <?php endif; ?>

    <h3 id="welcome" class="text-success mb-4 fw-bold"></h3>

    <!-- Department Accordion -->
    <h4 class="mb-3">Department List</h4>
    <div class="accordion" id="departmentAccordion">
        <?php foreach ($departments as $dept => $doctors): ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?= md5($dept) ?>">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse<?= md5($dept) ?>"
                        aria-expanded="false"
                        aria-controls="collapse<?= md5($dept) ?>"
                    >
                        <?= htmlspecialchars($dept) ?>
                    </button>
                </h2>
                <div
                    id="collapse<?= md5($dept) ?>"
                    class="accordion-collapse collapse"
                    aria-labelledby="heading<?= md5($dept) ?>"
                    data-bs-parent="#departmentAccordion"
                >
                    <div class="accordion-body">
                        <ul class="mb-0">
                            <?php foreach ($doctors as $doc): ?>
                                <li><?= htmlspecialchars($doc) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Appointment History -->
    <h4 class="mt-5 mb-3">Your Appointments</h4>
    <?php if (count($appointments) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-success">
                    <tr>
                        <th>Service</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Appointment Time</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['service']) ?></td>
                            <td><?= htmlspecialchars($row['doctor']) ?></td>
                            <td><?= htmlspecialchars($row['department']) ?></td>
                            <td><?= date("d M Y, h:i A", strtotime($row['appointment_datetime'])) ?></td>
                            <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-muted">No appointments booked yet.</p>
    <?php endif; ?>
</div>

<!-- Welcome Script -->
<script>
    const userName = "<?= addslashes($user['name']) ?>";
    document.getElementById("welcome").textContent = "Welcome to your dashboard, " + userName + "!";
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
