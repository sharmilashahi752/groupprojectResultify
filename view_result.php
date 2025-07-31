<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

$studentEmail = $_SESSION['user']['email'];

$query = "SELECT * FROM students WHERE email = '$studentEmail'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $roll = $student['roll_no'];

    $marksQuery = "SELECT * FROM marks WHERE roll_no = '$roll'";
    $marksResult = $conn->query($marksQuery);
    $marks = $marksResult->fetch_assoc();

    $subjects = ['python', 'web_tech', 'mis', 'sad', 'research'];
    $total = 0;
    $subject_gpas = [];
    $grades = [];

    foreach ($subjects as $sub) {
        $mark = $marks[$sub];
        $total += $mark;

        // Calculate GPA for each subject, capped at 4.0
        $gpa = round(min(4, $mark / 25), 2);
        $subject_gpas[$sub] = $gpa;

        // Assign letter grade
        if ($mark >= 90) $grades[$sub] = 'A+';
        elseif ($mark >= 80) $grades[$sub] = 'A';
        elseif ($mark >= 70) $grades[$sub] = 'B+';
        elseif ($mark >= 60) $grades[$sub] = 'B';
        elseif ($mark >= 50) $grades[$sub] = 'C+';
        elseif ($mark >= 40) $grades[$sub] = 'C';
        else $grades[$sub] = 'F';
    }

    // Calculate overall GPA
    $overall_gpa = round(array_sum($subject_gpas) / count($subject_gpas), 2);
} else {
    echo "Student record not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard - Resultify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<div class="container mt-5">
    <h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($student['name']); ?>!</h2>

    <div class="card text-dark">
        <div class="card-header bg-info text-white">
            <strong>Marksheet</strong>
        </div>
        <div class="card-body">
            <p><strong>Roll No:</strong> <?php echo htmlspecialchars($student['roll_no']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($student['department']); ?></p>

            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>GPA</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subjects as $subject): ?>
                        <tr>
                            <td><?php echo strtoupper(htmlspecialchars($subject)); ?></td>
                            <td><?php echo htmlspecialchars($marks[$subject]); ?></td>
                            <td><?php echo $subject_gpas[$subject]; ?></td>
                            <td><?php echo $grades[$subject]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p><strong>Total Marks:</strong> <?php echo htmlspecialchars($total); ?></p>
            <p><strong>Overall GPA:</strong> <?php echo htmlspecialchars($overall_gpa); ?> / 4.00</p>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="student_dashboard.php" class="btn btn-secondary me-2">← Back to Dashboard</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

</body>
</html>
