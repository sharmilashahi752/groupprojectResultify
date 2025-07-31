<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'university') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>University Dashboard - View All Results</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

  <style>
    body {
      background-color: #f0f2f5;
      padding: 30px;
    }
    .container {
      margin-top: 20px;
    }
    .heading {
      text-align: center;
      margin-bottom: 30px;
      color: purple;
    }
    .search-box {
      max-width: 400px;
      margin: 0 auto 30px;
    }
    .btn-group {
      margin-top: 20px;
      text-align: center;
      gap: 15px;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
    }
    .pdf-btn, .back-btn {
      background-color: #6f42c1;
      color: white;
      border: none;
      padding: 8px 16px;
      cursor: pointer;
      border-radius: 4px;
      text-decoration: none;
      display: inline-block;
      font-weight: 500;
      transition: background-color 0.3s ease;
    }
    .pdf-btn:hover, .back-btn:hover {
      background-color: #5a32a3;
      color: white;
      text-decoration: none;
    }
    canvas {
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgb(0 0 0 / 0.1);
      width: 400px !important;
      height: 400px !important;
    }
    .charts-wrapper {
      display: flex;
      justify-content: center;
      gap: 50px;
      flex-wrap: wrap;
      margin-top: 40px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2 class="heading">📊 All Student Results</h2>

  <div class="search-box mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Search by Roll No or Name..." />
  </div>

  <div id="tableSection">
    <table class="table table-bordered table-hover table-striped" id="resultsTable">
      <thead class="table-dark">
        <tr>
          <th>Roll No</th>
          <th>Name</th>
          <th>Dept</th>
          <th>Year</th>
          <th>Python</th>
          <th>Web Tech</th>
          <th>MIS</th>
          <th>SAD</th>
          <th>Research</th>
          <th>Total</th>
          <th>GPA</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $subjectTotals = ['python'=>0, 'web_tech'=>0, 'mis'=>0, 'sad'=>0, 'research'=>0];
          $count = 0;

          $query = "SELECT s.roll_no, s.name, s.department, s.year,
                           m.python, m.web_tech, m.mis, m.sad, m.research
                    FROM students s
                    INNER JOIN marks m ON s.roll_no = m.roll_no
                    ORDER BY s.roll_no ASC";
          $result = mysqli_query($conn, $query);

          if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
             $total = $row['python'] + $row['web_tech'] + $row['mis'] + $row['sad'] + $row['research'];
$percentage = ($total / 500) * 100;

if ($percentage >= 90) {
    $gpa = 4.00;
} elseif ($percentage >= 85) {
    $gpa = 3.8;
} elseif ($percentage >= 80) {
    $gpa = 3.6;
} elseif ($percentage >= 75) {
    $gpa = 3.3;
} elseif ($percentage >= 70) {
    $gpa = 3.0;
} elseif ($percentage >= 65) {
    $gpa = 2.7;
} elseif ($percentage >= 60) {
    $gpa = 2.5;
} elseif ($percentage >= 50) {
    $gpa = 2.0;
} else {
    $gpa = 0.0;
}


              // For chart averages
              $subjectTotals['python'] += $row['python'];
              $subjectTotals['web_tech'] += $row['web_tech'];
              $subjectTotals['mis'] += $row['mis'];
              $subjectTotals['sad'] += $row['sad'];
              $subjectTotals['research'] += $row['research'];
              $count++;

              echo "<tr>
                      <td>{$row['roll_no']}</td>
                      <td>{$row['name']}</td>
                      <td>{$row['department']}</td>
                      <td>{$row['year']}</td>
                      <td>{$row['python']}</td>
                      <td>{$row['web_tech']}</td>
                      <td>{$row['mis']}</td>
                      <td>{$row['sad']}</td>
                      <td>{$row['research']}</td>
                      <td><strong>{$total}</strong></td>
                      <td><span class='badge bg-success'>{$gpa}</span></td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='11' class='text-center text-danger'>No results found.</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </div>

  <div class="btn-group">
    <button onclick="generatePDF()" class="pdf-btn">📄 Export to PDF</button>
    <a href="university_dashboard.php" class="back-btn">⬅️ Back to Dashboard</a>
  </div>

  <div class="charts-wrapper">
    <canvas id="subjectChart" width="400" height="400"></canvas>
    <canvas id="pieChart" width="400" height="400"></canvas>
  </div>
</div>

<script>
  const searchInput = document.getElementById('searchInput');
  const table = document.getElementById('resultsTable');
  searchInput.addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
      if(row.cells.length < 2) return;
      const rollNo = row.cells[0].textContent.toLowerCase();
      const name = row.cells[1].textContent.toLowerCase();
      row.style.display = rollNo.includes(filter) || name.includes(filter) ? '' : 'none';
    });
  });

  async function generatePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'pt', 'a4');

    const tableSection = document.getElementById('tableSection');
    await html2canvas(tableSection).then(canvas => {
      const imgData = canvas.toDataURL('image/png');
      const imgProps = doc.getImageProperties(imgData);
      const pdfWidth = doc.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
      doc.addImage(imgData, 'PNG', 10, 10, pdfWidth - 20, pdfHeight);
      doc.save("Student_Results.pdf");
    });
  }

  // Chart data from PHP
  const avgPython = <?php echo $count > 0 ? round($subjectTotals['python'] / $count, 2) : 0; ?>;
  const avgWebTech = <?php echo $count > 0 ? round($subjectTotals['web_tech'] / $count, 2) : 0; ?>;
  const avgMIS = <?php echo $count > 0 ? round($subjectTotals['mis'] / $count, 2) : 0; ?>;
  const avgSAD = <?php echo $count > 0 ? round($subjectTotals['sad'] / $count, 2) : 0; ?>;
  const avgResearch = <?php echo $count > 0 ? round($subjectTotals['research'] / $count, 2) : 0; ?>;

  const ctxBar = document.getElementById('subjectChart').getContext('2d');
  const barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: ['Python', 'Web Tech', 'MIS', 'SAD', 'Research'],
      datasets: [{
        label: 'Average Marks',
        backgroundColor: ['#6f42c1', '#d63384', '#20c997', '#ffc107', '#0d6efd'],
        data: [avgPython, avgWebTech, avgMIS, avgSAD, avgResearch]
      }]
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Average Marks per Subject',
          font: { size: 24 }
        },
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          max: 100
        }
      }
    }
  });

  const ctxPie = document.getElementById('pieChart').getContext('2d');
  const pieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
      labels: ['Python', 'Web Tech', 'MIS', 'SAD', 'Research'],
      datasets: [{
        label: 'Average Marks Distribution',
        backgroundColor: ['#6f42c1', '#d63384', '#20c997', '#ffc107', '#0d6efd'],
        data: [avgPython, avgWebTech, avgMIS, avgSAD, avgResearch]
      }]
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Average Marks Distribution',
          font: { size: 24 }
        },
        legend: {
          position: 'bottom'
        }
      }
    }
  });
</script>

</body>
</html>
