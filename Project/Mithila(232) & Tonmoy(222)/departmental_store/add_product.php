<?php
session_start();
include 'db.php';

$error = '';
$success = '';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch categories for dropdown
$categories_result = $conn->query("SELECT * FROM categories ORDER BY name ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = trim($_POST['product_name']);
    $category_id = intval($_POST['category_id']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    if ($product_name == '' || $category_id == 0 || $price <= 0 || $quantity < 0) {
        $error = "Please fill all fields correctly.";
    } else {
        $insert = $conn->query("INSERT INTO products (name, category_id, price, quantity) VALUES ('$product_name', $category_id, $price, $quantity)");
        if ($insert) {
            $success = "Product added successfully!";
        } else {
            $error = "Database error: Could not add product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Product - Departmental Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-card {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
        }
        .form-card h2 {
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }
        .btn-primary {
            background: #667eea;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #5563c1;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 8px #667eea;
            border-color: #667eea;
        }
        .alert {
            font-weight: 500;
            text-align: center;
        }
        a.back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: white;
            text-decoration: underline;
            font-weight: 600;
            cursor: pointer;
        }
        a.back-link:hover {
            color: #c5c5c5;
        }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Add Product</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input
                type="text"
                class="form-control"
                id="product_name"
                name="product_name"
                placeholder="Enter product name"
                required
                autofocus
            />
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="" selected disabled>Select category</option>
                <?php while ($row = $categories_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price ($)</label>
            <input
                type="number"
                step="0.01"
                min="0"
                class="form-control"
                id="price"
                name="price"
                placeholder="Enter price"
                required
            />
        </div>

        <div class="mb-4">
            <label for="quantity" class="form-label">Quantity</label>
            <input
                type="number"
                min="0"
                class="form-control"
                id="quantity"
                name="quantity"
                placeholder="Enter quantity"
                required
            />
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Product</button>
    </form>

    <a href="index.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
