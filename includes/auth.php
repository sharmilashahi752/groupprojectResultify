<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    // Not logged in or not a student
    header("Location: ../login.php");
    exit();
}
?>
