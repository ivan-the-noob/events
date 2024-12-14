<?php
// Database connection
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $verification_code = $_POST['verification_code'];
    $email = $_POST['email'];

    // Query to check the verification code in the database
    $sql = "SELECT verification_code FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($stored_code);
    $stmt->fetch();

    // Compare the codes
    if (trim($stored_code) === trim($verification_code)) {
        echo 'correct';  // Return plain text to signal success
    } else {
        echo 'incorrect';  // Return plain text to signal failure
    }

    $stmt->close();
}

$conn->close();
?>
