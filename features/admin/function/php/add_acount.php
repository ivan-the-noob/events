<?php

    require '../../../../db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password']; 

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $role = 'admin';

        $query = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role); 

        if ($stmt->execute()) {
            header("Location: ../../web/admin-user.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
?>
