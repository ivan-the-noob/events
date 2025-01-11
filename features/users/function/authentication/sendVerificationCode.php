<?php
session_start();
require '../../../../db.php';
require '../../../../PHPMailer/src/PHPMailer.php';
require '../../../../PHPMailer/src/SMTP.php';
require '../../../../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Validate email format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Generate a random verification code
        $verificationCode = rand(1000, 9999);

        // Store the verification code in the database (update it for the user)
        $sql = "UPDATE users SET verification_code = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $verificationCode, $email);
        
        if ($stmt->execute()) {
            // Send email with the verification code
            $mail = new PHPMailer(true);

            try {
                // SMTP settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ejivancablanida@gmail.com'; 
                $mail->Password = 'acjf ngko qlfb cuju';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipient and sender details
                $mail->setFrom('your-email@gmail.com', 'Your App Name');
                $mail->addAddress($email);  // Recipient's email

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Your Verification Code';
                $mail->Body    = "Your verification code is: <b>$verificationCode</b>";

                // Send the email
                $mail->send();
                echo 'success';
            } catch (Exception $e) {
                error_log("Mailer Error: {$mail->ErrorInfo}"); 
                echo 'error';
            }
        } else {
            echo 'error'; // Failed to update verification code
        }
    } else {
        echo 'error'; // Invalid email format
    }
} else {
    echo 'error'; // Missing email parameter
}
?>
