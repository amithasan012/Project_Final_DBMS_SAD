<?php
// Database connection config
$conn = new mysqli('localhost', 'root', '', 'railway');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>
