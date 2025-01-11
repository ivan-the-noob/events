<?php
require '../../../../db.php';

$sql = "SELECT DATE_FORMAT(date, '%Y-%m-%d') AS date FROM unavailable_days";
$result = $conn->query($sql);

$unavailable_days = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $unavailable_days[] = $row['date'];
    }
}

echo json_encode($unavailable_days);

$conn->close();
