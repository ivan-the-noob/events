<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_error = $_FILES['image']['error'];

    if ($image_error === 0) {
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; 

        if (in_array(strtolower($image_extension), $allowed_extensions)) {
            $new_image_name = uniqid('terms_', true) . '.' . $image_extension;

            $image_path = '../../../../assets/terms_condition/' . $new_image_name;

            if (move_uploaded_file($image_tmp, $image_path)) {
                $query = "UPDATE terms_condition SET image = ? WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("si", $new_image_name, $id);

                if ($stmt->execute()) {
                    header("Location: ../../web/terms_condition.php?message=Term updated successfully");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
            } else {
                echo "Error uploading the image.";
            }
        } else {
            echo "Invalid image file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        echo "Error with file upload.";
    }
}
?>
