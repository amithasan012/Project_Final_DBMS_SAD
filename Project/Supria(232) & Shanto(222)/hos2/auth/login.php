<?php
require_once '../config/db.php';
session_start();

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['user'] = $user['id'];
      $_SESSION['name'] = $user['name'];
      $_SESSION['role'] = $user['role'];

      if ($user['role'] === 'admin') {
        header('Location: /hos2/admin/appointments.php');
      } else {
        header('Location: /hos2/user/appointments.php');
      }
      exit();
    } else {
      $msg = "Invalid password.";
    }
  } else {
    $msg = "User not found.";
  }
}
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5 col-md-6">
  <h2>Login</h2>
  <?php if ($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Email:</label>
      <input type="email" name="email" required class="form-control">
    </div>
    <div class="mb-3">
      <label>Password:</label>
      <input type="password" name="password" required class="form-control">
    </div>
    <button type="submit" class="btn btn-dark">Login</button>
  </form>
</div>
<?php include '../includes/footer.php'; ?>