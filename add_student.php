<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$success = $error = "";
include('includes/db.php');

// Insert logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $department = trim($_POST['department']);
    $year = trim($_POST['year']);
    $roll_no = trim($_POST['roll_no']);

    if ($name && $email && $department && $year && $roll_no) {
        $stmt = $conn->prepare("INSERT INTO students (name, email, department, year, roll_no) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $department, $year, $roll_no);

        if ($stmt->execute()) {
            $success = "✅ Student '$name' added successfully!";
        } else {
            $error = "❌ " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch student list
$students = $conn->query("SELECT * FROM students ORDER BY id DESC");
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Student - Admin | Resultify</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .resultify-card {
      background: #ffffff;
      border-radius: 12px;
      padding: 25px 30px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }
    .btn-primary {
      background: #3B71CA;
      border: none;
    }
    .btn-primary:hover {
      background: #315ca8;
    }
    .form-floating > label {
      color: #6c757d;
    }
    .table th {
      background-color: #3B71CA;
      color: white;
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
      background-color: #f0f4ff;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">➕ Add Student</h3>
    <a href="admin_dashboard.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left-circle"></i> Back to Dashboard</a>
  </div>

  <?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>

  <div class="resultify-card mb-5">
    <form method="POST" onsubmit="return validateForm();">
      <div class="row g-3">
        <div class="col-md-6 form-floating">
          <input type="text" name="name" id="name" class="form-control" placeholder="Name">
          <label for="name">Student Name</label>
        </div>
        <div class="col-md-6 form-floating">
          <input type="email" name="email" id="email" class="form-control" placeholder="Email">
          <label for="email">Student Email</label>
        </div>
        <div class="col-md-6 form-floating">
          <input type="text" name="department" id="department" class="form-control" placeholder="Department">
          <label for="department">Department</label>
        </div>
        <div class="col-md-6 form-floating">
          <select name="year" id="year" class="form-select">
            <option value="">-- Select Year --</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
          </select>
          <label for="year">Academic Year</label>
        </div>
        <div class="col-md-6 form-floating">
          <input type="text" name="roll_no" id="roll_no" class="form-control" placeholder="Roll No">
          <label for="roll_no">Roll Number</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-4 w-100"><i class="bi bi-person-plus"></i> Add Student</button>
    </form>
  </div>

  <div class="resultify-card">
    <h5 class="mb-3"><i class="bi bi-table"></i> All Students</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Year</th>
            <th>Roll No</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($students->num_rows > 0): ?>
            <?php while ($row = $students->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['department']); ?></td>
                <td><?php echo htmlspecialchars($row['year']); ?></td>
                <td><?php echo $row['roll_no']; ?></td>
                <td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="7" class="text-center">No students found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function validateForm() {
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const department = document.getElementById('department').value.trim();
  const year = document.getElementById('year').value;
  const roll_no = document.getElementById('roll_no').value.trim();

  if (!name || !email || !department || !year || !roll_no) {
    alert("⚠️ All fields are required.");
    return false;
  }

  const emailReg = /^[^@]+@[^@]+\.[a-z]{2,}$/;
  if (!emailReg.test(email)) {
    alert("📧 Please enter a valid email.");
    return false;
  }

  return true;
}
</script>

</body>
</html>
