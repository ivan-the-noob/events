<?php

require '../../../../db.php';

// Check if the form is submitted
if (isset($_POST['update'])) {
    // Get the form data
    $id = htmlspecialchars($_POST['id']); // Fetch the 'id' passed from the form
    $additional_pax = isset($_POST['add_pax']) ? (int)$_POST['add_pax'] : 0;
    $corkage_fee = isset($_POST['corkage_fee']) ? 1 : 0; // If checkbox is checked, corkage_fee will be 1

    // Prepare an SQL statement to update the booking record
    $sql = "UPDATE booking SET add_pax = ?, corkage_fee = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the SQL statement
        $stmt->bind_param("iii", $additional_pax, $corkage_fee, $id);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to a confirmation page or back to the bookings page
            header("Location: ../view/booking_list.php?update_success=true");
            exit();
        } else {
            echo "Error: Could not update the booking details.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error: Could not prepare the SQL statement.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Error: Form was not submitted.";
}
?>
