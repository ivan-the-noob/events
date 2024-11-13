<?php
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
    <link rel="stylesheet" href="../css/index.css">
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
                <span>Approved Booking</span>
            </a>
            
            </div>

        </div>
    </div>
    <!--Navigation Links End-->
    <div class="content flex-grow-1">
        <div class="header">
            <button class="navbar-toggler d-block d-md-none" type="button" onclick="toggleMenu()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    style="stroke: black; fill: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>

            <!--Notification and Profile Admin-->
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
        <!--Notification and Profile Admin End-->

      
<div class="container mt-4">
    <h3>Approve Booking</h3>
    <div class="table-responsive">
        <table class="table">
            <thead class="table-booking">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type of Event</th>
                    <th scope="col">Info</th>
                    <th scope="col">Status</th>

                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_type']); ?></td>
                        <td>
                            <button type="button" class="btn view " data-bs-toggle="modal" data-bs-target="#infoModal<?php echo $row['id']; ?>">
                                View
                            </button>
                        </td>
                        <td>
                            <select class="form-select form-select-sm" onchange="updateStatus(this, <?php echo $row['id']; ?>)">
                                <option value="Waiting" <?php echo $row['status'] === 'Waiting' ? 'selected' : ''; ?>>Waiting</option>
                                <option value="On-going" <?php echo $row['status'] === 'On-going' ? 'selected' : ''; ?>>On-going</option>
                                <option value="Finished" <?php echo $row['status'] === 'Finished' ? 'selected' : ''; ?>>Finished</option>
                            </select>
                        </td>

                        <script>
    // Function to update the status and change background color
    function updateStatus(selectElement, bookingId) {
        // Get the selected status
        const status = selectElement.value;

        // Change background color based on the selected status
        selectElement.classList.remove('bg-warning', 'bg-info', 'bg-success');  // Remove any previous background class
        
        if (status === 'Waiting') {
            selectElement.classList.add('bg-warning');  // Add yellow background
        } else if (status === 'On-going') {
            selectElement.classList.add('bg-success');
            selectElement.classList.add('text-white');     // Add blue background
        } else if (status === 'Finished') {
            selectElement.classList.add('bg-success');  // Add green background
        }

        // Create an AJAX request to update the status in the database
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../function/php/update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // When the request state changes
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the response from the server
                if (xhr.responseText.trim() === "success") {
                    alert("Status updated successfully!");  // Success alert
                } else {
                    alert("Failed to update status: " + xhr.responseText);  // Error alert
                }
            }
        };

        // Send the status update to the server
        xhr.send("id=" + bookingId + "&status=" + encodeURIComponent(status));
    }

    // Function to set the initial background color based on the status
    function setInitialBackgroundColor() {
        const selectElements = document.querySelectorAll('.form-select');

        // Loop through each select element (dropdown)
        selectElements.forEach(function(selectElement) {
            const status = selectElement.value;  // Get the current status from the dropdown value
            
            // Set the background color based on the status
            if (status === 'Waiting') {
                selectElement.classList.add('bg-warning');  // Yellow background for Waiting
            } else if (status === 'On-going') {
                selectElement.classList.add('bg-success');
                selectElement.classList.add('text-white');      // Blue background for On-going
            } else if (status === 'Finished') {
                selectElement.classList.add('bg-success');  // Green background for Finished
            }
        });
    }

    // Call the function to set initial background color when the page loads
    window.onload = function() {
        setInitialBackgroundColor();  // Set initial background color based on status
    }
</script>


                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="infoModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="infoModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="infoModalLabel<?php echo $row['id']; ?>">Event Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($row['full_name']); ?></p>
                                    <p><strong>Celebrant's Name:</strong> <?php echo htmlspecialchars($row['celebrants_name']); ?></p>
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                                    <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($row['phone_number']); ?></p>
                                    <p><strong>Event Date:</strong> <?php echo htmlspecialchars($row['events_date']); ?></p>
                                    <p><strong>Guest Count:</strong> <?php echo htmlspecialchars($row['guest_count']); ?></p>
                                    <p><strong>Event Duration:</strong> <?php echo htmlspecialchars($row['event_duration']); ?></p>
                                    <p><strong>Event Start Time:</strong> <?php echo htmlspecialchars($row['event_starttime']); ?></p>
                                    <p><strong>Event End Time:</strong> <?php echo htmlspecialchars($row['event_endtime']); ?></p>
                                    <p><strong>Event Type:</strong> <?php echo htmlspecialchars($row['event_type']); ?></p>
                                    <p><strong>Event Package:</strong> <?php echo htmlspecialchars($row['event_package']); ?></p>
                                    <p><strong>Event Options:</strong> <?php echo htmlspecialchars($row['event_options']); ?></p>
                                    <p><strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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



       

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>