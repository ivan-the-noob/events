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

$query = "SELECT SUM(cost) AS payment_amount FROM booking WHERE status = 'Finished'";
$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $payment_amount = $row['payment_amount'];
} else {
    $payment_amount = 0; 
}

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
    
    <link rel="stylesheet" href="../css/index.css">
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
                <a href="dashboard.php">
                    <i class="fa-solid fa-chart-line"></i>
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
                <a href="upcoming.php" class="navbar-highlight">
                    <i class="fa-solid fa-calendar-day "></i>
                    <span>Upcoming Booking</span>
            
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
                    <button class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                             <img src="../../../assets/logo.png" 
                                style="width: 40px; height: 40px; object-fit: cover;">
                        </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../../users/function/authentication/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


    
                <!-- Reminders -->
                <div class="container mt-4"> 
                    <div class="d-flex justify-content-between mb-2">
                        <h3>Upcoming Events</h3>       
                </div>

                
                 
                <?php
require '../../../db.php'; 

$query = "SELECT *
          FROM booking
          WHERE events_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)";
$result = mysqli_query($conn, $query);

$upcomingEvents = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $upcomingEvents[] = $row;   
    }
} else {
    $upcomingEvents = null;  
}
?>

<div class="row">
    <?php if ($upcomingEvents): ?>
        <?php foreach ($upcomingEvents as $event): ?>
            <div class="col-md-4 mb-4">
                <div class="card-c">
                    <div class="card-body">
                        <h5 class="card-title text-center">Event's Date: <?php echo htmlspecialchars($event['events_date']); ?></h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Full Name:</strong> <?php echo htmlspecialchars($event['full_name']); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Event Type:</strong> <?php echo htmlspecialchars($event['event_type']); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Event's Date:</strong> <?php echo htmlspecialchars($event['events_date']); ?>
                            </li>
                        </ul>
                        <button class="btn btn-primary m-2 d-flex mx-auto" 
                            data-bs-toggle="modal" 
                            data-bs-target="#eventModal" 
                            data-celebrants-name="<?php echo htmlspecialchars($event['celebrants_name']); ?>" 
                            data-phone-number="<?php echo htmlspecialchars($event['phone_number']); ?>" 
                            data-email="<?php echo htmlspecialchars($event['email']); ?>" 
                            data-events-date="<?php echo htmlspecialchars($event['events_date']); ?>" 
                            data-guest-count="<?php echo htmlspecialchars($event['guest_count']); ?>" 
                            data-event-starttime="<?php echo htmlspecialchars($event['event_starttime']); ?>" 
                            data-event-options="<?php echo htmlspecialchars($event['event_options']); ?>" 
                            data-reference-no="<?php echo htmlspecialchars($event['reference_no']); ?>" 
                            data-cost="<?php echo htmlspecialchars($event['cost']); ?>" 
                            data-payment-amount="<?php echo htmlspecialchars($event['payment_amount']); ?>" 
                            data-beef-dish="<?php echo htmlspecialchars($event['beef_dish']); ?>" 
                            data-pork-dish="<?php echo htmlspecialchars($event['pork_dish']); ?>" 
                            data-chicken-dish="<?php echo htmlspecialchars($event['chicken_dish']); ?>" 
                            data-pasta-dish="<?php echo htmlspecialchars($event['pasta_dish']); ?>" 
                            data-dessert-dish="<?php echo htmlspecialchars($event['dessert_dish']); ?>" 
                            data-fish-dish="<?php echo htmlspecialchars($event['fish_dish']); ?>" 
                            data-drinks-dish="<?php echo htmlspecialchars($event['drinks_dish']); ?>">
                            View Full Info
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-md-12">
            <p class="text-muted text-center">No upcoming events within the next 3 days.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Event Details Section -->
                <h5 class="text-primary">Event Details</h5>
                <p><strong>Celebrant's Name:</strong> <span id="modalCelebrantsName"></span></p>
                <p><strong>Phone Number:</strong> <span id="modalPhoneNumber"></span></p>
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                <p><strong>Event Date:</strong> <span id="modalEventDate"></span></p>
                <p><strong>Guest Count:</strong> <span id="modalGuestCount"></span> guests</p>
                <p><strong>Event Start Time:</strong> <span id="modalEventStartTime"></span>:00</p>
                <p><strong>Event Options:</strong> <span id="modalEventOptions"></span></p>
                <p><strong>Reference No:</strong> <span id="modalReferenceNo"></span></p>
                <p><strong>Total Cost:</strong> ₱<span id="modalTotalCost"></span></p>
                <p><strong>Remaining Balance:</strong> ₱<span id="modalRemainingBalance"></span></p>

                <!-- Food Details Section -->
                <h5 class="text-primary mt-4">Food Details</h5>
                <p><strong>Beef Dish:</strong> <span id="modalBeefDish"></span></p>
                <p><strong>Pork Dish:</strong> <span id="modalPorkDish"></span></p>
                <p><strong>Chicken Dish:</strong> <span id="modalChickenDish"></span></p>
                <p><strong>Pasta Dish:</strong> <span id="modalPastaDish"></span></p>
                <p><strong>Dessert Dish:</strong> <span id="modalDessertDish"></span></p>
                <p><strong>Fish Dish:</strong> <span id="modalFishDish"></span></p>
                <p><strong>Drinks:</strong> <span id="modalDrinksDish"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    const eventModal = document.getElementById('eventModal');
    eventModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const celebrantsName = button.getAttribute('data-celebrants-name');
        const phoneNumber = button.getAttribute('data-phone-number');
        const email = button.getAttribute('data-email');
        const eventDate = button.getAttribute('data-events-date');
        const guestCount = button.getAttribute('data-guest-count');
        const eventStartTime = button.getAttribute('data-event-starttime');
        const eventOptions = button.getAttribute('data-event-options');
        const referenceNo = button.getAttribute('data-reference-no');
        const totalCost = button.getAttribute('data-cost');
        const paymentAmount = button.getAttribute('data-payment-amount');
        const remainingBalance = parseFloat(totalCost) - parseFloat(paymentAmount);

        const beefDish = button.getAttribute('data-beef-dish');
        const porkDish = button.getAttribute('data-pork-dish');
        const chickenDish = button.getAttribute('data-chicken-dish');
        const pastaDish = button.getAttribute('data-pasta-dish');
        const dessertDish = button.getAttribute('data-dessert-dish');
        const fishDish = button.getAttribute('data-fish-dish');
        const drinksDish = button.getAttribute('data-drinks-dish');

        document.getElementById('modalCelebrantsName').textContent = celebrantsName;
        document.getElementById('modalPhoneNumber').textContent = phoneNumber;
        document.getElementById('modalEmail').textContent = email;
        document.getElementById('modalEventDate').textContent = eventDate;
        document.getElementById('modalGuestCount').textContent = guestCount;
        document.getElementById('modalEventStartTime').textContent = eventStartTime;
        document.getElementById('modalEventOptions').textContent = eventOptions;
        document.getElementById('modalReferenceNo').textContent = referenceNo;
        document.getElementById('modalTotalCost').textContent = parseFloat(totalCost).toFixed(2);
        document.getElementById('modalRemainingBalance').textContent = remainingBalance.toFixed(2);

        document.getElementById('modalBeefDish').textContent = beefDish;
        document.getElementById('modalPorkDish').textContent = porkDish;
        document.getElementById('modalChickenDish').textContent = chickenDish;
        document.getElementById('modalPastaDish').textContent = pastaDish;
        document.getElementById('modalDessertDish').textContent = dessertDish;
        document.getElementById('modalFishDish').textContent = fishDish;
        document.getElementById('modalDrinksDish').textContent = drinksDish;
    });
</script>

</div>

    </div>
</div>




        <script>
            document.getElementById('start_time').addEventListener('change', function() {
                const startTime = this.value; 
                const [hour, minute] = startTime.split(':').map(Number);

                const finishTime = new Date();
                finishTime.setHours(hour + 5, minute); 

                const formattedFinishTime = finishTime.toTimeString().slice(0, 5);
                document.getElementById('finish_time').value = formattedFinishTime;
            });
        </script>





</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../function/script/daily-chart.js"></script>
<script src="../function/script/month-chart.js"></script>
<script src="../function/script/status.js"></script>
<script src="../function/script/pie-chart.js"></script>
<script src="../function/script/nav-toggle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</html>