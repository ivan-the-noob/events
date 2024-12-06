<?php
session_start();


if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];  

require '../../../../db.php'; 

$stmt = $conn->prepare("SELECT name FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $name = $user['name']; 
} else {
    echo "User not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];        
    $subject = $_POST['subject'];   
    $feedback = $_POST['feedback']; 
    $image = $_FILES['image'];       

    $imageName = '';
    if ($image['error'] == 0) {
        $imageName = '' . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imageName);
    }

    $stmt = $conn->prepare("INSERT INTO reviews (email, name, rating, subject, feedback, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $email, $name, $rating, $subject, $feedback, $imageName);

    if ($stmt->execute()) {
        header("Location: ../../web/user-dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
