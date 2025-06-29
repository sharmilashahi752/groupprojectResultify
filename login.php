<?php
session_start();
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = $_POST['role'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
  $stmt->bind_param("ss", $email, $role);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;

    // Redirect based on role
    if ($user['role'] == 'student') {
      header("Location: student_dashboard.php");
    } elseif ($user['role'] == 'admin') {
      header("Location: admin_dashboard.php");
    } elseif ($user['role'] == 'university') {
      header("Location: university_dashboard.php");
    } else {
      echo "<script>alert('Invalid role.');</script>";
    }
    exit();
  } else {
    echo "<script>alert('Invalid email or password.');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Resultify</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/dashboard.css"> <!-- Reuse same CSS for consistency -->
</head>
<body>
  <div class="dashboard">
    <h2>Login to Resultify</h2>
    <form method="POST">
      <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
      <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
      <select name="role" class="form-control mb-3" required>
        <option value="">Select Role</option>
        <option value="student">Student</option>
        <option value="admin">Admin</option>
        <option value="university">University</option>
      </select>
      <button type="submit" class="btn btn-primary w-100">Login</button>
      <p class="mt-3">Don't have an account? <a href="register.php" style="color: #fff; font-weight: bold;">Register</a></p>
    </form>
  </div>
</body>
</html>
