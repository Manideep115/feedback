<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = htmlspecialchars($_POST["name"] ?? "");
  $email = htmlspecialchars($_POST["email"] ?? "");
  $subject = htmlspecialchars($_POST["subject"] ?? "");
  $feedback = htmlspecialchars($_POST["feedback"] ?? "");

  // simple file-based storage
  $entry = "Name: $name | Email: $email | Subject: $subject | Feedback: $feedback" . PHP_EOL;
  file_put_contents("feedback.txt", $entry, FILE_APPEND);

  $message = "✅ Thank you, $name! Your feedback about '$subject' has been recorded.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Feedback Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="text-center mb-4 text-primary">💬 Share Your Feedback</h2>

    <?php if ($message): ?>
      <div class="alert alert-success text-center">
        <?= $message ?>
      </div>
    <?php endif; ?>

    <div class="card shadow-lg p-4">
      <form action="" method="POST">
        <div class="mb-3">
          <label>Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Subject (Movie / Product / Dish / Anything)</label>
          <input type="text" name="subject" class="form-control" placeholder="e.g. Interstellar Movie" required>
        </div>
        <div class="mb-3">
          <label>Feedback</label>
          <textarea name="feedback" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit</button>
      </form>
    </div>
  </div>
</body>
</html>
