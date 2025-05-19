<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments - Payroll System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .header { background-color: #4CAF50; color: white; padding: 15px; text-align: center; }
        .container { padding: 20px; }
        .menu { background-color: #333; overflow: hidden; }
        .menu a { float: left; display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; }
        .menu a:hover { background-color: #ddd; color: black; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .add-btn { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; margin-bottom: 20px; }
        .add-btn:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Payroll Management System</h1>
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    </div>
    
    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="employees.php">Employees</a>
        <a href="payroll.php">Payroll</a>
        <a href="attendance.php">Attendance</a>
        <a href="departments.php">Departments</a>
        <a href="logout.php" style="float:right">Logout</a>
    </div>
    
    <div class="container">
        <h2>Department List</h2>
        <button class="add-btn" onclick="location.href='add_department.php'">Add Department</button>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Department Name</th>
                <th>Location</th>
                <th>Budget</th>
                <th>Max Staff</th>
                <th>Active Projects</th>
                <th>Actions</th>
            </tr>
            <?php
            $sql = "SELECT d.*, e.first_name, e.last_name 
                    FROM departments d
                    LEFT JOIN employees e ON d.manager_id = e.emp_id";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $manager_name = ($row['first_name']) ? $row['first_name']." ".$row['last_name'] : "Not assigned";
                    echo "<tr>
                        <td>".$row["dept_id"]."</td>
                        <td>".$row["dept_name"]."</td>
                        <td>".$row["location"]."</td>
                        <td>$".number_format($row["budget"], 2)."</td>
                        <td>".$row["max_staff"]."</td>
                        <td>".$row["active_projects"]."</td>
                        <td>
                            <a href='edit_department.php?id=".$row["dept_id"]."'>Edit</a> | 
                            <a href='delete_department.php?id=".$row["dept_id"]."' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No departments found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>