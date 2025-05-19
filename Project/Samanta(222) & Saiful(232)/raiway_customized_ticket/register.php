<?php
session_start();
require_once 'config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed);
            if ($stmt->execute()) {
                $success = "Registration successful. <a href='login.php'>Login here</a>.";
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Register - Railway Booking</title>
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
  <h3 class="mb-4 text-center text-purple">Create an Account</h3>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php elseif ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <form method="POST" novalidate>
    <div class="mb-3">
      <label for="name" class="form-label">Full Name</label>
      <input type="text" name="name" class="form-control" id="name" required />
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" name="email" class="form-control" id="email" required />
    </div>
    <div class="mb-4">
      <label for="password" class="form-label">Password (min 6 characters)</label>
      <input type="password" name="password" class="form-control" id="password" required minlength="6" />
    </div>
    <button type="submit" class="btn btn-primary w-100">Register</button>
  </form>
  <div class="mt-3 text-center">
    Already have an account? <a href="login.php">Login here</a>
  </div>
</div>
</body>
</html>
