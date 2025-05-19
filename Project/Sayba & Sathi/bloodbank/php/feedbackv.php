<?php

header('Content-Type: application/json; charset=utf-8');

$host = "localhost"; // Always localhost for cPanel hosting
$user = "googixxy_blood_donor"; // Your full MySQL username
$pass = "!odTH#[o0[;-"; // Your password
$db   = "googixxy_blood_db"; // Your database name

$con = mysqli_connect($host, $user, $pass, $db);


$sql = "SELECT * FROM feedback_submit";
$result = mysqli_query($con, $sql);
$rowcount = mysqli_num_rows($result);

$data = array(); 

    foreach ($result as $item) {
       $name = $item['name'];
       $phone = $item['phone'];
       $feedback = $item['feedback'];
      
       
       $userInfo['name'] = $name;
        $userInfo['phone'] = $phone;
         $userInfo['feedback'] = $feedback;
          
           array_push($data,$userInfo);
       
    }

echo json_encode($data); // ✅ Added this line to return JSON response

?>

