<?php
require '../../../../db.php';

if (isset($_GET['date'])) {
    $selected_date = $_GET['date'];

    $sql = "SELECT event_starttime FROM booking WHERE events_date = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $selected_date);
        $stmt->execute();
        $result = $stmt->get_result();
        $bookedTimes = [];
        while ($row = $result->fetch_assoc()) {
            $bookedTimes[] = $row['event_starttime'];
        }

        $totalBookings = count($bookedTimes);

        echo json_encode([
            'bookings_count' => $totalBookings,
            'booked_times' => $bookedTimes,
        ]);
    } else {
        echo json_encode(['error' => 'Failed to prepare statement']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'No date provided']);
}
?>
