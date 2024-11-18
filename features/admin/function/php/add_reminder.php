<?php

    require '../../../../db.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $description = $conn->real_escape_string($_POST['description']);
        $date = $conn->real_escape_string($_POST['date']);
        $start_time = $conn->real_escape_string($_POST['start_time']);
        $finish_time = $conn->real_escape_string($_POST['finish_time']);

        $sql = "INSERT INTO reminders (description, date, start_time, finish_time) 
                VALUES ('$description', '$date', '$start_time', '$finish_time')";

        if ($conn->query($sql) === TRUE) {
            header("Location: ../../web/dashboard.php"); 
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
?>