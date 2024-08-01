<?php
session_start();

// Enable error reporting and display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'Database/db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['customer_id'])) {
    $_SESSION['error'] = "Please log in to book a room.";
    header("Location: Login.php");
    exit();
}

// Check if room ID and room type are provided
if (!isset($_GET['room_id']) || !isset($_GET['room_type'])) {
    $_SESSION['error'] = "Room ID or room type not provided.";
    header("Location: viewRoom.php");
    exit();
}

// Retrieve room ID and room type from URL parameters
$room_id = $_GET['room_id'];
$room_type = $_GET['room_type'];

// Fetch room details including the room image from the database
$sql_room = "SELECT * FROM Rooms WHERE room_id = ? AND room_type = ?";
$stmt_room = $conn->prepare($sql_room);
$stmt_room->bind_param("is", $room_id, $room_type);
$stmt_room->execute();
$result_room = $stmt_room->get_result();
$row_room = $result_room->fetch_assoc();

// Check if room exists
if (!$row_room) {
    $_SESSION['error'] = "Room not found.";
    header("Location: viewRoom.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_booking'])) {
    // Retrieve form data
    $room_count = $_POST['num_rooms'];
    $customer_id = $_SESSION['customer_id'];
    $username = $_SESSION['username'];
    $checkin_datetime = $_POST['checkin_datetime']; // Assuming you have a form field for selecting date and time
    $checkout_datetime = $_POST['checkout_datetime']; // Assuming you have a form field for selecting date and time

    // Calculate the number of days
    $checkin_date = new DateTime($checkin_datetime);
    $checkout_date = new DateTime($checkout_datetime);
    $interval = $checkin_date->diff($checkout_date);
    $no_of_days = $interval->days;

    // Insert booking into Bookings table
    $sql_insert_booking = "INSERT INTO bookings (customer_id, username, room_id, room_count, room_type, checkin_time, checkout_datetime, no_of_days, status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
    $stmt_insert_booking = $conn->prepare($sql_insert_booking);
    if (!$stmt_insert_booking) {
        $_SESSION['error'] = "Error preparing statement: " . $conn->error;
        header("Location: viewRoom.php");
        exit();
    }

    $stmt_insert_booking->bind_param("ississsi", $customer_id, $username, $room_id, $room_count, $room_type, $checkin_datetime, $checkout_datetime, $no_of_days);
    if ($stmt_insert_booking->execute()) {
        $_SESSION['success'] = "Booking confirmed successfully!";
        header("Location: viewRoom.php");
        exit();
    } else {
        $_SESSION['error'] = "Error confirming booking: " . $conn->error;
        header("Location: viewRoom.php");
        exit();
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://source.unsplash.com/1920x1080/?resort');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .room-details {
            text-align: center;
            margin-bottom: 20px;
        }

        .room-image {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 8px;
            margin: 0 auto 10px;
            display: block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #333;
            margin-bottom: 8px;
        }

        p {
            margin-bottom: 8px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="number"], input[type="datetime-local"], button {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date();
            var yyyy = today.getFullYear();
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var dd = String(today.getDate()).padStart(2, '0');
            var hh = String(today.getHours()).padStart(2, '0');
            var min = String(today.getMinutes()).padStart(2, '0');
            
            var minDateTime = yyyy + '-' + mm + '-' + dd + 'T' + hh + ':' + min;
            
            document.getElementById("checkin_datetime").setAttribute("min", minDateTime);
            document.getElementById("checkout_datetime").setAttribute("min", minDateTime);
        });
    </script>
</head>
<body>

<div class="container">
    <h2>Book Room</h2>
    <div class="room-details">
        <img src="<?php echo $row_room['room_image']; ?>" alt="Room Image" class="room-image">
        <h3>Room Details</h3>
        <p><strong>Room Type:</strong> <?php echo $row_room['room_type']; ?></p>
        <p><strong>Available Rooms:</strong> <?php echo $row_room['room_count']; ?></p>
    </div>

    <?php if (isset($_SESSION['error'])) { ?>
        <p class="error"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php } ?>

    <form method="post">
        <label for="num_rooms">Number of Rooms:</label>
        <input type="number" id="num_rooms" name="num_rooms" min="1" max="<?php echo $row_room['room_count']; ?>" required>
        <br><br>
        <label for="checkin_datetime">Expected Check-in Date and Time:</label>
        <input type="datetime-local" id="checkin_datetime" name="checkin_datetime" required>
        <label for="checkout_datetime">Expected Check-Out Date and Time:</label>
        <input type="datetime-local" id="checkout_datetime" name="checkout_datetime" required>
        <br><br>
        <button type="submit" name="confirm_booking">Confirm Booking</button>
    </form>
</div>

</body>
</html>
