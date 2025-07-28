<?php
session_start();
include ('includes/db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Update marks
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roll_no = $_POST['roll_no'];
    $py = $_POST['python'];
    $wt = $_POST['web_tech'];
    $mis = $_POST['mis'];
    $sad = $_POST['sad'];
    $res = $_POST['research'];

    $check = mysqli_query($conn, "SELECT * FROM marks WHERE roll_no = '$roll_no'");
    if (mysqli_num_rows($check) > 0) {
        // Update existing marks
        $query = "UPDATE marks SET python=$py, web_tech=$wt, mis=$mis, sad=$sad, research=$res WHERE roll_no='$roll_no'";
    } else {
        // Insert new marks
        $query = "INSERT INTO marks (roll_no, python, web_tech, mis, sad, research) VALUES ('$roll_no', $py, $wt, $mis, $sad, $res)";
    }
    mysqli_query($conn, $query);
}

// Get student list
$students = mysqli_query($conn, "SELECT name, roll_no FROM students ORDER BY roll_no");

// Fetch full mark data
$allMarks = mysqli_query($conn, "
    SELECT s.name, s.roll_no, m.python, m.web_tech, m.mis, m.sad, m.research
    FROM students s
    LEFT JOIN marks m ON s.roll_no = m.roll_no
    ORDER BY s.roll_no
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">🛠️ Manage Student Marks</h2>

    <!-- Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Update Marks</div>
        <div class="card-body">
            <form method="POST">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Student (Roll No)</label>
                        <select name="roll_no" class="form-select" required>
                            <option value="">Select Student</option>
                            <?php while ($s = mysqli_fetch_assoc($students)): ?>
                                <option value="<?= $s['roll_no'] ?>"><?= $s['roll_no'] ?> - <?= htmlspecialchars($s['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md">
                        <label class="form-label">Python</label>
                        <input type="number" name="python" class="form-control" required min="0" max="100">
                    </div>
                    <div class="col-md">
                        <label class="form-label">Web Tech</label>
                        <input type="number" name="web_tech" class="form-control" required min="0" max="100">
                    </div>
                    <div class="col-md">
                        <label class="form-label">MIS</label>
                        <input type="number" name="mis" class="form-control" required min="0" max="100">
                    </div>
                    <div class="col-md">
                        <label class="form-label">SAD</label>
                        <input type="number" name="sad" class="form-control" required min="0" max="100">
                    </div>
                    <div class="col-md">
                        <label class="form-label">Research</label>
                        <input type="number" name="research" class="form-control" required min="0" max="100">
                    </div>
                    <div class="col-md-auto">
                        <button class="btn btn-success">Save / Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Marks Table -->
    <div class="card">
        <div class="card-header bg-secondary text-white">All Marks</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered m-0">
                    <thead class="table-light">
                        <tr>
                            <th>Roll No</th>
                            <th>Name</th>
                            <th>Python</th>
                            <th>Web Tech</th>
                            <th>MIS</th>
                            <th>SAD</th>
                            <th>Research</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($allMarks)): ?>
                            <tr>
                                <td><?= $row['roll_no'] ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= $row['python'] ?? '-' ?></td>
                                <td><?= $row['web_tech'] ?? '-' ?></td>
                                <td><?= $row['mis'] ?? '-' ?></td>
                                <td><?= $row['sad'] ?? '-' ?></td>
                                <td><?= $row['research'] ?? '-' ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</body>
</html>
