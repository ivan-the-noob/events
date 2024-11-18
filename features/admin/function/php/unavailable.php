<?php

    require '../../../../db.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];
        $id = $_POST['id'] ?? null;
        $date = $_POST['date'];
        $reason = $_POST['reason'];

        if ($action === 'add') {
            $query = "INSERT INTO unavailable_days (date, reason) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $date, $reason);
        } elseif ($action === 'edit' && $id) {
            $query = "UPDATE unavailable_days SET date = ?, reason = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $date, $reason, $id);
        } elseif ($action === 'delete' && $id) {
            $query = "DELETE FROM unavailable_days WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
        }

        if ($stmt->execute()) {
            header("Location: ../../web/unavailable.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
?>
