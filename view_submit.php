<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Correct database config
$host = 'localhost';
$db   = 'ss';               // ✅ Your actual database name
$user = 'root';             // ✅ Default username in XAMPP
$pass = '';                 // ✅ Empty password for XAMPP by default

// Connect to database
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name    = isset($_POST['name']) ? trim($_POST['name']) : '';
$email   = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate input
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
  die("Error: All fields are required.");
}

// Prepare SQL insert
$stmt = $conn->prepare("INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)");
if (!$stmt) {
  die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssss", $name, $email, $subject, $message);

// Execute and give feedback
if ($stmt->execute()) {
  echo "Message submitted successfully.";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
