<?php
include('databaseconnection.php');

// Initialize variables to avoid undefined variable warnings
$b = $c = $d = '';

// Check if hod id is set
if (isset($_REQUEST['Id'])) {
    $accid = $_REQUEST['Id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM hod WHERE Id = ?");
    $stmt->bind_param("i", $accid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['name'];
        $c = $row['contact'];
        $d = $row['address'];
    } else {
        echo "HOD not found.";
    }

    // Close statement
    $stmt->close();
}
?>

<html>
<body>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo isset($b) ? htmlspecialchars($b, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="contact">Contact:</label>
        <input type="text" name="contact" value="<?php echo isset($c) ? htmlspecialchars($c, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo isset($d) ? htmlspecialchars($d, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
// Handle form submission
if (isset($_POST['up'])) {
    // Retrieve updated values from the form
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
    $contact = htmlspecialchars($_POST['contact'], ENT_QUOTES);
    $address = htmlspecialchars($_POST['address'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE hod SET name = ?, contact = ?, address = ? WHERE Id = ?");
    $stmt->bind_param("sssi", $name, $contact, $address, $accid);

    if ($stmt->execute()) {
        // Redirect to hod.php on successful update
        header('Location: hod.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update HOD record. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>
