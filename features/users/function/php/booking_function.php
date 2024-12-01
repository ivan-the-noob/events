<?php
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo '<pre>';
    print_r($_POST); 
    echo '</pre>';

    $full_name = $_POST['full_name'];
    $celebrants_name = $_POST['celebrants_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $events_date = $_POST['events_date'];
    $guest_count = $_POST['guest_count'];
    $event_duration = $_POST['event_duration'];
    $event_starttime = $_POST['event_starttime'];
    $event_endtime = $_POST['event_endtime'];
    $event_type = $_POST['event_type'];
    $event_package = $_POST['event_package'];
    $cost = $_POST['cost'];

    $event_options = isset($_POST['event_options']) ? implode(", ", $_POST['event_options']) : 'None';  

    echo 'Event Options: ' . $event_options;

    $status = 'Pending';

    $sql = "INSERT INTO booking (full_name, celebrants_name, email, phone_number, events_date, guest_count, event_duration, event_starttime, event_endtime, event_type, event_package, event_options, cost, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssiisssssss", $full_name, $celebrants_name, $email, $phone_number, $events_date, $guest_count, $event_duration, $event_starttime, $event_endtime, $event_type, $event_package, $event_options, $cost, $status);

        if ($stmt->execute()) {
            header("Location: ../../web/appointment.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}
?>
