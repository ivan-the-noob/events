<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../../../../db.php';
    session_start();

    $id = $_POST['id'];
    $reference_no = $_POST['reference_no'];
    $payment_amount = $_POST['payment_amount'];
    $payment_image = '';

    // Get the booking cost
    $query = "SELECT cost FROM booking WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cost = $row['cost'];
    $min_payment = $cost * 0.5;

    // Validate minimum payment
    if ($payment_amount < $min_payment) {
        $_SESSION['status_message'] = "Payment amount must be at least 50% of the cost (PHP " . number_format($min_payment, 2) . ").";
        header('Location: ../../web/appointment.php');
        exit;
    }

    // Upload payment image
    if (isset($_FILES['payment_image']) && $_FILES['payment_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../../../assets/gcash-payments';
        $file_name = basename($_FILES['payment_image']['name']);
        $file_tmp = $_FILES['payment_image']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        $new_file_name = $file_name;

        if (move_uploaded_file($file_tmp, $upload_dir . '/' . $new_file_name)) {
            $payment_image = $new_file_name;
        } else {
            die("Failed to upload payment image.");
        }
    }

    // Update booking with payment details
    $query = "UPDATE booking SET payment_image = ?, reference_no = ?, payment_amount = ?, status_paid = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssii', $payment_image, $reference_no, $payment_amount, $id);

    if ($stmt->execute()) {
        $_SESSION['status_message'] = 'Payment details successfully submitted! Status updated to Paid.';
    } else {
        $_SESSION['status_message'] = 'Failed to submit payment details. Error: ' . $stmt->error;
    }

    $stmt->close();
    header('Location: ../../web/appointment.php');
    exit;
}

?>
