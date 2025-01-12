<?php 
    session_start();
    $email = isset($_SESSION['email']);
    
    // Check if the user is logged in and has the correct role
    if (!(isset($_SESSION['email']) && $_SESSION['role'] === 'users')) {
        header('Location: ../../../features/users/web/login.php');
        exit;
    }

    require '../../../db.php';

    $email = $_SESSION['email']; 
    $sql = "SELECT * FROM booking WHERE email = ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row; 
    }
    $query = "SELECT image_profile FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($imageProfile);
    $stmt->fetch();
    $stmt->close();


    $conn->close();

    
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/appointment.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <title>Amiel's MOM Event's Place</title>
    <link rel="icon" href="../../../assets/logo.png" type="image/png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="navbar-container">
        <div class="col-10 col-md-10">
        <div class="d-flex justify-content-between">
                        <div class="d-flex gap-3">
                            <img src="../../../assets/logo.png" alt="Logo" style="width: 60px; height: 60px;">
                            <h5 class="text-black d-flex align-items-center fw-bold mb-0">Amiel's MOM</h5>
                        </div>
                        <div class="d-flex align-items-center">
                        <p class="mb-0 text-black fw-bold w-100 d-flex">Where Memories Begin, and Moments Last Forever</p>
                        </div>
                    </div>
                <nav class="navbar navbar-expand-lg navbar-light">
                    
                    <div class="container">
                        
    
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                style="stroke: #000; fill: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
    
                        <div class="collapse navbar-collapse justify-content-center align-items-center" id="navbarNav">
                            <ul class="navbar-nav d-flex align-items-center "> 
                                <li class="nav-item">
                                    <a class="nav-link" href="../../../index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../../../index.php#our-services">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="packages.php">Packages</a>
                                </li>
                               
                                <li class="nav-item">
                                    <a class="nav-link" href="about-us.php">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contact_us.php">Contact Us</a>
                                </li>
                                <div class="d-flex gap-2 navbar-btn">
                              
                                <?php if ($email): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="history.php">Booking History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="faqs.php">FAQS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="terms_condition.php">Terms & Conditions</a>
                                </li>
                                <div class="dropdown second-dropdown d-flex align-items-center">
                                <button class="btn" type="button" id="dropdownMenuButton2"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; margin-top: 2px;">
                                        <img src="../../../assets/profile/<?php echo htmlspecialchars($imageProfile); ?>" alt="Profile Picture" 
                                        alt="Profile Image" 
                                        class="rounded-circle" 
                                        style="width: 30px; height: 30px; object-fit: cover; border: 1px solid #7A3015;">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="dashboard.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="../function/authentication/logout.php">Logout</a></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                               
                            </div>            
                            </ul>
                        </div>        
                    </div>
                </nav>   
        </div>
    </div>


    <section class="body">
    <p class="calendar-title text-center mb-0">Thank you for trusting us</p>
    <h3 class="text-center calendar-h3">Events History</h3>
    <div class="container">
    <?php if (!empty($bookings)): ?>
    <?php foreach ($bookings as $booking): ?>
        <div class="card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="card-title mb-0"><?php echo htmlspecialchars($booking['full_name']); ?></h5>
                    <p class="card-text text-muted"><?php echo htmlspecialchars($booking['email']); ?></p>
                </div>
                <div class="d-flex gap-2">
                    <!-- Modal for cancellation reason -->
                    <div class="modal fade" id="cancelModal-<?php echo $booking['id']; ?>" tabindex="-1" aria-labelledby="cancelModalLabel-<?php echo $booking['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelModalLabel-<?php echo $booking['id']; ?>">Reason for Cancellation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="../function/php/process_cancel.php">
                                        <input type="hidden" name="id" value="<?php echo $booking['id']; ?>" />
                                        
                                        <div class="mb-3">
                                            <label for="cancellationReason-<?php echo $booking['id']; ?>" class="form-label">Reason for cancellation:</label>
                                            <textarea class="form-control" id="cancellationReason-<?php echo $booking['id']; ?>" name="cancel_reason" rows="4" placeholder="Enter your reason here..."></textarea>
                                        </div>

                                        <!-- New input fields for Gcash name and number -->
                                        <div class="mb-3">
                                            <label for="gcashName-<?php echo $booking['id']; ?>" class="form-label">Gcash Name:</label>
                                            <input type="text" class="form-control" id="gcashName-<?php echo $booking['id']; ?>" name="gcash_name" placeholder="Enter your Gcash name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="gcashNumber-<?php echo $booking['id']; ?>" class="form-label">Gcash Number:</label>
                                            <input type="text" class="form-control" id="gcashNumber-<?php echo $booking['id']; ?>" name="gcash_number" placeholder="Enter your Gcash number" required>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="payNowModal-<?php echo $booking['id']; ?>" tabindex="-1" aria-labelledby="payNowModalLabel-<?php echo $booking['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="payNowModalLabel-<?php echo $booking['id']; ?>">Payment Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="../function/php/payment.php" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
                                    <div class="modal-body">
                                        
                                        <!-- Image Preview -->
                                        <div class="mb-3 text-center">
                                            <img id="preview-<?php echo $booking['id']; ?>" src="../../../assets/gcash.jpg" alt="Payment Image Preview" class="img-fluid">
                                        </div>
                                        <div class="mb-3">
                                            <?php
                                            $cost = $booking['cost']; 
                                            $min_payment = $cost * 0.5;
                                            ?>
                                            <label class="form-label">Amount to Pay:</label>
                                            <p><strong>Minimum: PHP <?php echo number_format($min_payment, 2); ?></strong></p>
                                        </div>

                                        <!-- Image Upload -->
                                        <div class="mb-3">
                                            <label for="imageInput-<?php echo $booking['id']; ?>" class="form-label">Upload Payment Screenshot</label>
                                            <input type="file" class="form-control" id="imageInput-<?php echo $booking['id']; ?>" name="payment_image" accept="image/*" onchange="previewImage(event, '<?php echo $booking['id']; ?>')" required>
                                        </div>

                                       

                                        <!-- Payment Amount -->
                                        <div class="mb-3">
                                            <label for="paymentAmount-<?php echo $booking['id']; ?>" class="form-label">Payment Amount</label>
                                            <input type="number" class="form-control" id="paymentAmount-<?php echo $booking['id']; ?>" name="payment_amount" placeholder="Enter payment amount (min: PHP <?php echo number_format($min_payment, 2); ?>)" min="<?php echo $min_payment; ?>" required>
                                        </div>

                                        <!-- Reference Number -->
                                        <div class="mb-3">
                                            <label for="referenceNo-<?php echo $booking['id']; ?>" class="form-label">Reference Number</label>
                                            <input type="text" class="form-control" id="referenceNo-<?php echo $booking['id']; ?>" name="reference_no" placeholder="Enter your payment reference number" required>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="confirmation-<?php echo $booking['id']; ?>" name="confirmation" required>
                                            <label class="form-check-label" for="confirmation-<?php echo $booking['id']; ?>">I confirm that all data is correct.</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit Payment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                  
                    <?php if ($booking['status'] === 'Finished' && $booking['review_status'] === 0): ?>
                        <button class="btn btn-primary text-white fw-bold" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            Rate our service
                        </button>
                    <?php endif; ?>

                    


                    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reviewModalLabel">Submit your Review</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="../function/php/submit_review.php" method="POST">
                                        <div class="mb-3">
                                            <label for="rating" class="form-label">Rating</label>
                                            <div class="star-rating">
                                                <input type="radio" id="star5" name="rating" value="5" required />
                                                <label for="star5" class="fa fa-star"></label>

                                                <input type="radio" id="star4" name="rating" value="4" />
                                                <label for="star4" class="fa fa-star"></label>

                                                <input type="radio" id="star3" name="rating" value="3" />
                                                <label for="star3" class="fa fa-star"></label>

                                                <input type="radio" id="star2" name="rating" value="2" />
                                                <label for="star2" class="fa fa-star"></label>

                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label for="star1" class="fa fa-star"></label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="feedback" class="form-label">Feedback</label>
                                            <textarea class="form-control" id="feedback" name="feedback" rows="3"  required maxlength="100" required placeholder="Max 100 letters."></textarea>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit Review</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <span class="status-badge <?php 
                        if (strtolower($booking['status']) === 'resched') {
                            echo 'bg-transparent'; 
                        } else {
                            echo strtolower($booking['status']) === 'cancel' ? 'bg-danger text-white' :
                                (strtolower($booking['status']) === 'cancel-pending' ? 'bg-warning text-black text-bold' :
                                (strtolower($booking['status']) === 'pending' ? 'bg-info text-white' :
                                (strtolower($booking['status']) === 'waiting' ? 'bg-primary text-white' : 
                                (strtolower($booking['status']) === 'approved' ? 'bg-success text-white' : ''))));
                        }
                    ?>">
                        <?php 
                        if (strtolower($booking['status']) === 'resched') {
                            echo ''; 
                        } else {
                            echo strtolower($booking['status']) === 'cancel' ? 'Cancelled' :
                                (strtolower($booking['status']) === 'cancel-pending' ? 'Refund on Pending' :
                                (strtolower($booking['status']) === 'pending' ? 'Waiting' :
                                (strtolower($booking['status']) === 'waiting' ? 'Approved' :
                                htmlspecialchars($booking['status']))));
                        }
                        ?>
                    </span>


                    <?php if ($booking['status'] === 'resched'): ?>
                        <?php if (isset($booking['events_date'])): ?>
                            <!-- Button to trigger modal with booking data -->
                            <button 
                                class="btn btn-danger text-white fw-bold" 
                                data-bs-toggle="modal" 
                                data-bs-target="#resched"
                                data-booking-id="<?= $booking['id']; ?>" 
                                data-booking-date="<?= date('F j, Y', strtotime($booking['events_date'])); ?>"
                            >
                                Re-sched
                            </button>
                        <?php else: ?>
                            <!-- Handle missing event_date, maybe display a default message -->
                            <p>Event date not available</p>
                        <?php endif; ?>
                    <?php endif; ?>

                  
                    <div class="modal fade" id="resched" tabindex="-1" aria-labelledby="reschedLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reschedLabel">Select Reschedule Date</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- FullCalendar will be placed here -->
                                     <div class="d-flex gap-2" style="font-size: 20px; padding-left: 50px;">
                                        <p>Selected Date:</p>
                                        <div class="selected-date">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div id="calendar"></div>
                                    <input type="hidden" id="selected-date">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="confirm-reschedule">Confirm Reschedule</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php if ($booking['status'] === 'To-pay'): ?>
                        <?php if ($booking['status_paid'] != 1): ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#payNowModal-<?php echo $booking['id']; ?>">
                                Pay Now
                            </button>
                        <?php endif; ?>
                       
                    <?php endif; ?>
                    <?php if ($booking['status'] === 'Pending' || $booking['status'] === 'Waiting'): ?>
                        <?php
                        $cost = $booking['cost']; 
                        $min_payment = $cost * 0.5;
                        $payment_amount = $booking['payment_amount']; 
                        ?>
                         <?php if ($payment_amount < $min_payment): ?>
                            <span class="btn btn-success">Paid half</span>
                           
                        <?php elseif ($payment_amount == $cost): ?>
                            <span class="btn btn-success">Paid in full</span>
                        <?php else: ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#payInFullModal-<?php echo $booking['id']; ?>">
                                Pay in full
                            </button>
                        <?php endif; ?>
                         <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal-<?php echo $booking['id']; ?>">
                                Cancel
                            </button>
                       
                    <?php endif; ?>

                </div>
            </div>
            <hr>
            <div class="card-body p-0">
                <div class="d-flex justify-content-between">
                        <p class="mb-1"><span class="info-label">Event Date:</span></p>
                        <p><?php echo (new DateTime($booking['events_date']))->format('F j, Y'); ?></p>
                    </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-1"><span class="info-label">Event's Time</span></p>
                    <p><?php echo formatTime(htmlspecialchars($booking['event_starttime'])); ?> - <?php echo htmlspecialchars($booking['event_endtime']); ?>: 00 PM</p>
                </div>
                <div class="d-flex justify-content-between">       
                    <p class="mb-1"><span class="info-label">Celebrant's Name</span></p>
                    <p><?php echo htmlspecialchars($booking['celebrants_name']); ?></p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-1"><span class="info-label">Phone Number</span></p>
                    <p><?php echo htmlspecialchars($booking['phone_number']); ?></p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-1"><span class="info-label">Package:</span></p>
                    <p><?php echo htmlspecialchars($booking['event_package']); ?></p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-1"><span class="info-label">Event Options:</span></p>
                    <p><?php echo htmlspecialchars($booking['event_options']); ?></p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-1"><span class="info-label">Type of Event:</span></p>
                    <p><?php echo htmlspecialchars($booking['event_type']); ?></p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-1"><span class="info-label">Theme of Event</span></p>
                    <p><?php echo htmlspecialchars($booking['theme']); ?></p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-1"><span class="info-label">Total Payment</span></p>
                    <p>₱<?php echo number_format(htmlspecialchars($booking['cost'] + ($booking['add_pax'] * 400) + ($booking['corkage_fee'] == 1 ? 500 : 0) + ($booking['add_extend'] * 1000)), 2); ?></p>
                </div>
                <?php if ($booking['add_pax'] != 0): ?>
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><span class="info-label">Add pax</span></p>
                        <p>₱<?php echo number_format(htmlspecialchars($booking['add_pax'] * 400), 2); ?></p>

                    </div>
                <?php endif; ?>

                <?php if ($booking['add_extend'] != 0): ?>
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><span class="info-label">Additional Hr.</span></p>
                        <p>₱<?php echo number_format(htmlspecialchars($booking['add_extend'] * 1000), 2); ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($booking['corkage_fee'] != 0): ?>
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><span class="info-label">Additional Hr.</span></p>
                        <p>₱<?php echo number_format(htmlspecialchars($booking['corkage_fee']), 2); ?></p>
                    </div>
                <?php endif; ?>




                <?php if (!empty($booking['payment_amount']) && !empty($booking['reference_no'])): ?>
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><span class="info-label">Downpayment</span></p>
                        <p>₱<?php echo number_format($booking['payment_amount'], 2); ?></p>
                    </div>
                    <?php if ($booking['add_payment'] != 0): ?>
                        <div class="d-flex justify-content-between">
                            <p class="mb-1"><span class="info-label">Additional Payment</span></p>
                            <p>₱<?php echo number_format(htmlspecialchars($booking['add_payment']), 2); ?></p>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><span class="info-label">Remaining Amount</span></p>
                        <p class="remaining">₱<?php echo number_format($booking['cost'] - $booking['payment_amount'] - $booking['add_payment'], 2); ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if (strtolower($booking['status']) === 'cancel' || strtolower($booking['status']) === 'cancel-pending'): ?>
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><span class="info-label">Reason for Cancellation</span></p>
                        <p><?php echo htmlspecialchars($booking['cancel_reason']); ?></p>
                    </div>

                    <?php if (strtolower($booking['status']) === 'cancel' || strtolower($booking['status']) === 'cancel-pending'): ?>
                        <div class="d-flex justify-content-between">
                            <p class="mb-1"><span class="info-label">Gcash Name</span></p>
                            <p><?php echo htmlspecialchars($booking['gcash_name']); ?></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-1"><span class="info-label">Gcash Number</span></p>
                            <p><?php echo htmlspecialchars($booking['gcash_number']); ?></p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>

        <div class="modal fade" id="payInFullModal-<?php echo $booking['id']; ?>" tabindex="-1" aria-labelledby="payInFullModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payInFullModalLabel">Pay in Full</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../function/php/pay_in_full.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Amount to Pay:</label>
                        <?php 
                        $remaining_amount = $booking['cost'] - $booking['payment_amount']; 
                        ?>
                        <p><strong>PHP <?php echo number_format($remaining_amount, 2); ?></strong></p>
                        <input type="hidden" name="payment_amount" value="<?php echo $remaining_amount; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="payment_image" class="form-label">Upload Payment Image:</label>
                        <input type="file" class="form-control" id="payment_image" name="payment_image" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="reference_no" class="form-label">Reference No:</label>
                        <input type="text" class="form-control" id="reference_no" name="reference_no" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No bookings found.</p>
