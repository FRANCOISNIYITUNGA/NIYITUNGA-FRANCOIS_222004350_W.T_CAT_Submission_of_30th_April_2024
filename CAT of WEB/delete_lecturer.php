<?php
include('databaseconnection.php');

// Check if Product_Id is set
if(isset($_REQUEST['Id'])) {
    $pid = $_REQUEST['Id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM lecturer WHERE Id=?");
    $stmt->bind_param("i", $pid);
    if ($stmt->execute()) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting data: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Id is not set.";
}

$connection->close();
?>
