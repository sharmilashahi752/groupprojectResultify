<?php
session_start();

$_SESSION['role'] = 'student';
$_SESSION['student_id'] = 1;
$_SESSION['student_name'] = 'Sonu Shahi';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

$studentId = $_SESSION['student_id'];
$studentName = $_SESSION['student_name'];

$conn = new mysqli("localhost", "root", "", "resultify_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT subject, marks, grade, remarks FROM results WHERE student_id = $studentId";
$result = $conn->query($sql);

$subjects = [];
$marks = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    :root {
      --primary: #7b1fa2;
      --secondary: #ce93d8;
      --accent: #f3e5f5;
      --text-dark: #333;
      --text-light: #fff;
    }

    body {
      background: linear-gradient(135deg, #fefefe, #f3e5f5);
      font-family: 'Segoe UI', sans-serif;
      color: var(--text-dark);
    }

    .navbar {
      background: linear-gradient(to right, var(--primary), var(--secondary));
    }

    .navbar-brand, .nav-link, .dropdown-toggle {
      color: #fff !important;
      font-weight: 600;
    }

    .dropdown-menu {
      background-color: #fff;
      border: none;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .dropdown-menu a {
      color: var(--text-dark);
    }

    .card {
      border-radius: 15px;
      transition: transform 0.3s ease;
      background: #fff;
      border: none;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .card:hover {
      transform: scale(1.01);
    }

    .table thead {
      background: linear-gradient(to right, var(--primary), var(--secondary));
      color: white;
    }

    .table-success {
      background-color: #e8f5e9;
    }

    .grade-badge {
      padding: 5px 10px;
      border-radius: 10px;
      color: #fff;
      font-weight: bold;
      animation: bounce 2s infinite;
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-4px); }
    }

    .grade-Aplus { background-color: #4caf50; }
    .grade-A { background-color: #8bc34a; }
    .grade-Bplus { background-color: #cddc39; }
    .grade-B { background-color: #ffc107; }
    .grade-C { background-color: #ff9800; }
    .grade-D { background-color: #ff5722; }
    .grade-F { background-color: #f44336; }

    .notice-board {
      background-color: #ffffff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .notice-item {
      background: #fafafa;
      padding: 10px 15px;
      border-left: 5px solid var(--primary);
      margin-bottom: 10px;
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Resultify</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= htmlspecialchars($studentName) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="#">View Profile</a></li>
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- DASHBOARD CONTENT WILL BE ADDED HERE -->




  <div class="container py-5">
    <h2 class="text-center mb-5 text-dark animate__animated animate__fadeInDown">🎓 Student Dashboard</h2>

    <div class="row g-4">
      <div class="col-md-8">
        <div class="card shadow-sm mb-4 animate__animated animate__fadeInUp">
          <div class="card-body">
            <h4 class="mb-3">📊 Result Summary</h4>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Subject</th>
                    <th>Marks</th>
                    <th>Grade</th>
                    <th>Remarks</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $total = 0;
                    $count = 0;
                    $gpaPoints = 0;
                    if ($result->num_rows > 0): 
                      while($row = $result->fetch_assoc()):
                        $subjects[] = $row['subject']; 
                        $marks[] = $row['marks']; 
                        $total += $row['marks'];
                        $count++;
                        $grade = $row['grade'];
                        switch ($grade) {
                          case 'A+': $gpaPoint = 4.0; break;
                          case 'A': $gpaPoint = 3.7; break;
                          case 'B+': $gpaPoint = 3.3; break;
                          case 'B': $gpaPoint = 3.0; break;
                          case 'C': $gpaPoint = 2.0; break;
                          case 'D': $gpaPoint = 1.0; break;
                          default: $gpaPoint = 0.0;
                        }
                        $gpaPoints += $gpaPoint;
                  ?>
                  <tr>
                    <td><?= $row['subject'] ?></td>
                    <td><?= $row['marks'] ?></td>
                    <td><span class="grade-badge grade-<?= str_replace('+', 'plus', $row['grade']) ?>"><?= $row['grade'] ?></span></td>
                    <td><?= $row['remarks'] ?></td>
                  </tr>
                  <?php 
                      endwhile; 
                      $average = $count > 0 ? $total / $count : 0;
                      $gpa = $count > 0 ? $gpaPoints / $count : 0;

                      if ($average >= 90) {
                        $overallGrade = 'A+';
                      } elseif ($average >= 80) {
                        $overallGrade = 'A';
                      } elseif ($average >= 70) {
                        $overallGrade = 'B+';
                      } elseif ($average >= 60) {
                        $overallGrade = 'B';
                      } elseif ($average >= 50) {
                        $overallGrade = 'C';
                      } elseif ($average >= 40) {
                        $overallGrade = 'D';
                      } else {
                        $overallGrade = 'F';
                      }
                  ?>
                  <tr class="table-success fw-bold">
                    <td>Total</td>
                    <td><?= $total ?></td>
                    <td colspan="2">Average: <?= round($average, 2) ?> | GPA: <?= round($gpa, 2) ?> | Final Grade: <span class="grade-badge grade-<?= str_replace('+', 'plus', $overallGrade) ?>"><?= $overallGrade ?></span></td>
                  </tr>
                  <?php else: ?>
                  <tr><td colspan="4">No results found.</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="card shadow-sm animate__animated animate__fadeInUp animate__delay-1s">
          <div class="card-body">
            <h4 class="mb-3">📈 Performance Chart</h4>
            <canvas id="performanceChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="notice-board animate__animated animate__fadeInRight animate__delay-1s">
          <h5 class="mb-3">📢 Notices</h5>
          <div class="notice-item">Mid-term result will be published on July 1st.</div>
          <div class="notice-item">College will remain closed on July 5th for Bhanu Jayanti.</div>
          <div class="notice-item">Project submission deadline extended to July 10th.</div>
        </div>

        <div class="text-center mt-4 animate__animated animate__fadeInUp animate__delay-2s">
          <a href="download_pdf.php" class="btn btn-outline-primary px-4 py-2 shadow">Download Marksheet PDF</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const performanceChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?= json_encode($subjects) ?>,
        datasets: [{
          label: 'Marks',
          data: <?= json_encode($marks) ?>,
          backgroundColor: '#7b1fa2',
          borderRadius: 8,
        }]
      },
      options: {
        responsive: true,
        animation: {
          duration: 1000,
          easing: 'easeInOutBounce'
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 100
          }
        }
      }
    });
  </script>
</body>
</html>
