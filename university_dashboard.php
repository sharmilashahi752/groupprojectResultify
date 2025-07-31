<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'university') {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>University Dashboard - Resultify</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Inline CSS -->
  <style>
    body {
      background: #f8f9fa;
      margin: 0;
    }

    .sidebar {
      height: 100vh;
      background: linear-gradient(135deg, #6f42c1, #8e44ad);
      color: #fff;
      padding: 20px;
      position: fixed;
      width: 220px;
    }

    .sidebar h3 {
      margin-bottom: 30px;
      font-weight: bold;
    }

    .sidebar a {
      display: block;
      color: #e0d8f3;
      text-decoration: none;
      margin-bottom: 15px;
      font-size: 16px;
      transition: 0.2s;
    }

    .sidebar a:hover {
      color: #ffffff;
      font-weight: bold;
    }

    .content {
      margin-left: 240px;
      padding: 40px;
    }

    .welcome {
      background: linear-gradient(135deg, #a06cd5, #6c5ce7);
      color: white;
      padding: 20px;
      border-radius: 10px;
    }

    .quick-actions .btn {
      font-weight: 500;
    }

    .footer {
      margin-top: 60px;
      color: #999;
      font-size: 14px;
      text-align: center;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h3>🎓 University</h3>
    <a href="view_uniresults.php">📊 View Results</a>
    <a href="student_data.php">📚 View Students</a>
    <a href="post_notice.php">📝 Post Notice</a>
    <a href="view_notices.php">📢 View Notices</a>
    <a href="logout.php">🚪 Logout</a>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="welcome">
      <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?> 🌟</h2>
      <p>This is your University Dashboard. Monitor results, manage students, and share notices with ease.</p>
    </div>

    <div class="mt-5">
      <h4>Quick Actions:</h4>
      <div class="row quick-actions">
        <div class="col-md-3 mb-3">
          <a href="view_uniresults.php" class="btn btn-primary w-100">📊 View Results</a>
        </div>
        <div class="col-md-3 mb-3">
          <a href="student_data.php" class="btn btn-warning w-100">📚 View Students</a>
        </div>
        <div class="col-md-3 mb-3">
          <a href="add_notice.php" class="btn btn-success w-100">📝 Post Notice</a>
        </div>
        <div class="col-md-3 mb-3">
          <a href="notices.php" class="btn btn-dark w-100">📢 View Notices</a>
        </div>
      </div>
    </div>

    <div class="footer">
      <p>Resultify &copy; <?php echo date('Y'); ?> | Empowering Academic Insight</p>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

