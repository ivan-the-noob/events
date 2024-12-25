<?php
session_start();
require '../../../../db.php';
require '../../../../PHPMailer/src/PHPMailer.php';
require '../../../../PHPMailer/src/SMTP.php';
require '../../../../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['refund_status'], $_POST['id'], $_POST['refunded_amount'])) {
    $id = $_POST['id']; // Use `id` as the identifier
    $refund_status = $_POST['refund_status'];
    $refunded_amount = $_POST['refunded_amount'];

    // Validate refund amount
    if (!is_numeric($refunded_amount) || $refunded_amount < 0) {
        $_SESSION['status_message'] = 'Invalid refund amount.';
        header('Location: ../../web/pending.php');
        exit;
    }

    // Fetch user details for the email
    $query = "SELECT email, full_name FROM booking WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $_SESSION['status_message'] = 'Booking not found.';
        header('Location: ../../web/pending.php');
        exit;
    }

    $user_email = $user['email'];
    $user_name = $user['full_name'];

    // Update refund_status and refunded_amount
    $update_query = "UPDATE booking SET refund_status = ?, refunded_amount = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('sdi', $refund_status, $refunded_amount, $id);

    if ($stmt->execute()) {
        $_SESSION['status_message'] = 'Refund status updated successfully.';

        // Send email for refundable statuses
        if ($refund_status == 'full-refund' || $refund_status == 'half-refund') {
            $mail = new PHPMailer(true);
            $mail_message = "Dear $user_name, <br><br>Your booking refund request has been processed. ";
            $mail_message .= "You have been refunded: <strong>PHP " . number_format($refunded_amount, 2) . "</strong>.";

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ejivancablanida@gmail.com'; 
                $mail->Password = 'acjf ngko qlfb cuju';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('AmielsMOM@gmail.com', 'Amiels Mom Events');
                $mail->addAddress($user_email, $user_name);

                $mail->isHTML(true);
                $mail->Subject = 'Booking Refund Notification';
                $mail->Body = $mail_message;

                $mail->send();
            } catch (Exception $e) {
                error_log("Mailer Error: {$mail->ErrorInfo}"); 
            }
        }
    } else {
        $_SESSION['status_message'] = 'Failed to update refund status.';
    }

    $stmt->close();
    $conn->close();

    header('Location: ../../web/pending.php');
    exit;
} else {
    $_SESSION['status_message'] = 'Invalid request.';
    header('Location: ../../web/pending.php');
    exit;
}
