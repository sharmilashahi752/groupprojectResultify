<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - Resultify</title>
  
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <!-- Custom CSS -->
  <style>
    body {
      background: #f8f9fa;
    }
    .sidebar {
      height: 100vh;
      background-color: #212529;
      color: #fff;
      padding: 20px;
      position: fixed;
      width: 220px;
    }
    .sidebar h3 {
      margin-bottom: 30px;
    }
    .sidebar a {
      display: block;
      color: #adb5bd;
      text-decoration: none;
      margin-bottom: 15px;
      font-size: 16px;
      transition: 0.2s;
    }
    .sidebar a:hover {
      color: #fff;
    }
    .content {
      margin-left: 240px;
      padding: 40px;
    }
    .welcome {
      background: linear-gradient(135deg, #0066ff, #33ccff);
      color: white;
      padding: 20px;
      border-radius: 10px;
    }
    .btn-logout {
      margin-top: 20px;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h3>📊 Admin Panel</h3>
    <a href="add_student.php">➕ Add Student</a>
    <a href="manage_results.php">🗂️ Manage Results</a>
    <a href="view_students.php">👨‍🎓 View All Students</a>
    <a href="post_notice.php">📢 Post Notice</a>
    <a href="logout.php">🚪 Logout</a>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="welcome">
      <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?> 🎉</h2>
      <p>This is your Admin Dashboard. Use the side panel to manage students, results, and notices efficiently.</p>
    </div>

    <div class="mt-5">
      <h4>Quick Actions:</h4>
      <div class="row">
        <div class="col-md-3 mb-3">
          <a href="add_student.php" class="btn btn-primary w-100">➕ Add Student</a>
        </div>
        <div class="col-md-3 mb-3">
          <a href="manage_results.php" class="btn btn-warning w-100">📊 Manage Results</a>
        </div>
        <div class="col-md-3 mb-3">
          <a href="view_students.php" class="btn btn-info w-100">👨‍🎓 View Students</a>
        </div>
        <div class="col-md-3 mb-3">
          <a href="post_notice.php" class="btn btn-success w-100">📢 Post Notice</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (Optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
