<?php
session_start();
include 'db.php';

// Redirect if not admin logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$success = '';
$error = '';

// Fetch only products with quantity > 0 (available stock)
$products = $conn->query("SELECT * FROM products WHERE quantity > 0 ORDER BY name ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Get current product info
    $res = $conn->query("SELECT * FROM products WHERE id = $product_id");
    $product = $res->fetch_assoc();

    if ($product) {
        if ($product['quantity'] >= $quantity) {
            $total = $product['price'] * $quantity;

            // Update product quantity
            $conn->query("UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id");

            // Insert into sales table with total_price and current datetime
            $stmt = $conn->prepare("INSERT INTO sales (product_id, quantity, total_price, sold_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("iid", $product_id, $quantity, $total);
            $stmt->execute();
            $stmt->close();

            $success = "✅ Product sold successfully!";
        } else {
            $error = "❌ Not enough stock!";
        }
    } else {
        $error = "❌ Product not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sell Product</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&family=Nunito&display=swap" rel="stylesheet" />

  <style>
    body {
      background: linear-gradient(to right, #000000, #434343);
      font-family: 'Nunito', sans-serif;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.06);
      backdrop-filter: blur(14px);
      border-radius: 20px;
      padding: 40px;
      max-width: 600px;
      width: 100%;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .form-title {
      font-family: 'Orbitron', sans-serif;
      text-align: center;
      font-size: 2rem;
      margin-bottom: 25px;
      color: #00ffd5;
      text-shadow: 0 0 5px #00ffd5;
    }

    .form-control {
      background-color: rgba(255, 255, 255, 0.1);
      border: none;
      color: white;
    }

    .form-control::placeholder {
      color: #ccc;
    }

    .btn-custom {
      background-color: transparent;
      border: 1px solid #00ffd5;
      color: #00ffd5;
      width: 100%;
      transition: 0.3s;
      font-weight: 600;
    }

    .btn-custom:hover {
      background-color: #00ffd5;
      color: black;
    }

    .alert {
      font-weight: 600;
      text-align: center;
      margin-bottom: 20px;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<div class="form-container animate__animated animate__fadeInUp">
  <div class="form-title">🛒 Sell Product</div>

  <?php if ($success): ?>
    <div class="alert alert-success animate__animated animate__fadeIn"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger animate__animated animate__shakeX"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label for="product_id" class="form-label">Select Product</label>
      <select name="product_id" class="form-control" required>
        <option value="" disabled selected>Choose product...</option>
        <?php while ($p = $products->fetch_assoc()): ?>
          <option value="<?= $p['id'] ?>">
            <?= htmlspecialchars($p['name']) ?> — ৳<?= number_format($p['price'], 2) ?> (<?= $p['quantity'] ?> in stock)
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="quantity" class="form-label">Quantity</label>
      <input type="number" name="quantity" min="1" class="form-control" placeholder="Enter quantity" required>
    </div>

    <button type="submit" class="btn btn-custom">Sell</button>
  </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
