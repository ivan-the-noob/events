<?php
require '../../../../db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "SELECT image FROM terms_condition WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();

    if ($image) {
        $image_path = '../../../../assets/terms_condition/' . $image;

        if (file_exists($image_path)) {
            unlink($image_path); 
        }
    }

    $stmt->close();

    $query = "DELETE FROM terms_condition WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../../web/terms_condition.php?message=Term deleted successfully");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
