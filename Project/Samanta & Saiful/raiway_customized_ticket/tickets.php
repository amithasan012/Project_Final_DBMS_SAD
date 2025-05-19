<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("SELECT from_station, to_station, travel_date, seats, booking_date FROM bookings WHERE user_id = ? ORDER BY booking_date DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$tickets = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>My Bookings - Railway Booking</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
  body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
    padding-top: 50px;
  }
  .container {
    max-width: 700px;
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
  }
  .ticket {
    border: 1px solid #764ba2;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
  }
  .ticket h5 {
    color: #764ba2;
  }
</style>
</head>
<body>
  <div class="container mx-auto">
    <h2 class="mb-4 text-center text-purple">My Bookings</h2>

    <?php if ($tickets): ?>
      <?php foreach ($tickets as $ticket): ?>
        <div class="ticket">
          <h5>From <strong><?= htmlspecialchars($ticket['from_station']) ?></strong> to <strong><?= htmlspecialchars($ticket['to_station']) ?></strong></h5>
          <p>Date: <?= htmlspecialchars($ticket['travel_date']) ?> | Seats: <?= htmlspecialchars($ticket['seats']) ?></p>
          <small>Booked on: <?= htmlspecialchars($ticket['booking_date']) ?></small>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-warning">You have no bookings yet.</div>
    <?php endif; ?>

    <div class="text-center mt-4">
      <a href="index.php" class="btn btn-outline-primary">&larr; Back to Home</a>
    </div>
  </div>
</body>
</html>
