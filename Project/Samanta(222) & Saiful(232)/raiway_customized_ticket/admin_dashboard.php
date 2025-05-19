<?php
session_start();
require_once 'config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch total users
$userCount = 0;
$userQuery = "SELECT COUNT(*) AS total FROM users";
$userResult = $conn->query($userQuery);
if ($userResult && $userResult->num_rows > 0) {
    $row = $userResult->fetch_assoc();
    $userCount = $row['total'];
}

// Fetch total bookings
$bookingCount = 0;
$bookingQuery = "SELECT COUNT(*) AS total FROM bookings";
$bookingResult = $conn->query($bookingQuery);
if ($bookingResult && $bookingResult->num_rows > 0) {
    $row = $bookingResult->fetch_assoc();
    $bookingCount = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f4f4f4;
      padding-top: 50px;
    }
    .dashboard-box {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      text-align: center;
      transition: all 0.3s ease;
    }
    .dashboard-box:hover {
      background-color: #f0f0f0;
      transform: scale(1.02);
    }
    .dashboard-box h4 {
      font-size: 24px;
      color: #764ba2;
    }
    .dashboard-box p {
      font-size: 40px;
      font-weight: bold;
    }
    a.no-decoration {
      text-decoration: none;
      color: inherit;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="text-center mb-5">Admin Dashboard</h2>
    <div class="row justify-content-center">
      <div class="col-md-4">
        <a href="admin_users.php" class="no-decoration">
          <div class="dashboard-box mb-4">
            <h4>Total Users</h4>
            <p><?= $userCount ?></p>
          </div>
        </a>
      </div>
      <div class="col-md-4">
        <a href="admin_bookings.php" class="no-decoration">
          <div class="dashboard-box mb-4">
            <h4>Total Bookings</h4>
            <p><?= $bookingCount ?></p>
          </div>
        </a>
      </div>
    </div>
    <div class="text-center">
      <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</body>
</html>
