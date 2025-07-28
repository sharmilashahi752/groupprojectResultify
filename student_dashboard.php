<?php
session_start();

// Redirect if not logged in or not a student
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') {
  header("Location: login.php");
  exit();
}

// Optional: sample student data (replace with DB data)
$studentName = htmlspecialchars($_SESSION['user']['username']);
$gpa = 3.8;
$totalCredits = 110;
$completedCourses = 32;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Dashboard - Resultify</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --bg-light: #f3f0ff;
      --bg-dark: #1e1e2f;
      --sidebar-light: linear-gradient(180deg, #6f42c1, #a066df);
      --sidebar-dark: #151520;
      --text-light: #212529;
      --text-dark: #f8f9fa;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: var(--bg-light);
      color: var(--text-light);
      transition: background 0.3s ease, color 0.3s ease;
    }
    body.dark {
      background: var(--bg-dark);
      color: var(--text-dark);
    }
    .sidebar {
      background: var(--sidebar-light);
      color: #fff;
      width: 240px;
      height: 100vh;
      position: fixed;
      padding: 20px;
      transition: transform 0.3s ease;
      z-index: 1000;
    }
    body.dark .sidebar {
      background: var(--sidebar-dark);
    }
    .sidebar a {
      color: #e0d6f2;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 15px 0;
      font-size: 16px;
      transition: all 0.3s;
    }
    .sidebar a:hover {
      color: #fff;
      transform: translateX(5px);
    }
    .content {
      margin-left: 260px;
      padding: 40px;
      transition: margin 0.3s ease;
    }
    .hamburger {
      font-size: 24px;
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 1100;
      cursor: pointer;
      color: var(--text-light);
      transition: color 0.3s;
    }
    body.dark .hamburger {
      color: var(--text-dark);
    }
    .mode-toggle {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1100;
      cursor: pointer;
      font-size: 24px;
      color: var(--text-light);
      transition: transform 0.3s ease, color 0.3s ease;
    }
    .mode-toggle:hover {
      transform: rotate(180deg);
    }
    body.dark .mode-toggle {
      color: var(--text-dark);
    }
    .welcome {
      background: linear-gradient(135deg, #9d70f9, #cba7ff);
      color: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      animation: fadeIn 1s ease;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }
    .card-action {
      border-radius: 12px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }
    .card-action:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        position: absolute;
      }
      .sidebar.show {
        transform: translateX(0);
      }
      .content {
        margin-left: 20px;
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <i class="fas fa-bars hamburger" id="hamburger"></i>
  <i class="fas fa-moon mode-toggle" id="modeToggle"></i>

  <div class="sidebar" id="sidebar">
    <h3><i class="fas fa-user-graduate me-2"></i>Student Panel</h3>
    <a href="view_results.php"><i class="fas fa-clipboard-list"></i> View Results</a>
    <a href="download_transcript.php"><i class="fas fa-file-download"></i> Download Transcript</a>
    <a href="notices.php"><i class="fas fa-bell"></i> View Notices</a>
    <a href="update_profile.php"><i class="fas fa-user-edit"></i> Update Profile</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>

  <div class="content">
    <div class="welcome">
      <h2>Welcome, <?php echo $studentName; ?> 🎓</h2>
      <p>Here's your academic summary and quick tools.</p>
    </div>

    <!-- Dashboard Cards -->
    <div class="row mt-5 g-4">
      <div class="col-12 col-sm-6 col-md-4">
        <div class="card bg-primary text-white text-center card-action">
          <div class="card-body">
            <i class="fas fa-graduation-cap fa-2x"></i>
            <h6 class="mt-2">GPA: <?= $gpa ?></h6>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-4">
        <div class="card bg-info text-white text-center card-action">
          <div class="card-body">
            <i class="fas fa-book-open fa-2x"></i>
            <h6 class="mt-2">Credits: <?= $totalCredits ?></h6>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-4">
        <div class="card bg-success text-white text-center card-action">
          <div class="card-body">
            <i class="fas fa-list-ul fa-2x"></i>
            <h6 class="mt-2">Courses: <?= $completedCourses ?></h6>
          </div>
        </div>
      </div>
    </div>

    <!-- Optionally Add Charts or Announcements Later -->
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const sidebar = document.getElementById('sidebar');
    document.getElementById('hamburger').addEventListener('click', () => {
      sidebar.classList.toggle('show');
    });

    const toggle = document.getElementById('modeToggle');
    if (localStorage.getItem('theme') === 'dark') {
      document.body.classList.add('dark');
      toggle.classList.remove('fa-moon');
      toggle.classList.add('fa-sun');
    }

    toggle.addEventListener('click', () => {
      document.body.classList.toggle('dark');
      const dark = document.body.classList.contains('dark');
      toggle.classList.toggle('fa-sun', dark);
      toggle.classList.toggle('fa-moon', !dark);
      localStorage.setItem('theme', dark ? 'dark' : 'light');
    });
  </script>
</body>
</html>
