<?php
require '../../../../db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Debugging: Output the form data
    echo '<pre>';
    print_r($_POST); // This will show the full array of data being submitted
    echo '</pre>';

    // Get data from the form
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

    // Handle event options (implode array into a comma-separated string)
    $event_options = isset($_POST['event_options']) ? implode(", ", $_POST['event_options']) : 'None';  // Default to 'None' if no options selected

    // Debugging: Output the value of event_options
    echo 'Event Options: ' . $event_options;

    // Prepare the SQL statement
    $sql = "INSERT INTO booking (full_name, celebrants_name, email, phone_number, events_date, guest_count, event_duration, event_starttime, event_endtime, event_type, event_package, event_options) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sssssiisssss", $full_name, $celebrants_name, $email, $phone_number, $events_date, $guest_count, $event_duration, $event_starttime, $event_endtime, $event_type, $event_package, $event_options);

        // Execute the query
        if ($stmt->execute()) {
            echo "Booking successfully created!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
