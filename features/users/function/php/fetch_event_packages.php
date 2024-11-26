<?php
require '../../../../db.php';

if (isset($_POST['event_type'])) {
    $eventType = $_POST['event_type'];

    $query = "SELECT description, price FROM event_packages WHERE type_of_event = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $eventType); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $response = [];
        while ($row = $result->fetch_assoc()) {

            $response[] = $row['description'] . "," . $row['price'];  
        }
        echo implode(';', $response);  
    } else {
        echo ''; 
    }
}
?>
