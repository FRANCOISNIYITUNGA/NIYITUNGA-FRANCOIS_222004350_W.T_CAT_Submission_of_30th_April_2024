<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>student Form</title>
</head>
<body bgcolor="ffffff">
    <h1>student Form</h1>
    <form method="post" action="student.php">

        <label for="Id"> ID:</label>
        <input type="number" id="Id" name="Id" required><br><br>

        <label for="Name">Name :</label>
        <input type="text" id="Name" name="Name" required><br><br>

        <label for="Contact"> Contact:</label>
        <input type="text" id="Contact" name="Contact" required><br><br>

        <label for="Date">Date :</label>
        <input type="date" id="Date" name="Date" required><br><br>

        <label for="Gender"> Gender:</label>
        <input type="text" id="Gender" name="Gender" required><br><br>

        <label for="Address">Address :</label>
        <input type="text" id="Address" name="Address" required><br><br>

        <label for="Password"> Password:</label>
        <input type="text" id="Password" name="Password" required><br><br>



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
        $Name = $_POST['Name'];
        $Contact = $_POST['Contact'];
        $Date = $_POST['Date'];
        $Gender = $_POST['Gender'];
        $Address = $_POST['Address'];
        $Password = $_POST['Password'];

        $sm = $connection->prepare("INSERT INTO student (Id, Name, Contact, Date, Gender, Address,Password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sm->bind_param("issssss", $Id, $Name, $Contact, $Date, $Gender, $Address, $Password);

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
            <th>Name </th>
            <th>Contact</th>
            <th>Date</th>
            <th>Gender</th>
            <th>Address</th>
            <th>password</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

        <?php
        // SQL query to fetch data from the student table
        $sql = "SELECT * FROM student";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                   <td>" . $row["Id"] . "</td>
                    <td>" . $row["Name"] . "</td>
                    <td>" . $row["Contact"] . "</td>
                    <td>" . $row["Date"] . "</td> 
                    <td>" . $row["Gender"] . "</td>
                    <td>" . $row["Address"] . "</td>
                    <td>" . $row["Password"] . "</td> 
                    <td><a style='padding:4px' href='delete_student.php?Id=" . $row["Id"] . "'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_student.php?Id=" . $row["Id"] . "'>Update</a></td> 
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
