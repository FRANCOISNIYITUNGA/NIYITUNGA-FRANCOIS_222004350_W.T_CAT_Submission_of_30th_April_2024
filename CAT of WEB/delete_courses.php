<?php
include('databaseconnection.php');

// Check if Product_Id is set
if(isset($_REQUEST['id'])) {
    $pid = $_REQUEST['id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM course WHERE id=?");
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
