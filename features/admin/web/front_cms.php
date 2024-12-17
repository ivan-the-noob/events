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
$total_query = "SELECT COUNT(*) as total FROM users";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
$query = "SELECT * FROM booking LIMIT $limit OFFSET $offset";
$result = $conn->query($query);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Admin</title>
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
                <a href="#" class=" dropdown-toggle" id="eventsListDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-tachometer-alt"></i>
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
            <a href="#">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Manage Admin Users</span>
            </a>
            <div class="dropdown dropup" >
                <a href="#" class="navbar-highlight dropdown-toggle" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-tachometer-alt"></i>
                    <span>CMS</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                    <li><a class="dropdown-item" href="front_cms.php" >Front CMS</a></li>
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

        <section class="cms">
        <h3 class="p-4">SYSTEM Settings</h3>
        <?php
            require '../../../db.php';
            $query = "SELECT * FROM cms LIMIT 1"; 
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if (!$row) {
                echo "Data not found.";
                exit();
            }
        ?>
        <form action="../function/php/update_cms.php" method="POST" enctype="multipart/form-data">
            <div class="container mt-4 p-4">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="system_name" class="form-label">System Name:</label>
                            <input type="text" class="form-control" id="system_name" name="system_name" value="<?php echo htmlspecialchars($row['system_name']); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="front_line" class="form-label">Front Line:</label>
                            <textarea class="form-control" id="front_line" name="front_line" rows="4"><?php echo htmlspecialchars($row['front_line']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="welcome_message" class="form-label">Welcome Message:</label>
                            <textarea class="form-control" id="welcome_message" name="welcome_message" rows="4"><?php echo htmlspecialchars($row['welcome_message']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="bg_img" class="form-label">Background Image</label>
                            <input type="file" class="form-control" id="bg_img" name="bg_img" accept="image/*">
                            <input type="hidden" name="existing_bg_img" value="<?php echo $row['bg_img']; ?>">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <p>Image Preview</p>
                            <img src="../../../assets/<?php echo $row['bg_img']; ?>" alt="Background Image" id="img_prev" style="width: 100%; height: 300px; border-radius: 10px;">
                        </div>
                    </div>
                </div>
                <div class="update w-100 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary w-25">Update</button>
                </div>
            </div>
        </form>

           
        </section>


       




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../function/script/status.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var userId = button.data('id');
        var modal = $(this);
        modal.find('.modal-body #deleteId').val(userId);
    });
</script>


</html>