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

$total_query = "SELECT COUNT(*) FROM booking WHERE status IN ('On-going') 
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

$query = "SELECT * FROM booking WHERE status IN ('Waiting', 'On-going') 
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
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>On-going | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">

</head>

<body>
    <!--Navigation Links-->
    <div class="navbar flex-column bg-white shadow-sm p-3 collapse d-md-flex" id="navbar">
        <div class="navbar-links">
            <a class="navbar-brand d-none d-md-block logo-container" href="#">
                <img src="../../../assets/logo.png" alt="Logo">
            </a>
            <a href="dashboard.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="calendar.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Calendar</span>
            </a>
            <a href="pending.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Pending Booking</span>
            </a>
            <a href="approve.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Approved Booking</span>
            </a>
            <a href="#" class="navbar-highlight">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>On going Booking</span>
            </a>
            <a href="refund.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Refund Pending</span>
            </a>
            <a href="cancel.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Cancelled Booking</span>
            </a>
            <a href="unavailable.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Unavailable</span>
            </a>
            <a href="invoice.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Invoice</span>
            </a>
            <a href="reviews.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Reviews</span>
            </a>
            <a href="history.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>History</span>
            </a>
            <div class="dropdown dropup">
                <a href="#" class=" dropdown-toggle" id="eventsListDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-tachometer-alt"></i>
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
            <a href="admin-user.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Manage Admin Users</span>
            </a>
            <div class="dropdown dropup">
                <a href="#" class="dropdown-toggle" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-tachometer-alt"></i>
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
    <div class="content flex-grow-1">
        <div class="header">
            <button class="navbar-toggler d-block d-md-none" type="button" onclick="toggleMenu()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    style="stroke: black; fill: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>

            <div class="profile-admin">
                <div class="dropdown">
                    <button class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../../../assets/profile/user.png"
                            style="width: 40px; height: 40px; object-fit: cover;">
                    </button>
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
                <h3>On going Booking</h3>
                <div class="search-form">
                    <form action="" method="get">
                        <input type="text" id="searchInput" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search...">
                        <button type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php $id = 1; while ($row = $result->fetch_assoc()): ?>
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Booking #<?php echo $id++; ?></h5>
                    <p class="card-text"><strong>Full Name:</strong> <?php echo htmlspecialchars($row['full_name']); ?></p>
                    <p class="card-text"><strong>Celebrant's Name:</strong> <?php echo htmlspecialchars($row['celebrants_name']); ?></p>
                    <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                    <p class="card-text"><strong>Type of Event:</strong> <?php echo htmlspecialchars($row['event_type']); ?></p>
                    <p class="card-text"><strong>Type of Package:</strong> <?php echo htmlspecialchars($row['event_package']); ?></p>
                    <p class="card-text"><strong>Amount:</strong> ₱<?php echo number_format($row['payment_amount'], 2); ?></p>

                    

                    <!-- Modal button for payment image -->
                     <div class="d-flex gap-1 mt-2 justify-content-center">
                    <button type="button" class="btn btn-info text-white fw-bold" data-bs-toggle="modal" data-bs-target="#paymentImageModal_<?php echo $row['id']; ?>">Payment</button>

                    <!-- Modal button for second payment image -->
                    <?php if (!empty($row['second_payment_image'])): ?>
                        <button type="button" class="btn btn-info text-white fw-bold" data-bs-toggle="modal" data-bs-target="#secondPaymentImageModal_<?php echo $row['id']; ?>">Second Payment</button>
                    <?php endif; ?>
                    
                </div>
                <!-- Modal button for full info -->
                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#detailsModal_<?php echo $row['id']; ?>">View Full Info</button>
                </div>
            </div>

            <!-- Modal for full details -->
            <div class="modal fade" id="detailsModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalLabel">Full Details for <?php echo htmlspecialchars($row['full_name']); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($row['phone_number']); ?></p>
                            <p><strong>Event Date:</strong> <?php echo htmlspecialchars($row['events_date']); ?></p>
                            <p><strong>Guest Count:</strong> <?php echo htmlspecialchars($row['guest_count']); ?> guests</p>
                            <p><strong>Event Start Time:</strong> <?php echo htmlspecialchars($row['event_starttime']); ?>:00</p>
                            <p><strong>Event Options:</strong> <?php echo htmlspecialchars($row['event_options']); ?></p>
                            <p><strong>Reference No:</strong> <?php echo htmlspecialchars($row['reference_no']); ?></p>
                            <p><strong>Total Cost:</strong> ₱<?php echo number_format($row['cost'], 2); ?></p>
                            <p><strong>Remaining Balance:</strong> ₱<?php echo number_format($row['cost'] - $row['payment_amount'], 2); ?></p>

                            <!-- Food details -->
                            <p><strong>Beef Dish:</strong> <?php echo htmlspecialchars($row['beef_dish']); ?></p>
                            <p><strong>Pork Dish:</strong> <?php echo htmlspecialchars($row['pork_dish']); ?></p>
                            <p><strong>Chicken Dish:</strong> <?php echo htmlspecialchars($row['chicken_dish']); ?></p>
                            <p><strong>Pasta Dish:</strong> <?php echo htmlspecialchars($row['pasta_dish']); ?></p>
                            <p><strong>Dessert Dish:</strong> <?php echo htmlspecialchars($row['dessert_dish']); ?></p>
                            <p><strong>Fish Dish:</strong> <?php echo htmlspecialchars($row['fish_dish']); ?></p>
                            <p><strong>Drinks:</strong> <?php echo htmlspecialchars($row['drinks_dish']); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for payment image -->
            <div class="modal fade" id="paymentImageModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="paymentImageModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentImageModalLabel">Payment Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="<?php echo htmlspecialchars($row['payment_image']); ?>" class="img-fluid" alt="Payment Image">
                            <p><strong>Reference No:</strong> <?php echo htmlspecialchars($row['reference_no']); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for second payment image -->
            <?php if (!empty($row['second_payment_image'])): ?>
            <div class="modal fade" id="secondPaymentImageModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="secondPaymentImageModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="secondPaymentImageModalLabel">Second Payment Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="<?php echo htmlspecialchars($row['second_payment_image']); ?>" class="img-fluid" alt="Second Payment Image">
                            <p><strong>Second Reference No:</strong> <?php echo htmlspecialchars($row['second_reference_no']); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   

</html>