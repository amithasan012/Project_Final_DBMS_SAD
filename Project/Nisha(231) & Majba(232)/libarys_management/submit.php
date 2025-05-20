<?php
$servername = "localhost";
$username = "root";
$password = ""; // Set your DB password
$dbname = "form_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$email = $_POST['email'];
$pass = $_POST['password'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $pass);

if ($stmt->execute()) {
  echo "New record created successfully.";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
