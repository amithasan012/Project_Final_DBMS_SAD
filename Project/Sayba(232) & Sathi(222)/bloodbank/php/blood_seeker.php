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
$sreason = $_GET['r'] ?? '';
$shospital = $_GET['h'] ?? '';
$sbloodgroup = $_GET['b'] ?? '';
$samount = $_GET['a'] ?? '';


$data = "INSERT INTO blood_seeker(name, phone, reason, hospital, blood_group,amount)
         VALUES('$sname', '$sphone', '$sreason', '$shospital', '$sbloodgroup','$samount')";

$result = mysqli_query($con, $data);

if ($result)
    echo "<br>Data inserted successfully.";
else
    echo "Query error: " . mysqli_error($con);
?>