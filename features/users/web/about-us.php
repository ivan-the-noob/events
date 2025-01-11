<?php 

    require '../../../db.php';
    session_start();
    $email = $_SESSION['email'] ?? '';

    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../features/users/css/about-us.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmgygVeipMUsrtGeZPZ9UzXRmcVdheIqw&libraries=places"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Amiel's MOM Event's Place</title>
    <link rel="icon" href="../../../assets/logo.png" type="image/png">
</head>
<body>
        
        <section class="display">
            <div class="navbar-container">
                <div class="col-10 col-md-10">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex gap-3">
                            <img src="../../../assets/logo.png" alt="Logo" style="width: 60px; height: 60px;">
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
                                    <img src="../../../assets/profile/user.png" alt="Profile Image" class="profile" style="width: 30px; height: 30px; margin-left: 5px; margin-right: 5px;">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="dashboard.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="../function/authentication/logout.php">Logout</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="login.php" class="sign-in">Sign In</a>
                        <?php endif; ?>
                               
                            </div>            
                            </ul>
                        </div>        
                    </div>
                </nav> 
                <div class="aboutus-head">
                    <h2 class="text-white fw-bold">About Us</h2>
                    <p class="text-white text-center">Welcome to Amiel's MOM Events Place, where cherished memories are made!</p>
                </div>
            </div>
        </div>
        <section class="about mt-4 mb-4 p-4">
            <p class="about-title text-center">About</p>
            <h3 class="about-h3 text-center">Who are we</h3>

            <div class="container about-img mt-4">
                    <div class="d-flex justify-content-between mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="p-4">At Amiel's MOM Events Place, we believe every occasion deserves to be extraordinary. Founded with a vision to bring dreams to life, we offer a stunning venue that blends elegance, versatility, and a touch of magic to ensure your special moments are unforgettable.</p>
                        </div>
                        <div class="col-md-6">
                            <img src="../../../assets/about/about1.jpg" alt="">
                        </div>
                    </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4 mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="../../../assets/about/about3.jpg" alt="">
                            </div>
                            <div class="col-md-6">
                                <h3 class="mb-0 fw-bold">Our Story</h3>
                                <p class="p-4">
                                Our journey began with a passion for creating beautiful experiences. Inspired by the joy of celebration, we established a space that caters to diverse events, from intimate gatherings to grand celebrations. Over the years, we’ve proudly hosted weddings, birthdays, corporate events, and countless other milestones, building lasting relationships with our clients.</p>
                            </div> 
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="mb-0 fw-bold">Our Mission</h3>
                                <p class="p-4">We are committed to providing exceptional service, seamless event management, and a venue that transforms your vision into reality. At Amiel's MOM Events Place, your satisfaction is our priority, and we aim to exceed your expectations every step of the way.</p>
                            </div>
                            <div class="col-md-6">
                                <img src="../../../assets/about/about4.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4 mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="../../../assets/about/about5.jpg" alt="">
                            </div>
                            <div class="col-md-6">
                                <h3 class="mb-4 fw-bold">Why Choose Us?</h3>
                                <p class="">
                                Choosing Amiel's MOM Events Place means entrusting your celebration to a team that genuinely cares. We understand the importance of your event and strive to make it a stress-free, memorable experience.
                                </p>
                                <p class="">
                                Join the many happy clients who have celebrated life’s special moments with us. Let us help you create memories that last a lifetime!
                                </p>
                                <p class="">
                                    Contact us today to book your next event at Amiel's MOM Events Place.</p>
                            </div> 
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </section>
            
          
</body>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
