<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $query = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $name, $email, $hashedPassword, $id);

    if ($stmt->execute()) {
        header("Location: ../../web/admin-user.php");
        exit();
    } else {
        echo "Error updating user.";
    }
}
?>
