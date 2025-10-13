<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "feedback_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set headers so browser downloads the file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=feedback_export.csv');

// Open output stream
$output = fopen("php://output", "w");

// Add column headers
fputcsv($output, ["ID", "Name", "Email", "Message", "Status", "Date"]);

// Fetch data from DB
$result = $conn->query("SELECT id, name, email, message, status, created_at FROM feedback");

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
