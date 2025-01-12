<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../users/web/login.php');
    exit();
}
require '../../../db.php';  



include '../function/php/table-dashboard.php';
$queryWaiting = "SELECT COUNT(*) AS waiting_count FROM booking WHERE status = 'Waiting'";
$queryDeclined = "SELECT COUNT(*) AS declined_count FROM booking WHERE status = 'Declined'";
$resultWaiting = $conn->query($queryWaiting);
$resultDeclined = $conn->query($queryDeclined);
$rowWaiting = $resultWaiting->fetch_assoc();
$rowDeclined = $resultDeclined->fetch_assoc();
$waitingCount = $rowWaiting['waiting_count'];
$declinedCount = $rowDeclined['declined_count'];

$query_payment = "SELECT SUM(cost) AS payment_amount FROM booking WHERE status = 'Finished'";
$result_payment = $conn->query($query_payment);

if ($result_payment && $row_payment = $result_payment->fetch_assoc()) {
    $payment_amount = $row_payment['payment_amount'];
} else {
    $payment_amount = 0; 
}

$query_refund = "SELECT SUM(refunded_amount) AS refunded_amount FROM booking WHERE status = 'Finished' AND refund_status IN ('full-refund', 'half-refund')";
$result_refund = $conn->query($query_refund);

if ($result_refund && $row_refund = $result_refund->fetch_assoc()) {
    $refund_amount = $row_refund['refunded_amount'];
} else {
    $refund_amount = 0; 
}

$total_sales = $payment_amount - $refund_amount;




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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>

    <div class="">   
        <div class="navbar flex-column  shadow-sm p-3 collapse show" id="navbar">
            <div class="navbar-header d-flex justify-content-between align-items-center w-100">
                <a class="navbar-brand d-none d-md-block logo-container" href="#">
                    <img src="../../../assets/logo.png" alt="Logo">
                </a>
            </div>
            <div class="navbar-links">
                <a href="dashboard.php" class="navbar-highlight">
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
                <a href="approve.php">
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
                            <img src="../../../assets/logo.png" 
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
            <h3>Dashboard</h3>
            <div class="row">
                <div class="col-md-2">
                    <div class="card p-0 mt-2">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="col-md-12">
                                    <p class="mb-1">Total Sales</p>
                                    <h5>₱<?php echo number_format($total_sales, 2); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-0 mt-2">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="col-md-12">
                                    <p class="mb-1">Approved Books</p>
                                    <h5><?php echo $waitingCount; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-0 mt-2">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="col-md-12">
                                    <p class="mb-1">Cancelled Books</p>
                                    <h5><?php echo $declinedCount ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mt-2 d-flex justify-content-center">
                    <div class="chart-container">
                        <h5 class="chart-title">Weekly Sales</h5>
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
                <div class="col-md-5 mt-2  d-flex justify-content-center">
                    <div class="chart-container">
                        <h5 class="chart-title">Yearly Sales</h5>
                        <canvas id="monthlySalesChart"></canvas>
                    </div>
                </div>

                <div id="chartContainer">
                    <canvas id="ratingPieChart" width="400" height="400"></canvas>
                </div>
              
                
               
                <div class="col-md-9 mt-4">
                    <h5>Pending Bookings</h5>
                    <div class="card">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Event Date</th>
                                    <th>Event</th>
                                    <th>Pax</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bookings_waiting as $booking): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['events_date']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['event_type']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['guest_count']); ?></td>
                                        <td>₱100</td>
                                        <td class="bg-warnings"><?php echo htmlspecialchars($booking['status']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="pending.php" class="d-flex justify-content-center text-decoration-none mt-2">Show all</a>

                    <h5 class="mt-4">Cancelled Bookings</h5>
                    <div class="card">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Event Date</th>
                                    <th>Event</th>
                                    <th>Pax</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bookings_declined as $booking): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['events_date']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['event_type']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['guest_count']); ?></td>
                                        <td>₱100</td>
                                        <td class="bg-declines"><?php echo htmlspecialchars($booking['status']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="cancel.php" class="d-flex justify-content-center text-decoration-none mt-2">Show all</a>
                </div>

                




</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../function/script/daily-chart.js"></script>
<script src="../function/script/month-chart.js"></script>
<script src="../function/script/status.js"></script>
<script src="../function/script/pie-chart.js"></script>
<script src="../function/script/nav-toggle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</html>