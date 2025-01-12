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

$query = "SELECT * FROM event_packages";
$result = $conn->query($query);




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
        <div class="navbar flex-column shadow-sm p-3 collapse show" id="navbar">
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
                <a href="upcoming.php">
                    <i class="fa-solid fa-calendar-day"></i>
                    <span>Upcoming Booking</span>
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
                    <a href="#" class="dropdown-toggle navbar-highlight" id="eventsListDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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


        <div class="container mt-4">
            <div class="d-flex justify-content-between mb-2">
                <h3>Package List</h3>
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
                    <th scope="col">Image</th>
                    <th scope="col">Event Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $query = "SELECT * FROM event_packages ORDER BY id DESC";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()): 
            ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['package_image'])): ?>
                                <img src="../../../assets/packages/<?php echo htmlspecialchars($row['package_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Package Image" style="width: 50px; height: 50px;">
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['type_of_event'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>₱<?php echo number_format(htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8'), 0, '.', ','); ?></td>
                        <td>
                            <button class="btn btn-warning edit-btn" data-id="<?php echo $row['id']; ?>" 
                                    data-event_name="<?php echo htmlspecialchars($row['type_of_event'], ENT_QUOTES, 'UTF-8'); ?>" 
                                    data-description="<?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'); ?>" 
                                    data-price="<?php echo htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8'); ?>" 
                                    data-image="<?php echo htmlspecialchars($row['package_image'], ENT_QUOTES, 'UTF-8'); ?>" 
                                    data-bs-toggle="modal" data-bs-target="#events_list">
                                Edit
                            </button>
                            <form method="POST" action="../function/php/event_packages.php"  enctype="multipart/form-data" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            </table>



            <div class="modal fade" id="events_list" tabindex="-1" aria-labelledby="events_listLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="events_listLabel">Manage Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="../function/php/event_packages.php" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="id" id="packageId">
                                <div class="mb-3">
                                    <label for="packageName" class="form-label">Event</label>
                                    <select class="form-control" id="packageName" name="type_of_event" required>
                                        <option value="" disabled selected>Select an event</option>
                                        <?php
                                        require '../../../db.php';
                                        $query = "SELECT id, type_of_event FROM event_list";
                                        $result = $conn->query($query);
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $eventTypeFormatted = strtolower(str_replace([' ', '/'], ['-', ''], $row['type_of_event']));
                                                echo '<option value="' . htmlspecialchars($row['type_of_event']) . '" data-type="' . $eventTypeFormatted . '">' 
                                                    . htmlspecialchars($row['type_of_event']) 
                                                    . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled>No events available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="currentImage" class="form-label">Current Image</label>
                                    <div id="currentImageContainer">
                                        <img id="currentImage" src="" alt="Current Event Image" class="img-fluid" style="max-width: 100%; height: auto;">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="packageImage" class="form-label">Package Image</label>
                                    <input type="file" class="form-control" id="packageImage" name="package_image" accept="image/*">
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" name="action" value="add" class="btn btn-primary">Add</button>
                                <button type="submit" name="action" value="edit" class="btn btn-success d-none" id="editPackageBtn">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                        const row = this.closest('tr');
                        const description = row.querySelector('td:nth-child(3)').textContent; // 3rd column for description
                        const price = row.querySelector('td:nth-child(4)').textContent.replace('₱', '').replace(',', ''); // 4th column for price
                        const imageUrl = row.querySelector('td:nth-child(1) img') ? row.querySelector('td:nth-child(1) img').src : ''; // 1st column for image

                        document.getElementById('packageId').value = id;
                        document.getElementById('packageName').value = eventName;
                        document.getElementById('description').value = description;
                        document.getElementById('price').value = price;

                        const currentImageElement = document.getElementById('currentImage');
                        if (imageUrl) {
                            currentImageElement.src = imageUrl;
                            currentImageElement.style.display = 'block'; 
                        } else {
                            currentImageElement.src = ''; 
                            currentImageElement.style.display = 'none'; 
                        }

                        document.getElementById('editPackageBtn').classList.remove('d-none');
                        document.querySelector('button[name="action"][value="add"]').classList.add('d-none');
                    });
                });
                </script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <script src="../function/script/status.js"></script>
                <script src="../function/script/nav-toggle.js"></script>


</html>