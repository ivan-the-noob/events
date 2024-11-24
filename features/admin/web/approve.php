<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../users/web/login.php');
    exit();
}
require '../../../db.php';

$results_per_page = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $results_per_page;

$total_query = "SELECT COUNT(*) FROM booking WHERE status IN ('Waiting', 'On-going')";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_row();
$total_bookings = $total_row[0];
$total_pages = ceil($total_bookings / $results_per_page);

$query = "SELECT * FROM booking WHERE status IN ('Waiting', 'On-going') LIMIT $start_from, $results_per_page";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
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
            <a href="#" class="navbar-highlight">
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
            <a href="history.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>History</span>
            </a>
            <a href="events_list.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Events List</span>
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
                <h3>Pending Booking</h3>
                <input type="text" id="searchInput" class="search" placeholder="Search..">
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-booking">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type of Event</th>
                            <th scope="col">Info</th>
                            <th scope="col">Actions</th>

                        </tr>
                    </thead>
                    <tbody id="bookingTable">
                    </tbody>

                </table>
            </div>
            <div id="modalsContainer">
            </div>

            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="infoModalLabel">Event Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h5>Customer Info</h5>
                                        <div class="form-group mt-1">
                                            <label for="modal-full-name" class="form-label">Full Name</label>
                                            <input type="text" id="modal-full-name" class="form-control" readonly>
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="modal-email" class="form-label">Email</label>
                                            <input type="email" id="modal-email" class="form-control" readonly>
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="modal-phone-number" class="form-label">Phone Number</label>
                                            <input type="number" id="modal-phone-number" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-0">
                                        <h5>Event Info</h5>
                                        <div class="form-group mt-1">
                                            <label for="modal-event-type" class="form-label">Type of Event</label>
                                            <input type="text" id="modal-event-type" class="form-control" readonly>
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="modal-events-date" class="form-label">Events Date</label>
                                            <input type="text" id="modal-events-date" class="form-control" readonly>
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="modal-guest-count" class="form-label">Guest Count</label>
                                            <input type="number" id="modal-guest-count" class="form-control" readonly>
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="modal-event-duration" class="form-label">Event Duration</label>
                                            <input type="text" id="modal-event-duration" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Event Packages</h5>
                                        <div class="form-group mt-1">
                                            <label for="modal-event-package" class="form-label">Event Package</label>
                                            <input type="text" id="modal-event-package" class="form-control" readonly>
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="modal-event-options" class="form-label">Event Options</label>
                                            <input type="text" id="modal-event-options" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelectorAll('.btn.view').forEach(button => {
                        button.addEventListener('click', event => {
                            const modal = document.querySelector('#infoModal');

                            const id = button.dataset.id;
                            const fullName = button.dataset.fullName;
                            const eventType = button.dataset.eventType;
                            const email = button.dataset.email;
                            const phone = button.dataset.phone;
                            const eventsDate = button.dataset.eventsDate;
                            const guestCount = button.dataset.guestCount;
                            const eventDuration = button.dataset.eventDuration;
                            const eventPackage = button.dataset.eventPackage;
                            const eventOptions = button.dataset.eventOptions;

                            modal.querySelector('#modal-full-name').value = fullName;
                            modal.querySelector('#modal-email').value = email;
                            modal.querySelector('#modal-phone-number').value = phone;
                            modal.querySelector('#modal-event-type').value = eventType;
                            modal.querySelector('#modal-events-date').value = eventsDate;
                            modal.querySelector('#modal-guest-count').value = guestCount;
                            modal.querySelector('#modal-event-duration').value =
                                `${eventDuration} hours`;
                            modal.querySelector('#modal-event-package').value = eventPackage;
                            modal.querySelector('#modal-event-options').value = eventOptions;
                        });
                    });
                });
            </script>
            <nav aria-label="Page navigation">
                <ul class="pagination d-flex justify-content-end">
                    <?php if ($page > 1): ?>
                        <li class="page-item pg-btn">
                            <a class="page-links" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item pg-btn disabled">
                            <span class="page-links" aria-hidden="true">&laquo;</span>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item pg-btn">
                            <a class="page-links" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item pg-btn disabled">
                            <span class="page-links" aria-hidden="true">&raquo;</span>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

        </div>
        <?php $conn->close(); ?>
</body>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../function/script/status.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        function fetchResults(page = 1) {
            var searchQuery = $('#searchInput').val();
            $.ajax({
                url: '../function/php/search/search_approve.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    search: searchQuery,
                    page: page
                },
                success: function(response) {
                    $('tbody').html(response.rows);

                    $('.pagination').html(response.pagination);

                    $('#modalsContainer').html(response.modals);

                    reinitializeModals();
                }
            });
        }

        $('#searchInput').on('keyup', function() {
            fetchResults(1);
        });

        window.fetchPage = function(page) {
            fetchResults(page);
        };

        function reinitializeModals() {
            $('button[data-bs-toggle="modal"]').each(function() {
                const targetModal = $(this).data('bs-target');
                const modalInstance = bootstrap.Modal.getOrCreateInstance(document.querySelector(
                    targetModal));
                $(this).off('click').on('click', function() {
                    modalInstance.show();
                });
            });
        }

        fetchResults(1);
    });
</script>

</html>