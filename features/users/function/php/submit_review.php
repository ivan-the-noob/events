<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];  

require '../../../../db.php'; 

$stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $name = $user['first_name'] . ' ' . $user['last_name']; 
} else {
    echo "User not found.";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];        
    $feedback = $_POST['feedback']; 

    $stmt = $conn->prepare("INSERT INTO reviews (email, name, rating, feedback) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $name, $rating, $feedback);

    if ($stmt->execute()) {
        $updateStmt = $conn->prepare("UPDATE booking SET review_status = 1 WHERE email = ? AND status = 'Finished'");
        $updateStmt->bind_param("s", $email);
        $updateStmt->execute();

        header("Location: ../../web/user-dashboar   d.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
