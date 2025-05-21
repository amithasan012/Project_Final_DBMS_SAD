<?php
include("database.php");



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values and escape to prevent SQL injection
    $original_email = $conn->real_escape_string($_POST['original_email']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $goal = $conn->real_escape_string($_POST['goal']);
    $time = $conn->real_escape_string($_POST['time']);

    // Update the record where email = original_email
    $sql = "UPDATE registration SET 
                Name = '$name', 
                Email = '$email', 
                Phone = '$phone', 
                DOB = '$dob', 
                Goal = '$goal', 
                Time = '$time' 
            WHERE Email = '$original_email'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to view page after successful update
        header("Location: view_members.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
