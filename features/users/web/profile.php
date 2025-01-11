<?php
session_start();
$email = isset($_SESSION['email']);

// Check if the user is logged in and has the correct role
if (!(isset($_SESSION['email']) && $_SESSION['role'] === 'users')) {
    header('Location: ../../../features/users/web/login.php');
    exit;
}

$name = '';

require '../../../db.php';

$stmt = $conn->prepare("SELECT first_name, last_name, image_profile FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $name = $row['first_name'] . ' ' . $row['last_name'];
    $imageProfile = isset($row['image_profile']) ? $row['image_profile'] : '';
}

$passwordError = '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/packages.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <title>Amiel's MOM Event's Place</title>
    <link rel="icon" href="../../../assets/logo.png" type="image/png">
</head>

<body>
<div class="navbar-container">
        <div class="col-10 col-md-10">
        <div class="d-flex justify-content-between">
                        <div class="d-flex gap-3">
                            <img src="../../../assets/logo.png" alt="Logo" style="width: 60px; height: 60px;">
                            <h5 class="text-black d-flex align-items-center fw-bold mb-0">Amiel's MOM</h5>
                        </div>
                        <div class="d-flex align-items-center">
                        <p class="mb-0 text-black fw-bold w-100 d-flex">Where Memories Begin, and Moments Last Forever</p>
                        </div>
                    </div>
                <nav class="navbar navbar-expand-lg navbar-light">
                    
                    <div class="container">
                        
    
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                style="stroke: #000; fill: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
    
                        <div class="collapse navbar-collapse justify-content-center align-items-center" id="navbarNav">
                            <ul class="navbar-nav d-flex align-items-center "> 
                                <li class="nav-item">
                                    <a class="nav-link" href="../../../index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../../../index.php#our-services">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="packages.php">Packages</a>
                                </li>
                               
                                <li class="nav-item">
                                    <a class="nav-link" href="about-us.php">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contact_us.php">Contact Us</a>
                                </li>
                                <div class="d-flex gap-2 navbar-btn">
                              
                                <?php if ($email): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="history.php">Booking History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="faqs.php">FAQS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="terms_condition.php">Terms & Conditions</a>
                                </li>
                                <div class="dropdown second-dropdown d-flex align-items-center">
                                <button class="btn" type="button" id="dropdownMenuButton2"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; margin-top: 2px;">
                                        <img src="../../assets/profile/<?php echo $imageProfile; ?>" 
                                        alt="Profile Image" 
                                        class="rounded-circle mb-3" 
                                        style="width: 120px; height: 120px; object-fit: cover; border: 1px solid #7A3015;">
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                                        <li><a class="dropdown-item" href="dashboard.php">Profile</a></li>
                                                                        <li><a class="dropdown-item" href="../function/authentication/logout.php">Logout</a></li>
                                                                    </ul>
                                                                </div>
                                        <?php endif; ?>
                               
                            </div>            
                            </ul>
                        </div>        
                    </div>
                </nav>   
        </div>
    </div>


    <section class="body">
        <h3 class="text-center calendar-h3 mt-4">Update Profile</h3>
        <body>
            <div class="container mt-5">
                <div class="card mx-auto" style="max-width: 500px;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Profile</h5>

                        <!-- Profile Picture -->
                        <form action="../function/php/profile_logic.php" method="POST" enctype="multipart/form-data" class="text-center mb-4">
                        <img src="../../../assets/profile/<?php echo $row['image_profile']; ?>" 
                            alt="Profile Image" 
                            class="rounded-circle mb-3" 
                            style="width: 120px; height: 120px; object-fit: cover; border: 1px solid #7A3015;">
                            <div class="mb-3">
                                <label for="image_profile" class="form-label">Change Profile Image</label>
                                <input type="file" name="image_profile" id="image_profile" class="form-control">
                            </div>
                            <button type="submit" name="update_profile" class="btn btn-primary w-100">Update Profile</button>
                        </form>

                        <!-- Change Password -->
                        <form action="../function/php/profile_logic.php" method="POST">
                            <h6 class="mb-3">Change Password</h6>

                            <?php if ($passwordError): ?>
                                <div class="alert alert-danger"><?php echo $passwordError; ?></div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" name="change_password" class="btn btn-success w-100">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
    </section>
    






    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="../function/script/calendar.js"></script>
    <script src="../function/script/time-duration.js"></script>
    <script src="../function/script/payment.js"></script>
    <script src="../function/script/event_function.js"></script>

</html>