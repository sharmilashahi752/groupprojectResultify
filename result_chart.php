<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

$studentEmail = $_SESSION['user']['email'];
$query = "SELECT * FROM students WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $studentEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $roll = $student['roll_no'];

    // Get Marks
    $marksQuery = "SELECT * FROM marks WHERE roll_no = ?";
    $stmt2 = $conn->prepare($marksQuery);
    $stmt2->bind_param("s", $roll);
    $stmt2->execute();
    $marksResult = $stmt2->get_result();
    $marks = $marksResult->fetch_assoc();

    $subjects = ['python', 'web_tech', 'mis', 'sad', 'research'];
    $total = 0;
    $grades = [];
    $subject_gpas = [];

    foreach ($subjects as $sub) {
        $mark = $marks[$sub];
        $total += $mark;
        $gpa = min(4, round($mark / 25, 2));
        $subject_gpas[$sub] = $gpa;

        if ($mark >= 90) $grades[$sub] = 'A+';
        elseif ($mark >= 80) $grades[$sub] = 'A';
        elseif ($mark >= 70) $grades[$sub] = 'B+';
        elseif ($mark >= 60) $grades[$sub] = 'B';
        elseif ($mark >= 50) $grades[$sub] = 'C+';
        elseif ($mark >= 40) $grades[$sub] = 'C';
        else $grades[$sub] = 'F';
    }

    $average = $total / count($subjects);
    $gpa = min(4, round($average / 25, 2));
} else {
    echo "Student record not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Result - Resultify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f5f3ff, #e0e7ff);
            color: #333;
        }
        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .btn-purple {
            background-color: #6b5b95;
            color: white;
        }
        .btn-purple:hover {
            background-color: #5a4a82;
        }
    </style>
</head>
<body>
<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">Lumbini Technological University<br>Student Marksheet</h2>

    <div class="card p-4 mb-4">
        <div class="card-body">
            <h5>Name: <?php echo $student['name']; ?></h5>
            <p>Roll No: <?php echo $student['roll_no']; ?> | Department: <?php echo $student['department']; ?> | Email: <?php echo $student['email']; ?></p>

            <table class="table table-bordered text-center mt-3">
                <thead class="table-secondary">
                    <tr>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>GPA</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subjects as $sub): ?>
                        <tr>
                            <td><?php echo strtoupper($sub); ?></td>
                            <td><?php echo $marks[$sub]; ?></td>
                            <td><?php echo $subject_gpas[$sub]; ?></td>
                            <td><?php echo $grades[$sub]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p><strong>Total Marks:</strong> <?php echo $total; ?></p>
            <p><strong>Overall GPA:</strong> <?php echo $gpa; ?> / 4</p>

            <div class="mt-4 text-center">
                <a href="student_dashboard.php" class="btn btn-purple">Go to Dashboard</a>
                <a href="logout.php" class="btn btn-danger ms-2">Logout</a>
            </div>
        </div>
    </div>

    <!-- 🎨 Charts Section -->
    <div class="card p-4">
        <h5 class="text-center">Result Visualization</h5>
        <canvas id="marksChart" class="my-4"></canvas>
        <canvas id="gpaChart" class="my-4"></canvas>
    </div>
</div>

<script>
    const subjectLabels = <?php echo json_encode(array_map('strtoupper', $subjects)); ?>;
    const subjectMarks = <?php echo json_encode(array_map(function($s) use ($marks) { return (int)$marks[$s]; }, $subjects)); ?>;
    const subjectGPA = <?php echo json_encode(array_values($subject_gpas)); ?>;

    // Marks Chart (Bar)
    new Chart(document.getElementById('marksChart'), {
        type: 'bar',
        data: {
            labels: subjectLabels,
            datasets: [{
                label: 'Marks',
                data: subjectMarks,
                backgroundColor: '#6b5b95'
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, max: 100 }
            }
        }
    });

    // GPA Chart (Line)
    new Chart(document.getElementById('gpaChart'), {
        type: 'line',
        data: {
            labels: subjectLabels,
            datasets: [{
                label: 'Subject GPA',
                data: subjectGPA,
                fill: false,
                borderColor: '#9f5de2',
                backgroundColor: '#9f5de2',
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, max: 4 }
            }
        }
    });

    // Pie Chart (Subject-wise Marks Distribution)
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: subjectLabels,
            datasets: [{
                label: 'Marks Distribution',
                data: subjectMarks,
                backgroundColor: ['#6b5b95', '#b8a9c9', '#f67280', '#355c7d', '#99b898'],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Subject-wise Marks Distribution (Pie Chart)',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });
</script>

</body>
</html>
