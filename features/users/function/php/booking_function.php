<?php
require '../../../../db.php';
require '../../../../PHPMailer/src/PHPMailer.php'; 
require '../../../../PHPMailer/src/SMTP.php'; 
require '../../../../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = $_POST['full_name'];
    $celebrants_name = $_POST['celebrants_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $event_date = $_POST['events_date']; 
    $guest_count = $_POST['guest_count'];
    $event_duration = $_POST['event_duration'];
    $event_starttime = $_POST['event_starttime'];
    $event_endtime = $_POST['event_endtime'];
    $event_type = $_POST['event_type'];
    $event_package = $_POST['event_package'];
    $cost = $_POST['cost'];
    $theme = $_POST['theme'];

    $sql = "INSERT INTO booking (full_name, celebrants_name, email, phone_number, events_date, guest_count, event_duration, event_starttime, event_endtime, event_type, event_package, event_options) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssiisssss", $full_name, $celebrants_name, $email, $phone_number, $event_date, $guest_count, $event_duration, $event_starttime, $event_endtime, $event_type, $event_package, $event_options);

        if ($stmt->execute()) {
            sendEmailNotification($email, $event_date);
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}

function sendEmailNotification($email, $event_date) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'amielsmomeventsplace@gmail.com'; 
        $mail->Password = 'frfl cfpq ylav clic';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('amielsmomeventsplace@gmail.com', 'Amiels MOM Events');
        $mail->addAddress($email); 
        $mail->addAddress('amielsmomeventsplace@gmail.com');  
        $mail->isHTML(true);
        $mail->Subject = 'Booked Successfully! Thank you for trusting Amiels\' MOM';
        $mail->Body    = "Hello!<br><br>You have a new booking scheduled for <strong>{$event_date}</strong>.<br>Thank you for trusting Amiels' MOM for your event.<br><br>Best regards,<br>Amiels MOM Events Team";

        $mail->send();
        header('Location: ../../web/history.php');
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
