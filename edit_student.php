<?php
session_start();
include 'includes/db.php';

// Only Admin Access
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get student data
if (!isset($_GET['id'])) {
    header("Location: view_students.php");
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$student) {
    echo "Student not found.";
    exit();
}

// Update student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $roll = trim($_POST['roll_no']);
    $dept = trim($_POST['department']);
    $year = trim($_POST['year']);

    $stmt = $conn->prepare("UPDATE students SET name=?, email=?, roll_no=?, department=?, year=? WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("sssssi", $name, $email, $roll, $dept, $year, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: view_students.php?msg=updated");
        exit();
    } else {
        echo "Update failed: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3 class="mb-4">✏️ Edit Student</h3>
  <form method="POST">
    <div class="mb-3">
      <label>Name</label>
      <input type="text" name="name" value="<?= htmlspecialchars($student['name']); ?>" class="form-control" required />
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($student['email']); ?>" class="form-control" required />
    </div>
    <div class="mb-3">
      <label>Roll No</label>
      <input type="text" name="roll_no" value="<?= htmlspecialchars($student['roll_no']); ?>" class="form-control" required />
    </div>
    <div class="mb-3">
      <label>Department</label>
      <input type="text" name="department" value="<?= htmlspecialchars($student['department']); ?>" class="form-control" required />
    </div>
    <div class="mb-3">
      <label>Year</label>
      <input type="text" name="year" value="<?= htmlspecialchars($student['year']); ?>" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="view_students.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
