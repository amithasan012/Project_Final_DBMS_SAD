<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connection.php';

$id = $_GET['id'];

$sql = "DELETE FROM employees WHERE emp_id=$id";

if ($conn->query($sql)) {
    header("Location: employees.php");
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>