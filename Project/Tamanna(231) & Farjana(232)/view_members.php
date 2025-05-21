<?php
include("database.php"); // this should define $conn

$sql = "SELECT * FROM registration";
$result = $conn->query($sql);

echo "<h2>Registered Members</h2>";
echo "<table border='1'>
<tr>

<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>DOB</th>
<th>Goal</th>
<th>Time</th>
<th>Action</th>
</tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        
        echo "<td>".$row['Name']."</td>";
        echo "<td>".$row['Email']."</td>";
        echo "<td>".$row['Phone']."</td>";
        echo "<td>".$row['DOB']."</td>";
        echo "<td>".$row['Goal']."</td>";
        echo "<td>".$row['Time']."</td>";
        echo "<td>                     
            <a href='edit_member.php?email={$row['Email']}'>Edit</a> | 
        <a href='delete_member.php?email={$row['Email']}' onclick='return confirm(\"Are you sure?\");'>Delete</a>       
        </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No members found</td></tr>";
}
echo "</table>";
?>
