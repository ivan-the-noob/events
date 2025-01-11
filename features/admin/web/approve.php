<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../users/web/login.php');
    exit();
}

require '../../../db.php';

// Retrieve search, month, and year from GET parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$month = isset($_GET['month']) ? intval($_GET['month']) : null;
$year = isset($_GET['year']) ? intval($_GET['year']) : null;

$results_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$start_from = ($page - 1) * $results_per_page; 

$search_term = "%" . $search . "%";

$total_query = "SELECT COUNT(*) FROM booking WHERE status IN ('Waiting', 'On-going','resched','Update-payment') 
    AND (
        full_name LIKE ? OR 
        celebrants_name LIKE ? OR 
        email LIKE ? OR 
        phone_number LIKE ? OR
        events_date LIKE ? OR
        guest_count LIKE ? OR
        event_starttime LIKE ? OR
        event_type LIKE ? OR
        event_package LIKE ? OR
        event_options LIKE ? OR
        reference_no LIKE ?
    )";

if ($month && $year) {
    $total_query .= " AND MONTH(events_date) = $month AND YEAR(events_date) = $year";
}

$stmt = $conn->prepare($total_query);
$stmt->bind_param("sssssssssss", $search_term, $search_term, $search_term, $search_term, $search_term, $search_term, $search_term, $search_term, $search_term, $search_term, $search_term);
$stmt->execute();
$total_result = $stmt->get_result();
$total_row = $total_result->fetch_row();
$total_bookings = $total_row[0];
$total_pages = ceil($total_bookings / $results_per_page);

$query = "SELECT * FROM booking WHERE status IN ('Waiting', 'On-going','resched','Update-payment') 
    AND (
        full_name LIKE ? OR 
        celebrants_name LIKE ? OR 
        email LIKE ? OR 
        phone_number LIKE ? OR
        events_date LIKE ? OR
        guest_count LIKE ? OR
        event_starttime LIKE ? OR
        event_type LIKE ? OR
        event_package LIKE ? OR
        event_options LIKE ? OR
        reference_no LIKE ?
    )";

if ($month && $year) {
    $query .= " AND MONTH(events_date) = $month AND YEAR(events_date) = $year";
}

$query .= " LIMIT ?, ?";

$stmt = $conn->prepare($query);
$stmt->bind_param(
    "ssssssssssiii", 
    $search_term, 
    $search_term, 
    $search_term, 
    $search_term, 
    $search_term, 
    $search_term, 
    $search_term, 
    $search_term, 
    $search_term, 
    $search_term, 
    $search_term, 
    $start_from, 
    $results_per_page
);
$stmt->execute();
$result = $stmt->get_result();

    
function formatTime($hour) {
    if ($hour == 0) {
        return '12:00 AM';
    } elseif ($hour < 12) {
        return $hour . ':00 AM';
    } elseif ($hour == 12) {
        return '12:00 PM';
    } else {
        return ($hour - 12) . ':00 PM';
    }
}




?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amiel's MOM Event's Place</title>
<link rel="icon" href="../../../assets/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">

</head>




<body>
   
