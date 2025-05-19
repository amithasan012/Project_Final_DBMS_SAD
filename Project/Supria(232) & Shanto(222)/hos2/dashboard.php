<?php
session_start();

if (!isset($_SESSION['user'])) {
  header('Location: index.php');
  exit();
}

if ($_SESSION['role'] === 'admin') {
  header('Location: admin/appointments.php');
} else {
  header('Location: user/appointments.php');
}
exit();