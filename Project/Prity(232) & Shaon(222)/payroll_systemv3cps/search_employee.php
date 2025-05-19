<?php
session_start();
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$db = new mysqli('localhost', 'root', '', 'payroll_db');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$employee = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])) {
    $id = $db->real_escape_string($_GET['id']);
    
    // Debug: Show what ID we're searching for
    echo "<!-- Searching for ID: $id -->";
    
    // Using prepared statement to prevent SQL injection
    $stmt = $db->prepare("SELECT * FROM employees WHERE emp_ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        $error = "No employee found with ID: " . htmlspecialchars($id);
    }
    $stmt->close();
}
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Employee</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .search-box { margin: 20px 0; padding: 15px; background: #f5f5f5; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .error { color: red; margin: 15px 0; }
        .success { color: green; }
        input[type="text"] { padding: 8px; width: 200px; }
        button { padding: 8px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search Employee</h1>
        
        <div class="search-box">
            <form method="GET" action="">
                <label for="emp_id">Enter Employee ID:</label>
                <input type="text" id="emp_id" name="id" required 
                       placeholder="e.g. 1, 2, 3..." 
                       value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($employee): ?>
            <div class="success">Employee Found!</div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Department</th>
                </tr>
                <tr>
                    <td><?= htmlspecialchars($employee['emp_ID']) ?></td>
                    <td><?= htmlspecialchars($employee['first_name']) . ' ' . htmlspecialchars($employee['last_name']) ?></td>
                    <td><?= htmlspecialchars($employee['email']) ?></td>
                    <td><?= htmlspecialchars($employee['position']) ?></td>
                    <td><?= htmlspecialchars($employee['department']) ?></td>
                    
                </tr>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>