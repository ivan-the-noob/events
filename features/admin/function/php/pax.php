<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;
    $typeOfEvent = $_POST['event_type']; 
    $pax = $_POST['pax']; 
    $price = $_POST['price'];  

    if ($action === 'add') {
        $query = "INSERT INTO pax (type_of_event, pax, price) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssd", $typeOfEvent, $pax, $price); 
    } elseif ($action === 'edit' && $id) {
        $query = "UPDATE pax SET type_of_event = ?, pax = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdi", $typeOfEvent, $pax, $price, $id); 
    } elseif ($action === 'delete' && $id) {
        $query = "DELETE FROM pax WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
    }

    if ($stmt->execute()) {
        header("Location: ../../web/pax.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
