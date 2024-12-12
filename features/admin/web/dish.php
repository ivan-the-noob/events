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

$query = "SELECT * FROM dishes";
$result = $conn->query($query);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dish | Admin</title>
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
                    <li><a class="dropdown-item" href="events_list.php">Events List</a></li>
                    <li><a class="dropdown-item" href="package_list.php">Package List</a></li>
                    <li><a class="dropdown-item" href="extra.php" class="navbar-highlight">Extra</a></li>
                    <li><a class="dropdown-item" href="pax.php">Pax</a></li>
                    <li><a class="dropdown-item" href="dish.php">Dish</a></li>
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
            <div class="d-flex justify-content-between mb-2">
                <h3>Dishes</h3>
                <div class="d-flex gap-2">
                <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#dishes_list">
                    + Add Dish
                </button>

                    <input type="text" class="search" placeholder="Search.." id="searchInput">
                </div>
            </div>
            <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Category</th>
                        <th scope="col">Dish Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><?php echo htmlspecialchars($row['dish_name']); ?></td>
                            <td>
                                <button class="btn btn-warning edit-btn" 
                                    data-id="<?php echo $row['id']; ?>"
                                    data-category="<?php echo htmlspecialchars($row['category']); ?>"
                                    data-dish_name="<?php echo htmlspecialchars($row['dish_name']); ?>"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#dishes_list">Edit</button>
                                <form method="POST" action="../function/php/dishes.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

<!-- Modal for Add/Edit Event -->
<div class="modal fade" id="dishes_list" tabindex="-1" aria-labelledby="dishes_listLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dishes_listLabel">Manage Dishes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="../function/php/dishes.php">
                <div class="modal-body">
                    <input type="hidden" name="id" id="dishId">
                    <div class="form-group mt-4">
                        <label for="dish-category" class="form-label">Category</label>
                        <select id="dish-category" name="category" class="form-control" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="beef">Beef</option>
                            <option value="pork">Pork</option>
                            <option value="chicken">Chicken</option>
                            <option value="pasta">Pasta</option>
                            <option value="dessert">Dessert</option>
                            <option value="fish">Fish</option>
                            <option value="drinks">Drinks</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dish-name" class="form-label">Dish Name</label>
                        <input type="text" class="form-control" id="dish-name" name="dish_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="action" value="add" class="btn btn-primary">Save</button>
                    <button type="submit" name="action" value="edit" class="btn btn-success d-none" id="editBtn">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>


<nav aria-label="Page navigation">
    <ul class="pagination d-flex justify-content-end">
    </ul>
</nav>

<script>
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const category = this.getAttribute('data-category');
            const dishName = this.getAttribute('data-dish_name');

            // Populate modal fields
            document.getElementById('dishId').value = id;
            document.getElementById('dish-category').value = category;
            document.getElementById('dish-name').value = dishName;

            // Show Update button and hide Add button
            document.getElementById('editBtn').classList.remove('d-none');
        });
    });
</script>







                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <script src="../function/script/status.js"></script>

</html>