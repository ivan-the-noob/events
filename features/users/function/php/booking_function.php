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

    // Get dish options
    $beef_dish = isset($_POST['beef_dish']) ? $_POST['beef_dish'] : null;
    $pork_dish = isset($_POST['pork_dish']) ? $_POST['pork_dish'] : null;
    $chicken_dish = isset($_POST['chicken_dish']) ? $_POST['chicken_dish'] : null;
    $pasta_dish = isset($_POST['pasta_dish']) ? $_POST['pasta_dish'] : null;
    $dessert_dish = isset($_POST['dessert_dish']) ? $_POST['dessert_dish'] : null;
    $fish_dish = isset($_POST['fish_dish']) ? $_POST['fish_dish'] : null;
    $drinks_dish = isset($_POST['drinks_dish']) ? $_POST['drinks_dish'] : null;

    $event_options = isset($_POST['event_options']) ? implode(", ", $_POST['event_options']) : 'None';  

    echo 'Event Options: ' . $event_options;

    $status = 'Pending';

    // Prepare the SQL query
    $sql = "INSERT INTO booking (full_name, celebrants_name, email, phone_number, events_date, guest_count, event_duration, event_starttime, event_endtime, event_type, event_package, event_options, cost, status, beef_dish, pork_dish, chicken_dish, pasta_dish, dessert_dish, fish_dish, drinks_dish) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("sssssiissssssssssssss", $full_name, $celebrants_name, $email, $phone_number, $events_date, $guest_count, $event_duration, $event_starttime, $event_endtime, $event_type, $event_package, $event_options, $cost, $status, $beef_dish, $pork_dish, $chicken_dish, $pasta_dish, $dessert_dish, $fish_dish, $drinks_dish);

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
