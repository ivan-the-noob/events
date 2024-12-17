<?php 

    require 'db.php';
    session_start();
    $email = $_SESSION['email'] ?? '';

    $query = "SELECT * FROM cms";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    
    $query = "SELECT image, title, description FROM scope_services";
    $result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="features/users/css/index.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmgygVeipMUsrtGeZPZ9UzXRmcVdheIqw&libraries=places"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
        
        <section class="display">
            <div class="navbar-container">
                <div class="col-10 col-md-10">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex gap-3">
                            <img src="assets/logo.png" alt="Logo" style="width: 60px; height: 60px;">
                            <h5 class="text-white d-flex align-items-center fw-bold mb-0">Amiel's MOM</h5>
                        </div>
                        <div class="d-flex align-items-center">
                        <p class="mb-0 text-white fw-bold w-100 d-flex">Where Memories Begin, and Moments Last Forever</p>
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
                                    <a class="nav-link" href="#">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#services">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#services">Packages</a>
                                </li>
                               
                                <li class="nav-item">
                                    <a class="nav-link" href="#about">About</a>
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
                        <h1 class="text-center">Celebrate your events with us at <span class="highlight">"<?php echo htmlspecialchars($row['system_name']); ?>!"</span></h1>
                        <p class="text-center"><?php echo htmlspecialchars($row['front_line']); ?></p>
                        <a href="features/users/web/calendar.php">Book an event now</a>
                    </div>
    
                </div>
            </div>
        </section>
        <section class="welcome">
           
            <div class="container p-4">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-7">
                        <h2 class="text-center h-100">Welcome to <?php echo htmlspecialchars($row['system_name']); ?></h2>
                    </div>
                    <div class="col-md-7">
                    <p class="mb-0 text-center mt-2"><?php echo htmlspecialchars($row['welcome_message']); ?>
                        </p>
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

                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <!-- Card -->
                            <div class="col-12 col-md-3">
                                <div class="card">
                                    <!-- Display the image -->
                                    <img src="assets/scope/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                    <div class="card-body">
                                        <div class="col-md-4">
                                            <p class="event">Event</p>
                                        </div>
                                        <!-- Display the title -->
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                        <!-- Display the description -->
                                        <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p>No services available.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php
                $conn->close();
                ?>
                </div>
            </div>
        </section>
        <section class="extra-events">
            <p class="extra-title text-center mb-0">Additional Services</p>
            <h3 class="text-center">Event extras</h3>

            <?php 
            require 'db.php';
            $query = "SELECT image, title, description FROM extras";
            $result = $conn->query($query);
            ?>

            <div class="container my-5">
                <div class="row g-4">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <!-- Card -->
                            <div class="col-md-4">
                                <div class="card">
                                    <!-- Display the image -->
                                    <img src="assets/extras/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                    <div class="context">
                                        <!-- Display the title -->
                                        <h5 class="card-title mt-2"><?php echo htmlspecialchars($row['title']); ?></h5>
                                        <div>
                                            <span class="badge-event">Event</span>
                                            <span class="badge-additional">Additional</span>
                                        </div>
                                        <!-- Display the description -->
                                        <p class="card-text mt-3"><?php echo htmlspecialchars($row['description']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p>No services available.</p>
                        </div>
                    <?php endif; ?>
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
            <section class="review">

    <?php
    require 'db.php';

    $sql = "SELECT reviews.name, users.image_profile, reviews.feedback, reviews.rating, reviews.created_at
            FROM reviews
            INNER JOIN users ON reviews.email = users.email
            WHERE reviews.status = 1";
    $result = $conn->query($sql);

    $reviews = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
    }

    $conn->close();
    ?>

    <p class="review-title text-center mb-0">Customer Review</p>
    <h3 class="text-center">What our customers say</h3>
    <div id="reviewCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php 
            $chunks = array_chunk($reviews, 3);
            foreach ($chunks as $index => $chunk): 
            ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                    <div class="container">
                        <div class="row">
                            <?php foreach ($chunk as $review): ?>
                                <div class="col-md-4">
                                    <div class="card p-3">
                                        <div class="header mb-2">
                                            <div class="review-profile d-flex gap-2 align-items-center">
                                                <img src="assets/profile/<?= htmlspecialchars($review['image_profile']); ?>" 
                                                    alt="Profile Image" 
                                                    style="width: 40px; height: 40px; border-radius: 50%;">
                                                <p class="mb-0 fw-bold"><?= htmlspecialchars($review['name']); ?></p>
                                            </div>
                                        </div>
                                        <div class="review-content">
                                            <p class="mb-0"><?= htmlspecialchars($review['feedback']); ?></p>
                                        </div>
                                        <div class="footer d-flex justify-content-between align-items-center">
                                            <div class="review-rating mt-2">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <?php if ($i <= $review['rating']): ?>
                                                        <i class="fas fa-star text-warning"></i>
                                                    <?php else: ?>
                                                        <i class="far fa-star text-warning"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                            <div class="date-posted mt-2">
                                                <p class="mb-0">Reviewed on <?= date("m/d/y", strtotime($review['created_at'])); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
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
          
</body>
<script src="features/function/map.js"></script>   
<script src="features/function/offer-slider.js"></script>     
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
