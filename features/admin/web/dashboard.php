<?php
    session_start();
    require '../../../db.php';
    $query = "SELECT COUNT(*) AS total_users FROM users WHERE role = 'users'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$total_users = $row['total_users'];

// Fetch total admins with role 'admin'
$query_admins = "SELECT COUNT(*) AS total_admin FROM users WHERE role = 'admin'";
$result_admins = $conn->query($query_admins);
$row_admins = $result_admins->fetch_assoc();
$total_admin = $row_admins['total_admin'];

// Function to get the latest 3 'Waiting' bookings
function getLatestWaitingBookings($conn) {
    $query = "SELECT * FROM booking WHERE status = 'Waiting' ORDER BY id DESC LIMIT 3";
    $result = $conn->query($query);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get the latest 3 'Declined' bookings
function getLatestDeclinedBookings($conn) {
    $query = "SELECT * FROM booking WHERE status = 'Declined' ORDER BY id DESC LIMIT 3";
    $result = $conn->query($query);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

try {
    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Fetch the latest 'Waiting' bookings
    $bookings_waiting = getLatestWaitingBookings($conn);

    // Fetch the latest 'Declined' bookings
    $bookings_declined = getLatestDeclinedBookings($conn);

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
    

    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <!--Navigation Links-->
    <div class="navbar flex-column bg-white shadow-sm p-3 collapse d-md-flex" id="navbar">
        <div class="navbar-links">
            <a class="navbar-brand d-none d-md-block logo-container" href="#">
                <img src="../../../assets/logo.png" alt="Logo">
            </a>
            <a href="#dashboard" class="navbar-highlight">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            
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
                        <li><a class="dropdown-item" href="../../users/web/api/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

      
        <div class="container mt-4">
            <h3>Dashboard</h3>
            <div class="row">
                <div class="col-md-2 total">
                    <div class="card p-0 mt-2">                        
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="col-md-12">
                                    <p class="mb-1">Total Sales</p>
                                    <h5>₱518, 024</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-0 mt-2">                        
                        <div class="card-body">
                            <div class="d-flex">
                                    <div class="col-md-12">
                                        <p class="mb-1">Approved Book</p>
                                        <h5>27</h5>
                                    </div>
                                </div>
                            </div>                          
                    </div>
                    <div class="card p-0 mt-2 ">                        
                        <div class="card-body">
                            <div class="d-flex">
                                    <div class="col-md-12">
                                        <p class="mb-1">Cancelled Book</p>
                                        <h5>4</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 mt-2">
                        <div class="chart-container">
                            <h5 class="chart-title">Monthly Sales</h5>
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div> 
                    <div class="col-md-5 mt-2">
                        <div class="chart-container">
                            <h5 class="chart-title">Yearly Sales</h5>
                            <canvas id="yearlySalesChart"></canvas>
                        </div>
                    </div>    
                </div>  
                <div class="row">
                    <div class="col-md-9 mt-4">
                        <h5>Approve Bookings</h5>
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
                                        <td><?php echo htmlspecialchars($booking['status']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-3 mt-4">
                        <h5 class="mt-0">Reminders</h5>
                        <div class="card p-0">
                            <div class="card-body d-flex justify-content-center gap-3">
                                <div class="event-content">
                                    <p class="mb-0">Ericka's 18th Birthday</p>
                                    <p class="mb-0">1:00 PM - 6:00 PM</p>
                                </div>
                                <div class="event-button">
                                    <button class="d-flex justfy-content-center mx-auto">:</button>
                                </div>
                            </div>
                        </div>
                        <button class="reminder-btn">+ Add Reminder</button>
                    </div>
                        <div class="col-md-9 mt-3">
                        <h5>Cancelled Bookings</h5>
                            <div class="card">
                            <table class="table">
                        <thead class="">
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
                                <td><?php echo htmlspecialchars($booking['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                            </div>
                        </div>  
                
                </div>          
            </div> 
             
          
        </div>


        
        </body>      
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../function/script/month-chart.js"></script>
        <script src="../function/script/year-chart.js"></script>
        <script src="../function/script/status.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</html>