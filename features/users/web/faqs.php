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
    <link rel="stylesheet" href="../../../features/users/css/faqs.css">
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
                            <h7 class=" text-center text-white d-flex align-items-center fw-bold mb-0">Amiel's MOM</h7>
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
                    <h1 class="text-white fw-bold text-center mt-4 mb-0">FAQ</h1>
                    <h5 class="text-white  text-center mt-2">How can we help you?</h5>
                    <div class="faq-search mb-4 mt-4">
                        <input type="text" id="faqSearchInput" class="search-input" placeholder="Search FAQs...">
                    </div>
                </div>
                <div class="faqs-content">
                        <div class="row" id="faqContainer">
                            <div class="col-md-4">
                                <div class="card">
                                <div class="card-body d-flex flex-column mt-4 align-items-center">
                                    <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4 d-flex">
                        </div>
                                        <h7 class=" text-center text-black fw-bold"> Who owns Amiel's MOM Events Place?</h7>
                                        <p class="text-start">The owner is Arlene Tacos-Alvarez.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold"> Where is Amiel's MOM Events Place located?</h7>
                                        <p class="text-start">We are located at Epza-Bacao Road, General Trias, Cavite.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                <div class="card-body d-flex flex-column mt-4 align-items-center">
                                    <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">What is the minimum number of guests required per catering?</h7>
                                        <p class="text-start">We require a minimum of 50 guests per catering.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">What is the maximum number of guests you can accommodate?</h7>
                                        <p class="text-start">We have catered events for up to 100 guests.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">What are the details of your packages?</h7>
                                        <p class="text-start">Please contact us to receive detailed information about our packages, including pricing and guest count. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">How much is the additional fee for excess guests?</h7>
                                        <p class="text-start">There is a charge of ₱400 per additional guest. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">What other services can be added to a package?</h7>
                                        <p class="text-start">Our packages already include a photobooth and sound system. Additional services we offer include: Light & sounds, Event host, magicians, mascosts, photo and video coverage </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold"> Is there an additional fee for bringing our own equipment or booths?</h7>
                                        <p class="text-start">No additional fees are charged for using your own photobooth or other equipment that requires electricity.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">What food options are included in your catering?</h7>
                                        <p class="text-start">We provide a food tray setup. Please contact us for the full menu.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">Is there a corkage fee for bringing our own food?</h7>
                                        <p class="text-start">Yes, a corkage fee of ₱500 per dish will be charged for food items brought in by clients.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">What amenities are included in your packages?</h7>
                                        <p class="text-start">Our amenities include: Venue, Stage, Comfort room, Changing room, Parking lot</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">What are your terms and conditions?</h7>
                                        <p class="text-start">Terms and conditions are outlined in our contract. Please contact us for more details.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">How many parties can you cater to in a day?</h7>
                                        <p class="text-start">2 parties in a day.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">How long is each event?</h7>
                                        <p class="text-start">Each event includes 5 hours of free use.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">Is there an additional fee if the event unexpectedly goes over time?</h7>
                                        <p class="text-start">Yes, an extra charge of ₱1,000 per hour applies.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">What are your operating hours for events?</h7>
                                        <p class="text-start">Event start times are flexible and depend on the client's preference.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">Are there days you do not cater to events?</h7>
                                        <p class="text-start">We usually do not cater on Christmas and New Year, but we can make exceptions for bookings.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">Can we rent just the venue?</h7>
                                        <p class="text-start">Yes, venue-only rentals are available.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body d-flex flex-column mt-4 align-items-center">
                                        <div class="img-div">
                                        <img src="../../../assets/faqs/icon.png" class="mb-4">
                        </div>
                                        <h7 class=" text-center text-black fw-bold">Is the venue pet-friendly?</h7>
                                        <p class="text-start">Yes, our venue is pet-friendly!</p>
                                    </div>
                                </div>
                            </div>
                            
                            
                           
                            
                           
                            
                        </div>
                    
                </div>
                

            </div>
        </div>
       
            
          
</body>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.getElementById("faqSearchInput").addEventListener("keyup", function () {
    const query = this.value.toLowerCase(); 
    const cards = document.querySelectorAll("#faqContainer .card");

    cards.forEach((card) => {
        const title = card.querySelector("h7").textContent.toLowerCase(); 
        const content = card.querySelector("p").textContent.toLowerCase();

        if (title.includes(query) || content.includes(query)) {
        card.parentElement.style.display = "";
        } else {
        card.parentElement.style.display = "none";
        }
    });
    });
</script>
</html>
