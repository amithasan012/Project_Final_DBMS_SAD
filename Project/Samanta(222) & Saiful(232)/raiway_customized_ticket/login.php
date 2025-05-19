<?php
session_start();
require_once 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed);
        $stmt->fetch();

        if (password_verify($password, $hashed)) {
            $_SESSION['user_id'] = $id;
            header("Location: index.php");
            exit();
        }
    }
    $error = "Invalid email or password.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login - Railway Booking</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
  body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .card {
    width: 400px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
  }
  .btn-primary {
    background: #764ba2;
    border: none;
  }
  .btn-primary:hover {
    background: #667eea;
  }
</style>
</head>
<body>
<div class="card p-4">
  <h3 class="mb-4 text-center text-purple">Login to Your Account</h3>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" novalidate>
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" name="email" class="form-control" id="email" required />
    </div>
    <div class="mb-4">
      <label for="password" class="form-label">Password</label>
      <input type="password" name="password" class="form-control" id="password" required />
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>
  <div class="mt-3 text-center">
    Don't have an account? <a href="register.php">Register here</a>
  </div>
</div>
</body>
</html>
