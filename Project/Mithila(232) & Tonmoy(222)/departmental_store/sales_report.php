<?php
include 'db.php';

$result = $conn->query("
    SELECT s.id, s.product_id, s.quantity, s.quantity_sold, s.total_price, s.sold_at, p.name AS product_name
    FROM sales s
    JOIN products p ON s.product_id = p.id
    ORDER BY s.sold_at DESC
");

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sales Report</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            min-height: 100vh;
            padding: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.4);
        }
        table {
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }
        thead th {
            position: sticky;
            top: 0;
            background: #4a148c;
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.05em;
            padding: 12px 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        tbody tr {
            cursor: pointer;
            transition: background-color 0.3s ease;
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }
        tbody tr:nth-child(even) {
            background: rgba(255,255,255,0.05);
        }
        tbody tr:hover {
            background-color: rgba(255,255,255,0.15);
        }
        tbody tr.show {
            opacity: 1;
        }
        td {
            padding: 14px 20px;
            text-align: center;
        }
        /* Fade in animation for rows */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <h1>Sales Report</h1>

    <div class="table-responsive">
        <table class="table table-borderless text-white align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Quantity Sold</th>
                    <th>Total Price (৳)</th>
                    <th>Sold At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $delay = 0;
                while ($row = $result->fetch_assoc()) {
                    // Animate rows one by one with delay
                    echo "<tr class='fade-in' style='animation-delay: {$delay}s'>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . ($row['quantity_sold'] ?? 'N/A') . "</td>";
                    echo "<td>৳ " . number_format($row['total_price'], 2) . "</td>";
                    echo "<td>" . date('d M Y, H:i', strtotime($row['sold_at'])) . "</td>";
                    echo "</tr>";
                    $delay += 0.1; // increase delay for each row (0.1s step)
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Optional Bootstrap JS for future interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Add 'show' class after page load to trigger fade-in animation
        window.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('tbody tr').forEach(tr => {
                setTimeout(() => {
                    tr.classList.add('show');
                }, 100);
            });
        });
    </script>
</body>
</html>
