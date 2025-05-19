<?php
$host = "localhost"; // Always localhost for cPanel hosting
$user = "googixxy_blood_donor"; // Your full MySQL username
$pass = "!odTH#[o0[;-"; // Your password
$db   = "googixxy_blood_db"; // Your database name

$con = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_errno())
    echo "NOT connected: " . mysqli_connect_error();
else
    echo "Connected<br>";

$sname = $_GET['n'] ?? '';
$sphone = $_GET['p'] ?? '';
$sfeedback = $_GET['f'] ?? '';



$data = "INSERT INTO feedback_submit(name, phone,feedback)
         VALUES('$sname', '$sphone','$sfeedback')";

$result = mysqli_query($con, $data);

if ($result)
    echo "<br>Data inserted successfully.";
else
    echo "Query error: " . mysqli_error($con);
?>