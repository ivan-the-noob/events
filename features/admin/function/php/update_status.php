<?php
    require '../../../../db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        error_log("POST Data: " . print_r($_POST, true));

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $status = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : '';

        if (!in_array($status, ['Waiting', 'On-going', 'Finished'])) {
            echo "Invalid status value.";
            exit;
        }

        $stmt = $conn->prepare("UPDATE booking SET status = ? WHERE id = ?");
        if ($stmt === false) {
            echo "Error preparing the statement: " . $conn->error;
            exit;
        }

        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Error updating status: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
?>
