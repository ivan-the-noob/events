<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../../../../db.php';
    session_start();

    $id = $_POST['id'];
    $reference_no = $_POST['reference_no'];
    $payment_image = '';
    $status_paid = 1; 

    $email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Email not set';

    echo "<script>console.log('ID: " . $id . "');</script>";
    echo "<script>console.log('Email: " . $email . "');</script>";

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

    $query = "UPDATE booking SET payment_image = ?, reference_no = ?, status_paid = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssii', $payment_image, $reference_no, $status_paid, $id);

    if ($stmt->execute()) {
        $_SESSION['status_message'] = 'Payment details successfully submitted, and status updated to Paid!';
    } else {
        $_SESSION['status_message'] = 'Failed to submit payment details. Error: ' . $stmt->error;
    }

    $stmt->close();
    header('Location: ../../web/appointment.php');
    exit;
}
?>
