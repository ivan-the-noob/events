<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imagePath = "../../../assets/scope/" . $imageName;

        move_uploaded_file($imageTmpName, $imagePath);

        $query = "UPDATE extras SET title = ?, description = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $title, $description, $imageName, $id);
    } else {
        // Update without changing the image
        $query = "UPDATE extras SET title = ?, description = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $title, $description, $id);
    }

    if ($stmt->execute()) {
        header("Location: ../../web/extras.php?message=Service updated successfully");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
