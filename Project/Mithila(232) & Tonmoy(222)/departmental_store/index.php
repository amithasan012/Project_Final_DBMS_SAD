<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Animate.css for motion -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Nunito:wght@400;700&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      font-family: 'Nunito', sans-serif;
      min-height: 100vh;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px 10px;
    }

    .dashboard-container {
      max-width: 1200px;
      width: 100%;
    }

    h1 {
      font-family: 'Orbitron', sans-serif;
      font-size: 2.8rem;
      text-align: center;
      margin-bottom: 40px;
      color: #00ffd5;
      text-shadow: 0 0 8px #00ffd5;
    }

    .card {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      padding: 30px;
      color: white;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
    }

    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 15px 30px rgba(0,0,0,0.4);
    }

    .card-title {
      font-size: 1.3rem;
      margin-bottom: 15px;
      color: #00ffd5;
    }

    .btn-custom {
      background-color: transparent;
      border: 1px solid #00ffd5;
      color: #00ffd5;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #00ffd5;
      color: #000;
      transform: scale(1.05);
    }

    .logout-btn {
      border-color: #ff4b5c;
      color: #ff4b5c;
    }

    .logout-btn:hover {
      background-color: #ff4b5c;
      color: white;
    }
  </style>
</head>
<body>

<div class="container dashboard-container animate__animated animate__fadeIn">
  <h1>👑 Welcome, Admin</h1>
  <div class="row g-4 justify-content-center">

    <div class="col-md-4">
      <div class="card text-center animate__animated animate__zoomIn">
        <div class="card-title">➕ Add Product</div>
        <a href="add_product.php" class="btn btn-custom">Enter</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center animate__animated animate__zoomIn animate__delay-1s">
        <div class="card-title">📦 View Products</div>
        <a href="view_products.php" class="btn btn-custom">View</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center animate__animated animate__zoomIn animate__delay-2s">
        <div class="card-title">🏷️ Add Category</div>
        <a href="add_category.php" class="btn btn-custom">Create</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center animate__animated animate__zoomIn animate__delay-3s">
        <div class="card-title">💰 Sell Product</div>
        <a href="sell_product.php" class="btn btn-custom">Sell</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center animate__animated animate__zoomIn animate__delay-4s">
        <div class="card-title">📊 Sales Report</div>
        <a href="sales_report.php" class="btn btn-custom">Report</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center animate__animated animate__zoomIn animate__delay-5s">
        <div class="card-title">🚪 Logout</div>
        <a href="logout.php" class="btn btn-custom logout-btn">Exit</a>
      </div>
    </div>

  </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
