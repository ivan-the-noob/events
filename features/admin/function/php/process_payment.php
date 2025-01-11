<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pay'])) {
        $id = intval($_POST['id']);
        $payment_method = $_POST['payment_method'];
        $add_payment = floatval($_POST['add_payment']);

        $query = "UPDATE booking 
                  SET payment_method = ?, 
                      add_payment = add_payment + ? 
                  WHERE id = ?";
        
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("sdi", $payment_method, $add_payment, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: ../../web/on-going.php?success=1");
                exit;
            } else {
                header("Location: ../../web/on-going.php?error=1");
                exit;
            }
            $stmt->close();
        } else {
            die('Query preparation failed: ' . $conn->error);
        }
    }
}
