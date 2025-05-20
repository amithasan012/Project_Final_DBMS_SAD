<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin'])) header("Location: login.php");

$sales = $conn->query("SELECT s.id, p.name, s.quantity_sold, s.total_price, s.sale_date FROM sales s JOIN products p ON s.product_id = p.id ORDER BY s.sale_date DESC LIMIT 1");
$row = $sales->fetch_assoc();
?>
<h2>Invoice</h2>
<p>Product: <?= $row['name'] ?></p>
<p>Quantity: <?= $row['quantity_sold'] ?></p>
<p>Total: $<?= $row['total_price'] ?></p>
<p>Date: <?= $row['sale_date'] ?></p>
