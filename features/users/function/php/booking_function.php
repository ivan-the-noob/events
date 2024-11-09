<?php
    require '../../../../db.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $celebrants_name = $_POST['celebrants_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $event_date = $_POST['event_date'];
    $guest_count = $_POST['guest_count'];
    $event_duration = $_POST['event_duration'];
    $event_starttime = $_POST['event_starttime'];
    $event_endtime = $_POST['event_endtime'];
    $event_type = $_POST['event_type'];
    $event_package = $_POST['event_package'];
    $event_options = isset($_POST['event_options']) ? implode(", ", $_POST['event_options']) : '';

    $sql = "INSERT INTO booking (full_name, celebrants_name, email, phone_number, event_date, guest_count, event_duration, event_starttime, event_endtime, event_type, event_package, event_options) 
            VALUES ('$full_name', '$celebrants_name', '$email', '$phone_number', '$event_date', '$guest_count', '$event_duration', '$event_starttime', '$event_endtime', '$event_type', '$event_package', '$event_options')";

    if ($conn->query($sql) === TRUE) {
        echo "Booking successfully created!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
