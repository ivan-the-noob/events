<?php 
    session_start();
    $email = $_SESSION['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="features/users/css/index.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmgygVeipMUsrtGeZPZ9UzXRmcVdheIqw&libraries=places"></script>
    <title>Document</title>
</head>
<body>
        
        <section class="display">
            <div class="navbar-container">
                <div class="col-10 col-md-10">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <a class="navbar-brand d-none d-lg-block" href="#">
                            <img src="assets/logo.png" alt="Logo" width="30" height="30">
                        </a>
    
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
                                <div class="d-flex gap-2 navbar-btn">
                              
                                <?php if ($email): ?>
                            <div class="dropdown second-dropdown d-flex align-items-center">
                                <button class="btn" type="button" id="dropdownMenuButton2"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; margin-top: 2px;">
                                    <img src="assets/profile/user.png" alt="Profile Image" class="profile" style="width: 30px; height: 30px; margin-left: 5px; margin-right: 5px;">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="features/users/web/api/dashboard.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="features/users/function/authentication/logout.php">Logout</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="features/users/web/login.php" class="sign-in">Sign In</a>
                        <?php endif; ?>
                                <a href="features/users/web/calendar.php" class="book-event">Book Event</a>
                            </div>            
                            </ul>
                        </div>        
                    </div>
                </nav>       
            </div>
            </div>
            <div class="container d-flex justify-content-center">
                <div class="row d-flex">
                    <div class="col-md-8 display-text">
                        <h1 class="text-center">Celebrate your events with us at <span class="highlight">"Amiel's MOM Events Place!"</span></h1>
                        <p class="text-center">From weddings to birthdays, reunions, and baptisms, we can cater to all your special events with elegance and deliciousness</p>
                        <a href="features/users/web/calendar.php">Book an event now</a>
                    </div>
    
                </div>
            </div>
        </section>
        <section class="slider-container">
            <p class="slider-heading mb-0">Services we have</p>
            <h1 class="slider-subheading">What We Offer</h1>
            <div class="slider">
              <button class="slider-btn prev">&lt;</button> 
              <div class="slider-wrapper">
                <!-- Slide 1 -->
                <div class="slider-item">
                  <img src="assets/events/birthday.png" class="card-img-top" alt="Wedding Image">
                  <div class="slider-text">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Catering Services</h3>
                            <button>Discover Packages</button>
                        </div>
                        <div class="col-md-6">
                            <p>
                                Turn your event into an unforgettable experience with our premium catering services.
                            </p>          
                        </div>
                    </div>
                  </div>
                </div>
          
                <!-- Slide 2 -->
                <div class="slider-item">
                  <img src="assets/events/birthday.png" class="card-img-top" alt="Corporate Event">
                  <div class="slider-text">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Corporate Events</h3>
                            <button>Discover Packages</button>
                        </div>
                        <div class="col-md-6">
                            <p>
                                Elevate your corporate events with our top-notch services, tailored to impress clients.
                              </p>
                        </div>
                    </div>
                  </div>
                </div>
          
                <!-- Slide 3 -->
                <div class="slider-item">
                  <img src="assets/events/birthday.png" class="card-img-top" alt="Birthday Celebration">
                  <div class="slider-text">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Birthday Parties</h3>
                            <button>Discover Packages</button>
                        </div>
                        <div class="col-md-6">
                            <p>Make birthdays memorable with our themed decorations, delicious food, and entertainment options, creating joyful experiences for all ages.
                              </p>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- Slide 4 -->
                
              </div>
              <button class="slider-btn next">&gt;</button> 
            </div>
        </section>   
        <section class="scope">
            <p class="scope-title text-center mb-0">Our Event Services</p>
            <h3 class="text-center">Scope of our services</h3>
            <div class="container">
                <div class="row">
                    <!-- Card 1 -->
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <img src="assets/scope/wedding.png" class="card-img-top" alt="Wedding Image">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <p class="event">Event</p>
                                </div>
                                <h5 class="card-title">Wedding</h5>
                                <p class="card-text">Celebrate your big day with a feast as unforgettable as your love story.</p>
                            </div>
                        </div>
                    </div>
                
                    <!-- Card 2 -->
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <img src="assets/scope/birthday.png" class="card-img-top" alt="Wedding Image">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <p class="event">Event</p>
                                </div>
                                <h5 class="card-title">Birthdays</h5>
                                <p class="card-text">Celebrate your big day with a feast as unforgettable as your love story.</p>
                            </div>
                        </div>
                    </div>
                
                    <!-- Card 3 -->
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <img src="assets/scope/wedding.png" class="card-img-top" alt="Wedding Image">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <p class="event">Event</p>
                                </div>
                                <h5 class="card-title">Reunion</h5>
                                <p class="card-text">Celebrate your big day with a feast as unforgettable as your love story.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <img src="assets/scope/wedding.png" class="card-img-top" alt="Wedding Image">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <p class="event">Event</p>
                                </div>
                                <h5 class="card-title">Anniversaries</h5>
                                <p class="card-text">Celebrate your big day with a feast as unforgettable as your love story.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="review">
            <p class="review-title text-center mb-0">Customer Review</p>
            <h3 class="text-center">What our customers say</h3>
            <div class="slider">
                <button class="slider-btn-prev">&lt;</button>
                <div class="testimonial-slider-container">
                    <!-- Slide 1 -->
                    <div class="review-item">
                        <div class="row reviews-item">
                            <!-- Testimonial Text Section -->
                            <div class="col-10 col-sm-12 col-md-6 d-flex flex-column">
                                <h4 class="text-center d-flex justify-content-center">
                                   first At Amiel's MOM, they cater a very excellent service! It's easy to use and scale, and is really handy to customize for any projects.
                                </h4>
                                <p class="text-center mt-2 pp">
                                    Ac faucibus orci id quis consectetur laoreet sed. Enim congue molestie nam odio pulvinar ac ultrices. Elementum ut pellentesque volutpat mi.
                                </p>
                                <p class="text-start mt-2 pp"><strong class="text-start">Rachel Bright</strong><br>Customer Mom</p>
                            </div>
        
                            <!-- Testimonial Image Section -->
                            <div class="col-10 col-sm-10 col-md-6">
                                <div class="slider-image">
                                    <img src="assets/review/review.png" alt="Testimonial Image" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <!-- Slide 2 -->
                    <div class="review-item">
                        <div class="row reviews-item">
                            <!-- Testimonial Text Section -->
                            <div class="col-10 col-sm-12 col-md-6 d-flex flex-column">
                                <h4 class="text-center d-flex justify-content-center">
                                   first At Amiel's MOM, they cater a very excellent service! It's easy to use and scale, and is really handy to customize for any projects.
                                </h4>
                                <p class="text-center mt-2 pp">
                                    Ac faucibus orci id quis consectetur laoreet sed. Enim congue molestie nam odio pulvinar ac ultrices. Elementum ut pellentesque volutpat mi.
                                </p>
                                <p class="text-start mt-2 pp"><strong class="text-start">Rachel Bright</strong><br>Customer Mom</p>
                            </div>
        
                            <!-- Testimonial Image Section -->
                            <div class="col-10 col-sm-10 col-md-6">
                                <div class="slider-image">
                                    <img src="assets/review/review.png" alt="Testimonial Image" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <button class="slider-btn-next">&gt;</button>
            </div>
            <div class="pagination-dots">
                <span class="dot active"></span>
                <span class="dot"></span>
            </div>
        </section>
        <section class="extra-events">
            <p class="extra-title text-center mb-0">Additional Services</p>
            <h3 class="text-center">Event extras</h3>

            <div class="container my-5">
                <div class="row g-4">
                  <!-- Photobooth Card -->
                  <div class="col-md-4">
                    <div class="card">
                      <img src="assets/extras/photobooth.png" alt="Photobooth Icon">
                      <div class="context">
                        <h5 class="card-title mt-2">Photobooth</h5>
                        <div>
                            <span class="badge-event">Event</span>
                            <span class="badge-additional">Additional</span>
                        </div>
                        <p class="card-text mt-3">Add an extra dash of fun and flair to your event with our interactive photo booths!</p>
                        </div>
                    </div>
                  </div>
                  <!-- Entertainers Card -->
                  <div class="col-md-4">
                    <div class="card">
                      <img src="assets/extras/entertainers.png" alt="Entertainers Icon">
                      <div class="context">
                        <h5 class="card-title mt-2">Entertainers</h5>
                        <div>
                            <span class="badge-event">Event</span>
                            <span class="badge-additional">Additional</span>
                        </div>
                        <p class="card-text mt-3">Bring your event to life with entertainers who know how to captivate an audience.</p>
                        </div>
                    </div>
                  </div>
                  <!-- Service Staff Card -->
                  <div class="col-md-4">
                    <div class="card">
                      <img src="assets/extras/servicestaff.png" alt="Service Staff Icon">
                      <div class="context">
                        <h5 class="card-title mt-2">Service Staff</h5>
                        <div>
                            <span class="badge-event">Event</span>
                            <span class="badge-additional">Additional</span>
                        </div>
                        <p class="card-text mt-3">Whether you need servers, bartenders, or coordinators, we have it all.</p>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
        </section>

        <section class="choose-us">
            <div class="container">
                <div class="card">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="assets/choose-us.png" alt="Choose Us Image" class="chooseus-img">
                            </div>
                            <div class="col-md-7">
                                <p class="chooseus-title text-center mb-0">The Difference We Bring</p>
                                <h3 class="text-center">Why choose us</h3>
                                <p class="text-center choose-p">When it comes to creating memorable dining expectations, our clients choose us for our professionalism, attention to detail, and unparalleled taste.</p>
                                <div class="check-p">
                                    <div class="d-flex">
                                        <span class="check"><img src="assets/check.png" alt="" srcset=""></span><p class="check-p">Customizable menus that is tailored to your tastes and dietary needs.</p>
                                    </div>
                                    <div class="d-flex">
                                        <span class="check"><img src="assets/check.png" alt="" srcset=""></span><p class="check-p">professional experienced staff, chefs, waitstaff, and event coordinators.</p>
                                    </div>
                                    <div class="d-flex">
                                        <span class="check"><img src="assets/check.png" alt="" srcset=""></span><p class="check-p">Exceptional Quality, Only the freshest ingredients and exquisite presentation.</p>
                                    </div>
                                    <div class="d-flex">
                                        <span class="check"><img src="assets/check.png" alt="" srcset=""></span><p class="check-p">Full-Service Experience, From setup to cleanup, we take care of it all.</p>
                                    </div>
                                </div>
                                <div class="chooseus-button mt-3 d-flex gap-3">
                                    <button class="book-event">Book event now</button>
                                    <button class="discover">Discover Packages</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="howitworks">
            <div class="container">
                <p class="howitworks-title text-center mb-0">Ready. Set . Ship</p>
                <h3 class="text-center">How it works</h3>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <img src="assets/howitworks/budget.png" class="howitworks-img" alt="Plan Your Budget">
                                <div class="card-body">
                                    <h5 class="card-title">Plan Your Budget with Us</h5>
                                    <p class="card-text">Tell us about your event, and we'll provide a custom quote.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <img src="assets/howitworks/customize.png" class="howitworks-img cz" alt="Customize Your Menu">
                                <div class="card-body">
                                    <h5 class="card-title">Customize Your Menu</h5>
                                    <p class="card-text">Work with our team to create the perfect menu.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <img src="assets/howitworks/enjoy.png" class="howitworks-img enj" alt="Enjoy the Event">
                                <div class="card-body">
                                    <h5 class="card-title">Enjoy the Event</h5>
                                    <p class="card-text">We handle the setup, serving, and cleanup so you can enjoy every moment.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            </section>

            <footer>
                <div class="container">
                    <div class="footer-front">
                        <p class="footer-title text-center mb-0">Elevate your special day</p>
                        <h2 class="text-center">Book your event today</h2>
                        <p class="text-center lets">Let's make your ocassion unforgettable</p>
                        <button class="d-flex mx-auto book">Book an event now</button>
                        <div id="map"></div>
                    </div>
                    <div class="footer-back">
                        <div class="container">
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">About</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Contact Us</a></li>
                            </ul>
                            <hr>
                            <p class="text-center mt-4">&copy;2024 All Rights Reserved @ Amiel's MOM</p>
                        </div>
                    </div>
                </div>
            </footer>
          

<script src="features/function/review.js"></script> 
<script src="features/function/map.js"></script>   
<script src="features/function/offer-slider.js"></script>     
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
