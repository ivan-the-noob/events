<?php
require '../../../../db.php';

if (isset($_POST['type_of_event'])) {
    $eventType = $_POST['type_of_event'];

    $query = "SELECT pax, price FROM pax WHERE type_of_event = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $eventType);  
    $stmt->execute();
    $result = $stmt->get_result();

    $paxOptions = [];
    while ($row = $result->fetch_assoc()) {
        $paxOptions[] = $row['pax'] . ',' . $row['price']; 
    }

    if (!empty($paxOptions)) {
        echo implode(';', $paxOptions); 
    } else {
        echo ''; 
    }
} else {
    echo ''; 
}
?>
