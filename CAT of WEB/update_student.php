<?php
// Connection details
include('databaseconnection.php');

// Check if student id is set
if (isset($_REQUEST['Id'])) {
    $accid = $_REQUEST['Id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM student WHERE Id = ?");
    $stmt->bind_param("i", $accid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['Name'];
        $c = $row['Contact'];
        $d = $row['Date'];
        $e = $row['Gender'];
        $f = $row['Address'];
        $g = $row['Password'];
    } else {
        echo "Student not found.";
    }

    // Close statement
    $stmt->close();
}
?>

<html>
<body>
    <form method="POST">
        <label for="Name">Name:</label>
        <input type="text" name="Name" value="<?php echo isset($b) ? htmlspecialchars($b, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="Contact">Contact:</label>
        <input type="text" name="Contact" value="<?php echo isset($c) ? htmlspecialchars($c, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="Date">Date:</label>
        <input type="date" name="Date" value="<?php echo isset($d) ? htmlspecialchars($d, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="Gender">Gender:</label>
        <input type="text" name="Gender" value="<?php echo isset($e) ? htmlspecialchars($e, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="Address">Address:</label>
        <input type="text" name="Address" value="<?php echo isset($f) ? htmlspecialchars($f, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="Password">Password:</label>
        <input type="password" name="Password" value="<?php echo isset($g) ? htmlspecialchars($g, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
// Handle form submission
if (isset($_POST['up'])) {
    // Retrieve updated values from the form
    $Name = htmlspecialchars($_POST['Name'], ENT_QUOTES);
    $Contact = htmlspecialchars($_POST['Contact'], ENT_QUOTES);
    $Date = htmlspecialchars($_POST['Date'], ENT_QUOTES);
    $Gender = htmlspecialchars($_POST['Gender'], ENT_QUOTES);
    $Address = htmlspecialchars($_POST['Address'], ENT_QUOTES);
    $Password = htmlspecialchars($_POST['Password'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE student SET Name = ?, Contact = ?, Date = ?, Gender = ?, Address = ?, Password = ? WHERE Id = ?");
    $stmt->bind_param("ssssssi", $Name, $Contact, $Date, $Gender, $Address, $Password, $accid);

    if ($stmt->execute()) {
        // Redirect to student.php on successful update
        header('Location: student.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update student record. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>
