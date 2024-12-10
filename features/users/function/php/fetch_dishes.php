<?php
require '../../../../db.php';  // Adjust path as needed

// Get category dynamically from POST request
$category = isset($_POST['category']) ? $_POST['category'] : '';

// Prepare SQL query to fetch dishes from the 'dishes' table based on selected category
$query = "SELECT dish_name FROM dishes WHERE category = '$category'";

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $dishes = [];
    while ($row = $result->fetch_assoc()) {
        $dishes[] = $row['dish_name'];
    }

    // Return the dishes as a semicolon-separated string
    echo implode(';', $dishes);
} else {
    echo '';  // If no dishes are found, return an empty string
}
?>
