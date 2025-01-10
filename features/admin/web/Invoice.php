<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../../users/web/login.php');
        exit();
    }
    require '../../../db.php';
    
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;
    
    // Retrieve search term, month, and year from GET parameters
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $month = isset($_GET['month']) ? intval($_GET['month']) : null;
    $year = isset($_GET['year']) ? intval($_GET['year']) : null;
    
    $search_term = "%" . $search . "%";
    
    $total_query = "SELECT COUNT(*) as total FROM booking WHERE status = 'Finished'";
    
    if (!empty($search)) {
        $total_query .= " AND (full_name LIKE ? OR celebrants_name LIKE ? OR email LIKE ?)";
    }
    
    if ($month && $year) {
        $total_query .= " AND MONTH(events_date) = $month AND YEAR(events_date) = $year";
    }
    
    $stmt = $conn->prepare($total_query);
    if (!empty($search)) {
        $stmt->bind_param("sss", $search_term, $search_term, $search_term);
    } else {
        $stmt->execute();
    }
    $total_result = $stmt->get_result();
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);
    
    $query = "SELECT * FROM booking WHERE status = 'Finished'";
    
    if (!empty($search)) {
        $query .= " AND (full_name LIKE ? OR celebrants_name LIKE ? OR email LIKE ?)";
    }
    
    if ($month && $year) {
        $query .= " AND MONTH(events_date) = $month AND YEAR(events_date) = $year";
    }
    
    $query .= " LIMIT $limit OFFSET $offset";
    
    $stmt = $conn->prepare($query);
    if (!empty($search)) {
        $stmt->bind_param("sss", $search_term, $search_term, $search_term);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $email = $_SESSION['email'];
    $query = "SELECT image_profile FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $image = null;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image = $row['image_profile'];
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" defer></script>
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
                <a href="approve.php">
                   <i class="fas fa-clipboard-check"></i>
                    <span>Approved Booking</span>
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
                <a href="invoice.php" class="navbar-highlight">
                    <i class="fa-solid fa-file-invoice"></i>
                    <span>Invoice</span>
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
    <div class="d-flex justify-content-between mb-2">
        <h3>Invoice Booking</h3>       
    </div>

    <div class="row">
        <?php 
        $id = 1;
        while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['full_name']); ?></h5>
                    <p class="card-text"><strong>Event Type:</strong> <?php echo htmlspecialchars($row['event_type']); ?></p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewDetailsModal-<?php echo $row['id']; ?>">View</button>
                </div>
            </div>
        </div>
        <?php 
        }
        ?>
    </div>

    <?php
    $result->data_seek(0);
    while ($row = $result->fetch_assoc()) {
    ?>
    <div class="modal fade" id="viewDetailsModal-<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewDetailsModalLabel-<?php echo $row['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel-<?php echo $row['id']; ?>">Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <style>
                   
                </style>
                <div class="modal-body" id="printContent-<?php echo $row['id']; ?>">
                    <div class="headers d-flex justify-content-center mx-auto mb-4">
                        <div class="div">
                            <img src="../../../assets/logo.png" alt="Logo" style="width: 100px; height: 100px; display: flex; justify-content-center; margin: auto;"> 
                            <h5>Amiel's Mom Event</h5>
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <div class="div">
                        <div class="info-row">
                            <div class="info-left"><strong>Full Name:</strong></div>
                            <div class="info-right"><?php echo htmlspecialchars($row['full_name']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-left"><strong>Celebrant's Name:</strong></div>
                            <div class="info-right"><?php echo htmlspecialchars($row['celebrants_name']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-left"><strong>Email:</strong></div>
                            <div class="info-right"><?php echo htmlspecialchars($row['email']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-left"><strong>Phone Number:</strong></div>
                            <div class="info-right"><?php echo htmlspecialchars($row['phone_number']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-left"><strong>Event Date:</strong></div>
                            <div class="info-right"><?php echo htmlspecialchars($row['events_date']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-left"><strong>Guest Count:</strong></div>
                            <div class="info-right"><?php echo htmlspecialchars($row['guest_count']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-left"><strong>Event Start Time:</strong></div>
                            <div class="info-right"><?php echo htmlspecialchars($row['event_starttime']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-left"><strong>Event Type:</strong></div>
                            <div class="info-right"><?php echo htmlspecialchars($row['event_type']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-left"><strong>Package Type:</strong></div>
                            <div class="info-right"><?php echo htmlspecialchars($row['event_package']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-left"><strong>Event Options:</strong></div>
                            <div class="info-right"><?php echo htmlspecialchars($row['event_options']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-left"><strong>Reference No:</strong></div>
                            <div class="info-right"><?php echo htmlspecialchars($row['reference_no']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-left"><strong>Total:</strong></div>
                            <div class="info-right">₱<?php echo number_format(htmlspecialchars($row['cost'] + ($row['add_pax'] * 400) + ($row['corkage_fee'] == 1 ? 500 : 0) + ($row['add_extend'] * 1000)), 2); ?></div>
                        </div>
                        <?php if ($row['add_pax'] != 0): ?>
                        <div class="info-row">
                            <div class="info-left"><strong>Add Pax:</strong></div>
                            <div class="info-right">₱<?php echo number_format(htmlspecialchars($row['add_pax'] * 400), 2); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if ($row['add_extend'] != 0): ?>
                            <div class="info-row">
                            <div class="info-left"><strong>Additional Hr:</strong></div>
                            <div class="info-right">₱<?php echo number_format(htmlspecialchars($row['add_extend'] * 1000), 2); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if ($row['corkage_fee'] != 0): ?>
                            <div class="info-row">
                            <div class="info-left"><strong>Corkage Fee</strong></div>
                            <div class="info-right">₱<?php echo number_format(htmlspecialchars($row['corkage_fee']), 2); ?></div>
                        </div>
                        <?php endif; ?>
                        <div class="info-row">
                            <div class="info-left"><strong>Payment Amount:</strong></div>
                            <div class="info-right">₱<?php echo number_format($row['payment_amount'], 2); ?></div>
                        </div>

                        <?php if ($row['add_payment'] != 0): ?>
                            <div class="info-row">
                            <div class="info-left"><strong>Additional Payment</strong></div>
                            <div class="info-right">₱<?php echo number_format(htmlspecialchars($row['add_payment']), 2); ?><div>
                        </div>
                        <?php endif; ?>
                       
                        <div class="info-row">
                            <div class="info-left"><strong>Remaining:</strong></div>
                            <div class="info-right">₱<?php echo number_format($row['cost'] - $row['payment_amount'] - $row['add_payment'], 2); ?></div>
                        </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary d-flex justify-content-center mx-auto" onclick="printModalContent(<?php echo $row['id']; ?>)">Print</button>
            </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <!-- Pagination -->
    <nav>
        <ul class="pagination d-flex justify-content-end">
            <?php
            if ($total_pages > 3) {
                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">&laquo;</a></li>';
                }
                $start = max(1, $page - 1);
                $end = min($total_pages, $start + 2);
                for ($i = $start; $i <= $end; $i++) {
                    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
                if ($page < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">&raquo;</a></li>';
                }
            }
            ?>
        </ul>
    </nav>
</div>

    <?php $conn->close(); ?>

    <?php
    if (isset($_SESSION['status_message'])) {
        echo "<script>
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success!',
                                                text: '" . $_SESSION['status_message'] . "',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                        </script>";
        unset($_SESSION['status_message']);
    }
    ?>
</body>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../function/script/status.js"></script>
<script src="../function/script/print.js"></script>
<script src="../function/script/nav-toggle.js"></script>



</html>