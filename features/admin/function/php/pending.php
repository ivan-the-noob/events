<?php
session_start();
require '../../../../db.php';
require '../../../../PHPMailer/src/PHPMailer.php';
require '../../../../PHPMailer/src/SMTP.php';
require '../../../../PHPMailer/src/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['action']) && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];

    $query = "SELECT email, full_name FROM booking WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $booking_id);
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

    if ($action == 'accept') {
        $status = 'Waiting';
        $_SESSION['status_message'] = 'Booking approved and set to Waiting!';
        $mail_message = "Dear $user_name, <br><br>Your booking has been approved! We look forward to serving you on your event day.";
    } elseif ($action == 'decline') {
        $status = 'Declined';
        $_SESSION['status_message'] = 'Booking declined!';
        $mail_message = "Dear $user_name, <br><br>We regret to inform you that your booking has been declined.";
    }

    $update_query = "UPDATE booking SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $status, $booking_id);
    $stmt->execute();
    $stmt->close();

    if ($action == 'accept') {
        $mail = new PHPMailer(true);

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
            $mail->Subject = 'Booking Approval Notification';
            $mail->Body = $mail_message;

            $mail->send();
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}"); 
        }
    }

    header('Location: ../../web/pending.php');
    exit;
}
?>
