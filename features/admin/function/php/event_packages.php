<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;
    $typeOfEvent = $_POST['type_of_event'] ?? null;
    $description = $_POST['description'] ?? null;
    $price = $_POST['price'] ?? null;

    try {
        if ($action === 'add') {
            $query = "INSERT INTO event_packages (type_of_event, description, price) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssd", $typeOfEvent, $description, $price);
        } elseif ($action === 'edit' && $id) {
            $query = "UPDATE event_packages SET type_of_event = ?, description = ?, price = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssdi", $typeOfEvent, $description, $price, $id);
        } elseif ($action === 'delete' && $id) {
            $query = "DELETE FROM event_packages WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
        } else {
            throw new Exception("Invalid action or missing data.");
        }

        if ($stmt->execute()) {
            header("Location: ../../web/package_list.php");
            exit();
        } else {
            throw new Exception("Database error: " . $stmt->error);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
