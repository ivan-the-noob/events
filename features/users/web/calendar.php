<?php
session_start();
$email = isset($_SESSION['email']);

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
    <link rel="stylesheet" href="../css/calendar.css">
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
                                        <li><a class="dropdown-item" href="">Profile</a></li>
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
                                            placeholder="Enter your text here">
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="celebrants-name" class="form-label">Celebrant's Name</label>
                                        <input type="text" id="celebrants-name" name="celebrants_name"
                                            class="form-control" placeholder="Enter your text here">
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Enter your text here">
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="phone-number" class="form-label">Phone Number</label>
                                        <input type="number" id="phone-number" name="phone_number" class="form-control"
                                            placeholder="Enter your text here">
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
                                            <option value="11">11</option>
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
                                        <select id="event-starttime" name="event_starttime" class="form-control">
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
                                        <select id="event-type" name="event_type" class="form-control">
                                            <option value="" disabled selected>Select an event</option>
                                            <option value="Kiddie Party">Kiddie Party</option>
                                            <option value="Adult Birthday party">Adult Birthday party</option>
                                            <option value="Debut">Debut</option>
                                            <option value="Wedding">Wedding</option>
                                            <option value="Christening">Christening</option>
                                            <option value="Despedida">Despedida</option>
                                            <option value="Christmas Year End party">Christmas / Year End party</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <h5 class=" mb-4">Event Packages</h5>
                                    <div class="form-group mt-4" id="kiddie-party-options" style="display: none;">
                                        <label for="kiddie-party-package" class="form-label">Select Event
                                            Package</label>
                                        <select id="kiddie-party-package" name="event_package" class="form-control">
                                            <option value="" disabled selected>Select a package</option>
                                            <option value="Package A (Kiddie Party, 50 pax)" data-cost="25000">Package A
                                                (Kiddie Party, 50 pax)</option>
                                            <option value="Package B (Kiddie Party, 60 pax)" data-cost="30000">Package B
                                                (Kiddie Party, 60 pax)</option>
                                            <option value="Package C (Kiddie Party, 80 pax)" data-cost="40000">Package C
                                                (Kiddie Party, 80 pax)</option>
                                            <option value="Package D (Kiddie Party, 100 pax)" data-cost="45000">Package
                                                D (Kiddie Party, 100 pax)</option>
                                            <option value="Other-kiddie-party" id="Other-kiddie-party">Other</option>
                                        </select>
                                    </div>

                                    <!-- Adult Birthday Packages -->
                                    <div class="form-group mt-4" id="adult-birthday-party-options"
                                        style="display: none;">
                                        <label for="adult-birthday-package" class="form-label">Select Event
                                            Package</label>
                                        <select id="adult-birthday-package" name="event_package" class="form-control">
                                            <option value="" disabled selected>Select a package</option>
                                            <option value="Package A (Adult Birthday Party, 50 pax)" data-cost="25000">
                                                Package A (Adult Birthday Party, 50 pax)</option>
                                            <option value="Package B (Adult Birthday Party, 60 pax)" data-cost="30000">
                                                Package B (Adult Birthday Party, 60 pax)</option>
                                            <option value="Package C (Adult Birthday Party, 80 pax)" data-cost="35000">
                                                Package C (Adult Birthday Party, 80 pax)</option>
                                            <option value="Package D (Adult Birthday Party, 100 pax)" data-cost="40000">
                                                Package D (Adult Birthday Party, 100 pax)</option>
                                            <option value="Other-adult-birthday-party" id="Other-adult-birthday-party">
                                                Other</option>
                                        </select>
                                    </div>

                                    <!-- Debut Packages -->
                                    <div class="form-group mt-4" id="debut-options" style="display: none;">
                                        <label for="debut-packages" class="form-label">Select Event Package</label>
                                        <select id="debut-packages" name="event_package" class="form-control">
                                            <option value="" disabled selected>Select a package</option>
                                            <option value="Package A (Debut Party, 50 pax)" data-cost="25000">Package A
                                                (Debut Party, 50 pax)</option>
                                            <option value="Package B (Debut Party, 60 pax)" data-cost="30000">Package B
                                                (Debut Party, 60 pax)</option>
                                            <option value="Package C (Debut Party, 80 pax)" data-cost="40000">Package C
                                                (Debut Party, 80 pax)</option>
                                            <option value="Package D (Debut Party, 100 pax)" data-cost="45000">Package D
                                                (Debut Party, 100 pax)</option>
                                            <option value="Other-debut" id="Other-debut">Other</option>
                                        </select>
                                    </div>
                                    <!-- Wedding Packages -->
                                    <div class="form-group mt-4" id="wedding-options" style="display: none;">
                                        <label for="wedding-package" class="form-label">Select Event Package</label>
                                        <select id="wedding-package" name="event_package" class="form-control">
                                            <option value="" disabled selected>Select a package</option>
                                            <option value="Package A (Wedding Party, 50 pax)" data-cost="30000">Package
                                                A (Wedding Party, 50 pax)</option>
                                            <option value="Package B (Wedding Party, 60 pax)" data-cost="35000">Package
                                                B (Wedding Party, 60 pax)</option>
                                            <option value="Package C (Wedding Party, 80 pax)" data-cost="45000">Package
                                                C (Wedding Party, 80 pax)</option>
                                            <option value="Package D (Wedding Party, 100 pax)" data-cost="55000">Package
                                                D (Wedding Party, 100 pax)</option>
                                            <option value="Other-wedding" id="Other-wedding">Other</option>
                                        </select>
                                    </div>

                                    <!-- Christening Packages -->
                                    <div class="form-group mt-4" id="christening-options" style="display: none;">
                                        <label for="christening-package" class="form-label">Select Event Package</label>
                                        <select id="christening-package" name="event_package" class="form-control">
                                            <option value="" disabled selected>Select a package</option>
                                            <option value="Package A (Christening Party, 50 pax)" data-cost="20000">
                                                Package A (Christening Party, 50 pax)</option>
                                            <option value="Package B (Christening Party, 60 pax)" data-cost="25000">
                                                Package B (Christening Party, 60 pax)</option>
                                            <option value="Package C (Christening Party, 80 pax)" data-cost="35000">
                                                Package C (Christening Party, 80 pax)</option>
                                            <option value="Package D (Christening Party, 100 pax)" data-cost="40000">
                                                Package D (Christening Party, 100 pax)</option>
                                            <option value="Other-christening" id="Other-christening">Other</option>
                                        </select>
                                    </div>

                                    <!-- Despedida Packages -->
                                    <div class="form-group mt-4" id="despedida-options" style="display: none;">
                                        <label for="despedida-package" class="form-label">Select Event Package</label>
                                        <select id="despedida-package" name="event_package" class="form-control">
                                            <option value="" disabled selected>Select a package</option>
                                            <option value="Package A (Despedida Party, 50 pax)" data-cost="20000">
                                                Package A (Despedida Party, 50 pax)</option>
                                            <option value="Package B (Despedida Party, 60 pax)" data-cost="25000">
                                                Package B (Despedida Party, 60 pax)</option>
                                            <option value="Package C (Despedida Party, 80 pax)" data-cost="35000">
                                                Package C (Despedida Party, 80 pax)</option>
                                            <option value="Package D (Despedida Party, 100 pax)" data-cost="40000">
                                                Package D (Despedida Party, 100 pax)</option>
                                            <option value="Other-despedida" id="Other-despedida">Other</option>
                                        </select>
                                    </div>

                                    <!-- Christmas Party Packages -->
                                    <div class="form-group mt-4" id="christmas-year-end-party-options"
                                        style="display: none;">
                                        <label for="christmas-party-package" class="form-label">Select Event
                                            Package</label>
                                        <select id="christmas-party-package" name="event_package" class="form-control">
                                            <option value="" disabled selected>Select a package</option>
                                            <option value="Package A (Christmas Party, 50 pax)" data-cost="20000">
                                                Package A (Christmas Party, 50 pax)</option>
                                            <option value="Package B (Christmas Party, 60 pax)" data-cost="25000">
                                                Package B (Christmas Party, 60 pax)</option>
                                            <option value="Package C (Christmas Party, 80 pax)" data-cost="35000">
                                                Package C (Christmas Party, 80 pax)</option>
                                            <option value="Package D (Christmas Party, 100 pax)" data-cost="40000">
                                                Package D (Christmas Party, 100 pax)</option>
                                            <option value="Other christmas-year-end-party"
                                                id="Other christmas-year-end-party">Other</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="event-cost" name="cost" value="">
                                    <script>
                                        document.getElementById('event-type').addEventListener('change', function() {
                                            let eventType = this.value;
                                            let costField = document.getElementById('event-cost');
                                            let packageSelect = document.querySelector(
                                                `#${eventType.toLowerCase().replace(/\s/g, '-')}-options select`
                                            );

                                            if (packageSelect) {
                                                packageSelect.addEventListener('change', function() {
                                                    let selectedOption = this.options[this.selectedIndex];
                                                    let cost = selectedOption ? selectedOption.getAttribute(
                                                        'data-cost') : 0;
                                                    costField.value = cost;
                                                });
                                            }
                                        });
                                    </script>

                                    <?php
                                    include '../function/php/script-event.php';
                                    include '../function/php/event_package_data.php';
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <h5 class=" mb-4">Total Payment</h5>

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <p>Event Type: </p>
                                                <p id="event_type">Kiddie Party</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p id="event_package"></p>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <p>Total Payment:</p>
                                                <p id="cost"></p>
                                            </div>
                                        </div>
                                    </div>


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

</html>