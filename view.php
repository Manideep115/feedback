<?php


session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}



$conn = new mysqli("localhost", "root", "", "feedback_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = "";
if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM feedback 
            WHERE name LIKE '%$search%' 
               OR email LIKE '%$search%' 
               OR feedback LIKE '%$search%' 
            ORDER BY submitted_at DESC";
} else {
    $sql = "SELECT * FROM feedback ORDER BY submitted_at DESC";
}
$result = $conn->query($sql);
?>
<a href="logout.php" class="btn btn-danger mb-3">Logout</a>
<a href="export.php" class="btn btn-success mb-3">Export to CSV</a>
<form method="GET" class="mb-3 d-flex" style="max-width:400px;">
  <input type="text" name="search" class="form-control me-2" placeholder="Search feedback..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
  <button type="submit" class="btn btn-primary">Search</button>
</form>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Feedback Records</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">📋 User Feedback</h2>
    <div class="card shadow-lg">
      <div class="card-body">
        <table class="table table-striped table-hover">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Subject</th>
              <th>Feedback</th>
              <th>Submitted At</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>".$i++."</td>
            <td>".($row['name'] ?: 'Anonymous')."</td>
            <td>".($row['email'] ?: 'N/A')."</td>
            <td>".(!empty($row['subject']) ? htmlspecialchars($row['subject']) : 'General')."</td>
            <td>".htmlspecialchars($row['feedback'])."</td>
            <td>".$row['submitted_at']."</td>
          </tr>";
}

            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
