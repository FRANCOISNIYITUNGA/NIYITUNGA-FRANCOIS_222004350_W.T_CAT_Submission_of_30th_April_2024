<?php
// Connection details
include('databaseconnection.php');

// Initialize variables to avoid undefined variable warnings
$b = $c = '';

// Check if course id is set
if (isset($_REQUEST['id'])) {
    $accid = $_REQUEST['id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM course WHERE id = ?");
    $stmt->bind_param("i", $accid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['name'];
        $c = $row['credit'];
    } else {
        echo "Course not found.";
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

        <label for="credit">Credit:</label>
        <input type="text" name="credit" value="<?php echo htmlspecialchars($c, ENT_QUOTES); ?>" required>
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
    $credit = htmlspecialchars($_POST['credit'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE course SET name = ?, credit = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $credit, $accid);

    if ($stmt->execute()) {
        // Redirect to course.php on successful update
        header('Location: course.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update course record. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>
