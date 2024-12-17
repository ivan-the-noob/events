<?php
require '../../../../db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "DELETE FROM scope_services WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../../web/scope_service.php?message=Service deleted successfully");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
