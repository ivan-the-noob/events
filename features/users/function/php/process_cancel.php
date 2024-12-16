<?php
require '../../../../db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['id']; 
    $cancel_reason = $_POST['cancel_reason'];
    $gcash_name = $_POST['gcash_name'];
    $gcash_number = $_POST['gcash_number'];

    if (!empty($booking_id) && !empty($cancel_reason) && !empty($gcash_name) && !empty($gcash_number)) {
        $stmt = $conn->prepare("UPDATE booking SET cancel_reason = ?, gcash_name = ?, gcash_number = ?, status = 'Cancel' WHERE id = ?");
        $stmt->bind_param('sssi', $cancel_reason, $gcash_name, $gcash_number, $booking_id);

        if ($stmt->execute()) {
            header("Location: ../../web/appointment.php");
            exit;
        } else {
            echo "Error updating record.";
        }
    } else {
        echo "Missing information.";
    }
}

?>
