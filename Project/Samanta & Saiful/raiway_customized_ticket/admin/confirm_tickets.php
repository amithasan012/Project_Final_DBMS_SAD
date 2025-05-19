<?php
include('../config/db.php');
include('../includes/header.php');

$result = $conn->query("SELECT bookings.id AS booking_id, users.username, tickets.train_name, bookings.status FROM bookings JOIN users ON bookings.user_id = users.id JOIN tickets ON bookings.ticket_id = tickets.id");

echo "<div class='container mt-4'><h2>Booking Requests</h2><table class='table'><tr><th>User</th><th>Train</th><th>Status</th><th>Action</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['username']}</td>
        <td>{$row['train_name']}</td>
        <td>{$row['status']}</td>
        <td><a href='confirm_tickets.php?confirm={$row['booking_id']}' class='btn btn-sm btn-success'>Confirm</a></td>
    </tr>";
}
echo "</table></div>";

if (isset($_GET['confirm'])) {
    $id = $_GET['confirm'];
    $conn->query("UPDATE bookings SET status = 'confirmed' WHERE id = $id");
    header("Location: confirm_tickets.php");
}
include('../includes/footer.php');