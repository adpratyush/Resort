<?php
// Start the session if it's not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection file
include 'Database/db_connection.php';

// Check if logout link is clicked
if(isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to index.php page
    header("Location: index.php");
    exit;
}

// Check if user is logged in
$loggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        <div class="menu-content flex">
            <ul class="menu-list flex">
                <?php if($loggedIn): ?>
                    <?php if($_SESSION['role'] == 'customer'): ?>
                        <!-- Show links for logged-in customers -->
                        <li><a href="welcomeCustomer.php" class="nav-link">Home</a></li>
                        <li><a href="viewRoom.php" class="nav-link">Rooms</a></li>
                        <li><a href="bookings.php" class="nav-link">My Bookings</a></li>
                    <?php elseif($_SESSION['role'] == 'admin'): ?>
                        <!-- Show links for logged-in admins -->
                        <li><a href="welcomeadmin.php" class="nav-link">Admin Home</a></li>
                        <!-- Add more admin links here -->
                    <?php endif; ?>
                    <li><a href="?logout=true" class="nav-link">Logout</a></li>
                <?php else: ?>
                    <!-- Show links for non-logged-in users -->
                    <li><a href="index.php" class="nav-link">Home</a></li>
                    <a href="viewRoom.php" class="nav-link">Rooms</a>
                    <li><a href="about.php" class="nav-link">About</a></li>
                    <li><a href="gallery.php" class="nav-link">Gallery</a></li>
                    <li><a href="contact.php" class="nav-link">Contact</a></li>
                    <!-- Add more non-logged-in links here -->
                <?php endif; ?>
            </ul>

            <?php if(!$loggedIn): ?>
                <div class="auth-links flex">
                    <a href="login.php" class="nav-link">Login</a>
                </div>
            <?php endif; ?>

            <!-- Social media icons -->
            <div class="media-icons flex">
                <a href="https://www.facebook.com"><i class='bx bxl-facebook'></i></a>
                <a href="https://twitter.com/i/flow/login"><i class='bx bxl-twitter' ></i></a>
                <a href="https://www.instagram.com/accounts/login"><i class='bx bxl-instagram-alt' ></i></a>
                <a href="https://github.com/login"><i class='bx bxl-github'></i></a>
                <a href="https://www.youtube.com/login"><i class='bx bxl-youtube'></i></a>
            </div>

            <i class='bx bx-x navClose-btn'></i>
        </div>
        
        <!-- Contact information -->
        <div class="contact-content flex">
            <i class='bx bx-phone phone-icon'></i>
                <a href="https://api.whatsapp.com/send/?phone=918861417390&text&type=phone_number&app_absent=0" target="_blank">
                    <span class="phone-number">+977-9840030049</span>
                </a>
        </div>

        <!-- Menu toggle button -->
        <i class='bx bx-menu navOpen-btn'></i>
    </nav>
</header>

</body>
</html>
<!-- Swiper JS -->
<script src="js/swiper-bundle.min.js"></script>

<!-- Scroll Reveal -->
<script src="js/scrollreveal.js"></script>

<!-- JavaScript -->
<script src="js/script.js"></script>
