-<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        move_uploaded_file($imageTmpName, "../../../../assets/scope/" . $imageName); 
    } else {
        $imageName = null; 
    }

    $query = "INSERT INTO extras (image, title, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $imageName, $title, $description);

    if ($stmt->execute()) {
        header("Location: ../../web/extras.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
