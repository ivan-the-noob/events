<?php
require '../../../../db.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = $_POST['id'];

    if ($action === 'delete') {
        $deleteQuery = "DELETE FROM reviews WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } elseif ($action === 'show' || $action === 'hide') {
        // Update status
        $status = ($action === 'show') ? 1 : 0;

        // Debugging: Check the status before running the update
        echo "Updating status for review ID $id to $status<br>";

        $updateQuery = "UPDATE reviews SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        
        if ($stmt === false) {
            // Debugging: Check if the statement preparation failed
            die('MySQL prepare failed: ' . $conn->error);
        }
        
        $stmt->bind_param("ii", $status, $id);
        
        if ($stmt->execute()) {
            echo "Status updated successfully.<br>";
        } else {
            // Debugging: Check if the execution failed
            die('Execute failed: ' . $stmt->error);
        }
    }
    header("Location: ../../web/reviews.php"); 
    exit();
}
?>