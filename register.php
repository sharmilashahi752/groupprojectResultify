<?php
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = $_POST['role'];

  $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $username, $email, $password, $role);
  $stmt->execute();
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register - Resultify</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="card">
    <h2>Create Account</h2>
    <form method="POST">
      <input type="text" class="form-control mb-3" name="username" placeholder="Full Name" required>
      <input type="email" class="form-control mb-3" name="email" placeholder="Email" required>
      <input type="password" class="form-control mb-3" name="password" placeholder="Password" required>
      <select class="form-control mb-3" name="role" required>
        <option value="">Select Role</option>
        <option value="student">Student</option>
        <option value="admin">Admin</option>
        <option value="university">University</option>
      </select>
      <button type="submit" class="btn btn-primary w-100">Register</button>
      <p class="text-center mt-3">Already have an account? <a href="login.php" style="color:#fff;font-weight:bold;">Login</a></p>
    </form>
  </div>
</body>
</html>
