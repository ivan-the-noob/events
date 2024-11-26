<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../users/web/login.php');
    exit();
}
require '../../../db.php';
include '../function/php/table-dashboard.php';
include '../function/php/reminder.php';
$queryWaiting = "SELECT COUNT(*) AS waiting_count FROM booking WHERE status = 'Waiting'";
$queryDeclined = "SELECT COUNT(*) AS declined_count FROM booking WHERE status = 'Declined'";
$resultWaiting = $conn->query($queryWaiting);
$resultDeclined = $conn->query($queryDeclined);
$rowWaiting = $resultWaiting->fetch_assoc();
$rowDeclined = $resultDeclined->fetch_assoc();
$waitingCount = $rowWaiting['waiting_count'];
$declinedCount = $rowDeclined['declined_count'];
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
            <a href="calendar.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Calendar</span>
            </a>
            <a href="pending.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Pending</span>
            </a>
            <a href="approve.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Approved Booking</span>
            </a>

            <a href="packages.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Event Packages</span>
            </a>
            <a href="unavailable.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Unavailable</span>
            </a>
            <a href="history.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>History</span>
            </a>
            <div class="dropdown dropup">
                <a href="#" class="navbar-highlight dropdown-toggle" id="eventsListDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-tachometer-alt"></i>
                    <span>Events List</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="eventsListDropdown">
                    <li><a class="dropdown-item" href="events_list.php">Events List</a></li>
                    <li><a class="dropdown-item" href="package_list.php">Package List</a></li>
                    <li><a class="dropdown-item" href="extra.php">Extra</a></li>
                    <li><a class="dropdown-item" href="pax.php">Pax</a></li>
                </ul>
            </div>
            <a href="admin-user.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Manage Admin Users</span>
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
                        <li><a class="dropdown-item" href="../../users/function/authentication/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="container mt-4">
            <h3>Dashboard</h3>
            <div class="row">
                <div class="col-md-2">
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
                                    <p class="mb-1">Approved Books</p>
                                    <h5><?php echo $waitingCount; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-0 mt-2">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="col-md-12">
                                    <p class="mb-1">Cancelled Books</p>
                                    <h5><?php echo $declinedCount ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mt-2 d-flex justify-content-center">
                    <div class="chart-container">
                        <h5 class="chart-title">Monthly Sales</h5>
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
                <div class="col-md-5 mt-2  d-flex justify-content-center">
                    <div class="chart-container">
                        <h5 class="chart-title">Yearly Sales</h5>
                        <canvas id="yearlySalesChart"></canvas>
                    </div>
                </div>
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
                                        <td class="bg-warnings"><?php echo htmlspecialchars($booking['status']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="approve.php" class="d-flex justify-content-center text-decoration-none mt-2">Show all</a>

                    <h5 class="mt-4">Cancelled Bookings</h5>
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
                                <?php foreach ($bookings_declined as $booking): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['events_date']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['event_type']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['guest_count']); ?></td>
                                        <td>₱100</td>
                                        <td class="bg-declines"><?php echo htmlspecialchars($booking['status']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="cancel.php" class="d-flex justify-content-center text-decoration-none mt-2">Show all</a>
                </div>

                <!-- Reminders -->
                <div class="col-md-3 mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <h5 class="mt-0 d-flex align-items-center mb-0">Reminders</h5>
                        <button class="reminder-notif"> <i class="fa-regular fa-bell fa-xl"></i></button>
                    </div>
                    <div class="card-container" style="height: 50vh; overflow-y: auto; padding: 10px;">
                        <?php
                        if ($result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                        ?>
                                <div class="col-md-12 mb-2">
                                    <div class="card p-0">
                                        <div class="card-body d-flex justify-content-between gap-3">
                                            <div class="event-content">
                                                <p class="mb-0 date-detail"><?php echo htmlspecialchars($row['description']); ?>
                                                </p>
                                                <p class="mb-0 date">
                                                    <?php echo htmlspecialchars(date('F j, Y', strtotime($row['date']))); ?></p>
                                                <div class="d-flex align-items-center gap-1">
                                                    <p class="mb-0 date">
                                                        <?php echo htmlspecialchars(date('g:i A', strtotime($row['start_time']))); ?>
                                                    </p> -
                                                    <p class="mb-0 date">
                                                        <?php echo htmlspecialchars(date('g:i A', strtotime($row['finish_time']))); ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="event-button">
                                                <button class="d-flex justify-content-center mx-auto">
                                                    <i class="fa fa-ellipsis-vertical fa-xl"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                        else:
                            ?>
                            <p>Empty Reminders.</p>
                        <?php
                        endif;
                        ?>
                        <button class="reminder-btn mt-3" data-bs-toggle="modal" data-bs-target="#addReminderModal">+
                            Add Reminder</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Reminder Modal -->
        <div class="modal fade" id="addReminderModal" tabindex="-1" aria-labelledby="addReminderModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="../function/php/add_reminder.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addReminderModalLabel">Add Reminder</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <select class="form-control" id="start_time" name="start_time" required>
                                    <?php
                                    for ($hour = 8; $hour <= 23; $hour++) {
                                        $formatted_time = date('h:i A', strtotime("$hour:00"));
                                        echo "<option value='" . date('H:i', strtotime("$hour:00")) . "'>$formatted_time</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="finish_time" class="form-label">Finish Time</label>
                                <input type="time" class="form-control" id="finish_time" name="finish_time" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Reminder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('start_time').addEventListener('change', function() {
                const startTime = this.value; // Get selected start time (HH:MM)
                const [hour, minute] = startTime.split(':').map(Number); // Split into hour and minute

                const finishTime = new Date();
                finishTime.setHours(hour + 5, minute); // Add 5 hours to the start time

                // Correctly format finish time to HH:MM
                const formattedFinishTime = finishTime.toTimeString().slice(0, 5); // Get HH:MM in 24-hour format
                document.getElementById('finish_time').value = formattedFinishTime;
            });
        </script>





</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../function/script/month-chart.js"></script>
<script src="../function/script/year-chart.js"></script>
<script src="../function/script/status.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</html>