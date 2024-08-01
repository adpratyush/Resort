<?php
session_start();

// Logout logic
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

include 'Database/db_connection.php';

// Fetch room details from the database
$sql = "SELECT * FROM Rooms";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
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
    <style>
        body {
            font-family: Arial, sans-serif;
           /* background-image: url('images/banner2.jpeg');
            background-repeat: no-repeat;
            background-size: cover;*/
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            width: 80%;
            max-width: 400px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .modal-buttons button {
            background-color: #007BFF;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .modal-buttons button:hover {
            background-color: #0056b3;
        }

        .modal-buttons .cancel-btn {
            background-color: #6c757d;
        }

        .modal-buttons .cancel-btn:hover {
            background-color: #5a6268;
        }
        .banner {
            width: 100%;
            height: 250px;
            background-image: url('images/banner_image.jpg');
            background-size: cover;
            background-position: center;
            text-align: center;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 36px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<!-- Header -->
<?php include 'partials/custHeader.php'; ?>
<!-- Banner -->
<div class="banner">
    Rooms
</div>

<!-- Section -->
<div class="containerss">
    <div class="containerss">
        <div class="wrapper-containerss">
            <?php
            // Check if there are rooms available
            if ($result->num_rows > 0) {
                // Output data of each room
                while ($row = $result->fetch_assoc()) {
                    $roomImage = $row["room_image"];
                    $roomType = $row["room_type"];
                    $roomPrice = $row["cost"];
            ?>
            <div class="wrapper">
                <div class="banner-image">
                    <img src="<?php echo $roomImage; ?>" alt="Room Image">
                </div>
                <h1><?php echo $roomType; ?></h1>
                <div class="button-wrapper">
                    <form action="bookRoom.php" method="get" onsubmit="return checkLoginStatus();">
                        <input type="hidden" name="room_id" value="<?php echo $row["room_id"]; ?>">
                        <input type="hidden" name="room_type" value="<?php echo $roomType; ?>">
                        <button class="btn outline"><?php echo 'Rs.' . $roomPrice; ?></button>
                        <button type="submit" class="btn fill">BOOK NOW</button>
                    </form>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p class='no-rooms'>No rooms available.</p>";
            }

            // Close database connection
            $conn->close();
            ?>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <p>Please log in to book a room.</p>
    <div class="modal-buttons">
        <button onclick="redirectToLogin()">Log In</button>
        <button class="cancel-btn" onclick="closeModal()">Cancel</button>
    </div>
  </div>
</div>

<script>
    function checkLoginStatus() {
        <?php if (!isset($_SESSION['username'])): ?>
            document.getElementById('loginModal').style.display = 'flex';
            return false;
        <?php endif; ?>
        return true;
    }

    function closeModal() {
        document.getElementById('loginModal').style.display = 'none';
    }

    function redirectToLogin() {
        window.location.href = "login.php";
    }

    window.addEventListener('scroll', function() {
        var header = document.querySelector('.header');
        var navLinks = document.querySelectorAll('.nav-link');
        var scrollTop = window.scrollY;

        if (scrollTop > 0) {
            header.classList.add('fixed-header');
            navLinks.forEach(function(link) {
                link.style.color = 'black';
            });
        } else {
            header.classList.remove('fixed-header');
            navLinks.forEach(function(link) {
                link.style.color = 'white';
            });
        }
    });

    window.onclick = function(event) {
        var modal = document.getElementById('loginModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<?php include 'partials/footer.php'; ?>

</body>
</html>
<!-- Swiper JS -->
<script src="js/swiper-bundle.min.js"></script>

<!-- Scroll Reveal -->
<script src="js/scrollreveal.js"></script>

<!-- JavaScript -->
<script src="js/script.js"></script>
