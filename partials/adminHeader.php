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
<!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="css/demo.css">

  <!----===== Boxicons CSS ===== -->
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

  <!--<title>Dashboard Sidebar Menu</title>-->
</head>
<body>
<nav class="sidebar close">
    <header>
      <div class="image-text">
        <span class="image">
          <i class='bx bx-coffee logo-icon'></i>
        </span>

        <div class="text logo-text">
          <span class="name">Aranya Soukhya</span>
        </div>
      </div>

      <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
      <div class="menu">

        <ul class="menu-links">
          <li class="nav-link">
            <a href="welcomeadmin.php">
              <i class='bx bx-home-alt icon'></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="addrooms.php">
              <i class='bx bx-bar-chart-alt-2 icon'></i>
              <span class="text nav-text">Add Rooms</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="viewBooking.php">
              <i class='bx bx-book icon'></i>
              <span class="text nav-text">Bookings</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="inout.php">
              <i class='bx bx-pie-chart-alt icon'></i>
              <span class="text nav-text">Checkin/Out</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="paidCustomer.php">
              <i class='bx bx-money icon'></i>
              <span class="text nav-text">Paid Customer</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="details.php">
              <i class='bx bx-history icon'></i>
              <span class="text nav-text">History</span>
            </a>
          </li>

        </ul>
      </div>

      <div class="bottom-content">
        <li class="">
          <a href="?logout=true">
            <i class='bx bx-log-out icon'></i>
            <span class="text nav-text">Logout</span>
          </a>
        </li>

      </div>
    </div>

  </nav>
  <body>
  
<script src="js/demo.js"></script>

</body>

</html>