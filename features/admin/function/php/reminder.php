<?php 
    $currentDate = date('Y-m-d'); 
    $twoDaysLater = date('Y-m-d', strtotime('+2 days')); 
    $query = "SELECT * FROM reminders WHERE date BETWEEN '$currentDate' AND '$twoDaysLater'";
    $result = $conn->query($query);
?>