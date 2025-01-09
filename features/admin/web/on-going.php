<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../users/web/login.php');
    exit();
}

require '../../../db.php';

// Fetch the booking record to get the 'id' (auto-increment field)
$query = "SELECT * FROM booking WHERE status = 'On-going'";
$stmt = $conn->prepare($query);
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
    <title>On-going | Admin</title>
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
                <a href="approve.php">
                   <i class="fas fa-clipboard-check"></i>
                    <span>Approved Booking</span>
                </a>
                <a href="on-going.php" class="navbar-highlight">
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
                <a href="invoice.php">
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
                <h3>On going Booking</h3>
              
            </div>
            <?php ; while ($row = $result->fetch_assoc()): ?>
            <div class="card h-100 ongoing-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="full_name" class="form-label"><strong>Full Name:</strong></label>
                        <input type="text" id="full_name" class="form-control" value="<?php echo htmlspecialchars($row['full_name']); ?>" readonly>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="event_type" class="form-label"><strong>Type of Event:</strong></label>
                        <input type="text" id="event_type" class="form-control" value="<?php echo htmlspecialchars($row['event_type']); ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="event_package" class="form-label"><strong>Type of Package:</strong></label>
                        <input type="text" id="event_package" class="form-control" value="<?php echo htmlspecialchars($row['event_package']); ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="payment_amount" class="form-label"><strong>Amount:</strong></label>
                        <input type="text" id="payment_amount" class="form-control" value="₱<?php echo number_format($row['payment_amount'], 2); ?>" readonly>
                    </div>
                    <div class="d-flex gap-1 mt-2 justify-content-center">
                    <button type="button" class="btn btn-info text-white fw-bold" data-bs-toggle="modal" data-bs-target="#paymentImageModal_<?php echo $row['id']; ?>">Payment</button>

                    <!-- Modal button for second payment image -->
                    <?php if (!empty($row['second_payment_image'])): ?>
                        <button type="button" class="btn btn-info text-white fw-bold" data-bs-toggle="modal" data-bs-target="#secondPaymentImageModal_<?php echo $row['id']; ?>">Second Payment</button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-primary text-white fw-bold" data-bs-toggle="modal" data-bs-target="#detailsModal_<?php echo $row['id']; ?>">View Full Info</button>
                    
                    
            
                </div>
                    </div>
                    <div style="width: 2px; border-left:1px solid #808080; opacity: 30%;"></div>
                    <div class="col-md-5 d-flex flex-column justify-content-center mx-auto">

                    <h5 class="text-center">UPDATE EVENTS DETAILS</h5>
                    <form action="../function/php/update_booking.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
        

                        <div class="d-flex flex-column">
                            
                    <div class="d-flex gap-1">
                        <div class="form-group mb-3 w-100">
                            <label for="additional-extend" class="form-label"><strong>Additional Hr</strong></label>
                            <input type="number" id="additional-extend" name="add_extend" class="form-control w-100" min="0" max="2" value="<?php echo number_format($row['add_extend']); ?>">
                        </div>
                        <div class="form-group mb-3 w-100">
                            <label for="total-extend" class="form-label"><strong>Total Extend Cost:</strong></label>
                            <input type="text" id="total-extend" class="form-control w-100" value="₱<?php echo number_format($row['add_extend'] * 1000); ?>" readonly>
                        </div>
                    </div>
                        <div class="d-flex gap-1">
                        <div class="form-group mb-3">
                            <label for="additional-pax" class="form-label"><strong>Additional Pax</strong></label>
                            <input type="number" id="additional-pax" name="add_pax" class="form-control" min="0" placeholder="Enter Pax" value="<?php echo htmlspecialchars($row['add_pax']); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="total-pax" class="form-label"><strong>Total Pax Cost:</strong></label>
                            <input type="text" id="total-pax" class="form-control" value="₱<?php echo number_format($row['add_pax'] * 400, 2); ?>" readonly>
                        </div>
                    </div>
                    <div class="d-flex gap-1 align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="corkage-fee" name="corkage_fee" <?php echo ($row['corkage_fee'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="corkage-fee"><strong>Include Corkage Fee (₱500)</strong></label>
                        </div>
                        <div class="form-group mb-3 flex-grow-1">
                            <label for="total-cost" class="form-label"><strong>Total Corkage Fee:</strong></label>
                            <input type="text" id="total-cost" class="form-control" value="₱<?php echo ($row['corkage_fee'] == 1) ? '500.00' : '0.00'; ?>" readonly>
                        </div>
                    </div>
                    <?php 
                        $baseCost = $row['cost'];
                        $addPaxCost = $row['add_pax'] * 400;
                        $corkageFee = ($row['corkage_fee'] == 1) ? 500 : 0;
                        $extendCost = 0; 
                        if ($row['add_extend'] > 0) {
                            $extendCost = $row['add_extend'] * 1000; 
                        }
                        $totalAmount = $baseCost + $addPaxCost + $corkageFee + $extendCost;
                        ?>
                    <div class="form-group mb-3 w-50 d-flex flex-column" style="margin-left: auto;">
                        <hr class="mb-1 mt-0">
                        <label for="amount" class="form-label"><strong>Amount: </strong></label>
                        <input type="text" id="amount" class="form-control" value="₱<?php echo number_format(($row['add_pax'] * 400) + ($row['corkage_fee'] == 1 ? 500 : 0), 2); ?>" readonly>
                    </div>
                        </div>
                        <div class="form-group mb-3 w-75 d-flex flex-column mt-4" style="margin-left: auto;">
                        <label for="total-amount" class="form-label"><strong>Total Amount: </strong></label>
                        <input type="text" id="total-amount" class="form-control" value="₱<?php echo number_format($totalAmount, 2); ?>" readonly>
                    </div>


                        <input type="hidden" id="initial-cost" value="<?php echo number_format($row['cost'], 2); ?>" />

                        <div class="d-flex gap-1">
                            <?php 
                             if (!is_null($row['payment_method']) || $row['add_payment'] != 0) {
                                echo '<button type="button" class="btn btn-success mt-3 d-flex justify-content-center w-100">PAID</button>';
                             }
                            ?>
                            <button type="submit" name="update" class="btn btn-primary mt-3 d-flex justify-content-center w-100">Update</button>
                            </form>
                            <?php 
                                if ($addPaxCost != 0 || $corkageFee != 0 || $extendCost != 0){ 
                                    echo '<button type="button" class="btn btn-warning mt-3 d-flex justify-content-center w-100 text-white" data-bs-toggle="modal" data-bs-target="#paymentModal_' . $row['id'] . '">Pay Now</button>';
                                }
                            ?>
                          
                        </div>

                        <div class="modal fade" id="paymentModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="paymentModalLabel">Payment Options</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="../function/php/process_payment.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

                                        <div class="mb-3">
                                            <label for="payment-method" class="form-label"><strong>Select Payment Method:</strong></label>
                                            <select id="payment-method" name="payment_method" class="form-control">
                                                <option value="cash">Cash</option>
                                                <option value="gcash">GCash</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="payment-amount" class="form-label"><strong>Amount:</strong></label>
                                            <input type="number" id="payment-amount" name="add_payment" class="form-control" min="1" required>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" name="pay" class="btn btn-primary">Proceed</button>
                                        </div>
                                    </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                                            
                    </div>
                    </div>       
                </div>
            </div>

         
            <!-- Modal for full details -->
            <div class="modal fade" id="detailsModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalLabel">Full Details for <?php echo htmlspecialchars($row['full_name']); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Celebrant's Name:</strong> <?php echo htmlspecialchars($row['celebrants_name']); ?></p>
                            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($row['phone_number']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
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
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentImageModalLabel">Payment Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="../../../assets/gcash-payments/<?php echo htmlspecialchars($row['payment_image']); ?>" class="img-fluid" alt="Payment Image">
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
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="secondPaymentImageModalLabel">Second Payment Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="../../../assets/gcash-payments/<?php echo htmlspecialchars($row['second_payment_image']); ?>" class="img-fluid" alt="Second Payment Image">
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

            
               

        </div>
        <?php $conn->close(); ?>
</body>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../function/script/status.js"></script>
<script src="../function/script/additional_pax.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../function/script/nav-toggle.js"></script>


   

</html>