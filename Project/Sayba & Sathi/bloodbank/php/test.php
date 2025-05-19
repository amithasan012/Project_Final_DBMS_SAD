<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$con = mysqli_connect("localhost", "googixxy_blood_donor", "!odTH#[o0[;-", "googixxy_blood_db");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully!";
?>
