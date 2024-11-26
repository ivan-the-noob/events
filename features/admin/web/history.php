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
$total_query = "SELECT COUNT(*) as total FROM booking";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
$query = "SELECT * FROM booking LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

$query = "SELECT * FROM booking WHERE status = 'finished'";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <!--Navigation Links-->
    <div class="navbar flex-column bg-white shadow-sm p-3 collapse d-md-flex" id="navbar">
        <div class="navbar-links">
            <a class="navbar-brand d-none d-md-block logo-container" href="#">
                <img src="../../../assets/logo.png" alt="Logo">
            </a>
            <a href="dashboard.php">
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
            <a href="cancel.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Cancelled Booking</span>
            </a>
            <a href="packages.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Event Packages</span>
            </a>
            <a href="unavailable.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Unavailable</span>
            </a>
            <a href="#" class="navbar-highlight">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>History</span>
            </a>
            <a href="events_list.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Events List</span>
            </a>
            <a href="package_list.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Package List</span>
            </a>
            <a href="pax.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Pax</span>
            </a>
            <a href="extra.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Extra</span>
            </a>
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
            <div class="d-flex justify-content-between mb-2">
                <h3>History</h3>
                <input type="text" class="search" placeholder="Search.." id="searchInput">
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-booking">
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type of Event</th>
                            <th scope="col">Info</th>
                            <th scope="col">Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo date("F j, Y", strtotime($row['events_date'])); ?></td>
                                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['event_type']); ?></td>
                                <td>
                                    <button type="button" class="btn view " data-bs-toggle="modal"
                                        data-bs-target="#infoModal<?php echo $row['id']; ?>">
                                        View
                                    </button>
                                </td>
                                <td>
                                    <p class="done">Done</p>
                                </td>

                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="infoModal<?php echo $row['id']; ?>" tabindex="-1"
                                aria-labelledby="infoModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="infoModalLabel<?php echo $row['id']; ?>">Event
                                                Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h5>Customer Info</h5>
                                                        <div class="form-group mt-1">
                                                            <label for="full-name" class="form-label">Full Name</label>
                                                            <input type="text" id="full-name" name="full_name"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($row['full_name']); ?>"
                                                                readonly>
                                                        </div>
                                                        <div class="form-group mt-1">
                                                            <label for="celebrants-name" class="form-label">Celebrant's
                                                                Name</label>
                                                            <input type="text" id="celebrants-name" name="celebrants_name"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($row['celebrants_name']); ?>"
                                                                readonly>
                                                        </div>
                                                        <div class="form-group mt-1">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" id="email" name="email" class="form-control"
                                                                value="<?php echo htmlspecialchars($row['email']); ?>"
                                                                readonly>
                                                        </div>
                                                        <div class="form-group mt-1">
                                                            <label for="phone-number" class="form-label">Phone
                                                                Number</label>
                                                            <input type="number" id="phone-number" name="phone_number"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($row['phone_number']); ?>"
                                                                readonly>
                                                        </div>
                                                        <h5 class="events">Event Info</h5>
                                                        <div class="form-group mt-1">
                                                            <label for="events-date" class="form-label">Events Date</label>
                                                            <input type="text" id="events-date" name="events_date"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($row['events_date']); ?>"
                                                                readonly>
                                                        </div>
                                                        <div class="form-group mt-1">
                                                            <label for="guess-count" class="form-label">Guest Count</label>
                                                            <input type="number" id="guess-count" name="guest_count"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($row['guest_count']); ?>"
                                                                readonly>
                                                        </div>
                                                        <div class="form-group mt-1">
                                                            <label for="event-duration" class="form-label">Event
                                                                Duration</label>
                                                            <input type="text" id="event-duration" name="event_duration"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($row['event_duration']); ?> hours"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-group mt-4">
                                                            <label for="event-starttime" class="form-label">Event Start
                                                                Time</label>
                                                            <input type="text" id="event-starttime" name="event_starttime"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($row['event_starttime']); ?>:00"
                                                                readonly>
                                                        </div>

                                                        <div class="form-group mt-1">
                                                            <label for="event-endtime" class="form-label">Event End
                                                                Time</label>
                                                            <input type="text" id="event-endtime" name="event_endtime"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($row['event_endtime']); ?>:00"
                                                                readonly>
                                                        </div>
                                                        <h5 class=" eventss">Event Selection</h5>
                                                        <div class="form-group">
                                                            <label for="event-type" class="form-label">Type of Event</label>
                                                            <input type="text" id="event-type" name="event_type"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($row['event_type']); ?>"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5 class="">Event Packages</h5>
                                                        <div class="form-group mt-1">
                                                            <label for="event-package" class="form-label">Event
                                                                Package</label>
                                                            <input type="text" id="event-package" name="event_package"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($row['event_package']); ?>"
                                                                readonly>
                                                        </div>
                                                        <div class="form-group mt-1">
                                                            <label for="event-options" class="form-label">Event
                                                                Options</label>
                                                            <input type="text" id="event-options" name="event_options"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($row['event_options']); ?>"
                                                                readonly>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
            </div>
        <?php endwhile; ?>
        </tbody>
        </table>
        </div>
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
                } else {
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
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

</html>