<?php
require_once '../config/auth.php';
require_once '../queries/query.php';
include '../includes/header.php';
include '../includes/navbar.php';

redirect_if_not_logged_in();

$user_id = $_SESSION['user'];
$msg = "";

// Handle new appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['appointment_date'];

    if (create_appointment($user_id, $doctor_id, $date)) {
        $msg = "Appointment requested successfully!";
    } else {
        $msg = "Error booking appointment.";
    }
}

// Get doctors list
$doctors = get_all_doctors();
?>

<div class="container mt-4">
  <h3>Book Appointment</h3>
  <?php if ($msg): ?><div class="alert alert-info"><?= $msg ?></div><?php endif; ?>
  <form method="POST" class="row g-3">
    <div class="col-md-4">
      <label>Doctor</label>
      <select name="doctor_id" class="form-select" required>
        <?php while ($doc = $doctors->fetch_assoc()): ?>
          <option value="<?= $doc['id'] ?>"><?= $doc['name'] ?> (<?= $doc['specialty'] ?>)</option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-4">
      <label>Appointment Date</label>
      <input type="date" name="appointment_date" required class="form-control">
    </div>
    <div class="col-md-4 mt-4">
      <button type="submit" class="btn btn-primary mt-2">Book Appointment</button>
    </div>
  </form>

  <hr class="my-4">
  <h4>Your Appointments</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Doctor</th>
        <th>Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $res = $conn->query("SELECT a.*, d.name AS doctor FROM appointments a 
                             JOIN doctors d ON a.doctor_id = d.id 
                             WHERE a.user_id = $user_id");
        while ($row = $res->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['doctor'] ?></td>
          <td><?= $row['appointment_date'] ?></td>
          <td><?= $row['status'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>