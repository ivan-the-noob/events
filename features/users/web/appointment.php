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

    $sql = "SELECT * FROM booking WHERE email = ? AND review_status = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row; 
    }

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
    <title>Document</title>
</head>
<body>
    <div class="navbar-container">
        <div class="col-10 col-md-10">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand d-none d-lg-block" href="#">
                    <img src="../../../assets/logo.png" alt="Logo" width="30" height="30">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        style="stroke: #000; fill: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav"> 
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                       
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#services">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact-us">Contact Us</a>
                        </li>
                        <?php if ($email): ?>
                            <div class="dropdown second-dropdown">
                                <button class="btn" type="button" id="dropdownMenuButton2"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; margin-top: 2px;">
                                    <img src="../../../assets/profile/user.png" alt="Profile Image" class="profile" style="width: 30px; height: 30px; margin-left: 5px; margin-right: 5px;">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="user-dashboard.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="../function/authentication/logout.php">Logout</a></li>
                                </ul>
                            </div>


                        <?php else: ?>
                            <a href="features/users/web/login.php" class="sign-in">Sign In</a>
                        <?php endif; ?>
            
                    </ul>
               
                </div>
             
            </div>
        </nav>       
    </div>
    </div>

    <section class="body">
    <p class="calendar-title text-center mb-0">Book your event today</p>
    <h3 class="text-center calendar-h3">Let's Plan Your Perfect Event</h3>
    <div class="container">
    <a href="user-dashboard.php" class="btn btn-success mb-4 d-flex" style="width: 80px; margin-left: auto;">History</a>
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



                    <span class="status-badge <?php echo strtolower($booking['status']) === 'cancel' ? 'bg-danger text-white' : (strtolower($booking['status']) === 'cancel-pending' ? 'bg-warning text-black text-bold' : ''); ?>">
                        <?php echo strtolower($booking['status']) === 'cancel' ? 'Cancelled' : (strtolower($booking['status']) === 'cancel-pending' ? 'Cancel on Pending' : htmlspecialchars($booking['status'])); ?>
                    </span>

                    <?php if ($booking['status'] === 'Pending'): ?>
                        <?php if ($booking['status_paid'] != 1): ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#payNowModal-<?php echo $booking['id']; ?>">
                                Pay Now
                            </button>
                        <?php else: ?>
                            <span class="btn btn-success">Paid</span>
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
                    <p class="mb-1">Event Date:</p>
                    <p><?php echo (new DateTime($booking['events_date']))->format('F j, Y'); ?></p>
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
                    <p class="mb-1"><span class="info-label">Total Payment</span></p>
                    <p>₱<?php echo number_format(htmlspecialchars($booking['cost']), 2); ?></p>
                </div>
                <?php if (!empty($booking['payment_amount']) && !empty($booking['reference_no'])): ?>
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><span class="info-label">Downpayment</span></p>
                        <p>₱<?php echo number_format($booking['payment_amount'], 2); ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><span class="info-label">Remaining Amount</span></p>
                        <p class="remaining">₱<?php echo number_format($booking['cost'] - $booking['payment_amount'], 2); ?></p>
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
    <?php endforeach; ?>
<?php else: ?>
    <p>No bookings found.</p>
<?php endif; ?>


</div>
</section>



   


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
