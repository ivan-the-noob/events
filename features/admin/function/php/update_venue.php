<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $venue = $_POST['venue'];

    // Update the venue column
    $query = "UPDATE features SET venue = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $venue, $id);

    if ($stmt->execute()) {
        header("Location: ../../web/features.php?message=Venue updated successfully");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
