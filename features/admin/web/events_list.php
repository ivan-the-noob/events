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

$query = "SELECT * FROM event_list";
$result = $conn->query($query);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List | Admin</title>
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
                <span>Pending Booking</span>
            </a>
            <a href="approve.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Approved Booking</span>
            </a>
            <a href="refund.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Refund Pending</span>
            </a>
            <a href="cancel.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Cancelled Booking</span>
            </a>

            <a href="unavailable.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Unavailable</span>
            </a>
            <a href="invoice.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Invoice</span>
            </a>
            <a href="reviews.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Reviews</span>
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
                    <li><a class="dropdown-item" href="events_list.php" class="navbar-highlight">Events List</a></li>
                    <li><a class="dropdown-item" href="package_list.php">Package List</a></li>
                    <li><a class="dropdown-item" href="extra.php">Extra</a></li>
                    <li><a class="dropdown-item" href="pax.php">Pax</a></li>
                    <li><a class="dropdown-item" href="dish.php">Dish</a></li>
                </ul>
            </div>         
            <a href="admin-user.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Manage Admin Users</span>
            </a>
            <div class="dropdown dropup">
                <a href="#" class="dropdown-toggle" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-tachometer-alt"></i>
                    <span>CMS</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                    <li><a class="dropdown-item" href="front_cms.php">Front CMS</a></li>
                    <li><a class="dropdown-item" href="scope_service.php">Scope Service</a></li>
                    <li><a class="dropdown-item" href="extras.php">Extras</a></li>
                </ul>
            </div>
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
                <h3>Event List</h3>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#events_list">+
                        Add</button>
                    <input type="text" class="search" placeholder="Search.." id="searchInput">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Event Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['type_of_event']); ?></td>
                                <td>
                                    <button class="btn btn-warning edit-btn" data-id="<?php echo $row['id']; ?>"
                                        data-event_name="<?php echo htmlspecialchars($row['type_of_event']); ?>"
                                        data-bs-toggle="modal" data-bs-target="#events_list">Edit</button>
                                    <form method="POST" action="../function/php/event_list.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="action" value="delete"
                                            class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div class="modal fade" id="events_list" tabindex="-1" aria-labelledby="events_listLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="events_listLabel">Manage Event</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form method="POST" action="../function/php/event_list.php">
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="eventPackageId">
                                    <div class="mb-3">
                                        <label for="eventName" class="form-label">Event Name</label>
                                        <input type="text" class="form-control" id="eventName" name="type_of_event"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="action" value="add"
                                        class="btn btn-primary">Save</button>
                                    <button type="submit" name="action" value="edit" class="btn btn-success d-none"
                                        id="editBtn">Update</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <nav aria-label="Page navigation">
                    <ul class="pagination d-flex justify-content-end">
                        <?php if ($page > 1): ?>
                            <li class="page-item pg-btn"><a class="page-links"
                                    href="?page=<?php echo $page - 1; ?>">&laquo;</a></li>
                        <?php else: ?>
                            <li class="page-item pg-btn disabled"><span class="page-links">&laquo;</span></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item pg-btn"><a class="page-links"
                                    href="?page=<?php echo $page + 1; ?>">&raquo;</a></li>
                        <?php else: ?>
                            <li class="page-item pg-btn disabled"><span class="page-links">&raquo;</span></li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <script>
                    document.querySelectorAll('.edit-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const id = this.getAttribute('data-id');
                            const eventName = this.getAttribute('data-event_name');

                            document.getElementById('eventPackageId').value = id;
                            document.getElementById('eventName').value = eventName;

                            document.getElementById('editBtn').classList.remove('d-none');
                        });
                    });

                    document.getElementById('events_list').addEventListener('hidden.bs.modal', function() {
                        document.getElementById('eventPackageId').value = '';
                        document.getElementById('eventName').value = '';
                        document.getElementById('editBtn').classList.add('d-none');
                    });
                </script>




                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <script src="../function/script/status.js"></script>

</html>