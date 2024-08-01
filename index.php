<?php

include 'Database/db_connection.php';

// Fetch room details from the database
$sql = "SELECT * FROM Rooms LIMIT 4";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aranya Soukhya</title>
    <link rel="icon" href="images/ban1.jpeg" type="image/x-icon"/>
    <!-- Swiper JS CSS-->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <!-- Scroll Reveal -->
    <link rel="stylesheet" href="css/scrollreveal.min.js">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/rooms.css">
    <link rel="stylesheet" href="css/about.css">
</head>
<body>
<!-- Header -->
<header class="header">
            <nav class="nav container flex">
                    <a href="#" class="logo-content flex">
                        <span class="logo-text">Aranya Soukhya</span>
                    </a>

                    <div class="menu-content">
                            <ul class="menu-list flex">
                                <li><a href="index.php" class="nav-link">Home</a></li>
                                <li><a href="viewRoom.php" class="nav-link">Rooms</a></li>
                                <li><a href="about.php" class="nav-link">About</a></li>
                                <li><a href="gallery.php" class="nav-link">Gallery</a></li>
                                <li><a href="contact.php" class="nav-link">Contact</a></li>
                                <li><a href="login.php" class="nav-link">Login</a></li>



                            </ul>

                            <div class="media-icons flex">
                                    <a href="https://www.facebook.com"><i class='bx bxl-facebook'></i></a>
                                    <a href="https://twitter.com/i/flow/login"><i class='bx bxl-twitter' ></i></a>
                                    <a href="https://www.instagram.com/accounts/login"><i class='bx bxl-instagram-alt' ></i></a>
                                    <a href="https://github.com/login"><i class='bx bxl-github'></i></a>
                                    <a href="https://www.youtube.com/login"><i class='bx bxl-youtube'></i></a>
                            </div>

                            <i class='bx bx-x navClose-btn'></i>
                        </div>
                        
                        <div class="contact-content flex">
                                <i class='bx bx-phone phone-icon'></i>
                                <a href="https://api.whatsapp.com/send/?phone=918861417390&text&type=phone_number&app_absent=0" target="_blank">
                                        <span class="phone-number">+977-9840030049</span>
                                </a>
                        </div>

                        <i class='bx bx-menu navOpen-btn'></i>
                </nav>
        
</header>

<!-- Home Section -->
        <section class="home" id="home">
                <div class="home-content">
                        <div class="swiper mySwiper data-autoplay="{&quot;delay&quot;: 5000}"">
                                <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                                <img src="images/ban1.jpeg" alt="" class="home-img">

                                                <div class="home-details">
                                                        <div class="home-text">
                                                                <h4 class="homeSubtitle">We really like what we do.</h4>
                                                                <h2 class="homeTitle">Coffee Beans with a <br> Perfect Aroma</h2>
                                                        </div>

                                                        <button class="button">Explore</button>
                                                </div>
                                        </div>

                                        <div class="swiper-slide">
                                                <img src="images/ban2.jpeg" alt="" class="home-img">

                                                <div class="home-details">
                                                        <div class="home-text">
                                                                <h4 class="homeSubtitle">Enjoy the finest coffee drinks.</h4>
                                                                <h2 class="homeTitle">Enjoy Our Exclusive <br> Coffee and Cocktails</h2>
                                                        </div>

                                                        <button class="button">Explore</button>
                                                </div>
                                        </div>

                                        <div class="swiper-slide">
                                                <img src="images/ban3.jpeg" alt="" class="home-img">

                                                <div class="home-details">
                                                        <div class="home-text">
                                                                <h4 class="homeSubtitle">Making Our coffee with lover.</h4>
                                                                <h2 class="homeTitle">Alluring and Fragrant <br> Coffee Aroma</h2>
                                                        </div>

                                                        <button class="button">Explore</button>
                                                </div>
                                        </div>
                                </div>

                                <div class="swiper-button-next swiper-navBtn"></div>
                                <div class="swiper-button-prev swiper-navBtn"></div>
                                <div class="swiper-pagination"></div>
                        </div>
                </div>
        </section>
<!-- About Us -->
        <section class="section about" id="about">
                <div class="about-content container">
                        <div class="about-imageContent">
                                <img src="images/aboutus.jpeg" alt="" class="about-img">

                                <div class="aboutImg-textBox">
                                        <i class='bx bx-heart heart-icon flex'></i>
                                        <p class="content-description">Indulge in Tranquil Luxury. Where Serenity Meets Adventure.</p>
                                </div>
                        </div>

                        <div class="about-details">
                                <div class="about-text">
                                        <h4 class="content-subtitle"><i>Our Resort</i></h4>
                                        <h2 class="content-title">We Combine Classics <br> and Modernity</h2>
                                        <p class="content-description">We appreciate your trust greatly. 
                                        Choose Serenity, Choose Excellence. Where Luxury Meets Perfection.</p>

                                        <!-- <ul class="about-lists flex">
                                                <li class="about-list">Cappucino</li>
                                                <li class="about-list dot">.</li>
                                                <li class="about-list">Late</li>
                                                <li class="about-list dot">.</li>
                                                <li class="about-list">Arabica</li>
                                        </ul> -->
                                </div>

                                <div class="about-buttons flex">
                                        <button class="button">About Us</button>
                                        <a href="about.php" class="about-link flex">
                                                <span class="link-text">see more</span>
                                                <i class='bx bx-right-arrow-alt about-arrowIcon'></i>
                                        </a>
                                </div>
                        </div>

                </div>
        </section>
