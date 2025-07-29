<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

$studentName = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard - Resultify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card:hover {
            transform: scale(1.02);
            transition: 0.3s ease;
        }
        body {
            background-color: #121212;
            color: white;
        }
        .card {
            background-color: #1f1f1f;
            border: 1px solid #333;
            border-radius: 20px;
            color: white;
        }
        .card a {
            color: white;
            text-decoration: none;
        }
        .card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">🎓 Welcome, <?php echo htmlspecialchars($studentName); ?>!</h2>

    <div class="row g-4">
        <!-- View Marksheet -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>📄 View Marksheet</h4>
                <a href="view_result.php" class="btn btn-outline-info mt-3">Go</a>
            </div>
        </div>

        <!-- Update Profile -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>📝 Update Profile</h4>
                <a href="update_profile.php" class="btn btn-outline-success mt-3">Go</a>
            </div>
        </div>

        <!-- View Notices -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>📢 View Notices</h4>
                <a href="view_notices.php" class="btn btn-outline-warning mt-3">Go</a>
            </div>
        </div>

        <!-- Download PDF -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>⬇️ Download PDF</h4>
               <a href="download_marksheet.php" class="btn btn-outline-primary mt-2">Go</a>

            </div>
        </div>

        <!-- Result Visualization -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>📊 Result Chart</h4>
                <a href="result_chart.php" class="btn btn-outline-light mt-3">Go</a>
            </div>
        </div>

        <!-- Logout -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h4>🚪 Logout</h4>
                <a href="logout.php" class="btn btn-outline-danger mt-3">Logout</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
