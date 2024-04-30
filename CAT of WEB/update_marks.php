<?php
// Connection details
include('databaseconnection.php');

// Check if class id is set
if (isset($_REQUEST['Id'])) {
    $accid = $_REQUEST['Id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM marks WHERE Id = ?");
    $stmt->bind_param("i", $accid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['courses'];
        $c = $row['lecturers'];
    } else {
        echo "Record not found.";
    }

    // Close statement
    $stmt->close();
}
?>

<html>
<body>
    <form method="POST">
        <label for="courses">Courses:</label>
        <input type="text" name="courses" value="<?php echo isset($b) ? htmlspecialchars($b, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="lecturers">Lecturers:</label>
        <input type="text" name="lecturers" value="<?php echo isset($c) ? htmlspecialchars($c, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
// Handle form submission
if (isset($_POST['up'])) {
    // Retrieve updated values from the form
    $courses = htmlspecialchars($_POST['courses'], ENT_QUOTES);
    $lecturers = htmlspecialchars($_POST['lecturers'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE marks SET courses = ?, lecturers = ? WHERE Id = ?");
    $stmt->bind_param("ssi", $courses, $lecturers, $accid);

    if ($stmt->execute()) {
        // Redirect to marks.php on successful update
        header('Location: marks.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update marks record. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>
