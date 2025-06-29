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
  <meta charset="UTF-8">
  <title>University Dashboard</title>
  <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
  <div class="dashboard">
    <h2>Welcome University, <?php echo $_SESSION['user']['username']; ?> 🎉</h2>
    <p>This is your personalized dashboard.</p>
    <a href="logout.php" class="btn">Logout</a>
  </div>
</body>
</html>