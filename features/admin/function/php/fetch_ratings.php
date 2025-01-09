<?php
require '../../../../db.php';

$sql = "SELECT rating FROM reviews";
$result = $conn->query($sql);

$ratings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ratings[] = $row['rating'];
    }
}

$conn->close();

// Sending raw data as CSV
echo implode(',', $ratings); 
?>
