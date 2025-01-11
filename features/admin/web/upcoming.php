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


    
                <!-- Reminders -->
                <div class="container mt-4"> 
                    <div class="d-flex justify-content-between mb-2">
                        <h3>Upcoming Events</h3>       
                </div>

                
                 
    <?php
    require '../../../db.php'; 

    $query = "SELECT full_name, event_type, events_date
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

   
        </div>
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