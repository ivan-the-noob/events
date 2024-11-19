<?php
    session_start();
    require '../../../db.php';
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../css/calendar.css">
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
            <a href="#" class="navbar-highlight">
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
            <a href="cancel.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Cancelled Booking</span>
            </a>
            <a href="packages.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Event Packages</span>
            </a>
            <a href="#">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Unavailable</span>
            </a>
            <a href="history.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>History</span>
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
                        <li><a class="dropdown-item" href="../../users/web/api/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

      
        <section class="body">
        <p class="calendar-title text-center mb-0">Book your event today</p>
        <h3 class="text-center calendar-h3">Let's Plan Your Perfect Event</h3>
        <div class="container">
            <div class="container-calendar">
                <div id="calendar" class="calendar"></div>
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
                        <div class="col-md-4">
                            <h5>Customer Info</h5>
                            <div class="form-group mt-4">
                                <label for="full-name" class="form-label">Full Name</label>
                                <input type="text" id="full-name" name="full_name" class="form-control" placeholder="Enter your text here">
                            </div>
                            <div class="form-group mt-4">
                                <label for="celebrants-name" class="form-label">Celebrant's Name</label>
                                <input type="text" id="celebrants-name" name="celebrants_name" class="form-control" placeholder="Enter your text here">
                            </div>
                            <div class="form-group mt-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your text here">
                            </div>
                            <div class="form-group mt-4">
                                <label for="phone-number" class="form-label">Phone Number</label>
                                <input type="number" id="phone-number" name="phone_number" class="form-control" placeholder="Enter your text here">
                            </div>
                            <h5 class="mb-4 events">Event Info</h5>
                            <div class="form-group mt-4">
                                <label for="events-date" class="form-label">Events Date</label>
                                <input type="text" id="events-date" name="events_date" value="" class="form-control" readonly> 
                            </div>                        
                            <div class="form-group mt-4">
                                <label for="guess-count" class="form-label">Guest Count</label>
                                <input type="number" id="guess-count" name="guest_count" class="form-control" placeholder="Enter your text here" min="1" max="999" maxlength="3" required>
                            </div>
                            <div class="form-group mt-4">
                                <label for="event-duration" class="form-label">Event Duration</label>
                                <select id="event-duration" name="event_duration" class="form-control">
                                    <option value="" disabled selected>Select time duration</option>
                                    <option value="3">3 hours</option>
                                    <option value="5">5 hours</option>
                                    <option value="8">8 hours</option>
                                    <option value="16">16 hours</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
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
                                <input type="text" id="event-endtime" name="event_endtime" class="form-control" placeholder="End time" readonly>
                            </div>
                            <h5 class="mb-4 eventss">Event Selection</h5>
                            <div class="form-group mt-4">
                                <label for="event-type" class="form-label">Type of Event</label>
                                <select id="event-type" name="event_type" class="form-control">
                                    <option value="" disabled selected>Select an event start time</option>
                                    <option value="Birthday Party">Birthday Party</option>
                                    <option value="Wedding">Wedding</option>
                                    <option value="Christmas Party">Christmas Party</option>
                                    <option value="Year End Party">Year End Party</option>
                                    <option value="Anniversaries">Anniversaries</option>
                                    <option value="Family Gathering">Family Gathering</option>
                                    <option value="Despedida">Despedida</option>
                                    <option value="Reunions">Reunions</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h5 class=" mb-4">Event Packages</h5>
                            <div class="form-group mt-4">
                                <label for="event-package" class="form-label">Select Event Package</label>
                                <select id="event-package" name="event_package" class="form-control">
                                    <option value="" disabled selected>Select a package</option>
                                    <option value="Package A">Package A</option>
                                    <option value="Package B">Package B</option>
                                    <option value="Package C">Package C</option>
                                    <option value="Package D">Package D</option>
                                    <option value="Package E">Package E</option>
                                    <option value="Package F">Package F</option>
                                    <option value="Package G">Package G</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                              <div class="form-group mt-4" id="event-options-group" style="display: none;">
                                <label class="form-label">Select Event Package Options</label>
                            
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="pax-50" name="event_options[]" value="50 Pax">
                                    <label class="form-check-label" for="pax-50">50 Pax Package</label>
                                </div>
                                
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="pax-60" name="event_options[]" value="60 Pax">
                                    <label class="form-check-label" for="pax-60">60 Pax Package</label>
                                </div>
                                
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="pax-70" name="event_options[]" value="70 Pax">
                                    <label class="form-check-label" for="pax-70">70 Pax Package</label>
                                </div>
                            
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="pax-80" name="event_options[]" value="80 Pax">
                                    <label class="form-check-label" for="pax-80">80 Pax Package</label>
                                </div>
                            
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="pax-100" name="event_options[]" value="100 Pax">
                                    <label class="form-check-label" for="pax-100">100 Pax Package</label>
                                </div>
                            
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="pax-150" name="event_options[]" value="150 Pax">
                                    <label class="form-check-label" for="pax-150">150 Pax Package</label>
                                </div>
                            
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="pax-200" name="event_options[]" value="200 Pax">
                                    <label class="form-check-label" for="pax-200">200 Pax Package</label>
                                </div>
                            
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="photobooth" name="event_options[]" value="Photobooth">
                                    <label class="form-check-label" for="photobooth">Photobooth</label>
                                </div>
                            
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="clowns" name="event_options[]" value="Clowns">
                                    <label class="form-check-label" for="clowns">Clowns</label>
                                </div>
                            
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="magicians" name="event_options[]" value="Magicians">
                                    <label class="form-check-label" for="magicians">Magicians</label>
                                </div>
                            
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="grazing-table" name="event_options[]" value="Grazing Table">
                                    <label class="form-check-label" for="grazing-table">Grazing Table</label>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../users/function/script/calendar.js"></script>
    <script src="../../users/function/script/time-duration.js"></script> 
    <script src="../../users/function/script/other-package.js"></script>

</html>