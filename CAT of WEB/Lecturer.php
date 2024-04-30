<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lecturer Form</title>
</head>
<body bgcolor="#ffffff">
    <h1>Lecturer Form</h1>
    <form method="post" action="lecturer.php">

        <label for="Id">ID:</label>
        <input type="number" id="Id" name="Id" required><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" required><br><br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="gender">Gender:</label>
        <input type="text" id="gender" name="gender" required><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="courseId">Course ID:</label>
        <input type="text" id="courseId" name="courseId" required><br><br>

        <input type="submit" name="add" value="Insert"><br><br>

        <a href="./home.html">Go Back to Home</a>

    </form>

    <?php
    // Connection details
    include('databaseconnection.php');

    // Check if the form is submitted for insert
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Insert section
        $Id = $_POST['Id'];
        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $date = $_POST['date'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $courseId = $_POST['courseId'];

        $stmt = $connection->prepare("INSERT INTO lecturer (Id, name, contact, date, gender, address, courseId) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $Id, $name, $contact, $date, $gender, $address, $courseId);

        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br>
                 <a href='home.html'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    } 
    ?>

    <h2>Lecturer Data</h2>
    <table border="2">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Date</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Course ID</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

        <?php
        // SQL query to fetch data from the lecturer table
        $sql = "SELECT * FROM lecturer";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["Id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["contact"] . "</td>
                    <td>" . $row["date"] . "</td> 
                    <td>" . $row["gender"] . "</td>
                    <td>" . $row["address"] . "</td>
                    <td>" . $row["courseId"] . "</td> 
                    <td><a style='padding:4px' href='delete_lecturer.php?Id=" . $row["Id"] . "'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_lecturer.php?Id=" . $row["Id"] . "'>Update</a></td> 
                </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No data found</td></tr>";
        }
        // Close connection
        $connection->close();
        ?>
    </table>

    <footer>
        <center> 
            <b><h2>Designed by: Francois</h2></b>
        </center>
    </footer>
</body>
</html>
