<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOD Form</title>
</head>
<body bgcolor="ffffff">
    <h1>HOD Form</h1>
    <form method="post" action="hod.php">

        <label for="Id">HOD ID:</label>
        <input type="number" id="Id" name="Id" required><br><br>

        <label for="name"> name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="contact">contact :</label>
        <input type="text" id="contact" name="contact" required><br><br>

        <label for="address"> Address:</label>
        <input type="text" id="address" name="address" required><br><br>

        <input type="submit" name="add" value="Insert"><br><br>

        <a href="./home.html">Go Back to Home</a>

    </form>

    <?php
    include('databaseconnection.php');

    // Check if the form is submitted for insert
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Insert section
        $Id = $_POST['Id'];
        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];

        $sm = $connection->prepare("INSERT INTO hod (Id, name, contact, address) VALUES (?, ?, ?, ?)");
        $sm->bind_param("isss", $Id, $name, $contact, $address);

        if ($sm->execute()) {
            echo "New record has been added successfully.<br><br>
                 <a href='home.html'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $sm->error;
        }

        $sm->close();
    } 
    ?>

    <h2>hods Data</h2>
    <table border="2">
        <tr>
            <th>ID</th>
            <th>name </th>
            <th>contact</th>
            <th>address</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

        <?php
        // SQL query to fetch data from the student table
        $sql = "SELECT * FROM hod";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["Id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["contact"] . "</td>
                    <td>" . $row["address"] . "</td>
                    <td><a style='padding:4px' href='delete_hod.php?Id=" . $row["Id"] . "'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_hod.php?Id=" . $row["Id"] . "'>Update</a></td> 
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
