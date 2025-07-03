<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Fetch Appointments
$appointments = $pdo->query("SELECT * FROM appointments ORDER BY appointment_datetime DESC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch Users
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch Messages
$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ShasthoBondhu Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">ShasthoBondhu Admin Dashboard</a>
        <div class="ms-auto">
            <a href="logout.php" class="btn btn-light">Logout</a>
        </div>
    </div>
</nav>

<div class="container my-4">
    <h2>Appointments</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Service</th>
                    <th>Appointment Date & Time</th>
                    <th>Message</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= htmlspecialchars($a['first_name'] . ' ' . $a['last_name']) ?></td>
                        <td><?= htmlspecialchars($a['email']) ?></td>
                        <td>
                            <?php if ($a['image']): ?>
                                <img src="<?= htmlspecialchars($a['image']) ?>" alt="Patient Image" width="50">
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($a['address']) ?></td>
                        <td><?= htmlspecialchars($a['city']) ?></td>
                        <td><?= htmlspecialchars($a['state']) ?></td>
                        <td><?= htmlspecialchars($a['zip']) ?></td>
                        <td><?= htmlspecialchars($a['department']) ?></td>
                        <td><?= htmlspecialchars($a['doctor']) ?></td>
                        <td><?= htmlspecialchars($a['service']) ?></td>
                        <td><?= htmlspecialchars($a['appointment_datetime']) ?></td>
                        <td><?= htmlspecialchars($a['message']) ?></td>
                        <td><?= htmlspecialchars($a['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2 class="mt-5">Registered Users</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['name']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <?php if ($u['image']): ?>
                                <img src="<?= htmlspecialchars($u['image']) ?>" alt="User Image" width="50">
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($u['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2 class="mt-5">User Messages</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-warning">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Comment</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $m): ?>
                    <tr>
                        <td><?= $m['id'] ?></td>
                        <td><?= htmlspecialchars($m['full_name']) ?></td>
                        <td><?= htmlspecialchars($m['email']) ?></td>
                        <td><?= htmlspecialchars($m['address']) ?></td>
                        <td><?= htmlspecialchars($m['comment']) ?></td>
                        <td><?= htmlspecialchars($m['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
