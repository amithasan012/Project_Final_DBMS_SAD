<?php
include '../includes/header.php';
include '../includes/navbar.php';
include '../queries/query.php';

$doctors = get_all_doctors();
?>

<div class="container mt-4">
  <h2 class="mb-4">Our Doctors</h2>
  <div class="row">
    <?php while ($doc = $doctors->fetch_assoc()): ?>
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title"><?= $doc['name'] ?></h5>
            <p class="card-text">Specialty: <?= $doc['specialty'] ?></p>
            <p class="card-text">Contact: <?= $doc['contact'] ?></p>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include '../includes/footer.php'; ?>