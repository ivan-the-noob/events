<?php
require '../../../../db.php'; // Database connection

$chartData = [];

// Calculate the start and end dates of the current month
$startOfMonth = date('Y-m-01');
$endOfMonth = date('Y-m-t');

// Fetch all booking records for the current month
$stmt = $conn->prepare("
    SELECT 
        created_at, 
        SUM(payment_amount) AS total
    FROM booking
    WHERE status = 'finished' AND DATE(created_at) BETWEEN ? AND ?
    GROUP BY DATE(created_at)
    ORDER BY created_at
");
$stmt->bind_param('ss', $startOfMonth, $endOfMonth);
$stmt->execute();
$result = $stmt->get_result();

// Initialize data for all weeks in the current month
$numberOfWeeks = ceil(date('t') / 7); // Total weeks in the month
for ($i = 1; $i <= $numberOfWeeks; $i++) {
    $chartData[$i] = 0; // Default all weeks to 0
}

// Process query results and group data by week
while ($row = $result->fetch_assoc()) {
    $createdDate = $row['created_at'];
    $dayOfMonth = (int)date('j', strtotime($createdDate)); // Get the day of the month
    $weekIndex = (int)(($dayOfMonth - 1) / 7) + 1; // Calculate week number (1-based)
    
    if (isset($chartData[$weekIndex])) {
        $chartData[$weekIndex] += (float)$row['total']; // Sum payments for the week
    }
}

// Output chart data as a comma-separated string
echo implode(',', array_values($chartData));

// Close the database connection
$conn->close();
?>
