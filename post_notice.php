<?php
session_start();
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['university', 'admin'])) 
{
  header("Location: login.php");
  exit();
}
include('includes/db.php');

$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $message = trim($_POST['message']);

    if (!empty($title) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO notices (title, message, posted_by) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $message, $_SESSION['user']['username']);
        if ($stmt->execute()) {
            $success = "Notice posted successfully!";
        } else {
            $error = "Error posting notice.";
        }
        $stmt->close();
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Notice - University Dashboard</title>
    <style>
        body { font-family: Arial; margin: 30px; background: #f5f5f5; }
        form { background: white; padding: 20px; border-radius: 10px; width: 500px; }
        input, textarea { width: 100%; padding: 10px; margin-top: 10px; }
        button { padding: 10px 20px; background: purple; color: white; border: none; margin-top: 10px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Post a New Notice</h2>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Notice Title</label>
        <input type="text" name="title" required>
        
        <label>Message</label>
        <textarea name="message" rows="5" required></textarea>
        
        <button type="submit">Post Notice</button>
    </form>
</body>
</html>
