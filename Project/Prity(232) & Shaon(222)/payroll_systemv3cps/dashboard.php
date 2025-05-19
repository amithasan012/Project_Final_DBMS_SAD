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
    <title>Payroll System - Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .header { background-color: #4CAF50; color: white; padding: 15px; text-align: center; }
        .container { padding: 20px; }
        .menu { background-color: #333; overflow: hidden; }
        .menu a { float: left; display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; }
        .menu a:hover { background-color: #ddd; color: black; }
        .card { box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; width: 30%; margin: 10px; float: left; }
        .card:hover { box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2); }
        .card-container { padding: 2px 16px; }
        .clearfix::after { content: ""; clear: both; display: table; }
        .action-links a { 
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .action-links a:hover {
            background-color: #45a049;
        }
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
        <h2>Dashboard</h2>
        
        <div class="card">
            <div class="card-container">
                <h3><b>Employees</b></h3>
                <?php
                $sql = "SELECT COUNT(*) as total FROM employees";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo "<p>Total: " . $row['total'] . "</p>";
                ?>
                <div class="action-links">
                    <a href="employees.php">View All</a>
                    <a href="search_employee.php" style="margin-left:10px;">Search Employee</a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-container">
                <h3><b>Departments</b></h3>
                <?php
                $sql = "SELECT COUNT(*) as total FROM departments";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo "<p>Total: " . $row['total'] . "</p>";
                ?>
                <div class="action-links">
                    <a href="departments.php">View All</a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-container">
                <h3><b>Recent Payroll</b></h3>
                <?php
                $sql = "SELECT COUNT(*) as total FROM payroll";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo "<p>Total records: " . $row['total'] . "</p>";
                ?>
                <div class="action-links">
                    <a href="payroll.php">View All</a>
                </div>
            </div>
        </div>
        
        <div class="clearfix"></div>
    </div>
</body>
</html>