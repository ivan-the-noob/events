<?php
require '../../../../db.php';

$id = intval($_POST['id']);
$second_payment_amount = floatval($_POST['second_payment_amount']);

// First, retrieve the current payment_amount
$sql = "SELECT payment_amount FROM booking WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($current_payment_amount);
$stmt->fetch();
$stmt->close();

// Add the second_payment_amount to the current payment_amount
$new_payment_amount = $current_payment_amount + $second_payment_amount;

// Now, update both payment_amount and second_payment_amount
$sql = "UPDATE booking SET second_payment_amount = ?, payment_amount = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('dii', $second_payment_amount, $new_payment_amount, $id);

if ($stmt->execute()) {
    // Redirect to the approve page with a success message
    header("Location: ../../web/approve.php?message=Payment updated successfully");
    exit; 
} else {
    echo "Error updating payment: " . $stmt->error;
}
?>
