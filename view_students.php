<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "resultify_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete student
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM students WHERE id = $id");
    header("Location: view_students.php?msg=deleted");
    exit();
}

$result = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Students | Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4 fw-bold">👨‍🎓 All Students</h3>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
      <div class="alert alert-success">Student deleted successfully!</div>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Roll No</th>
          <th>Class</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id']; ?></td>
          <td><?= htmlspecialchars($row['name']); ?></td>
          <td><?= htmlspecialchars($row['email']); ?></td>
          <td><?= $row['roll_no']; ?></td>
          <td><?= $row['class']; ?></td>
          <td>
            <a href="edit_student.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-primary">
              <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="view_students.php?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?');" class="btn btn-sm btn-danger">
              <i class="bi bi-trash"></i> Delete
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
