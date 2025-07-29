<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'tcpdf/tcpdf.php'; // Path to TCPDF

$studentEmail = $_SESSION['user']['email'];

// Fetch student details
$query = "SELECT * FROM students WHERE email = '$studentEmail'";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    die("Student not found.");
}

$student = $result->fetch_assoc();
$roll = $student['roll_no'];

// Fetch marks
$marksQuery = "SELECT * FROM marks WHERE roll_no = '$roll'";
$marksResult = $conn->query($marksQuery);

if (!$marksResult || $marksResult->num_rows === 0) {
    die("Marks not found.");
}

$marks = $marksResult->fetch_assoc();
$subjects = ['python', 'web_tech', 'mis', 'sad', 'research'];

// GPA & Grade
$total = 0;
$html = '';
foreach ($subjects as $subject) {
    $score = $marks[$subject];
    $total += $score;

    $gpa = min(round($score / 25, 2), 4.0); // GPA rule
    $grade = match (true) {
        $gpa >= 4.0 => 'A+',
        $gpa >= 3.6 => 'A',
        $gpa >= 3.2 => 'B+',
        $gpa >= 2.8 => 'B',
        $gpa >= 2.4 => 'C+',
        $gpa >= 2.0 => 'C',
        default => 'F',
    };

    $html .= "<tr>
                <td>" . strtoupper($subject) . "</td>
                <td>$score</td>
                <td>$gpa</td>
                <td>$grade</td>
              </tr>";
}

$average = $total / count($subjects);
$final_gpa = min(round($average / 25, 2), 4.0);

// Create PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 12);

// PDF Content
$content = "
<h2 style='text-align:center;'>Lumbini Technological University</h2>
<h3 style='text-align:center;'>Student Marksheet</h3>
<p><strong>Name:</strong> {$student['name']}</p>
<p><strong>Roll No:</strong> {$student['roll_no']}</p>
<p><strong>Email:</strong> {$student['email']}</p>
<p><strong>Department:</strong> {$student['department']}</p>

<table border='1' cellpadding='5'>
    <thead>
        <tr>
            <th>Subject</th>
            <th>Marks</th>
            <th>GPA</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        $html
    </tbody>
</table>

<p><strong>Total Marks:</strong> $total</p>
<p><strong>GPA:</strong> $final_gpa</p>
";

// Write content and download
$pdf->writeHTML($content, true, false, true, false, '');
$pdf->Output('marksheet.pdf', 'D'); // D = download
?>
