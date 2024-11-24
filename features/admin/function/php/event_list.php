<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;
    $typeOfEvent = $_POST['type_of_event'];

    if ($action === 'add') {
        $query = "INSERT INTO event_list (type_of_event) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $typeOfEvent);
    } elseif ($action === 'edit' && $id) {
        $query = "UPDATE event_list SET type_of_event = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $typeOfEvent, $id);
    } elseif ($action === 'delete' && $id) {
        $query = "DELETE FROM event_list WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
    }

    if ($stmt->execute()) {
        header("Location: ../../web/events_list.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
