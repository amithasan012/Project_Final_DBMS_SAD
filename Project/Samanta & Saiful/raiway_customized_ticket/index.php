<?php
session_start();
require_once 'config/db.php';

function getUserName($conn, $id) {
    $stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name);
    $stmt->fetch();
    return $name ?: "User";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Railway Ticket Booking</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
  body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  .hero {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: white;
    text-align: center;
    padding: 50px 20px;
  }
  .btn-custom {
    background: #764ba2;
    border: none;
  }
  .btn-custom:hover {
    background: #667eea;
  }
</style>
</head>
<body>
  <div class="hero container">
    <h1 class="display-4 fw-bold mb-3">Welcome to Railway Ticket Booking</h1>
    <p class="lead mb-5">Book your railway tickets easily, securely, and quickly.</p>

    <?php if (isset($_SESSION['user_id'])): ?>
      <p class="mb-4 fs-5">Hello, <?= htmlspecialchars(getUserName($conn, $_SESSION['user_id'])) ?>!</p>
      <a href="booking.php" class="btn btn-custom btn-lg me-3 mb-3">Book Ticket</a>
      <a href="tickets.php" class="btn btn-info btn-lg me-3 mb-3">My Bookings</a>
      <a href="logout.php" class="btn btn-danger btn-lg mb-3">Logout</a>
    <?php else: ?>
      <a href="login.php" class="btn btn-custom btn-lg me-3 mb-3">Login</a>
      <a href="register.php" class="btn btn-outline-light btn-lg mb-3">Register</a>
    <?php endif; ?>
  </div>
</body>
</html>
