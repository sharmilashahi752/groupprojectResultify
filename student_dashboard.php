<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

$studentName = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resultify | Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #6a1b9a;
        }

        .navbar-brand,
        .nav-link,
        .dropdown-item {
            color: #fff !important;
        }

        .navbar-brand:hover,
        .nav-link:hover,
        .dropdown-item:hover {
            color: #d1c4e9 !important;
        }

        .dashboard-heading {
            color: #ba68c8;
            font-weight: 600;
        }

        .card {
            background: #1e1e2f;
            border: 1px solid #333;
            border-radius: 20px;
            color: #fff;
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 15px rgba(186, 104, 200, 0.3);
        }

        .btn-outline-custom {
            border-color: #ba68c8;
            color: #ba68c8;
        }

        .btn-outline-custom:hover {
            background-color: #ba68c8;
            color: white;
        }

        .container {
            margin-top: 80px;
        }

        .card h4 {
            margin-bottom: 15px;
        }

        .dropdown-menu {
            background-color: #2c2c3a;
        }

        .dropdown-item {
            color: white;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="#">🎓 Resultify</a>
        <div class="ms-auto">
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item me-3">
                    <span class="nav-link fw-bold">👤 <?php echo htmlspecialchars($studentName); ?></span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-sm btn-outline-light" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Dashboard Cards -->
<div class="container">
    <h2 class="text-center dashboard-heading mb-5">Welcome, <?php echo htmlspecialchars($studentName); ?> 👋</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>📄 View Marksheet</h4>
                <a href="view_result.php" class="btn btn-outline-custom mt-3">Go</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>📝 Update Profile</h4>
                <a href="update_profile.php" class="btn btn-outline-custom mt-3">Go</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>📢 View Notices</h4>
                <a href="view_notices.php" class="btn btn-outline-custom mt-3">Go</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>⬇️ Download PDF</h4>
                <a href="download_marksheet.php" class="btn btn-outline-custom mt-3">Go</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>📊 Result Chart</h4>
                <a href="result_chart.php" class="btn btn-outline-custom mt-3">Go</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>🚪 Logout</h4>
                <a href="logout.php" class="btn btn-outline-custom mt-3">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 