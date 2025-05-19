<?php
header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$user = "googixxy_blood_donor";
$pass = "!odTH#[o0[;-";
$db   = "googixxy_blood_db";

$con = mysqli_connect($host, $user, $pass, $db);

// Optional: Check if connection fails
if (!$con) {
    echo json_encode(["error" => "Database connection failed."]);
    exit();
}

$sql = "SELECT * FROM blood_seeker"; // Or your correct table
$result = mysqli_query($con, $sql);

$data = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $userInfo = array(
            "name"      => $row["name"] ?? "",
            "phone"     => $row["phone"] ?? "",
            "blood_group"=> $row["blood_group"] ?? "",
            "reason"    => $row["reason"] ?? "",
            "hospital"  => $row["hospital"] ?? "",
            "amount"    => $row["amount"] ?? ""
        );
        $data[] = $userInfo;
    }
}

echo json_encode($data);
?>