<!-- Section -->
        <section class="section menu" id="menu">
                <h2 style="text-align:center;color:white;">Our Popular Rooms</h2>

                <div class="containerss">
                        <div class="wrapper-containerss">
                                <?php if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) { ?>
                                        <div class="wrapper">
                                                <div class="banner-image">
                                                        <img src="<?php echo $row['room_image']; ?>" alt="">
                                                </div>
                                                <h1 style="color:white;"><?php echo $row['room_type']; ?></h1>
                                                <div class="button-wrapper">
                                                        <button class="btn outline"><?php echo 'Rs.' . $row['cost']; ?></button>
                                                </div>
                                        </div>
                                <?php }
                                } ?>
                        </div>
                </div>
        </section>

<!-- Reviews Section -->
        <section class="section review" id="review">
            <div class="review-container container">
                    <div class="review-text">
                            <h4 class="section-subtitle"><i>Reviews</i></h4>
                            <h2 class="section-title">What Clients Says</h2>
                            <p class="section-description">Some reviews that customer said</p>
                    </div>

                    <div class="tesitmonial swiper mySwiper">
                            <div class="swiper-wrapper">
                                    <div class="testi-content swiper-slide flex">
                                            <img src="Images/gym.webp" alt="" class="review-img">
                                            <p class="review-quote">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea, ad.</p>
                                            <i class='bx bxs-quote-alt-left quote-icon'></i>

                                            <div class="testi-personDetails flex">
                                                    <span class="name">dfdasgfds</span>
                                                    <span class="job">App Developer</span>
                                            </div>
                                    </div>
                                    <div class="testi-content swiper-slide flex">
                                            <img src="images/resturant.webp" alt="" class="review-img">
                                            <p class="review-quote">fkds hfidshfi dkhfksdahfkds ih gsdfhidshfgi eh hgidsfhdifids f dsfhids fids fids</p>
                                            <i class='bx bxs-quote-alt-left quote-icon'></i>

                                            <div class="testi-personDetails flex">
                                                    <span class="name">dfadsg</span>
                                                    <span class="job">App Developer</span>
                                            </div>
                                    </div>
                                    <div class="testi-content swiper-slide flex">
                                            <img src="Images/massage.jpeg" alt="" class="review-img">
                                            <p class="review-quote">gfdsjfaghih vi ifhdsi f8sijdsfigdfk fhgkdfsgfdsgkfdhg</p>
                                            <i class='bx bxs-quote-alt-left quote-icon'></i>

                                            <div class="testi-personDetails flex">
                                                    <span class="name">dfads</span>
                                                    <span class="job">App Developer</span>
                                            </div>
                                    </div>
                                </div>
                                <div class="swiper-button-next swiper-navBtn"></div>
                                <div class="swiper-button-prev swiper-navBtn"></div>
                                <div class="swiper-pagination"></div>
                    </div>
            </div>
        </section>

<!-- Footer -->
<footer>
        <section class="slogan-section">
                <div class="containerrr">
                <h3 class="slogan-text">CREATE MEMORIES WITH US THAT WOULD NEVER FADE</h3>
                <a href="viewRoom.php" class="book-now-button">Book Now</a>
                </div>
                <img src="images/resort.jpeg" alt="Slogan Image" class="slogan-image">
        </section>
        <div class="section footer">
            <div class="footer-container container">
                    <div class="footer-content">
                        <a href="#" class="logo-content flex">
                                <i class='bx bx-coffee logo-icon'></i>
                                <span class="logo-text">Aranya Soukhya</span>
                            </a>

                            <p class="content-description"> ndsfdsf gdf kdsfhg kdsfg kdshg adsfgo dsgidsgiorh gdfsgo</p>

                            <div class="footer-location flex">
                                <i class='bx bx-map map-icon'></i>
                                
                                <div class="location-text">
                                        Neelkantha 06,Dhading Nepal.
                                </div>
                            </div>
                    </div>

                    <div class="footer-linkContent">
                            <ul class="footer-links">
                                    <h4 class="footerLinks-title">Facility</h4>

                                    <li><a href="#" class="footer-link">Private Room</a></li>
                                    <li><a href="#" class="footer-link">Meeting Room</a></li>
                                    <li><a href="#" class="footer-link">Event Room</a></li>
                                    <li><a href="#" class="footer-link">Gym</a></li>
                                    <li><a href="#" class="footer-link">Swimming Pool</a></li>
                            </ul>
                            <ul class="footer-links">
                                    <h4 class="footerLinks-title">Facility</h4>

                                    <!-- <li><a href="#" class="footer-link">Resturant</a></li> -->
                                    <li><a href="#" class="footer-link">Beverages</a></li>
                                    <li><a href="#" class="footer-link">Dishes</a></li>
                            </ul>
                            <ul class="footer-links">
                                    <h4 class="footerLinks-title">Support</h4>

                                    <li><a href="about.php" class="footer-link">About Us</a></li>
                                    <li><a href="gallery.php" class="footer-link">Gallery</a></li>
                                    <li><a href="contact.php" class="footer-link">Contact Us</a></li>
                                    <li><a href="#" class="footer-link">Help Us</a></li>
                            </ul>
                    </div>
            </div>
            <div class="footer-copyRight">Aranya Soukhya &#169;. All rigths reserved</div>
        </div>
</footer>

<!-- Scroll Up -->
        <a href="#home" class="scrollUp-btn flex">
                <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
        </a>
    
        

</body>
</html>
<!-- Swiper JS -->
<script src="js/swiper-bundle.min.js"></script>

<!-- Scroll Reveal -->
<script src="js/scrollreveal.js"></script>

<!-- JavaScript -->
<script src="js/script.js"></script>
