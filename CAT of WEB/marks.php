<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>marks Form</title>
</head>
<body bgcolor="ffffff">
    <h1>marks Form</h1>
    <form method="post" action="marks.php">

        <label for="Id"> ID:</label>
        <input type="number" id="Id" name="Id" required><br><br>

        <label for="courses">courses :</label>
        <input type="text" id="courses" name="courses" required><br><br>

        <label for="lecturers"> lecturers:</label>
        <input type="text" id="lecturers" name="lecturers" required><br><br>


        <input type="submit" name="add" value="Insert"><br><br>

        <a href="./home.html">Go Back to Home</a>

    </form>

    <?php
    include('databaseconnection.php');

    // Check if the form is submitted for insert
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Insert section
        $Id = $_POST['Id'];
        $courses = $_POST['courses'];
        $lecturers = $_POST['lecturers'];

        $sm = $connection->prepare("INSERT INTO marks (Id, courses, lecturers) VALUES (?, ?, ?)");
        $sm->bind_param("iss", $Id, $courses, $lecturers);

        if ($sm->execute()) {
            echo "New record has been added successfully.<br><br>
                 <a href='home.html'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $sm->error;
        }

        $sm->close();
    } 
    ?>

    <h2>marks Data</h2>
    <table border="2">
        <tr>
            <th>ID</th>
            <th>courses</th>
            <th>lecturers </th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

        <?php
        // SQL query to fetch data from the student table
        $sql = "SELECT * FROM marks";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["Id"] . "</td>
                    <td>" . $row["courses"] . "</td>
                    <td>" . $row["lecturers"] . "</td>
                    <td><a style='padding:4px' href='delete_marks.php?Id=" . $row["Id"] . "'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_marks.php?Id=" . $row["Id"] . "'>Update</a></td> 
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        // Close connection
        $connection->close();
        ?>
    </table>

    <footer>
        <center> 
            <b><h2>Designed by:francois </h2></b>
        </center>
    </footer>
</body>
</html>
