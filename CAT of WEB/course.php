<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>courses Form</title>
</head>
<body bgcolor="ffffff">
    <h1>courses Form</h1>
    <form method="post" action="course.php">

        <label for="id">student ID:</label>
        <input type="number" id="id" name="id" required><br><br>

        <label for="name">student name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="credit">credit :</label>
        <input type="text" id="credit" name="credit" required><br><br>

        <input type="submit" name="add" value="Insert"><br><br>

        <a href="./home.html">Go Back to Home</a>

    </form>

    <?php
    include('databaseconnection.php');

    // Check if the form is submitted for insert
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Insert section
        $id = $_POST['id'];
        $name = $_POST['name'];
        $credit = $_POST['credit'];

        $sm = $connection->prepare("INSERT INTO course (id, name, credit) VALUES (?, ?, ?)");
        $sm->bind_param("iss", $id, $name, $credit);

        if ($sm->execute()) {
            echo "New record has been added successfully.<br><br>
                 <a href='home.html'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $sm->error;
        }

        $sm->close();
    } 
    ?>

    <h2>courses Data</h2>
    <table border="2">
        <tr>
            <th>ID</th>
            <th>name </th>
            <th>credit</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

        <?php
        // SQL query to fetch data from the student table
        $sql = "SELECT * FROM course";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["credit"] . "</td>
                    <td><a style='padding:4px' href='delete_courses.php?id=" . $row["id"] . "'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_courses.php?id=" . $row["id"] . "'>Update</a></td> 
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
