<?php

require '../../../../db.php';

$currentMonth = date('Y-m');
$lastMonth = date('Y-m', strtotime('-1 month'));

// Query for sales data for the current month
$stmtCurrentMonth = $conn->prepare("
    SELECT MONTH(created_at) AS month, SUM(payment_amount) AS total
    FROM booking
    WHERE DATE_FORMAT(created_at, '%Y-%m') = ? AND status = 'finished'
    GROUP BY MONTH(created_at)
");
$stmtCurrentMonth->bind_param('s', $currentMonth);
$stmtCurrentMonth->execute();
$resultCurrentMonth = $stmtCurrentMonth->get_result();
$currentMonthData = $resultCurrentMonth->fetch_all(MYSQLI_ASSOC);

// Query for sales data for the last month
$stmtLastMonth = $conn->prepare("
    SELECT MONTH(created_at) AS month, SUM(payment_amount) AS total
    FROM booking
    WHERE DATE_FORMAT(created_at, '%Y-%m') = ? AND status = 'finished'
    GROUP BY MONTH(created_at)
");
$stmtLastMonth->bind_param('s', $lastMonth);
$stmtLastMonth->execute();
$resultLastMonth = $stmtLastMonth->get_result();
$lastMonthData = $resultLastMonth->fetch_all(MYSQLI_ASSOC);

// Initialize arrays for chart data
$currentMonthChartData = array_fill(0, 12, 0);
$lastMonthChartData = array_fill(0, 12, 0);

// Fill current month's data
foreach ($currentMonthData as $row) {
    $currentMonthChartData[$row['month'] - 1] = (float) $row['total'];
}

// Fill last month's data
foreach ($lastMonthData as $row) {
    $lastMonthChartData[$row['month'] - 1] = (float) $row['total'];
}

// Format response as `currentMonthData|lastMonthData`
echo implode(',', $currentMonthChartData) . '|' . implode(',', $lastMonthChartData);

// Close the database connection
$conn->close();

?>