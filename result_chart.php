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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-bottom: 40px;
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

        /* Chart container */
      .charts-wrapper {
  max-width: 960px;
  margin: 30px auto 0 auto;
  padding: 20px 10px;
}

/* Flex container for pie + bar charts side by side */
.top-charts {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 40px;
  flex-wrap: wrap;
}

canvas {
  background: white;
  border-radius: 8px;
  box-shadow: 0 0 15px rgba(0,0,0,0.1);
  width: 100% !important;
  height: auto !important;
  max-width: 400px;
  max-height: 300px;
  transition: box-shadow 0.3s ease;
}

canvas:hover {
  box-shadow: 0 0 25px rgba(0,0,0,0.2);
}

/* Slightly larger pie chart */
#pieChart {
  max-width: 350px;
  max-height: 350px;
}

/* Responsive stacking on smaller screens */
@media (max-width: 768px) {
  .top-charts {
    flex-direction: column;
    align-items: center;
    gap: 30px;
  }
  canvas {
    max-width: 90vw;
    max-height: 350px;
  }
}


        #marksChart, #gpaChart {
            width: 350px !important;
            height: 250px !important;
        }
        #pieChart {
            width: 220px !important;
            height: 220px !important;
        }

        /* Responsive: stack charts vertically on small screens */
        @media (max-width: 768px) {
            .top-charts {
                flex-direction: column;
                align-items: center;
                gap: 25px;
            }
            #marksChart, #gpaChart, #pieChart {
                width: 90vw !important;
                height: auto !important;
                max-height: 320px;
            }
        }

        h2 {
            max-width: 600px;
            margin: 0 auto 20px auto;
            font-weight: 700;
            color: #5a4a82;
        }

        .container {
            max-width: 900px;
        }

        table {
            margin-top: 20px;
        }

        .btn-group {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5 mb-5">
    <h2 class="text-center">Lumbini Technological University<br>Student Marksheet</h2>

    <div class="card p-4 mb-4">
        <div class="card-body">
            <h5>Name: <?php echo htmlspecialchars($student['name']); ?></h5>
            <p>Roll No: <?php echo htmlspecialchars($student['roll_no']); ?> | Department: <?php echo htmlspecialchars($student['department']); ?> | Email: <?php echo htmlspecialchars($student['email']); ?></p>

            <table class="table table-bordered text-center">
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
                            <td><?php echo strtoupper(htmlspecialchars($sub)); ?></td>
                            <td><?php echo htmlspecialchars($marks[$sub]); ?></td>
                            <td><?php echo htmlspecialchars($subject_gpas[$sub]); ?></td>
                            <td><?php echo htmlspecialchars($grades[$sub]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="mt-3"><strong>Total Marks:</strong> <?php echo htmlspecialchars($total); ?></p>
            <p><strong>Overall GPA:</strong> <?php echo htmlspecialchars($gpa); ?> / 4</p>

            <div class="btn-group">
                <a href="student_dashboard.php" class="btn btn-purple">Go to Dashboard</a>
                <a href="logout.php" class="btn btn-danger ms-2">Logout</a>
            </div>
        </div>
    </div>

    <!-- 🎨 Charts Section -->
    <div class="card p-4 charts-wrapper">
        <div class="top-charts">
            <canvas id="marksChart"></canvas>
            <canvas id="pieChart"></canvas>
        </div>
        <div class="mt-4 d-flex justify-content-center">
            <canvas id="gpaChart"></canvas>
        </div>
    </div>
</div>

<script>
    // Improve rendering quality for high DPI devices
    function enhanceCanvasResolution(chart) {
        const ctx = chart.ctx;
        const canvas = ctx.canvas;
        const dpr = window.devicePixelRatio || 1;
        canvas.width = canvas.clientWidth * dpr;
        canvas.height = canvas.clientHeight * dpr;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    const subjectLabels = <?php echo json_encode(array_map('strtoupper', $subjects)); ?>;
    const subjectMarks = <?php echo json_encode(array_map(function($s) use ($marks) { return (int)$marks[$s]; }, $subjects)); ?>;
    const subjectGPA = <?php echo json_encode(array_values($subject_gpas)); ?>;

    // Marks Chart (Bar)
    const marksChart = new Chart(document.getElementById('marksChart'), {
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
            },
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'nearest',
                intersect: true
            },
            plugins: {
                tooltip: {
                    enabled: true,
                    mode: 'nearest',
                    intersect: true
                }
            }
        }
    });
    enhanceCanvasResolution(marksChart);

    // Pie Chart (Subject-wise Marks Distribution)
    const pieChart = new Chart(document.getElementById('pieChart'), {
  type: 'pie',
  data: {
    labels: subjectLabels,
    datasets: [{
      label: 'Marks Distribution',
      data: subjectMarks,
      backgroundColor: [
        '#6b5b95',
        '#b8a9c9',
        '#f67280',
        '#355c7d',
        '#99b898'
      ],
      borderColor: '#fff',
      borderWidth: 2,
      hoverOffset: 30,   // This makes pie slices "pop out" on hover, nicer effect
      spacing: 5        // Space between slices
    }]
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: 'Subject-wise Marks Distribution',
        font: {
          size: 16,
          weight: 'bold'
        }
      },
      legend: {
        position: 'bottom',
        labels: {
          padding: 15,
          boxWidth: 20,
          font: { size: 14 }
        }
      },
      tooltip: {
        enabled: true
      }
    },
    responsive: true,
    maintainAspectRatio: true,  // Let it keep aspect ratio nicely
    animation: {
      animateRotate: true,
      animateScale: true
    },
    interaction: {
      mode: 'nearest',
      intersect: true
    }
  }
});

    enhanceCanvasResolution(pieChart);

    // GPA Chart (Line)
    const gpaChart = new Chart(document.getElementById('gpaChart'), {
        type: 'line',
        data: {
            labels: subjectLabels,
            datasets: [{
                label: 'Subject GPA',
                data: subjectGPA,
                fill: false,
                borderColor: '#9f5de2',
                backgroundColor: '#9f5de2',
                tension: 0.3,
                pointHoverRadius: 7,
                pointRadius: 5
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, max: 4 }
            },
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'nearest',
                intersect: true
            },
            plugins: {
                tooltip: {
                    enabled: true
                }
            }
        }
    });
    enhanceCanvasResolution(gpaChart);
</script>

</body>
</html>
