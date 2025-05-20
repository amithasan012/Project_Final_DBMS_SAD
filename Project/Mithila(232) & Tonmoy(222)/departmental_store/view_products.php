<?php
include 'db.php';

// Fetch products with quantity > 0
$result = $conn->query("SELECT p.id, p.name, p.quantity, p.price, c.name AS category_name 
                        FROM products p 
                        LEFT JOIN categories c ON p.category_id = c.id
                        WHERE p.quantity > 0
                        ORDER BY p.name ASC");

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Available Products</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Orbitron&family=Nunito&display=swap" rel="stylesheet" />

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
  body {
    background: linear-gradient(to right, #000000, #434343);
    font-family: 'Nunito', sans-serif;
    color: #fff;
    margin: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
  }

  .container {
    background: rgba(255, 255, 255, 0.06);
    backdrop-filter: blur(14px);
    border-radius: 20px;
    padding: 40px;
    max-width: 960px;
    width: 100%;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
  }

  h1 {
    font-family: 'Orbitron', sans-serif;
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 30px;
    color: #00ffd5;
    text-shadow: 0 0 8px #00ffd5;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    color: #fff;
  }

  thead {
    background: #00ffd5;
    color: #000;
  }

  thead th {
    padding: 15px 20px;
    font-weight: 700;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-align: center;
    border-right: 1px solid rgba(0,0,0,0.1);
    user-select: none;
  }

  thead th:last-child {
    border-right: none;
  }

  tbody tr {
    background: rgba(255, 255, 255, 0.1);
    transition: background-color 0.3s ease, transform 0.2s ease;
    cursor: default;
  }

  tbody tr:hover {
    background: #00ffd5;
    color: #000;
    transform: scale(1.03);
  }

  tbody td {
    padding: 15px 20px;
    text-align: center;
    font-weight: 600;
    font-size: 1rem;
    border-right: 1px solid rgba(255,255,255,0.2);
  }

  tbody td:last-child {
    border-right: none;
  }

  /* Responsive: convert table to cards */
  @media (max-width: 720px) {
    table, thead, tbody, th, td, tr {
      display: block;
      width: 100%;
    }
    thead tr {
      display: none;
    }
    tbody tr {
      background: rgba(255, 255, 255, 0.06);
      margin-bottom: 20px;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 8px 20px rgba(0, 255, 213, 0.3);
      transform: none !important;
    }
    tbody tr:hover {
      background: #00ffd5;
      color: #000;
    }
    tbody td {
      text-align: left;
      padding: 12px 15px;
      border: none;
      position: relative;
      font-size: 1rem;
      font-weight: 600;
    }
    tbody td::before {
      content: attr(data-label);
      position: absolute;
      left: 15px;
      top: 12px;
      font-weight: 700;
      color: #00ffd5;
      text-transform: uppercase;
      font-size: 0.9rem;
    }
  }
</style>

</head>
<body>

<div class="container animate__animated animate__fadeInUp">
  <h1>Available Products</h1>
  <table>
    <thead>
      <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Price (৳)</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $counter = 1;
      while ($row = $result->fetch_assoc()) : ?>
        <tr>
          <td data-label="S.No"><?= $counter ?></td>
          <td data-label="Name"><?= htmlspecialchars($row['name']) ?></td>
          <td data-label="Category"><?= htmlspecialchars($row['category_name'] ?? 'Uncategorized') ?></td>
          <td data-label="Quantity"><?= (int)$row['quantity'] ?></td>
          <td data-label="Price">৳ <?= number_format($row['price'], 2) ?></td>
        </tr>
      <?php 
      $counter++; 
      endwhile; 
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
