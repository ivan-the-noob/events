<?php
session_start();
require '../../../db.php';
require '../../../PHPMailer/src/PHPMailer.php'; 
require '../../../PHPMailer/src/SMTP.php'; 
require '../../../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && !isset($_POST['verification_code'])) {
        $email = $_POST['email'];

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $_SESSION['error'] = "Email not found.";
            $showVerificationForm = false; 
        } else {
            $user = $result->fetch_assoc();
            $userId = $user['id'];

            $verification_code = rand(1000, 9999);

            $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));

            $stmt = $conn->prepare("UPDATE users SET recovery_code = ?, code_expires = ? WHERE id = ?");
            $stmt->bind_param("ssi", $verification_code, $expires, $userId);

            if ($stmt->execute()) {
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'amielsmomeventsplace@gmail.com'; 
                    $mail->Password = 'frfl cfpq ylav clic';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('amielsmomeventsplace@gmail.com', 'Amiels Mom');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Your recovery Code';
                    $mail->Body    = "Your recovery code is: <b>$verification_code</b>";

                    $mail->send();
                    $_SESSION['message'] = "Recovery code sent to your email.";
                    $showVerificationForm = true;
                    $_SESSION['email'] = $email;  
                } catch (Exception $e) {
                    error_log("Mailer Error: {$mail->ErrorInfo}");
                    $_SESSION['error'] = "Failed to send email. Try again later.";
                    $showVerificationForm = false;
                }
            } else {
                $_SESSION['error'] = "Failed to generate recovery code.";
                $showVerificationForm = false;
            }
        }
    }

    if (isset($_POST['verification_code'])) {
        $verification_code = $_POST['verification_code'];
        $email = $_SESSION['email'];
    
        $stmt = $conn->prepare("SELECT recovery_code, code_expires FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stored_code = $user['recovery_code'];
            $expires_at = $user['code_expires'];
    
            if ($verification_code == $stored_code && strtotime($expires_at) > time()) {
                $_SESSION['message'] = "Code verified successfully. You can now reset your password.";
                $showPasswordForm = true;  
                $showVerificationForm = false; 
            } else {
                $_SESSION['error'] = "Invalid or expired verification code.";
                $showPasswordForm = false;
                $showVerificationForm = true;  
            }
        } else {
            $_SESSION['error'] = "User not found.";
            $showPasswordForm = false;
            $showVerificationForm = true;
        }
    }

    if (isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_SESSION['email'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
    
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashed_password, $_SESSION['email']);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = "Password reset successfully.";
                unset($_SESSION['email']);  
                header('Location: login.php');
                exit();
            } else {
                $_SESSION['error'] = "Failed to reset password.";
            }
        } else {
            $_SESSION['error'] = "Passwords do not match.";
            $showPasswordForm = false; 
            $showVerificationForm = false;
            $showPasswordForm = true;
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amiel's MOM Event's Place</title>
    <link rel="icon" href="../../../assets/logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="row login-container">
                    <div class="col-md-5 login-left text-center">
                        <img src="../../../assets/logo.png" alt="Logo">
                    </div>
                    <div class="col-md-7 login-right">
                        <h6 class="mb-3 w-75">Forgot Password</h6>
                        <?php
                            if (isset($_SESSION['message'])) {
                                echo "<div class='btn btn-success d-flex justify-content-center mb-4'>";
                                echo "<p class='mb-4 text-center'>" . $_SESSION['message'] . "</p>";
                                echo "</div>";
                                unset($_SESSION['message']);
                            }
                            if (isset($_SESSION['error'])) {
                                echo "<div class='btn btn-danger d-flex justify-content-center mb-4'>";
                                echo "<p class='mb-4 text-center'>" . $_SESSION['error'] . "</p>";
                                echo "</div>";
                                unset($_SESSION['error']);
                            }
                        ?>
                            <form method="POST" action="">
                                <div class="mb-3" id="emailInput" <?php if (isset($showVerificationForm) && $showVerificationForm || isset($showPasswordForm) && $showPasswordForm) echo 'style="display:none;"'; ?>>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                </div>
                                <?php if (!isset($showVerificationForm) || !$showVerificationForm && !isset($showPasswordForm)): ?>
                                    <button type="submit" class="btn btn-primary w-100" id="recoverButton">Recover</button>
                                    <hr>
                                    <div class="d-flex justify-content-center mt-2">
                                        <a href="login.php">Log In</a>
                                    </div>
                                <?php endif; ?>
                            </form>

                            <?php if (isset($showVerificationForm) && $showVerificationForm): ?>
                                <form method="POST" action="">
                                    <div class="mb-3" id="verificationInput">
                                        <input type="text" id="verificationCode" name="verification_code" class="form-control" placeholder="Enter 4-digit code" maxlength="4" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100" id="verifyButton">Verify</button>
                                </form>
                            <?php endif; ?>

                            <?php if (isset($showPasswordForm) && $showPasswordForm): ?>
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                                </form>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

