<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$success = $error = "";

// DB connection
$conn = new mysqli("localhost", "root", "", "resultify_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $roll_no = trim($_POST['roll_no']);
    $class = trim($_POST['class']);

    if ($name && $email && $roll_no && $class) {
        $stmt = $conn->prepare("INSERT INTO students (name, email, roll_no, class) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $roll_no, $class);

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

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom Resultify Theme -->
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
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">➕ Add Student</h3>
    <a href="admin_dashboard.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left-circle"></i> Back to Dashboard</a>
  </div>

  <!-- Alert -->
  <?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>

  <!-- Form -->
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
          <input type="text" name="roll_no" id="roll_no" class="form-control" placeholder="Roll No">
          <label for="roll_no">Roll Number</label>
        </div>
        <div class="col-md-6 form-floating">
          <select name="class" id="class" class="form-select">
            <option value="">-- Select Class --</option>
            <option value="BCA 1st Semester">CS&AI 2nd Semester</option>
            <option value="BCA 2nd Semester">CS&AI 4th Semester</option>
            <option value="BIT 1st Semester">BIT 2nd Semester</option>
            <option value="BIT 2nd Semester">BIT 4th Semester</option>
          </select>
          <label for="class">Class</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-4 w-100"><i class="bi bi-person-plus"></i> Add Student</button>
    </form>
  </div>

  <!-- Student List -->
  <div class="resultify-card">
    <h5 class="mb-3"><i class="bi bi-table"></i> All Students</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roll No</th>
            <th>Class</th>
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
                <td><?php echo $row['roll_no']; ?></td>
                <td><?php echo $row['class']; ?></td>
                <td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6" class="text-center">No students found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- JS Validation -->
<script>
function validateForm() {
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const roll_no = document.getElementById('roll_no').value.trim();
  const student_class = document.getElementById('class').value;

  if (!name || !email || !roll_no || !student_class) {
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
