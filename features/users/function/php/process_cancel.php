<?php
require '../../../../db.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['id']; 
    $cancel_reason = $_POST['cancel_reason'];

    if (!empty($booking_id) && !empty($cancel_reason)) {
        $stmt = $conn->prepare("UPDATE booking SET cancel_reason = ?, status = 'Cancel' WHERE id = ?");
        $stmt->bind_param('si', $cancel_reason, $booking_id);

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
