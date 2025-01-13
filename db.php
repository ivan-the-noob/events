<?php
    $servername = "localhost";
    $username = "u373116035_events";
    $password = "#Bakitako23";
    $dbname = "u373116035_events"; 

    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
?>
