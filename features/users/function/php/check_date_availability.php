<?php
require '../../../../db.php';

if (isset($_GET['date'])) {
    $selected_date = $_GET['date'];

    $sql = "SELECT COUNT(*) AS bookings FROM booking WHERE events_date = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $selected_date);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        echo json_encode(['bookings' => $data['bookings']]);
    } else {
        echo json_encode(['error' => 'Failed to prepare statement']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'No date provided']);
}
?>
