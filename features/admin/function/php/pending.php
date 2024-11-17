<?php
session_start();
require '../../../../db.php';

if (isset($_POST['action']) && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];
    
    if ($action == 'accept') {
        $status = 'Waiting';
        $_SESSION['status_message'] = 'Booking approved and set to Waiting!';
    } elseif ($action == 'decline') {
        $status = 'Declined';
        $_SESSION['status_message'] = 'Booking declined!';
    }
    
    $update_query = "UPDATE booking SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $status, $booking_id);
    $stmt->execute();
    $stmt->close();

    header('Location: ../../web/pending.php');
    exit;
}
?>
