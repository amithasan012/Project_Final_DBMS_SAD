<?php
// delete.php
include('config.php');

$phone = $_GET['phone'];

$sql = "DELETE FROM donors WHERE phone = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $phone);

if ($stmt->execute()) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>