<?php endif; ?>
</div>
</section>

<?php
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

<script>
document.addEventListener('DOMContentLoaded', async function () {
    const calendarEl = document.getElementById('calendar');
    const selectedDateDiv = document.querySelector('.selected-date p'); // Selecting the <p> tag inside the div

    // Fetch unavailable days
    let unavailableDays = [];
    try {
        const response = await fetch('../function/php/unavailable.php');
        if (response.ok) {
            unavailableDays = await response.json();
        } else {
            console.error('Failed to fetch unavailable days:', response.status);
        }
    } catch (error) {
        console.error('Error fetching unavailable days:', error);
    }

    console.log('Initial unavailableDays:', unavailableDays);

    // Calendar initialization
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            right: 'prev,next',
        },
        dayCellDidMount: async function (info) {
            const selectedDate = new Date(info.date);
            selectedDate.setHours(0, 0, 0, 0);
            const selectedDateStr = selectedDate.toLocaleDateString('en-CA');

            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const todayStr = today.toLocaleDateString('en-CA');

            // Disable past days
            if (selectedDateStr < todayStr) {
                info.el.style.backgroundColor = 'white';
                info.el.style.opacity = 0.2;
                info.el.style.cursor = 'not-allowed';
            } else if (unavailableDays.includes(selectedDateStr)) {
                // Disable unavailable days
                info.el.style.backgroundColor = '#FFBFBD';
                info.el.style.cursor = 'not-allowed';
            } else {
                try {
                    const response = await fetch(`../function/php/check_date_availability.php?date=${selectedDateStr}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const result = await response.json();

                    if (result.bookings_count >= 1) {
                        console.log(`Booked Date: ${selectedDateStr}`);
                        console.log('Booking +7 days unavailable:');
                        // Mark the next 7 days as unavailable
                        for (let i = 1; i <= 7; i++) {
                            const futureDate = new Date(selectedDate);
                            futureDate.setDate(selectedDate.getDate() + i);
                            const futureDateStr = futureDate.toLocaleDateString('en-CA');
                            console.log(futureDateStr);
                            if (!unavailableDays.includes(futureDateStr)) {
                                unavailableDays.push(futureDateStr);
                            }
                        }
                        console.log('Unavailable days after booking +7 days:', unavailableDays);
                    }

                    console.log(`Processing Date: ${selectedDateStr}`);
                    console.log('Current unavailableDays:', unavailableDays);

                    if (unavailableDays.includes(selectedDateStr)) {
                        info.el.style.backgroundColor = '#FFBFBD';
                        info.el.style.cursor = 'not-allowed';
                    } else if (result.bookings_count >= 2) {
                        info.el.style.backgroundColor = '#D2B48C';
                        info.el.style.cursor = 'not-allowed';
                        info.el.style.setProperty('color', 'white', 'important');
                    } else {
                        info.el.style.backgroundColor = '#FFFFFF';
                        info.el.addEventListener('mouseenter', function () {
                            info.el.style.backgroundColor = '#100E44';
                            info.el.style.color = '#FFFFFF';
                        });

                        info.el.addEventListener('mouseleave', function () {
                            info.el.style.backgroundColor = '#FFFFFF';
                            info.el.style.color = '';
                        });

                        // Update the selected date value when a day is clicked, no modal opening
                        info.el.addEventListener('click', async function () {
                            // Update the content of the <div class="selected-date">
                            if (selectedDateDiv) {
                                selectedDateDiv.textContent = selectedDateStr; // Set the selected date as text inside <p>
                            }

                            // Optionally, you can add any extra logic here if needed
                            console.log(`Selected date: ${selectedDateStr}`);
                        });
                    }
                } catch (error) {
                    console.error('Error fetching availability:', error);
                }
            }
        }
    });

    // Re-render FullCalendar when the modal is shown
    $('#resched').on('shown.bs.modal', function () {
        calendar.render();
    });

    // Initial rendering of the calendar
    calendar.render();

    // When the "Confirm Reschedule" button is clicked
    document.getElementById('confirm-reschedule').addEventListener('click', function () {
        const newDate = document.getElementById('selected-date').value;

        // Get the booking ID from the button (stored as data attribute)
        const bookingId = document.querySelector('[data-bs-toggle="modal"][data-bs-target="#resched"]').getAttribute('data-booking-id');

        // Make sure the new date is selected
        if (newDate) {
            // Update the booking with new date (via Pure AJAX)
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../function/php/reschedule.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = xhr.responseText;
                    console.log('Response from reschedule:', response); // Inspect the response
                    if (response === 'Booking rescheduled successfully') {
                        alert('Booking successfully rescheduled!');
                        location.reload();
                    } else {
                        alert(response); // Display error message
                    }
                }
            };

            // Send bookingId and newDate as form data
            const data = `bookingId=${encodeURIComponent(bookingId)}&newDate=${encodeURIComponent(newDate)}`;
            xhr.send(data);
        } else {
            alert('Please select a date before confirming.');
        }
    });
});




</script>



   

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
