<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Temporary hardcoded credentials (replace with database check later)
$valid_username = "admin";
$valid_password = "admin123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
        header("Location: index.php?error=".urlencode($error));
        exit;
    }
}
?>