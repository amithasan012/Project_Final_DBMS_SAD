<?php
require_once'../config/db.php';
function get_all_doctors() {
    global $conn;
    return $conn->query("SELECT * FROM doctors");
}

function get_user_by_email($email) {
    global $conn;
    $email = $conn->real_escape_string($email);
    return $conn->query("SELECT * FROM users WHERE email = '$email'");
}

function create_appointment($user_id, $doctor_id, $date) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO appointments (user_id, doctor_id, appointment_date, status) VALUES (?, ?, ?, 'Pending')");
    $stmt->bind_param("iis", $user_id, $doctor_id, $date);
    return $stmt->execute();
}

function get_all_appointments() {
    global $conn;
    return $conn->query("SELECT a.*, d.name AS doctor_name, u.name AS user_name 
                         FROM appointments a 
                         JOIN users u ON a.user_id = u.id 
                         JOIN doctors d ON a.doctor_id = d.id");
}

function confirm_appointment($id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE appointments SET status = 'Confirmed' WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>