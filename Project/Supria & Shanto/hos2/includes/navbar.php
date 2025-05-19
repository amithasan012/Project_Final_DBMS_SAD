<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/hos2/index.php">Hospital System</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if (!isset($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="/hos2/auth/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="/hos2/auth/register.php">Register</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/hos2/user/appointments.php">My Appointments</a></li>
          <li class="nav-item"><a class="nav-link" href="/hos2/auth/logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>