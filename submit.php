<?php
$conn = new mysqli("localhost", "root", "", "feedback_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$feedback = $_POST['feedback'];

$sql = "INSERT INTO feedback (name, email, subject, feedback, submitted_at) 
        VALUES ('$name', '$email', '$subject', '$feedback', NOW())";

if ($conn->query($sql)) {
    echo "<h2>✅ Thank you! Your feedback has been submitted.</h2>";
    echo "<a href='index.html'>Go back</a>";
} else {
    echo "Error: " . $conn->error;
}
?>
