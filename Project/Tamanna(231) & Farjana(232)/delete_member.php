<?php
include("database.php");


if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Escape email to avoid SQL errors (basic protection)
    $email = $conn->real_escape_string($email);

    $sql = "DELETE FROM registration WHERE Email = '$email'";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_members.php");
        exit();
    } else {
        echo "Error deleting member: " . $conn->error;
    }
} else {
    echo "Email not provided.";
}
?>
