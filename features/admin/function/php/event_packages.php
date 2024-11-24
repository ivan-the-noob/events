<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;
    $packageName = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if ($action === 'add') {
        $query = "INSERT INTO event_packages (package_name, description, price) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssd", $packageName, $description, $price);
    } elseif ($action === 'edit' && $id) {
        $query = "UPDATE event_packages SET package_name = ?, description = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdi", $packageName, $description, $price, $id);
    } elseif ($action === 'delete' && $id) {
        $query = "DELETE FROM event_packages WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
    }

    if ($stmt->execute()) {
        header("Location: ../../web/packages.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
