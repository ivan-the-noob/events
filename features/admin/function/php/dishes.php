<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;
    $category = $_POST['category'];
    $dishName = $_POST['dish_name'];

    if ($action === 'add') {
        $query = "INSERT INTO dishes (category, dish_name) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $category, $dishName);
    } elseif ($action === 'edit' && $id) {
        $query = "UPDATE dishes SET category = ?, dish_name = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $category, $dishName, $id);
    } elseif ($action === 'delete' && $id) {
        $query = "DELETE FROM dishes WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
    }

    if ($stmt->execute()) {
        header("Location: ../../web/dish.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
