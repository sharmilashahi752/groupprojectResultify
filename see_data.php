<?php
include 'db_connect.php';

$students = [
    ["Aarav Shrestha", "aarav@gmail.com", "R101"],
    ["Pratiksha Karki", "pratiksha@gmail.com", "R102"],
    ["Bibek KC", "bibek@gmail.com", "R103"],
    ["Supriya Thapa", "supriya@gmail.com", "R104"],
    ["Nishan Gurung", "nishan@gmail.com", "R105"],
    ["Saurav Neupane", "saurav@gmail.com", "R106"],
    ["Anisha Lama", "anisha@gmail.com", "R107"],
    ["Sabitri Adhikari", "sabitri@gmail.com", "R108"],
    ["Ramesh Shahi", "ramesh@gmail.com", "R109"],
    ["Shristi KC", "shristi@gmail.com", "R110"],
];

foreach ($students as $s) {
    mysqli_query($conn, "INSERT IGNORE INTO students (name, email, roll_no, department, year) 
        VALUES ('$s[0]', '$s[1]', '$s[2]', 'IT', '2025')");

    $py = rand(50, 100);
    $wt = rand(50, 100);
    $mis = rand(50, 100);
    $sad = rand(50, 100);
    $res = rand(50, 100);

    mysqli_query($conn, "INSERT IGNORE INTO marks (roll_no, python, web_tech, mis, sad, research) 
        VALUES ('$s[2]', $py, $wt, $mis, $sad, $res)");
}

echo "✅ Data seeded into database 'ss'";
?>
