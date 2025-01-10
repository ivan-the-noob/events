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

$query = "SELECT * FROM unavailable_days";
$result = $conn->query($query);

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
                    <i class="fa-solid fa-gauge-high"></i>
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
                <a href="unavailable.php" class="navbar-highlight">
                    <i class="fa-solid fa-exclamation-circle"></i>
                    <span>Unavailable</span>
                </a>
                <a href="invoice.php">
                    <i class="fa-solid fa-file-invoice"></i>
                    <span>Invoice</span>
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


        <div class="container mt-4">
            <div class="d-flex justify-content-between mb-2">
                <h3>Unavailable Days</h3>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary add-btn" data-bs-toggle="modal"
                        data-bs-target="#unavailableDaysModal">+ Add</button>
                    <input type="text" class="search" placeholder="Search.." id="searchInput">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?php echo date("F j, Y", strtotime($row['date'])); ?></td>
                                <td><?php echo htmlspecialchars($row['reason']); ?></td>
                                <td>
                                    <button class="btn btn-warning edit-btn" data-id="<?php echo $row['id']; ?>"
                                        data-date="<?php echo $row['date']; ?>"
                                        data-reason="<?php echo htmlspecialchars($row['reason']); ?>" data-bs-toggle="modal"
                                        data-bs-target="#unavailableDaysModal">Edit</button>
                                    <form method="POST" action="../function/php/unavailable.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="action" value="delete"
                                            class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="modal fade" id="unavailableDaysModal" tabindex="-1" aria-labelledby="unavailableDaysModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="unavailableDaysModalLabel">Add Unavailable Day</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="../function/php/unavailable.php">
                            <div class="modal-body">
                                <input type="hidden" name="id" id="unavailableDayId">
                                <!-- Hidden input for Edit/Update -->
                                <div class="mb-3">
                                    <label for="unavailableDate" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="unavailableDate" name="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Reason</label>
                                    <textarea class="form-control" id="reason" name="reason" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="action" value="add" class="btn btn-primary">Save</button>
                                <button type="submit" name="action" value="edit" class="btn btn-success d-none"
                                    id="editBtn">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
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
<script>
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const date = this.getAttribute('data-date');
            const reason = this.getAttribute('data-reason');

            document.getElementById('unavailableDayId').value = id;
            document.getElementById('unavailableDate').value = date;
            document.getElementById('reason').value = reason;

            document.getElementById('editBtn').classList.remove('d-none');
        });
    });

    // Reset Modal on Close
    document.getElementById('unavailableDaysModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('unavailableDayId').value = '';
        document.getElementById('unavailableDate').value = '';
        document.getElementById('reason').value = '';
        document.getElementById('editBtn').classList.add('d-none');
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../function/script/status.js"></script>
<script src="../function/script/nav-toggle.js"></script>


</html>