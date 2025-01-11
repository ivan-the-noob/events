<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;
    $typeOfEvent = $_POST['type_of_event'] ?? null;
    $description = $_POST['description'] ?? null;
    $price = $_POST['price'] ?? null;
    $packageImage = null;


    if (isset($_FILES['package_image']) && $_FILES['package_image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../../../../assets/packages/"; 
        $fileName = time() . "_" . basename($_FILES['package_image']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['package_image']['tmp_name'], $targetFile)) {
            $packageImage = $fileName;
        } else {
            echo "Failed to upload image. Error code: " . $_FILES['package_image']['error'];
            exit();
        }
    }

    try {
        if ($action === 'add') {
            $query = "INSERT INTO event_packages (type_of_event, description, price, package_image) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssds", $typeOfEvent, $description, $price, $packageImage);
        } elseif ($action === 'edit' && $id) {
            if ($packageImage) {
                $query = "UPDATE event_packages SET type_of_event = ?, description = ?, price = ?, package_image = ? WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssdsi", $typeOfEvent, $description, $price, $packageImage, $id);
            } else {
                $query = "UPDATE event_packages SET type_of_event = ?, description = ?, price = ? WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssdi", $typeOfEvent, $description, $price, $id);
            }
        } elseif ($action === 'delete' && $id) {
            $query = "DELETE FROM event_packages WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
        } else {
            throw new Exception("Invalid action or missing data.");
        }

        if ($stmt->execute()) {
            header("Location: ../../web/package_list.php");
            exit();
        } else {
            throw new Exception("Database error: " . $stmt->error);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
