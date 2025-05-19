<?php
require_once '../config/auth.php';
require_once '../queries/query.php';
include '../includes/header.php';
include '../includes/navbar.php';

redirect_if_not_logged_in();
redirect_if_not_admin();

// Confirm logic
if (isset($_GET['confirm'])) {
  confirm_appointment($_GET['confirm']);
  header("Location: appointments.php");
  exit();
}

$appList = get_all_appointments();
?>

<div class="container mt-4">
  <h3>All Appointments</h3>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>User</th>
        <th>Doctor</th>
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($a = $appList->fetch_assoc()): ?>
      <tr>
        <td><?= $a['id'] ?></td>
        <td><?= $a['user_name'] ?></td>
        <td><?= $a['doctor_name'] ?></td>
        <td><?= $a['appointment_date'] ?></td>
        <td><?= $a['status'] ?></td>
        <td>
          <?php if ($a['status'] === 'Pending'): ?>
            <a href="?confirm=<?= $a['id'] ?>" class="btn btn-success btn-sm">Confirm</a>
          <?php else: ?>
            <span class="badge bg-success">Confirmed</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>