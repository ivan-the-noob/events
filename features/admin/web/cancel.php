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

$declined_query = "SELECT * FROM booking WHERE status = 'declined' LIMIT $limit OFFSET $offset";
$declined_result = $conn->query($declined_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelled | Admin</title>
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
            <a href="#" class="navbar-highlight">
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
                <h3>Cancelled Booking</h3>
                <input type="text" class="search" placeholder="Search.." id="searchInput">
            </div>

            <div class="table-responsive">
                <table class="table" id="bookingTable">
                    <thead class="table-booking">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type of Event</th>
                            <th scope="col">Reason</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['event_type']); ?></td>
                                <td>
                                    <p>Dummy Reason.</p>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <script>
                const searchInput = document.getElementById('searchInput');
                const tableBody = document.getElementById('tableBody');
                const rows = tableBody.getElementsByTagName('tr');

                // Listen for input in the search field and trigger table filtering
                searchInput.addEventListener('input', function() {
                    const searchTerm = searchInput.value.toLowerCase();

                    // Loop through table rows
                    for (let row of rows) {
                        const cells = row.getElementsByTagName('td');
                        let rowText = '';

                        // Loop through each cell in the row and concatenate the text content
                        for (let cell of cells) {
                            rowText += cell.textContent.toLowerCase() + ' ';
                        }

                        // If the row's text content matches the search term, display it; otherwise, hide it
                        if (rowText.includes(searchTerm)) {
                            row.style.display = ''; // Show row
                        } else {
                            row.style.display = 'none'; // Hide row
                        }
                    }
                });
            </script>
            <nav aria-label="Page navigation">
                <ul class="pagination d-flex justify-content-end">
                    <?php if ($page > 1): ?>
                        <li class="page-item pg-btn"><a class="page-links" href="?page=<?php echo $page - 1; ?>">&laquo;</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item pg-btn disabled"><span class="page-links">&laquo;</span></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item pg-btn"><a class="page-links" href="?page=<?php echo $page + 1; ?>">&raquo;</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item pg-btn disabled"><span class="page-links">&raquo;</span></li>
                    <?php endif; ?>
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