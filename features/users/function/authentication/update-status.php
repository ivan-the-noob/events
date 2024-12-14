<?php
session_start();

require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $query = "UPDATE users SET status = 1 WHERE email = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('s', $email);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header("Location: ../../web/login.php?message=Sign up success! Please log in.");
                exit();
            } else {
                echo 'error'; 
            }
        } else {
            echo 'error'; 
        }

        $stmt->close();
    } else {
        echo 'error'; 
    }
}

$conn->close();

?>
