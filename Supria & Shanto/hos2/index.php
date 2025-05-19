<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container mt-4">
  <h1 class="text-center">Welcome to Hospital Management System</h1>
  <p class="lead text-center">Book and manage appointments with doctors easily.</p>

  <div class="row mt-5 text-center">
    <div class="col-md-4">
      <h4>Doctors</h4>
      <p>Browse list of doctors available.</p>
      <a href="doctors/index.php" class="btn btn-primary">View Doctors</a>
    </div>
    <div class="col-md-4">
      <h4>Appointments</h4>
      <p>Login to book appointments with our doctors.</p>
      <?php if (!isset($_SESSION['user'])): ?>
        <a href="auth/login.php" class="btn btn-success">Login to Book</a>
      <?php else: ?>
        <a href="user/appointments.php" class="btn btn-success">My Appointments</a>
      <?php endif; ?>
    </div>
    <div class="col-md-4">
      <h4>Admin Panel</h4>
      <p>Admin can manage appointments here.</p>
      <a href="admin/appointments.php" class="btn btn-dark">Admin Panel</a>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>