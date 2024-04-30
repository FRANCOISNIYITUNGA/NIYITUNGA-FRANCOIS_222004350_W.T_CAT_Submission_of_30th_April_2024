<?php
// Connection details
include('databaseconnection.php');

// Initialize variables to avoid undefined variable warnings
$b = $c = $d = $e = $f = $g = '';

// Check if lecturer id is set
if (isset($_REQUEST['Id'])) {
    $accid = $_REQUEST['Id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM Lecturer WHERE Id = ?");
    $stmt->bind_param("i", $accid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['name'];
        $c = $row['contact'];
        $d = $row['date'];
        $e = $row['gender'];
        $f = $row['address'];
        $g = $row['courseId'];
    } else {
        echo "Lecturer not found.";
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

        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo isset($d) ? htmlspecialchars($d, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="gender">Gender:</label>
        <input type="text" name="gender" value="<?php echo isset($e) ? htmlspecialchars($e, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo isset($f) ? htmlspecialchars($f, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="courseId">Course ID:</label>
        <input type="text" name="courseId" value="<?php echo isset($g) ? htmlspecialchars($g, ENT_QUOTES) : ''; ?>" required>
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
    $date = htmlspecialchars($_POST['date'], ENT_QUOTES);
    $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES);
    $address = htmlspecialchars($_POST['address'], ENT_QUOTES);
    $courseId = htmlspecialchars($_POST['courseId'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE Lecturer SET name = ?, contact = ?, date = ?, gender = ?, address = ?, courseId = ? WHERE Id = ?");
    $stmt->bind_param("ssssssi", $name, $contact, $date, $gender, $address, $courseId, $accid);

    if ($stmt->execute()) {
        // Redirect to Lecturer.php on successful update
        header('Location: Lecturer.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update lecturer record. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>
