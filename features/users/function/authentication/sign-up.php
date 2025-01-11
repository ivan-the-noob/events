<?php
session_start();
require '../../../../db.php';
require '../../../../PHPMailer/src/PHPMailer.php';
require '../../../../PHPMailer/src/SMTP.php';
require '../../../../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Check if password fields are empty
    if (empty($password) || empty($confirm_password)) {
        die("Password fields cannot be empty.");
    }

    // Hash the password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Check if email is already registered
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($existing_email);
    $stmt->fetch();
    $stmt->close();

    if ($existing_email) {
        die("Email is already registered.");
    }

    // Optional: Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Generate a random verification code
    $verification_code = rand(1000, 9999);

    // Insert new user data with default status 0
    $sql = "INSERT INTO users (first_name, last_name, address, contact_number, email, password, verification_code, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 0)"; // Default status set to 0

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $first_name, $last_name, $address, $contact_number, $email, $password_hashed, $verification_code);
    
    if ($stmt->execute()) {
        // Send email with the verification code
        $mail = new PHPMailer(true);

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ejivancablanida@gmail.com'; // Sender's email
            $mail->Password = 'acjf ngko qlfb cuju'; // Sender's email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipient details
            $mail->setFrom('amielseventsplace@gmail.com', 'Amiel Events Place');
            $mail->addAddress($email);  // Recipient's email

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your Verification Code';
            $mail->Body    = "Your verification code is: <b>$verification_code</b>";

            // Send the email
            $mail->send();
            echo 'success'; // Indicate the success of the process
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}"); 
            echo 'error'; // If there is an error with the email sending process
        }
    } else {
        echo 'error'; // Failed to insert user
    }
}
?>