<div class="">   
        <div class="navbar flex-column shadow-sm p-3 collapse show" id="navbar">
            <div class="navbar-header d-flex justify-content-between align-items-center w-100">
                <a class="navbar-brand d-none d-md-block logo-container" href="#">
                    <img src="../../../assets/logo.png" alt="Logo">
                </a>
            </div>
            <div class="navbar-links">
                <a href="dashboard.php">
                    <i class="fa-solid fa-gauge-high"></i>
                    <span>Dashboard</span>
                </a>
                <a href="calendar.php">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Calendar</span>
                </a>
                <a href="pending.php">
                    <i class="fa-solid fa-clock"></i>
                    <span>Pending Booking</span>
                </a>
                <a href="approve.php" class="navbar-highlight">
                   <i class="fas fa-clipboard-check"></i>
                    <span>Approved Booking</span>
                </a>
                <a href="upcoming.php">
                    <i class="fa-solid fa-calendar-day"></i>
                    <span>Upcoming Booking</span>
                </a>
                <a href="on-going.php">
                    <i class="fa-solid fa-spinner"></i>
                    <span>On-going Booking</span>
                </a>
                <a href="refund.php">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <span>Refund Pending</span>
                </a>
                <a href="cancel.php">
                    <i class="fa-solid fa-ban"></i>
                    <span>Cancelled Booking</span>
                </a>
                <a href="unavailable.php">
                    <i class="fa-solid fa-exclamation-circle"></i>
                    <span>Unavailable</span>
                </a>
                <a href="Invoice.php">
                    <i class="fa-solid fa-file-invoice"></i>
                    <span>Invoice</span>
                </a>
                <a href="concerns.php"> 
                    <i class="fa-solid fa-star"></i>
                    <span>Concerns</span>
                </a>
                <a href="reviews.php">
                    <i class="fa-solid fa-star"></i>
                    <span>Reviews</span>
                </a>
                <a href="history.php">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>History</span>
                </a>
                <div class="dropdown dropup">
                    <a href="#" class="dropdown-toggle" id="eventsListDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-list"></i>
                        <span>Events List</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="eventsListDropdown">
                        <li><a class="dropdown-item" href="events_list.php">Events List</a></li>
                        <li><a class="dropdown-item" href="package_list.php">Package List</a></li>
                        <li><a class="dropdown-item" href="extra.php">Extra</a></li>
                        <li><a class="dropdown-item" href="pax.php">Pax</a></li>
                        <li><a class="dropdown-item" href="dish.php">Dish</a></li>
                    </ul>
                </div>
                <a href="reports.php">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Reports & Analytics</span>
                </a>
                <a href="admin-user.php">
                    <i class="fa-solid fa-users-gear"></i>
                    <span>Manage Admin Users</span>
                </a>
                <div class="dropdown dropup">
                    <a href="#" class="dropdown-toggle" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>CMS</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                        <li><a class="dropdown-item" href="front_cms.php">Front CMS</a></li>
                        <li><a class="dropdown-item" href="scope_service.php">Scope Service</a></li>
                        <li><a class="dropdown-item" href="extras.php">Extras</a></li>
                        <li><a class="dropdown-item" href="features.php">Venue Features</a></li>
                        <li><a class="dropdown-item" href="terms_condition.php">Terms & Condition</a></li>
                    </ul>
                </div>
            </div>
        </div>
    
    </div>

    </div>
    </div>
    <div class="content flex-grow-1">
        <div class="header">
        <button class="btn btn-outline-secondary toggle-nav mt-1" id="toggleNavbarBtn">
            <i class="fa-solid fa-bars"></i>
        </button>

            <div class="profile-admin">
                <div class="dropdown">
                   
                   <?php if (!empty($image)): ?>
                        <button class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../../../assets/profile/<?php echo htmlspecialchars($image); ?>" 
                                style="width: 40px; height: 40px; object-fit: cover;">
                        </button>
                    <?php endif; ?>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../../users/function/authentication/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="container mt-4">
        <div class="date-filter-form mb-2">
                    <form action="" method="get">
                        <div class="date-filter">
                            <select name="month" id="month" class="form-control">
                                <option value="">Select Month</option>
                                <?php 
                                $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                foreach ($months as $index => $month) {
                                    $selected = (isset($_GET['month']) && $_GET['month'] == $index + 1) ? 'selected' : '';
                                    echo "<option value='" . ($index + 1) . "' $selected>$month</option>";
                                }
                                ?>
                            </select>
                            <select name="year" id="year" class="form-control">
                                <option value="">Select Year</option>
                                <?php
                                $current_year = date('Y');
                                for ($i = $current_year - 5; $i <= $current_year; $i++) {
                                    $selected = (isset($_GET['year']) && $_GET['year'] == $i) ? 'selected' : '';
                                    echo "<option value='$i' $selected>$i</option>";
                                }
                                ?>
                            </select>

                            <button type="submit">Filter</button>
                        </div>
                    </form>
                </div>
            <div class="d-flex justify-content-between mb-2">
                <h3>Approve Booking</h3>
                <div class="search-form">
                    <form action="" method="get">
                        <input type="text" id="searchInput" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search...">
                        <button type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
            <table class="table mt-4">
                <thead class="table-booking">
                    <tr>
                        <th scope="col">Booking ID</th>
                        <th scope="col">Customer's Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Booking Date</th>
                        <th scope="col">Event Date</th>
                        <th scope="col">Event Start</th>
                        <th scope="col">Event End</th>
                        <th scope="col">View</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $id = 1; 
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                            <td><?php echo $id++; ?></td>
                                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($row['events_date']); ?></td>
                                <td><?php echo formatTime(htmlspecialchars($row['event_starttime'])); ?></td>
                                <td><?php echo formatTime(htmlspecialchars($row['event_endtime'])); ?></td>
                                <td>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['id']; ?>">View</button>
                                </td>
                                <td>
                                <select class="form-select form-select-sm" onchange="updateStatus(this, <?php echo $row['id']; ?>)">
                                    <option value="Waiting" <?php echo ($row['status'] === 'Waiting' ? 'selected' : ''); ?>>Waiting</option>
                                    <option value="Cancel" <?php echo ($row['status'] === 'Cancel' ? 'selected' : ''); ?>>Cancel Booking</option>
                                    <option value="Update-payment" <?php echo ($row['status'] === 'Update-payment' ? 'selected' : ''); ?>>Update Payment</option>
                                    <option value="resched" <?php echo ($row['status'] === 'resched' ? 'selected' : ''); ?>>Reschedule Booking</option>
                                    <option value="On-going" <?php echo ($row['status'] === 'On-going' ? 'selected' : ''); ?>>On-going</option>
                                    <option value="Finished" <?php echo ($row['status'] === 'Finished' ? 'selected' : ''); ?>>Finished</option>
                                </select>
                                
                                </td>
                            </tr>
                                      <!-- Bootstrap Modal -->
                                <div class="modal fade" id="viewModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel<?php echo $row['id']; ?>">Booking Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                        <label for="status_<?php echo $row['id']; ?>" class="form-label">Status</label>
                                                        <input type="text" class="form-control" id="status_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['status']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="booking_id_<?php echo $row['id']; ?>" class="form-label">Booking ID</label>
                                                    <input type="text" class="form-control" id="booking_id_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="customer_name_<?php echo $row['id']; ?>" class="form-label">Customer's Name</label>
                                                    <input type="text" class="form-control" id="customer_name_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['full_name']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email_<?php echo $row['id']; ?>" class="form-label">Email</label>
                                                    <input type="text" class="form-control" id="email_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['email']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="booking_date_<?php echo $row['id']; ?>" class="form-label">Booking Date</label>
                                                    <input type="text" class="form-control" id="booking_date_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['created_at']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="event_date_<?php echo $row['id']; ?>" class="form-label">Event Date</label>
                                                    <input type="text" class="form-control" id="event_date_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['events_date']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="event_start_<?php echo $row['id']; ?>" class="form-label">Event Start</label>
                                                    <input type="text" class="form-control" id="event_start_<?php echo $row['id']; ?>" value="<?php echo formatTime(htmlspecialchars($row['event_starttime'])); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="event_end_<?php echo $row['id']; ?>" class="form-label">Event End</label>
                                                    <input type="text" class="form-control" id="event_end_<?php echo $row['id']; ?>" value="<?php echo formatTime(htmlspecialchars($row['event_endtime'])); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="event_type_<?php echo $row['id']; ?>" class="form-label">Event Type</label>
                                                    <input type="text" class="form-control" id="event_type_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['event_type']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="event_package_<?php echo $row['id']; ?>" class="form-label">Event Package</label>
                                                    <input type="text" class="form-control" id="event_package_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['event_package']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="event_options_<?php echo $row['id']; ?>" class="form-label">Event Options</label>
                                                    <input type="text" class="form-control" id="event_options_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['event_options']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="reference_no_<?php echo $row['id']; ?>" class="form-label">Reference Number</label>
                                                    <input type="text" class="form-control" id="reference_no_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['reference_no']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="cost_<?php echo $row['id']; ?>" class="form-label">Cost</label>
                                                    <input type="text" class="form-control" id="cost_<?php echo $row['id']; ?>" value="₱<?php echo number_format($row['cost'], 2); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="payment_amount_<?php echo $row['id']; ?>" class="form-label">Payment Amount</label>
                                                    <input type="text" class="form-control" id="payment_amount_<?php echo $row['id']; ?>" value="₱<?php echo number_format($row['payment_amount'], 2); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="balance_<?php echo $row['id']; ?>" class="form-label">Balance</label>
                                                    <input type="text" class="form-control" id="balance_<?php echo $row['id']; ?>" value="₱<?php echo number_format($row['cost'] - $row['payment_amount'], 2); ?>" readonly>
                                                </div>

                                                <!-- Additional Fields -->
                                                <div class="mb-3">
                                                    <label for="beef_dish_<?php echo $row['id']; ?>" class="form-label">Beef Dish</label>
                                                    <input type="text" class="form-control" id="beef_dish_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['beef_dish']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pork_dish_<?php echo $row['id']; ?>" class="form-label">Pork Dish</label>
                                                    <input type="text" class="form-control" id="pork_dish_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['pork_dish']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="chicken_dish_<?php echo $row['id']; ?>" class="form-label">Chicken Dish</label>
                                                    <input type="text" class="form-control" id="chicken_dish_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['chicken_dish']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasta_dish_<?php echo $row['id']; ?>" class="form-label">Pasta Dish</label>
                                                    <input type="text" class="form-control" id="pasta_dish_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['pasta_dish']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dessert_dish_<?php echo $row['id']; ?>" class="form-label">Dessert Dish</label>
                                                    <input type="text" class="form-control" id="dessert_dish_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['dessert_dish']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fish_dish_<?php echo $row['id']; ?>" class="form-label">Fish Dish</label>
                                                    <input type="text" class="form-control" id="fish_dish_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['fish_dish']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="drinks_dish_<?php echo $row['id']; ?>" class="form-label">Drinks</label>
                                                    <input type="text" class="form-control" id="drinks_dish_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['drinks_dish']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="payment_image_<?php echo $row['id']; ?>" class="form-label">Payment Image</label>
                                                    <img id="payment_image_<?php echo $row['id']; ?>" src="../../../assets/gcash-payments/<?php echo htmlspecialchars($row['payment_image']); ?>" alt="Payment Image" class="img-fluid" style="max-width: 100%; height: auto;">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="reference_no_<?php echo $row['id']; ?>" class="form-label">Reference Number</label>
                                                    <input type="text" class="form-control" id="reference_no_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['reference_no']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <?php if (!is_null($row['second_payment_image']) && !empty($row['second_payment_image'])): ?>
                                                        <label for="second_payment_image_<?php echo $row['id']; ?>" class="form-label">Second Payment Image</label>
                                                        <img id="second_payment_image_<?php echo $row['id']; ?>" src="../../../assets/gcash-payments/<?php echo htmlspecialchars($row['second_payment_image']); ?>" alt="Secondary Payment Image" class="img-fluid" style="max-width: 100%; height: auto;">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="mb-3">
                                                    <?php if (!is_null($row['second_reference_no']) && !empty($row['second_reference_no'])): ?>
                                                        <label for="secondary_reference_no_<?php echo $row['id']; ?>" class="form-label">Second Reference Number</label>
                                                        <input type="text" class="form-control" id="secondary_reference_no_<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['second_reference_no']); ?>" readonly>
                                                    <?php endif; ?>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                           

                            

                            <div class="modal fade" id="updatePaymentModal" tabindex="-1" aria-labelledby="updatePaymentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="../function/php/update_second.php" method="post" onsubmit="handleModalSubmit(event)">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updatePaymentModalLabel">Update Second Payment Amount</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" id="bookingId" value="">
                                                    <div class="mb-3">
                                                        <label for="secondPaymentAmount" class="form-label">Second Payment Amount</label>
                                                        <input type="text" class="form-control" name="second_payment_amount" id="secondPaymentAmount" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        <?php endwhile; ?>
                </tbody>
            </table>
            </div>
            <div class="modal fade" id="paymentImageModal" tabindex="-1" aria-labelledby="paymentImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentImageModalLabel">Payment Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="" id="paymentImage" class="img-fluid" alt="Payment Image" style="max-width: 60%; display: flex; margin: auto;">
                        </div>
                        </div>
                    </div>
                </div>

                


                <script>
                    const paymentImageButtons = document.querySelectorAll('[data-bs-target="#paymentImageModal"]');
                    paymentImageButtons.forEach(button => {
                        button.addEventListener('click', function() {
                        const paymentImage = this.getAttribute('data-payment-image');
                        document.getElementById('paymentImage').src = "../../../assets/gcash-payments/" + paymentImage;
                        });
                    });

                    
                </script>

            
                <nav aria-label="Page navigation">
                    <ul class="pagination d-flex justify-content-end">
                        <?php if ($page > 1): ?>
                            <li class="page-item pg-btn"><a class="page-links" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">&laquo;</a></li>
                        <?php else: ?>
                            <li class="page-item pg-btn disabled"><span class="page-links">&laquo;</span></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item pg-btn"><a class="page-links" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">&raquo;</a></li>
                        <?php else: ?>
                            <li class="page-item pg-btn disabled"><span class="page-links">&raquo;</span></li>
                        <?php endif; ?>
                    </ul>
                </nav>

        </div>
        <?php $conn->close(); ?>
</body>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../function/script/status.js"></script>
<script src="../function/script/nav-toggle.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   

</html>