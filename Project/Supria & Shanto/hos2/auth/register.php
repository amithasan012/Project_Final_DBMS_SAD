<?php
require_once '../config/db.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = 'user';

  $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
  if ($check->num_rows > 0) {
    $msg = "Email already registered!";
  } else {
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    if ($stmt->execute()) {
      $msg = "Registration successful! <a href='login.php'>Login here</a>.";
    } else {
      $msg = "Error registering user.";
    }
  }
}
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5 col-md-6">
  <h2>Register</h2>
  <?php if ($msg): ?><div class="alert alert-info"><?= $msg ?></div><?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Name:</label>
      <input type="text" name="name" required class="form-control">
    </div>
    <div class="mb-3">
      <label>Email:</label>
      <input type="email" name="email" required class="form-control">
    </div>
    <div class="mb-3">
      <label>Password:</label>
      <input type="password" name="password" required class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</div>
<?php include '../includes/footer.php'; ?>