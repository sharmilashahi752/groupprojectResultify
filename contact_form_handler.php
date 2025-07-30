<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = htmlspecialchars($_POST["name"]);
  $email = htmlspecialchars($_POST["email"]);
  $subject = htmlspecialchars($_POST["subject"]);
  $message = htmlspecialchars($_POST["message"]);

  // You could send an email or store in database here
  // Example (for dev):
  echo "<script>alert('Thank you, $name. Your message has been received.'); window.location.href = 'index.html';</script>";
}
?>
