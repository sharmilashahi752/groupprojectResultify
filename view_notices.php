<?php
include('includes/db.php');
$result = mysqli_query($conn, "SELECT * FROM notices ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Notices</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f9f9f9; }
        .notice { background: #fff; padding: 15px; margin-bottom: 15px; border-left: 5px solid purple; }
        .notice h4 { margin: 0; }
        .notice small { color: gray; }
    </style>
</head>
<body>
    <h2>📢 Notices</h2>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="notice">
            <h4><?php echo htmlspecialchars($row['title']); ?></h4>
            <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
            <small>Posted by <?php echo $row['posted_by']; ?> on <?php echo $row['created_at']; ?></small>
        </div>
    <?php endwhile; ?>
</body>
</html>
