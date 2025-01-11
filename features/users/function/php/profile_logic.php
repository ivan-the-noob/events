<?php
session_start();


// Initialize variables
$passwordError = ''; // Ensure this is initialized to prevent warnings

require '../../../../db.php';

// Fetch user data
$email = $_SESSION['email'];
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (isset($_POST['update_profile'])) {
    $image = $_FILES['image_profile']['name'];
    $imageTmp = $_FILES['image_profile']['tmp_name'];

    if ($image) {
        $targetDir = "../../../../assets/profile/"; // Corrected path relative to htdocs
        $imagePath = basename($image); 

        $targetFilePath = $targetDir . $imagePath;

        if (move_uploaded_file($imageTmp, $targetFilePath)) {
            $updateQuery = "UPDATE users SET image_profile = ? WHERE email = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('ss', $imagePath, $email);
            $updateStmt->execute();

            header('Location: ../../web/profile.php');
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

if (isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (password_verify($currentPassword, $user['password'])) {
        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordQuery = "UPDATE users SET password = ? WHERE email = ?";
            $updatePasswordStmt = $conn->prepare($updatePasswordQuery);
            $updatePasswordStmt->bind_param('ss', $hashedPassword, $email);
            $updatePasswordStmt->execute();

            header('Location: ../../web/profile.php');
            exit();
        } else {
            $passwordError = 'New password and confirm password do not match.';
        }
    } else {
        $passwordError = 'Current password is incorrect.';
    }
}

$stmt->close();
$conn->close();
?>
