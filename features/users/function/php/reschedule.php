<?php
require_once '../../../../db.php'; 
header('Content-Type: text/plain');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingId = $_POST['bookingId'] ?? '';
    $newDate = $_POST['newDate'] ?? '';

    $bookingId = filter_var($bookingId, FILTER_SANITIZE_NUMBER_INT);
    $newDate = filter_var($newDate, FILTER_SANITIZE_STRING);

    if ($bookingId && $newDate) {
        $query = "UPDATE booking SET events_date = ?, status = 'waiting' WHERE id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("si", $newDate, $bookingId);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo 'Booking rescheduled successfully';
                } else {
                    echo 'Booking not found or date unchanged';
                }
            } else {
                echo 'Error executing the query';
            }

            $stmt->close();
        } else {
            echo 'Error preparing the statement';
        }
    } else {
        echo 'Invalid booking ID or date';
    }
} else {
    echo 'Invalid request method';
}
?>
