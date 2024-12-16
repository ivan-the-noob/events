<?php
require '../../../../db.php'; // Database connection

$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));

// Query for today's data
$stmtToday = $conn->prepare("
    SELECT DAYNAME(created_at) AS day, SUM(payment_amount) AS total
    FROM booking
    WHERE DATE(created_at) = ? AND status = 'finished'
    GROUP BY DAYNAME(created_at)
    ORDER BY FIELD(DAYNAME(created_at), 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
");
$stmtToday->bind_param('s', $today);
$stmtToday->execute();
$resultToday = $stmtToday->get_result();
$todayData = $resultToday->fetch_all(MYSQLI_ASSOC);

// Query for yesterday's data
$stmtYesterday = $conn->prepare("
    SELECT DAYNAME(created_at) AS day, SUM(payment_amount) AS total
    FROM booking
    WHERE DATE(created_at) = ? AND status = 'finished'
    GROUP BY DAYNAME(created_at)
    ORDER BY FIELD(DAYNAME(created_at), 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
");
$stmtYesterday->bind_param('s', $yesterday);
$stmtYesterday->execute();
$resultYesterday = $stmtYesterday->get_result();
$yesterdayData = $resultYesterday->fetch_all(MYSQLI_ASSOC);

// Initialize arrays for chart data
$todayChartData = array_fill(0, 7, 0);
$yesterdayChartData = array_fill(0, 7, 0);
$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

// Fill today's data
foreach ($todayData as $row) {
    $dayIndex = array_search($row['day'], $daysOfWeek);
    if ($dayIndex !== false) {
        $todayChartData[$dayIndex] = (float) $row['total'];
    }
}

// Fill yesterday's data
foreach ($yesterdayData as $row) {
    $dayIndex = array_search($row['day'], $daysOfWeek);
    if ($dayIndex !== false) {
        $yesterdayChartData[$dayIndex] = (float) $row['total'];
    }
}

// Format response as `todayData|yesterdayData`
echo implode(',', $todayChartData) . '|' . implode(',', $yesterdayChartData);

// Close the database connection
$conn->close();
?>
