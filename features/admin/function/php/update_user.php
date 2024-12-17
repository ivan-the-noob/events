<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = null;
    }

    $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, password = COALESCE(?, password) WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $hashedPassword, $id);

    if ($stmt->execute()) {
        header("Location: ../../web/admin-user.php");
        exit();
    } else {
        echo "Error updating user.";
    }
}
?>
