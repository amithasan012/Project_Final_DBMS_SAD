<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$query = "
SELECT b.id, u.name AS user_name, b.from_station, b.to_station, b.travel_date, b.seats, b.total_price, b.booking_date
FROM bookings b
JOIN users u ON b.user_id = u.id
ORDER BY b.id DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Booking Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Booking Details</h2>
  <a href="admin_dashboard.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>User</th>
        <th>From</th>
        <th>To</th>
        <th>Date</th>
        <th>Seats</th>
        <th>Total Price</th>
        <th>Booked On</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['user_name']) ?></td>
          <td><?= htmlspecialchars($row['from_station']) ?></td>
          <td><?= htmlspecialchars($row['to_station']) ?></td>
          <td><?= $row['travel_date'] ?></td>
          <td><?= $row['seats'] ?></td>
          <td>৳<?= $row['total_price'] ?></td>
          <td><?= $row['booking_date'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
