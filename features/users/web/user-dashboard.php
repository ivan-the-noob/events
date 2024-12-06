<?php 
    session_start();
    $email = isset($_SESSION['email']);
    $name = isset($_SESSION['name']);
    
    if (!(isset($_SESSION['email']) && $_SESSION['role'] === 'users')) {
        header('Location: ../../../features/users/web/login.php');
        exit;
    }

    require '../../../db.php';

    $email = $_SESSION['email']; 

    $sql = "SELECT * FROM booking WHERE email = ? AND status = 'Finished'";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                                    <li><a class="dropdown-item" href="">Profile</a></li>
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
    <p class="calendar-title text-center mb-0">Thank you for trusting us!</p>
    <h3 class="text-center calendar-h3">Events History</h3>
    <div class="container">
    <?php if (!empty($bookings)): ?>
        <?php foreach ($bookings as $booking): ?>
            <div class="card p-4 mb-4">
                <div class="d-flex align-items-start mb-3 justify-content-between">
                    <div>
                        <h5 class="card-title mb-0"><?php echo htmlspecialchars($booking['full_name']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($booking['email']); ?></p>
                    </div>
                    <div class="d-flex gap-1 justtify-content-end" style="margin-left: auto;">
                        <span class="status-badge <?php echo $booking['status'] === 'Finished' ? 'success' : ''; ?>">
                            <?php echo $booking['status'] === 'Finished' ? 'Done' : htmlspecialchars($booking['status']); ?>
                        </span>
                        <button class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#ratingModal">
                            Rate our service
                        </button>
                    </div>
                    <form method="POST" action="../function/php/submit_review.php" enctype="multipart/form-data">
                        <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ratingModalLabel">Rate our Service</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="rate d-flex mx-auto justify-content-center">
                                            <input type="radio" id="star5" name="rating" value="5" />
                                            <label for="star5" title="text">5 stars</label>
                                            <input type="radio" id="star4" name="rating" value="4" />
                                            <label for="star4" title="text">4 stars</label>
                                            <input type="radio" id="star3" name="rating" value="3" />
                                            <label for="star3" title="text">3 stars</label>
                                            <input type="radio" id="star2" name="rating" value="2" />
                                            <label for="star2" title="text">2 stars</label>
                                            <input type="radio" id="star1" name="rating" value="1" />
                                            <label for="star1" title="text">1 star</label>
                                        </div>

                                        <!-- Subject Input -->
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter feedback subject" required>
                                        </div>

                                        <!-- Feedback Textarea Input -->
                                        <div class="mb-3">
                                            <label for="feedback" class="form-label">Your Feedback</label>
                                            <textarea class="form-control" name="feedback" id="feedback" rows="3" placeholder="Write your feedback here..." required></textarea>
                                        </div>

                                        <!-- Image Input -->
                                        <div class="mb-3">
                                            <label for="imageInput" class="form-label">Upload Image</label>
                                            <input class="form-control" type="file" name="image" id="imageInput" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


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
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
    <?php endif; ?>
</div>
</section>



   


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
