<?php 

    require '../../../db.php';
    session_start();
    $email = $_SESSION['email'] ?? '';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../features/users/css/contact_us.css">
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
                                    <a class="nav-link" href="#contact-us">Contact Us</a>
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
                        <?php else: ?>
                            <a href="login.php" class="sign-in">Sign In</a>
                        <?php endif; ?>
                               
                            </div>            
                            </ul>
                        </div>        
                    </div>
                </nav> 
                <div class="aboutus-head">
                    <h1 class="text-white fw-bold text-center mt-4">Get in Touch</h1>
                    <p class="text-white text-center">Have questions or ready to start planning? Our team is here to help you bring your vision to life. Wheter
                        you're curious about our services, need guidance on menu options, or want to book a venue, we're just a message or call away.
                    </p>
                
                </div>
                <div class="container content text-white">
                    <div class="row">
                        <div class="col-md-5">
                            <h3 class="fw-bold">Contact Us</h3>
                            <div class="contents">
                                <div class="d-flex gap-2 mb-4">
                                    <img src="../../../assets/contact/call.png" alt="">
                                    <div class="d-flex flex-column">
                                        <p class="mb-0">Phone</p>
                                        <p class="mb-0">(09)33-818-2822</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 mb-4">
                                    <img src="../../../assets/contact/mail.png" alt="">
                                    <div class="d-flex flex-column">
                                        <p class="mb-0">Mail</p>
                                        <p class="mb-0">amielsevents@gmail.com</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 mb-4">
                                    <img src="../../../assets/contact/location.png" alt="">
                                    <div class="d-flex flex-column">
                                        <p class="mb-0">Location</p>
                                        <p class="mb-0">Epza-Bacao Road, General Trias, Cavite.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-card">
                                <h5 class="mb-4">Let's Talk</h5>
                                <form action="../function/php/submit_contact.php" method="POST">
                                    <div class="mb-3">
                                        <input type="text" class="form-control form-control-line mb-2" name="name" id="name" placeholder="Enter your full name" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control form-control-line mb-2" name="email" id="email" placeholder="Enter your email" required>
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control form-control-line mb-2" id="message" name="message" rows="2" placeholder="Enter your message" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-light w-25">Submit</button>
                                </form>
                            </div>
                        </div>

                       
                    </div>
                </div>

            </div>
        </div>
       
            
          
</body>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
