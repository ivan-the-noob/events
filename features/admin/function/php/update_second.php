<?php
require '../../../../db.php';

// Get form data
$id = intval($_POST['id']);
$second_payment_amount = floatval($_POST['second_payment_amount']);  // Ensure this is a valid float

// First, retrieve the current payment_amount and second_payment_amount
$sql = "SELECT payment_amount, second_payment_amount FROM booking WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($current_payment_amount, $current_second_payment_amount);

// Check if the booking exists
if (!$stmt->fetch()) {
    echo "Error: No booking found with the given ID.";
    exit;
}

$stmt->close();

// If second_payment_amount is NULL, set it to 0
if ($current_second_payment_amount === NULL) {
    $current_second_payment_amount = 0;
}

// Add the second_payment_amount to the current payment_amount
$new_payment_amount = $current_payment_amount + $second_payment_amount;

// Now, update both payment_amount and second_payment_amount
$sql = "UPDATE booking SET second_payment_amount = ?, payment_amount = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

// Ensure we're binding parameters correctly
$stmt->bind_param('iii', $second_payment_amount, $new_payment_amount, $id);

if ($stmt->execute()) {
    echo "success";  // This indicates success
} else {
    echo "Error: " . $stmt->error;  // Output the actual error message
}
?>
