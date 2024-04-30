<?php
// Connection details
include('databaseconnection.php');

// Initialize variables to avoid undefined variable warnings
$b = $c = '';

// Check if class id is set
if (isset($_REQUEST['Id'])) {
    $accid = $_REQUEST['Id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM class WHERE Id = ?");
    $stmt->bind_param("i", $accid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['name'];
        $c = $row['courses'];
    } else {
        echo "Class not found.";
    }

    // Close statement
    $stmt->close();
}
?>

<html>
<body>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($b, ENT_QUOTES); ?>" required>
        <br><br>

        <label for="courses">Courses:</label>
        <input type="text" name="courses" value="<?php echo htmlspecialchars($c, ENT_QUOTES); ?>" required>
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
    $courses = htmlspecialchars($_POST['courses'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE class SET name = ?, courses = ? WHERE Id = ?");
    $stmt->bind_param("ssi", $name, $courses, $accid);

    if ($stmt->execute()) {
        // Redirect to class.php on successful update
        header('Location: class.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update class record. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>
