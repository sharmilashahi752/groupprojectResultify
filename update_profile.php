<?php
session_start();
include('includes/db.php'); // Update path if needed

// Ensure student is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION['user']['email'];
$success = $error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $department = trim($_POST['department']);

    if ($name && $email && $department) {
        $updateQuery = "UPDATE students SET name = ?, email = ?, department = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateQuery);
        if ($updateStmt) {
            $updateStmt->bind_param("ssss", $name, $email, $department, $userEmail);
            if ($updateStmt->execute()) {
                $success = "Profile updated successfully.";
                $_SESSION['user']['email'] = $email;
            } else {
                $error = "Failed to update profile.";
            }
        } else {
            $error = "Prepare failed: " . $conn->error;
        }
    } else {
        $error = "Please fill all the fields.";
    }
}

// Fetch current student data
$query = "SELECT name, email, department FROM students WHERE email = ?";
$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
} else {
    die("Prepare failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile - Resultify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e8eafc, #f3e5f5);
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(160, 120, 240, 0.2);
        }
        .btn-purple {
            background: #7e57c2;
            color: white;
        }
        .btn-purple:hover {
            background: #673ab7;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h3>👤 Update Profile</h3>
        <a href="logout.php" class="btn btn-purple">Logout</a>
    </div>
    <div class="card p-4">
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="<?= htmlspecialchars($_POST['name'] ?? $student['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email ID</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? $student['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department"
                       value="<?= htmlspecialchars($_POST['department'] ?? $student['department']) ?>" required>
            </div>
            <button type="submit" class="btn btn-purple">Update Profile</button>
        </form>
    </div>
</div>
</body>
</html>
