<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = '../../../../assets/terms_condition/' . $image;

        if (move_uploaded_file($image_tmp, $image_folder)) {
            $query = "INSERT INTO terms_condition (image) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $image);
            if ($stmt->execute()) {
                header("Location: ../../web/terms_condition.php"); 
                exit();
            } else {
                echo "Error: " . $stmt->error; 
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "No image uploaded or there was an upload error.";
    }
}
?>
