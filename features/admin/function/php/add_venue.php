<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venue = $_POST['venue'];

    $query = "INSERT INTO features (venue) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $venue);

    if ($stmt->execute()) {
        header("Location: ../../web/features.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
