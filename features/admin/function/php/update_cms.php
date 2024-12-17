<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $system_name = $_POST['system_name'];
    $front_line = $_POST['front_line'];
    $welcome_message = $_POST['welcome_message'];

    if (isset($_FILES['bg_img']) && $_FILES['bg_img']['error'] == 0) {
        $imageTmpName = $_FILES['bg_img']['tmp_name'];
        $imageName = $_FILES['bg_img']['name'];
        $imagePath = $imageName; 

        move_uploaded_file($imageTmpName, '../../../../assets/' . $imageName);
    } else {
        $imagePath = $_POST['existing_bg_img'];
    }

    $query = "UPDATE cms SET system_name = ?, front_line = ?, welcome_message = ?, bg_img = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $system_name, $front_line, $welcome_message, $imagePath);

    if ($stmt->execute()) {
        header("Location: ../../web/cms.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
