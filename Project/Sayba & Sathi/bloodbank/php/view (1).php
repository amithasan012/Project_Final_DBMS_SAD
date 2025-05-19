<?php

header('Content-Type: application/json; charset=utf-8');

$host = "localhost"; // Always localhost for cPanel hosting
$user = "googixxy_blood_donor"; // Your full MySQL username
$pass = "!odTH#[o0[;-"; // Your password
$db   = "googixxy_blood_db"; // Your database name

$con = mysqli_connect($host, $user, $pass, $db);


$sql = "SELECT * FROM login";
$result = mysqli_query($con, $sql);
$rowcount = mysqli_num_rows($result);

$data = array(); 

    foreach ($result as $item) {
       $name = $item['name'];
       $phone = $item['phone'];
       $bloodgroup = $item['bloodgroup'];
       $address = $item['address'];
       $gender = $item['gender'];
       
       $userInfo['name'] = $name;
        $userInfo['phone'] = $phone;
         $userInfo['bloodgroup'] = $bloodgroup;
          $userInfo['address'] = $address;
           $userInfo['gender'] = $gender;
           array_push($data,$userInfo);
       
    }

echo json_encode($data); // ✅ Added this line to return JSON response

?>

