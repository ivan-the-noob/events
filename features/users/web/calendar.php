<?php
session_start();

$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

$name = '';

if ($email) {
    require '../../../db.php';

    $stmt = $conn->prepare("SELECT first_name, last_name, contact_number FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $contact_number = $row['contact_number'];
    }
}


if (!(isset($_SESSION['email']) && $_SESSION['role'] === 'users')) {
    header('Location: ../../../features/users/web/login.php');
    exit;
}


require '../../../db.php';
$query = "SELECT event_starttime FROM booking";
$result = $conn->query($query);
$bookedTimes = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookedTimes[] = (int) $row['event_starttime']; // Store as integers for easier comparison
    }
}

// Function to check if the time is within 5 hours of any booked time
function isTimeAvailable($time, $bookedTimes) {
    foreach ($bookedTimes as $bookedTime) {
        if ($bookedTime == $time || $time >= $bookedTime && $time <= $bookedTime + 5) {
            return false; // Time is not available
        }
    }
    return true; // Time is available
}

$query = "SELECT image_profile FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($imageProfile);
    $stmt->fetch();
    $stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/calendar.css">
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
                                    <a class="nav-link" href="about_us.php">About</a>
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
                                        <img src="../../../assets/profile/<?php echo htmlspecialchars($imageProfile); ?>" alt="Profile Picture" 
                                        alt="Profile Image" 
                                        class="rounded-circle" 
                                        style="width: 30px; height: 30px; object-fit: cover; border: 1px solid #7A3015;">
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
        <p class="calendar-title text-center mb-0">Book your event today</p>
        <h3 class="text-center calendar-h3">Let's Plan Your Perfect Event</h3>
        <div class="container">
            <div class="container-calendar d-flex flex-column flex-lg-row gap-3">
                <div class="card calendar-card">
                    <div class="card-body">
                        <div class="cont-avail d-flex align-items-center gap-3 mb-2">
                            <div class="available"></div>
                            <p class="mb-0">Available</p>
                        </div>
                        <div class="cont-unavail d-flex align-items-center gap-3 mb-2">
                            <div class="booked"></div>
                            <p class="mb-0">Booked</p>
                        </div>
                        <div class="cont-unavailable d-flex align-items-center gap-3 mb-2">
                            <div class="unavailable"></div>
                            <p class="mb-0">Unavailable</p>
                        </div>
                    </div>
                </div>
                <div id="calendar" class="calendar flex-grow-1"></div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered custom-modal mx-auto">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../function/php/booking_function.php" method="POST">
                        <p class="calendar-title text-center mb-0">Customize your needs</p>
                        <h3 class="text-center calendar-h3">Fill out form</h3>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3">
                                    <h5>Customer Info</h5>
                                    <div class="form-group mt-4">
                                        <label for="full-name" class="form-label">Full Name</label>
                                        <input type="text" id="full-name" name="full_name" class="form-control"
                                        value="<?= htmlspecialchars($first_name . ' ' . $last_name); ?>" placeholder="Enter your text here" readonly>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="celebrants-name" class="form-label">Celebrant's Name</label>
                                        <input type="text" id="celebrants-name" name="celebrants_name"
                                            class="form-control" placeholder="Enter your text here" required>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                        value="<?= htmlspecialchars($email); ?>" placeholder="Enter your text here" readonly>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="phone-number" class="form-label">Phone Number</label>
                                        <input type="number" id="phone-number" name="phone_number" class="form-control"
                                        value="<?= htmlspecialchars($contact_number); ?>" placeholder="Enter your text here">
                                    </div>
                                    <h5 class="mb-4 events">Event Info</h5>
                                    <div class="form-group mt-4">
                                        <label for="events-date" class="form-label">Events Date</label>
                                        <input type="text" id="events-date" name="events_date" value=""
                                            class="form-control" readonly>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="guest-count" class="form-label">Guest Count</label>
                                        <select id="guest-count" name="guest_count" class="form-control" required>
                                            <option value="50">50</option>
                                            <option value="60">60</option>
                                            <option value="80">80</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="event-duration" class="form-label">Event Duration</label>
                                        <input type="text" id="event-duration" name="event_duration"
                                            class="form-control" value="5 hours" readonly>
                                    </div>

                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group mt-4">
                                        <label for="event-starttime" class="form-label">Event Start Time</label>
                                        <select id="event-starttime" name="event_starttime" class="form-control" required>
                                            <option value="8">8:00 AM</option>
                                            <option value="9">9:00 AM</option>
                                            <option value="10">10:00 AM</option>
                                            <option value="11">11:00 AM</option>
                                            <option value="12">12:00 PM</option>
                                            <option value="13">1:00 PM</option>
                                            <option value="14">2:00 PM</option>
                                            <option value="15">3:00 PM</option>
                                            <option value="16">4:00 PM</option>
                                            <option value="17">5:00 PM</option>
                                            <option value="18">6:00 PM</option>
                                            <option value="19">7:00 PM</option>
                                            <option value="20">8:00 PM</option>
                                            <option value="21">9:00 PM</option>
                                            <option value="22">10:00 PM</option>
                                            <option value="23">11:00 PM</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="event-endtime" class="form-label">Event End Time</label>
                                        <input type="text" id="event-endtime" name="event_endtime" class="form-control"
                                            placeholder="End time" readonly>
                                    </div>
                                    <h5 class="mb-4 eventss">Event Selection</h5>
                                    <div class="form-group mt-4">
                                        <label for="event-type" class="form-label">Type of Event</label>
                                        <select id="event-type" name="event_type" class="form-control" required>
                                            <option value="" disabled selected>Select an event</option>
                                            <?php
                                            require '../../../db.php';
                                            $query = "SELECT id, type_of_event FROM event_list";
                                            $result = $conn->query($query);
                                            if ($result && $result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['type_of_event']) . '">' . htmlspecialchars($row['type_of_event']) . '</option>';
                                                }
                                            } else {
                                                echo '<option value="" disabled>No events available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group mt-4">
                                            <label for="celebrants-name" class="form-label">Theme</label>
                                            <input type="text" id="celebrants-name" name="theme"
                                                class="form-control" placeholder="Enter your text here" required>
                                        </div>
                                    </div>

                                <div class="col-md-3">
                                    
                                    <div class="">
                                        <h5 class="mb-4">Event Packages</h5>
                                        <div class="form-group mt-4" id="event-package-options" style="display: none;">
                                            <label for="event-package" class="form-label">Select Event Package</label>
                                            <select id="event-package" name="event_package" class="form-control" required>
                                                <option value="" disabled selected>Select a package</option>
                                              
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mt-4 custom-package-options" style="display: none;">
                                        <label class="custom-package-label"> Customize your Package</label>
                                        <div class="form-check-group">
                                        </div>
                                        <div class="form-group " id="extra-options-container"></div>   
                                    </div>
                                    <div class="form-group mt-4" id="beef-options" style="display: none;">
                                        <label for="beef-select" class="form-label">Beef</label>
                                        <select id="beef-select" name="beef_dish" class="form-control" required>
                                            <option value="" disabled selected>Select a dish</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-4" id="pork-options" style="display: none;">
                                        <label for="pork-select" class="form-label">Pork</label>
                                        <select id="pork-select" name="pork_dish" class="form-control" required>
                                            <option value="" disabled selected>Select a dish</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-4" id="chicken-options" style="display: none;">
                                        <label for="chicken-select" class="form-label">Chicken</label>
                                        <select id="chicken-select" name="chicken_dish" class="form-control" required>
                                            <option value="" disabled selected>Select a dish</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-4" id="pasta-options" style="display: none;">
                                        <label for="pasta-select" class="form-label">Pasta</label>
                                        <select id="pasta-select" name="pasta_dish" class="form-control" required>
                                            <option value="" disabled selected>Select a dish</option>
                                        </select>
                                    </div>

                                    <!-- New Dessert Form Group -->
                                    <div class="form-group mt-4" id="dessert-options" style="display: none;">
                                        <label for="dessert-select" class="form-label">Dessert</label>
                                        <select id="dessert-select" name="dessert_dish" class="form-control" required>
                                            <option value="" disabled selected>Select a dish</option>
                                        </select>
                                    </div>

                                    <!-- New Fish Form Group -->
                                    <div class="form-group mt-4" id="fish-options" style="display: none;">
                                        <label for="fish-select" class="form-label">Fish</label>
                                        <select id="fish-select" name="fish_dish" class="form-control" required>
                                            <option value="" disabled selected>Select a dish</option>
                                        </select>
                                    </div>

                                    <!-- New Drinks Form Group -->
                                    <div class="form-group mt-4" id="drinks-options" style="display: none;">
                                        <label for="drinks-select" class="form-label">Drinks</label>
                                        <select id="drinks-select" name="drinks_dish" class="form-control" required>
                                            <option value="" disabled selected>Select a dish</option>
                                        </select>
                                    </div>

                                    
                                  
                                </div>
                                <div class="col-md-4 justify-content-between">
                                    <h5 class="mb-4">Total Payment</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <p>Event Type: </p>
                                                <p id="event_type"></p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <div id="event_package"></div>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <p>Total Payment:</p>
                                                <p id="cost"></p>
                                                <input type="hidden" id="event-cost" name="cost" value="">
                                            </div>          
                                        </div>
                                        
                                    </div>
                                    <div class="form-check mt-4">
                                            <input type="checkbox" class="form-check-input" id="payment_confirmation" required>
                                            <label class="form-check-label" for="payment_confirmation">
                                                I confirm that all the payment credentials provided are correct
                                            </label>
                                        </div>

                                </div>
                                
                                
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submit">Book Appointment</button>
                </div>
                </form>
            </div>
        </div>
    </div>






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