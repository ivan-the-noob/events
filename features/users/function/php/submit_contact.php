<?php
require '../../../../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $sql = "INSERT INTO contact (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
       header('Location: ../../web/contact_us.php');
       exit();
    } else {
        echo "<script>alert('Error submitting your message. Please try again later.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
