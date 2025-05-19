<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connection.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $position = $_POST['position'];
    $hire_date = $_POST['hire_date'];
    $salary = $_POST['salary'];
    $department = $_POST['department'];
    $status = $_POST['status'];
    
    $sql = "UPDATE employees SET 
            first_name='$first_name', 
            last_name='$last_name', 
            email='$email', 
            phone='$phone', 
            address='$address', 
            position='$position', 
            hire_date='$hire_date', 
            salary=$salary, 
            department='$department', 
            status='$status'
            WHERE emp_id=$id";
    
    if ($conn->query($sql)) {
        header("Location: employees.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Get current employee data
$sql = "SELECT * FROM employees WHERE emp_id=$id";
$result = $conn->query($sql);
$employee = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee - Payroll System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .header { background-color: #4CAF50; color: white; padding: 15px; text-align: center; }
        .container { padding: 20px; }
        .menu { background-color: #333; overflow: hidden; }
        .menu a { float: left; display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; }
        .menu a:hover { background-color: #ddd; color: black; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"], input[type="date"], input[type="number"], textarea, select {
            width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;
        }
        button { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .error { color: red; }
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
        <h2>Edit Employee</h2>
        
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="post" action="edit_employee.php?id=<?php echo $id; ?>">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $employee['first_name']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $employee['last_name']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $employee['email']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?php echo $employee['phone']; ?>">
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3"><?php echo $employee['address']; ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" id="position" name="position" value="<?php echo $employee['position']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="hire_date">Hire Date</label>
                <input type="date" id="hire_date" name="hire_date" value="<?php echo $employee['hire_date']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="salary">Salary</label>
                <input type="number" id="salary" name="salary" step="0.01" value="<?php echo $employee['salary']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="department">Department</label>
                <select id="department" name="department" required>
                    <option value="">Select Department</option>
                    <?php
                    $sql = "SELECT dept_name FROM departments";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                        $selected = ($row['dept_name'] == $employee['department']) ? 'selected' : '';
                        echo "<option value='".$row['dept_name']."' $selected>".$row['dept_name']."</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="Active" <?php echo ($employee['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?php echo ($employee['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            
            <button type="submit">Update Employee</button>
            <button type="button" onclick="location.href='employees.php'">Cancel</button>
        </form>
    </div>
</body>
</html>