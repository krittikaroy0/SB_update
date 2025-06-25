<?php
session_start();
require_once "config.php"; // Your DB connection file

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$userEmail = $user['email'];
$imagePath = !empty($user['image']) ? 'uploads/' . htmlspecialchars($user['image']) : 'assets/img/default-profile.png';

// Hospital data for departments, doctors, and services (for navbar dropdown)
$hospital_data = [
    "Cardiology" => [
        "doctors" => ["Dr. Arif Rahman", "Dr. Maya Das"],
        "services" => ["ECG", "Echocardiogram", "Angiography"]
    ],
    "Neurology" => [
        "doctors" => ["Dr. Hossain Kabir"],
        "services" => ["EEG", "Stroke Management", "Neuro Imaging"]
    ],
    "Pediatrics" => [
        "doctors" => ["Dr. Rita Sultana", "Dr. Noman Akter"],
        "services" => ["Child Vaccination", "Growth Monitoring"]
    ],
    "Orthopedics" => [
        "doctors" => ["Dr. Amina Karim", "Dr. Jamal Uddin"],
        "services" => ["Fracture Treatment", "Joint Replacement"]
    ],
    "Gynecology & Obstetrics" => [
        "doctors" => ["Dr. Shabnam Noor"],
        "services" => ["Prenatal Checkup", "Delivery", "Ultrasound"]
    ],
    "Dermatology" => [
        "doctors" => ["Dr. Fahim Rahman"],
        "services" => ["Skin Biopsy", "Allergy Test", "Laser Treatment"]
    ],
];

// Fetch user's appointments from database
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
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar img.profile-pic {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
    }

    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-left: 0.1rem;
        margin-right: 0.1rem;
    }

    /* Remove blue outline on focus for accordion buttons */
    .accordion-button:focus {
        box-shadow: none;
    }

    .table thead {
        background-color: #198754;
        color: white;
    }

    .welcome-message {
        font-weight: 700;
        font-size: 1.4rem;
        color: #198754;
        margin-bottom: 1.5rem;
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary-subtle px-4 stick">
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/logo_bg.png" alt="ShasthoBondhu Logo" height="40" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">



            <!-- User info and actions -->
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item d-flex align-items-center">
                    <img src="<?= $imagePath ?>" alt="Profile Picture" class="profile-pic me-2" />
                    <div class="text-primary">
                        <div><strong><?= htmlspecialchars($user['name']) ?></strong></div>
                        <div class="small"><?= htmlspecialchars($user['email']) ?></div>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="appointments.php" class="btn btn-success text-warning btn-sm ms-3">Appointments</a>
                </li>
                <!-- Departments Dropdown -->
                <ul class="navbar-nav me-0 align-items-center">
                    <li class="nav-item d-flex align-items-center dropdown">
                        <a class="nav-link dropdown-toggle text-success fw-bold text-uppercase" href="#"
                            id="departmentsDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Departments</a>
                        <ul class="dropdown-menu" aria-labelledby="departmentsDropdown">
                            <?php foreach ($hospital_data as $dept => $details): ?>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#"><?= htmlspecialchars($dept) ?></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <h6 class="dropdown-header">Doctors</h6>
                                    </li>
                                    <?php foreach ($details['doctors'] as $doctor): ?>
                                    <li><a class="dropdown-item" href="#"><?= htmlspecialchars($doctor) ?></a></li>
                                    <?php endforeach; ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <h6 class="dropdown-header">Services</h6>
                                    </li>
                                    <?php foreach ($details['services'] as $service): ?>
                                    <li><a class="dropdown-item" href="#"><?= htmlspecialchars($service) ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>

                <li class="nav-item">
                    <a href="https://meet.google.com/" target="_blank"
                        class="text-success text-uppercase text-decoration-none fw-bold ms-2">Google Meet</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="btn btn-danger btn-sm ms-2">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main container -->
    <div class="container mt-4">

        <div id="welcome" class="welcome-message"></div>

        <!-- Appointment History -->
        <h4>Your Appointments</h4>
        <?php if (count($appointments) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Appointment Time</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= htmlspecialchars($appointment['service']) ?></td>
                        <td><?= htmlspecialchars($appointment['doctor']) ?></td>
                        <td><?= htmlspecialchars($appointment['department']) ?></td>
                        <td><?= date("d M Y, h:i A", strtotime($appointment['appointment_datetime'])) ?></td>
                        <td><?= date("d M Y, h:i A", strtotime($appointment['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-muted">No appointments booked yet.</p>
        <?php endif; ?>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Welcome message script -->
    <script>
    const userName = <?= json_encode($user['name']) ?>;
    document.getElementById('welcome').textContent = `Welcome to your dashboard, ${userName}!`;
    </script>

    <!-- Dropdown submenu support (Bootstrap 5 does not natively support multi-level dropdown) -->
    <script>
    // Enable dropdown submenu toggle on hover and click
    document.querySelectorAll('.dropdown-submenu > a').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;
            if (submenu) {
                submenu.classList.toggle('show');
            }
            // Close other open submenus
            document.querySelectorAll('.dropdown-submenu .dropdown-menu.show').forEach(function(
                openSubmenu) {
                if (openSubmenu !== submenu) {
                    openSubmenu.classList.remove('show');
                }
            });
            e.stopPropagation();
        });
    });

    // Close submenu when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-submenu .dropdown-menu.show').forEach(function(submenu) {
            submenu.classList.remove('show');
        });
    });
    </script>

</body>

</html>