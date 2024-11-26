<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;
    $typeOfEvent = $_POST['event_type']; 
    $extra = $_POST['extra_name']; 
    $price = $_POST['price'];  

    if ($action === 'add') {
        $query = "INSERT INTO extra (type_of_event, extra_name, price) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssd", $typeOfEvent, $extra, $price); 
    } elseif ($action === 'edit' && $id) {
        $query = "UPDATE extra SET type_of_event = ?, extra_name = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdi", $typeOfEvent, $extra, $price, $id); 
    } elseif ($action === 'delete' && $id) {
        $query = "DELETE FROM extra WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
    }

    if ($stmt->execute()) {
        header("Location: ../../web/extra.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
