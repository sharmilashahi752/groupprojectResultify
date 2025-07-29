<?php
session_start();
include 'includes/db.php';

// Access Control: Only Admins
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Delete Student Securely
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: view_students.php?msg=deleted");
    exit();
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_param = "%{$search}%";

// Fetch students with search + pagination
$query = "SELECT * FROM students WHERE name LIKE ? OR email LIKE ? OR roll_no LIKE ? ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssii", $search_param, $search_param, $search_param, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Count total for pagination
$count_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM students WHERE name LIKE ? OR email LIKE ? OR roll_no LIKE ?");
$count_stmt->bind_param("sss", $search_param, $search_param, $search_param);
$count_stmt->execute();
$total_result = $count_stmt->get_result();
$total_students = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_students / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Students | Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">👨‍🎓 All Students</h3>
    <a href="admin_dashboard.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left-circle"></i> Back</a>
  </div>

  <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    <div class="alert alert-success">✅ Student deleted successfully!</div>
  <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
    <div class="alert alert-success">✅ Student updated successfully!</div>
  <?php endif; ?>

  <!-- Search -->
  <form method="GET" class="mb-3">
    <div class="input-group">
      <input type="text" name="search" class="form-control" placeholder="Search by name, email, or roll no" value="<?= htmlspecialchars($search); ?>">
      <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Search</button>
    </div>
  </form>

  <!-- Student Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Roll No</th>
          <th>Department</th>
          <th>Year</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><?= htmlspecialchars($row['name']); ?></td>
              <td><?= htmlspecialchars($row['email']); ?></td>
              <td><?= htmlspecialchars($row['roll_no']); ?></td>
              <td><?= htmlspecialchars($row['department']); ?></td>
              <td><?= htmlspecialchars($row['year']); ?></td>
              <td>
                <a href="edit_student.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a>
                <a href="view_students.php?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?');" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7" class="text-center">No students found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <nav>
    <ul class="pagination justify-content-center">
      <?php if ($page > 1): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $page - 1; ?>&search=<?= urlencode($search); ?>">&laquo; Prev</a></li>
      <?php endif; ?>
      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?= $i === $page ? 'active' : ''; ?>">
          <a class="page-link" href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>"><?= $i; ?></a>
        </li>
      <?php endfor; ?>
      <?php if ($page < $total_pages): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $page + 1; ?>&search=<?= urlencode($search); ?>">Next &raquo;</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</div>
</body>
</html>
