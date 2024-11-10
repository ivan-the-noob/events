<?php 
    session_start();
    $email = isset($_SESSION['email']);
    
    // Check if the user is logged in and has the correct role
    if (!(isset($_SESSION['email']) && $_SESSION['role'] === 'users')) {
        header('Location: ../../../features/users/web/login.php');
        exit;
    }

    require '../../../db.php';

    // Get the email from the session
    $email = $_SESSION['email']; 

    // Prepare the SQL query to select bookings based on the session email
    $sql = "SELECT * FROM booking WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all the booking records
    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row; // Store each booking record in an array
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
    <p class="calendar-title text-center mb-0">Book your event today</p>
    <h3 class="text-center calendar-h3">Let's Plan Your Perfect Event</h3>
    <div class="container">
    <?php if (!empty($bookings)): ?>
        <?php foreach ($bookings as $booking): ?>
            <div class="card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="card-title mb-0"><?php echo htmlspecialchars($booking['full_name']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($booking['email']); ?></p>
                    </div>
                    <span class="status-badge"><?php echo htmlspecialchars($booking['status']); ?></span>
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
