<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $category_name);
        if ($stmt->execute()) {
            $success = "✅ Category added successfully!";
        } else {
            $error = "❌ Error adding category!";
        }
        $stmt->close();
    } else {
        $error = "⚠️ Category name cannot be empty!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Category</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&family=Nunito&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #232526, #414345);
      font-family: 'Nunito', sans-serif;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 40px;
      max-width: 500px;
      width: 100%;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
    }

    .form-title {
      font-family: 'Orbitron', sans-serif;
      text-align: center;
      font-size: 1.8rem;
      margin-bottom: 30px;
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
    }

    .btn-custom:hover {
      background-color: #00ffd5;
      color: black;
    }

    .message {
      margin-top: 20px;
      font-size: 1rem;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="form-container animate__animated animate__fadeInDown">
  <div class="form-title">➕ Add New Category</div>

  <?php if ($success): ?>
    <div class="alert alert-success text-center animate__animated animate__bounceIn"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger text-center animate__animated animate__shakeX"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <input type="text" name="category_name" class="form-control" placeholder="Enter category name" required>
    </div>
    <button type="submit" class="btn btn-custom">Add Category</button>
  </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
