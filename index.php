<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Resultify - Smart Result Management</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <style>
    :root {
      --blue: #3D5AFE;
      --purple: #9C27B0;
      --accent-purple: #BA68C8;
      --light-bg: #E8EEFF;
      --white: #FFFFFF;
      --dark-bg: #1f1f2e;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f5f0ff, #e6e9ff);
      margin: 0;
      color: #333;
      transition: background 0.3s ease, color 0.3s ease;
    }

    body.dark-mode {
      background: #1f1f2e;
      color: #e0e0e0;
    }

    /* Navbar */
    .navbar {
      background: linear-gradient(90deg, #9C27B0, #BA68C8);
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .navbar-brand img {
      height: 60px;
      border-radius: 50%;
    }

    .nav-link,
    .navbar-brand {
      color: #fff !important;
      font-weight: 600;
    }

    .nav-link:hover {
      color: #ffd700 !important;
    }

    .toggle-dark {
      cursor: pointer;
      font-size: 1.5rem;
      color: #fff;
      margin-left: 1rem;
      transition: transform 0.3s ease;
    }

    .toggle-dark i {
      transition: transform 0.4s ease, opacity 0.3s ease;
    }

    .toggle-dark i.animate {
      transform: rotate(180deg);
      opacity: 0.8;
    }

    /* Hero */
    .hero {
      background: linear-gradient(135deg, #9C27B0 0%, #E8EEFF 100%);
      color: white;
      text-align: center;
      padding: 130px 20px;
      position: relative;
      border-radius: 0 0 40px 40px;
      box-shadow: 0 8px 25px rgba(156, 39, 176, 0.3);
    }

    .dark-mode .hero {
      background: linear-gradient(135deg, #6a1b9a, #4a148c);
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: 700;
      margin-bottom: 16px;
      text-shadow: 1px 1px 6px rgba(0,0,0,0.3);
    }

    .btn-hero {
      background: linear-gradient(90deg, #BA68C8, #9C27B0);
      color: #fff;
      padding: 14px 32px;
      border-radius: 40px;
      border: none;
      font-weight: bold;
      box-shadow: 0 0 15px #BA68C8;
      transition: 0.4s ease;
    }

    .btn-hero:hover {
      transform: scale(1.05);
      box-shadow: 0 0 30px #BA68C8;
    }

    /* Section Titles */
    .section-title {
      font-weight: 700;
      background: linear-gradient(90deg, #9C27B0, #BA68C8);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* Feature Cards */
    .feature-card {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 30px;
      transition: all 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .feature-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .features-icon {
      font-size: 3rem;
      color: var(--accent-purple);
    }

    /* Footer */
    .resultify-footer {
      background: linear-gradient(135deg, #9C27B0, #84518b);
      color: #ccc;
      font-family: 'Poppins', sans-serif;
      border-top: 3px solid #ba68c8;
      box-shadow: 0 -10px 20px rgba(0, 0, 0, 0.2);
    }

    .resultify-footer h6 {
      font-size: 1rem;
      background: linear-gradient(90deg, #eeedee, #BA68C8);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .footer-link {
      color: #bbb;
      text-decoration: none;
      display: inline-block;
      margin-bottom: 6px;
      transition: color 0.3s ease;
    }

    .footer-link:hover {
      color: #ffd700;
    }

    .resultify-footer i.text-accent {
      color: #ba68c8;
    }
  </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="images/logo3.png" alt="Resultify Logo" />
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
   
        <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="view_notices.php">View Notices</a></li>


        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item toggle-dark" onclick="toggleDarkMode()">
          <i id="mode-icon" class="bi bi-sun-fill"></i>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <div class="container" data-aos="fade-up">
    <h1>Empower Results. Inspire Futures.</h1>
    <p class="lead mb-4">Fast, Accurate & Beautiful Result Management</p>
    <a href="student/login.php" class="btn btn-hero">Check Result</a>
  </div>
</section>

<!-- About Section -->
<section class="py-5 bg-white" id="about">
  <div class="container text-center" data-aos="fade-right">
    <h2 class="section-title mb-3">What is Resultify</h2>
    <p class="text-muted">A dynamic result management system that enables real-time marksheet generation, performance tracking, and secure multi-role access for students, admin, and university staff. All in a beautiful UI.</p>
  </div>
</section>

<!-- Features Section -->
<section class="py-5" id="features">
  <div class="container">
    <h2 class="text-center section-title mb-5" data-aos="fade-up">Why Choose Resultify?</h2>
    <div class="row g-4">
      <div class="col-md-4" data-aos="zoom-in">
        <div class="feature-card text-center">
          <div class="features-icon mb-3"><i class="bi bi-bar-chart-fill"></i></div>
          <h5>Performance Analytics</h5>
          <p class="text-muted">Visualize marks and progress using interactive charts and color-coded feedback.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="150">
        <div class="feature-card text-center">
          <div class="features-icon mb-3"><i class="bi bi-filetype-pdf"></i></div>
          <h5>Marksheet Generator</h5>
          <p class="text-muted">Create & download clean, printable PDF results instantly with breakdowns.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
        <div class="feature-card text-center">
          <div class="features-icon mb-3"><i class="bi bi-lock-fill"></i></div>
          <h5>Secure Multi-Login</h5>
          <p class="text-muted">Separate portals with login security for students, faculty, and administrators.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5 bg-white">
  <div class="container" data-aos="fade-up">
    <h2 class="section-title text-center mb-4">Let's Connect</h2>
    <p class="text-center text-muted mb-5">Feel free to reach out to us using the form below.</p>

    <div class="row justify-content-center">
      <div class="col-md-8">
       <form id="contactForm" method="POST" action="view_submit.php" class="bg-light p-4 rounded shadow-sm">

          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Your Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Your Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label fw-semibold">Subject</label>
            <input type="text" name="subject" class="form-control" id="subject" placeholder="Message subject" required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label fw-semibold">Your Message</label>
            <textarea name="message" id="message" class="form-control" rows="5" placeholder="Write your message..." required></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-hero px-5">Send Message</button>
          </div>

          <div id="thankYouMessage" class="alert alert-success mt-4 d-none text-center">
            <strong>Thank you for getting in touch!</strong><br>
            We will respond shortly. Have a great day!
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Footer Section -->
<footer class="resultify-footer py-5 mt-5">
  <div class="container">
    <div class="row gy-4 justify-content-between align-items-start">
      <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center mb-3">
          <img src="images/logo3.png" alt="Resultify Logo" class="me-2 rounded-circle" style="height: 50px;" />
          <span class="fs-5 fw-bold text-white">Resultify</span>
        </div>
        <p class="text-muted small">
          A modern result management system that simplifies academic performance tracking with secure multi-role access and beautiful UI/UX.
        </p>
      </div>
      <div class="col-lg-2 col-md-6">
        <h6 class="text-white fw-semibold mb-3">Explore</h6>
        <ul class="list-unstyled small">
          <li><a href="#about" class="footer-link">About</a></li>
          <li><a href="#features" class="footer-link">Features</a></li>
          <li><a href="#contact" class="footer-link">Contact</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6">
        <h6 class="text-white fw-semibold mb-3">Contact</h6>
        <ul class="list-unstyled small text-muted">
          <li><i class="bi bi-envelope me-2 text-accent"></i> support@resultify.com</li>
          <li><i class="bi bi-phone me-2 text-accent"></i> +977-1234567890</li>
          <li><i class="bi bi-geo-alt me-2 text-accent"></i> Lumbini Technological University</li>
        </ul>
      </div>
    </div>
    <hr class="my-4 border-light-subtle" />
    <div class="text-center small text-muted">
      &copy; 2025 <strong class="text-white">Resultify</strong>. Built with <i class="bi bi-heart-fill text-accent"></i> for academic excellence.
    </div>
  </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000, once: true });

  function toggleDarkMode() {
    const body = document.body;
    const icon = document.getElementById('mode-icon');
    icon.classList.add('animate');
    body.classList.toggle('dark-mode');
    setTimeout(() => {
      if (body.classList.contains('dark-mode')) {
        icon.classList.remove('bi-sun-fill');
        icon.classList.add('bi-moon-fill');
      } else {
        icon.classList.remove('bi-moon-fill');
        icon.classList.add('bi-sun-fill');
      }
      icon.classList.remove('animate');
    }, 300);
  }

 

  AOS.init({ duration: 1000, once: true });

  function toggleDarkMode() {
    const body = document.body;
    const icon = document.getElementById('mode-icon');
    icon.classList.add('animate');
    body.classList.toggle('dark-mode');
    setTimeout(() => {
      if (body.classList.contains('dark-mode')) {
        icon.classList.remove('bi-sun-fill');
        icon.classList.add('bi-moon-fill');
      } else {
        icon.classList.remove('bi-moon-fill');
        icon.classList.add('bi-sun-fill');
      }
      icon.classList.remove('animate');
    }, 300);
  }

  // ✅ REPLACE OLD FORM HANDLER WITH THIS
  document.getElementById('contactForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch('view_submit.php', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (!response.ok) throw new Error('Network response was not OK');
      return response.text();
    })
    .then(data => {
      form.reset();
      const messageBox = document.getElementById('thankYouMessage');
      messageBox.classList.remove('d-none');
      setTimeout(() => {
        messageBox.classList.add('d-none');
      }, 8000);
    })
    .catch(error => {
      alert("There was an error submitting the form. Please try again later.");
      console.error("Error:", error);
    });
  });





</script>
</body>
</html>
<!-- Elfsight WhatsApp Chat | Untitled WhatsApp Chat -->
<!-- Elfsight WhatsApp Chat |  WhatsApp Chat -->
<script src="https://static.elfsight.com/platform/platform.js" async></script>
<div class="elfsight-app-6aac0d16-85a8-49f2-a3dc-e925a919a149" data-elfsight-app-lazy></div>
