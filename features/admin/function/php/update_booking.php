<?php

require '../../../../db.php';

if (isset($_POST['update'])) {
    $id = htmlspecialchars($_POST['id']); 
    $additional_pax = isset($_POST['add_pax']) ? (int)$_POST['add_pax'] : 0;
    $corkage_fee = isset($_POST['corkage_fee']) ? 1 : 0; 
    $additional_extend = isset($_POST['add_extend']) ? (int)$_POST['add_extend'] : 0;

    $sql = "UPDATE booking SET add_pax = ?, corkage_fee = ?, add_extend = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iiii", $additional_pax, $corkage_fee, $additional_extend, $id);

        if ($stmt->execute()) {
            header("Location: ../../web/on-going.php?update_success=true");
            exit();
        } else {
            echo "Error: Could not update the booking details.";
        }

        $stmt->close();
    } else {
        echo "Error: Could not prepare the SQL statement.";
    }

    $conn->close();
} else {
    echo "Error: Form was not submitted.";
}
?>
