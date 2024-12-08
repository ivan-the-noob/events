<?php
session_start();

$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

$name = '';

if ($email) {
    require '../../../db.php';

    $stmt = $conn->prepare("SELECT name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $name = $row['name'];
    }
}


if (!(isset($_SESSION['email']) && $_SESSION['role'] === 'users')) {
    header('Location: ../../../features/users/web/login.php');
    exit;
}

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
    <title>Document</title>
</head>

<body>
    <div class="navbar-container">
        <div class="col-10 col-md-10">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <a class="navbar-brand d-none d-lg-block" href="#">
                        <img src="../../../assets/logo.png" alt="Logo" width="30" height="30">
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            style="stroke: #000; fill: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>

                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#about">About</a>
                            </li>
                           
                            <li class="nav-item">
                                <a class="nav-link" href="#services">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about">Packages</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact-us">Contact Us</a>
                            </li>
                            <?php if ($email): ?>
                                <div class="dropdown second-dropdown">
                                    <button class="btn" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="padding: 0; margin-top: 2px;">
                                        <img src="../../../assets/profile/user.png" alt="Profile Image" class="profile"
                                            style="width: 30px; height: 30px; margin-left: 5px; margin-right: 5px;">
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <li><a class="dropdown-item" href="user-dashboard.php">Profile</a></li>
                                        <li><a class="dropdown-item" href="../function/authentication/logout.php">Logout</a>
                                        </li>
                                    </ul>
                                </div>


                            <?php else: ?>
                                <a href="features/users/web/login.php" class="sign-in">Sign In</a>
                            <?php endif; ?>


                        </ul>

                    </div>

                </div>
            </nav>
        </div>
    </div>

    <section class="body">
        <p class="calendar-title text-center mb-0">Explore Our Exclusive Packages</p>
        <h3 class="text-center calendar-h3">Find the Perfect Package for Your Needs</h3>
        <div class="container package">
    <div class="row">
        <?php
        $eventTypes = [
            'Kiddie Party',
            'Adult Party',
            'Christening',
            'Christmas Year End Party',
            'Debut',
            'Despedida',
            'Wedding'
        ];

        function displayEventImages($eventType) {
            global $conn;
            $query = "SELECT * FROM event_packages WHERE type_of_event = '$eventType'";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                echo '<h3>' . htmlspecialchars($eventType) . '</h3>';
                while ($row = $result->fetch_assoc()) {
                    $imagePath = "../../../assets/packages/" . htmlspecialchars($row['package_image'], ENT_QUOTES, 'UTF-8');
                    echo '<div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="' . $imagePath . '" alt="' . htmlspecialchars($eventType) . ' Image" class="card-img-top" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-imgsrc="' . $imagePath . '">
                            </div>
                          </div>';
                }
            } else {
                echo '<div class="col-md-3 mb-4"><p>No ' . htmlspecialchars($eventType) . ' packages found.</p></div>';
            }
        }

        foreach ($eventTypes as $eventType) {
            displayEventImages($eventType);
        }
        ?>
    </div>
</div>


<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="modalImage" alt="Zoomed Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>

    var modalImage = document.getElementById('modalImage');
    var imgElements = document.querySelectorAll('[data-bs-toggle="modal"]');

    imgElements.forEach(function(img) {
        img.addEventListener('click', function() {
            var imgSrc = img.getAttribute('data-bs-imgsrc');
            modalImage.src = imgSrc; 
        });
    });
</script>

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