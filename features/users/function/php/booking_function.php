<?php
require '../../../../db.php';
require '../../../../PHPMailer/src/PHPMailer.php'; 
require '../../../../PHPMailer/src/SMTP.php'; 
require '../../../../PHPMailer/src/Exception.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo '<pre>';
    print_r($_POST); 
    echo '</pre>';

    $full_name = $_POST['full_name'];
    $celebrants_name = $_POST['celebrants_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $events_date = $_POST['events_date'];
    $guest_count = $_POST['guest_count'];
    $event_duration = $_POST['event_duration'];
    $event_starttime = $_POST['event_starttime'];
    $event_endtime = $_POST['event_endtime'];
    $event_type = $_POST['event_type'];
    $event_package = $_POST['event_package'];
    $cost = $_POST['cost'];
    $theme = $_POST['theme'];

    // Get dish options with NULL if not set
    $beef_dish = isset($_POST['beef_dish']) ? $_POST['beef_dish'] : NULL;
    $pork_dish = isset($_POST['pork_dish']) ? $_POST['pork_dish'] : NULL;
    $chicken_dish = isset($_POST['chicken_dish']) ? $_POST['chicken_dish'] : NULL;
    $pasta_dish = isset($_POST['pasta_dish']) ? $_POST['pasta_dish'] : NULL;
    $dessert_dish = isset($_POST['dessert_dish']) ? $_POST['dessert_dish'] : NULL;
    $fish_dish = isset($_POST['fish_dish']) ? $_POST['fish_dish'] : NULL;
    $drinks_dish = isset($_POST['drinks_dish']) ? $_POST['drinks_dish'] : NULL;

    // Event options (Null if not selected)
    $event_options = isset($_POST['event_options']) ? implode(", ", $_POST['event_options']) : NULL;

    echo 'Event Options: ' . $event_options;

    $status = 'To-pay';

    // Prepare the SQL query
    $sql = "INSERT INTO booking (full_name, celebrants_name, email, phone_number, events_date, guest_count, event_duration, event_starttime, event_endtime, event_type, event_package, event_options, cost, theme, status, beef_dish, pork_dish, chicken_dish, pasta_dish, dessert_dish, fish_dish, drinks_dish) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters, ensuring NULL values are handled
        $stmt->bind_param("sssssiisssssssssssssss", 
            $full_name, 
            $celebrants_name, 
            $email, 
            $phone_number, 
            $events_date, 
            $guest_count, 
            $event_duration, 
            $event_starttime, 
            $event_endtime, 
            $event_type, 
            $event_package, 
            $event_options, 
            $cost, 
            $theme, 
            $status, 
            $beef_dish, 
            $pork_dish, 
            $chicken_dish, 
            $pasta_dish, 
            $dessert_dish, 
            $fish_dish, 
            $drinks_dish
        );

        if ($stmt->execute()) {
            // Send email notification
            sendEmailNotification($email, $events_date);
            header("Location: ../../web/history.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}

// Function to send email
function sendEmailNotification($email, $events_date) {
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
        $mail->Body    = "Hello!<br><br>You have a new booking scheduled for <strong>{$events_date}</strong>.<br>Thank you for trusting Amiels' MOM for your event.<br><br>Best regards,<br>Amiels MOM Events Team";

        $mail->send();
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
