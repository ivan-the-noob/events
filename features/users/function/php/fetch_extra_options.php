<?php
require '../../../../db.php';

if (isset($_POST['type_of_event'])) {
    $eventType = $_POST['type_of_event'];

    $query = "SELECT extra_name, price FROM extra WHERE type_of_event = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $eventType); 
    $stmt->execute();
    $result = $stmt->get_result();

    $extraOptions = [];
    while ($row = $result->fetch_assoc()) {
        $extraOptions[] = $row['extra_name'] . ',' . $row['price']; 
    }

    if (!empty($extraOptions)) {
        echo implode(';', $extraOptions); 
    } else {
        echo ''; 
    }
} else {
    echo ''; 
}
?>
