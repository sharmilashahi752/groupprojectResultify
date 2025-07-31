<?php
session_start();
include('includes/db.php');

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($email) || empty($password) || empty($role)) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables based on role
            $_SESSION['user'] = $user; // Optional

            if ($role === 'student') {
                $_SESSION['role'] = 'student';
                $_SESSION['student_id'] = $user['id'];
                $_SESSION['student_name'] = $user['name'];
                header("Location: student_dashboard.php");
            } elseif ($role === 'admin') {
                $_SESSION['role'] = 'admin';
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_name'] = $user['name'];
                header("Location: admin_dashboard.php");
            } elseif ($role === 'university') {
                $_SESSION['role'] = 'university';
                $_SESSION['university_id'] = $user['id'];
                $_SESSION['university_name'] = $user['name'];
                header("Location: university_dashboard.php");
            } else {
                $error = "Invalid user role.";
            }
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Resultify</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #7b1fa2, #ce93d8);
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
      height: 100vh;
    }
    .login-container {
      max-width: 400px;
      margin: 80px auto;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.2);
      color: #333;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #7b1fa2;
    }
    .form-control {
      border-radius: 10px;
    }
    .btn-primary {
      background-color: #7b1fa2;
      border: none;
      border-radius: 10px;
    }
    .btn-primary:hover {
      background-color: #6a1b9a;
    }
    .error-msg {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
    a {
      color: #7b1fa2;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login to Resultify</h2>
    <?php if ($error): ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="mb-3">
        <select name="role" class="form-control" required>
          <option value="">Select Role</option>
          <option value="student">Student</option>
          <option value="admin">Admin</option>
          <option value="university">University</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
      <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register</a></p>
    </form>
  </div>
</body>
</html>