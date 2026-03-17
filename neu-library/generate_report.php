<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

require('fpdf.php');
include('db.php');

$range = isset($_GET['range']) ? $_GET['range'] : 'today';

if ($range == 'week') {
    $query = "SELECT logs.*, users.name, users.college FROM logs 
              JOIN users ON logs.user_id = users.id 
              WHERE YEARWEEK(visit_date, 1) = YEARWEEK(CURDATE(), 1)";
    $title = "Weekly Attendance Report";
} elseif ($range == 'month') {
    $query = "SELECT logs.*, users.name, users.college FROM logs 
              JOIN users ON logs.user_id = users.id 
              WHERE MONTH(visit_date) = MONTH(CURDATE()) AND YEAR(visit_date) = YEAR(CURDATE())";
    $title = "Monthly Attendance Report";
} else {
    $query = "SELECT logs.*, users.name, users.college FROM logs 
              JOIN users ON logs.user_id = users.id 
              WHERE DATE(visit_date) = CURDATE()";
    $title = "Daily Attendance Report";
}

$result = mysqli_query($conn, $query);

$pdf = new FPDF();
$pdf->AddPage();

// Header
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(85, 93, 66); // Olive Green
$pdf->Cell(0, 10, 'NEU LIBRARY VISITOR LOG', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(100, 100, 100);
$pdf->Cell(0, 10, $title . ' - ' . date('Y-m-d'), 0, 1, 'C');
$pdf->Ln(10);

// Table Header
$pdf->SetFillColor(85, 93, 66);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 10, 'Time', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Name', 1, 0, 'C', true);
$pdf->Cell(55, 10, 'College', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Purpose', 1, 1, 'C', true);


// --- FIXED TABLE DATA LOOP ---
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);

while ($row = mysqli_fetch_assoc($result)) {
    // 1. Prepare data
    $time = date('h:i A', strtotime($row['visit_date']));
    $name = $row['name'];
    $college = $row['college'];
    $purpose = $row['purpose'];

    // 2. Calculate the height needed for the "Purpose" column
    // We check how many lines the purpose text will take at 40mm width
    $columnWidth = 40;
    $nbLines = $pdf->GetStringWidth($purpose) > ($columnWidth - 2) ? 2 : 1;
    // If it's very long, you might need a more complex line counter, 
    // but this handles the 2-line overlap shown in your screenshot.
    $rowHeight = ($nbLines * 5) + 5;
    if ($rowHeight < 10) $rowHeight = 10;

    // 3. Save starting positions
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // 4. Print columns 1, 2, and 3 with the calculated Row Height
    $pdf->Cell(35, $rowHeight, $time, 1, 0, 'C');
    $pdf->Cell(60, $rowHeight, $name, 1, 0, 'L');
    $pdf->Cell(55, $rowHeight, $college, 1, 0, 'L');

    // 5. Use MultiCell for the "Purpose" column (The Fix)
    // We save the X/Y before printing so we can jump to the next row correctly
    $pdf->MultiCell($columnWidth, ($rowHeight / $nbLines), $purpose, 1, 'L');

    // 6. Reset position to the start of the next row
    // This prevents the "stacking" effect
    $pdf->SetXY($x, $y + $rowHeight);
}
// Clean the output buffer to ensure no whitespace is sent
ob_end_clean();

// Output the PDF
$pdf->Output('D', 'NEU_Library_Report_' . $range . '.pdf');
exit();

