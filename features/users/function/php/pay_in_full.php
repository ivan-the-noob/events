<?php
require '../../../../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $payment_amount = $_POST['payment_amount'];  // The amount to be added
    $reference_no = $_POST['reference_no'];
    $payment_image = '';  // Default image value

    // Get the current payment_amount from the database
    $query = "SELECT payment_amount FROM booking WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $current_payment_amount = $row['payment_amount'];
        $stmt->close();
    } else {
        die("Failed to retrieve current payment amount.");
    }

    // Add the second payment amount to the current payment amount
    $new_payment_amount = $current_payment_amount + $payment_amount;

    // Check if a payment image was uploaded
    if (isset($_FILES['payment_image']) && $_FILES['payment_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../../../assets/gcash-payments';
        $file_name = basename($_FILES['payment_image']['name']);
        $file_tmp = $_FILES['payment_image']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        
        // Create a unique filename to prevent overwriting
        $new_file_name = time() . '_' . $file_name;

        if (move_uploaded_file($file_tmp, $upload_dir . '/' . $new_file_name)) {
            $payment_image = $new_file_name;
        } else {
            die("Failed to upload payment image.");
        }
    }

    // Insert second payment details into the database
    $query = "UPDATE booking SET second_payment_amount = ?, second_reference_no = ?, second_payment_image = ?, payment_amount = ? WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('dssii', $payment_amount, $reference_no, $payment_image, $new_payment_amount, $id);

        if ($stmt->execute()) {
            $_SESSION['status_message'] = 'Second payment details successfully submitted!';
        } else {
            $_SESSION['status_message'] = 'Failed to submit second payment details. Error: ' . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
    header('Location: ../../web/appointment.php');
    exit;
}
?>
