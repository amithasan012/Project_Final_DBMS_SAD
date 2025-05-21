<?php
include("database.php");

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Escape email to prevent SQL issues
    $email = $conn->real_escape_string($email);

    // Fetch the member from the database
    $sql = "SELECT * FROM registration WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // ✅ Now $row is defined

        // Show the form
        ?>
        <h2>Edit Member</h2>
        <form method="post" action="update_member.php">
            <input type="hidden" name="original_email" value="<?php echo $row['Email']; ?>">
            Name: <input type="text" name="name" value="<?php echo $row['Name']; ?>"><br>
            Email: <input type="text" name="email" value="<?php echo $row['Email']; ?>"><br>
            Phone: <input type="text" name="phone" value="<?php echo $row['Phone']; ?>"><br>
            DOB: <input type="date" name="dob" value="<?php echo $row['DOB']; ?>"><br>
            Goal: <input type="text" name="goal" value="<?php echo $row['Goal']; ?>"><br>
            Time: <input type="text" name="time" value="<?php echo $row['Time']; ?>"><br>
            <input type="submit" value="Update">
        </form>
        <?php
    } else {
        echo "Member not found.";
    }
} else {
    echo "Email not provided.";
}
?>
