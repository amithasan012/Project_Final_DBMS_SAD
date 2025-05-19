<?php
// add_ticket.php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) { // assuming user ID 1 is admin
  header('Location: login.php');
  exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $source = $_POST['source'];
  $destination = $_POST['destination'];
  $travel_date = $_POST['travel_date'];
  $available_seats = $_POST['available_seats'];

  $stmt = $conn->prepare("INSERT INTO tickets (source, destination, travel_date, available_seats) VALUES (?, ?, ?, ?)");
  if ($stmt->execute([$source, $destination, $travel_date, $available_seats])) {
    $message = "Ticket successfully added.";
  } else {
    $message = "Error adding ticket.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Ticket</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #a1c4fd, #c2e9fb);
    }
    .form-container {
      max-width: 500px;
      margin: 80px auto;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h3 class="mb-4 text-center">Add New Ticket</h3>

    <?php if ($message): ?>
      <div class="alert alert-info"> <?= $message ?> </div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label for="source" class="form-label">Source</label>
        <input type="text" name="source" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="destination" class="form-label">Destination</label>
        <input type="text" name="destination" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="travel_date" class="form-label">Travel Date</label>
        <input type="date" name="travel_date" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="available_seats" class="form-label">Available Seats</label>
        <input type="number" name="available_seats" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success w-100">Add Ticket</button>
    </form>

    <div class="text-center mt-3">
      <a href="index.php" class="btn btn-outline-secondary">Back to Home</a>
    </div>
  </div>
</body>
</html>
