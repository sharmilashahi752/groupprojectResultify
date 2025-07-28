<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

$id = intval($_GET['id'] ?? 0);
$student = $conn->query("SELECT * FROM students WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $roll_no = $_POST['roll_no'];
    $class = $_POST['class'];

    $stmt = $conn->prepare("UPDATE students SET name=?, email=?, roll_no=?, class=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $roll_no, $class, $id);
    $stmt->execute();
    header("Location: view_students.php?msg=updated");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Student | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">✏️ Edit Student</h3>

    <form method="POST">
      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($student['name']); ?>">
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($student['email']); ?>">
      </div>
      <div class="mb-3">
        <label>Roll No</label>
        <input type="text" name="roll_no" class="form-control" required value="<?= $student['roll_no']; ?>">
      </div>
      <div class="mb-3">
        <label>Class</label>
        <select name="class" class="form-select" required>
          <option <?= $student['class'] == 'B.Tech in CS&AI 2nd Semester' ? 'selected' : '' ?>>CS&AI 2nd Semester</option>
          <option <?= $student['class'] == 'B.Tech in CS&AI 4th Semester' ? 'selected' : '' ?>>CS&AI 4th Semester</option>
          <option <?= $student['class'] == 'B.Tech in IT 2nd Semester' ? 'selected' : '' ?>>BIT 2nd Semester</option>
          <option <?= $student['class'] == 'B.Tech in IT 4th Semester' ? 'selected' : '' ?>>BIT 4th Semester</option>
        </select>
      </div>
      <button type="submit" class="btn btn-success">Update</button>
      <a href="view_students.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>
