<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: customerLogin.php");
    exit();
}

// Include database connection
include 'Database/db_connection.php';

// Retrieve customer ID from session
$customerId = $_SESSION['customer_id'];

// Fetch bookings associated with the customer including room type and room image
$sql = $sql = "SELECT bookings.booking_id, Rooms.room_type, Rooms.room_image, bookings.status 
FROM bookings 
INNER JOIN Rooms ON bookings.room_id = Rooms.room_id
WHERE bookings.customer_id = '$customerId'
ORDER BY bookings.booking_id DESC";

$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



// Process cancel booking action
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cancel_booking'])) {
        $bookingId = $_POST['booking_id'];
        // Perform cancellation action
        $sql_cancel = "DELETE FROM bookings WHERE booking_id = '$bookingId'";
        if ($conn->query($sql_cancel) === TRUE) {
            // Redirect back to the same page
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        } else {
            // Error message
            echo "Error canceling booking: " . $conn->error;
        }
    }
}
// Function to check if a booking ID is paid
function isBookingPaid($conn, $bookingId) {
    $sql = "SELECT * FROM esewapayments WHERE booking_id = '$bookingId'";
    $result = $conn->query($sql);
    return $result->num_rows > 0;
}

function Isstripepaid($conn, $bookingId) {
    $sql = "SELECT * FROM stripepayments WHERE booking_id = '$bookingId'";
    $result = $conn->query($sql);
    return $result->num_rows > 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Google Fonts Poppins */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    /* background-color: #f0f0f0; */
    background-image:url('images/ban1.jpeg');
    background-size:cover;
    background-repeat:no repeat;
}

.containersss {
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: -1;
    margin-top:5em
}

h2 {
    margin-top: 0;
    color: #333;
}

.booking-card {
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}

.booking-details {
    display: flex;
    align-items: center;
}

.booking-details img {
    width: 180px; /* Adjust the width of the image */
    height: auto;
    object-fit: cover;
}

.booking-info {
    padding: 10px;
    flex-grow: 1; /* Allow the info section to grow */
}

.booking-actions {
    padding: 10px;
    background-color: #f9f9f9;
    display: flex;
    justify-content: flex-end; /* Align actions to the right */
}

.booking-actions button {
    margin-left: 10px; /* Add spacing between buttons */
    padding: 8px 16px;
    background-color: #e74c3c;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.booking-actions button:hover {
    background-color: #c0392b;
}

.btn-pay button {
    background-color: #3498db;
}

.btn-pay button:hover {
    background-color: #2980b9;
}

p {
    margin: 5px 0;
}



    </style>
</head>
<body>
    <?php include 'partials/custHeader.php'; ?>
    
    <div class="containersss">
        <h1 style="margin-top: 1em;">Available Rooms</h1>

        <?php if ($result->num_rows > 0) { ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="booking-card">
                    <div class="booking-details">
                        <img src="<?php echo $row['room_image']; ?>" alt="Room Image">
                        <div class="booking-info">
                            <p><strong>Booking ID:</strong> <?php echo $row['booking_id']; ?></p>
                            <p><strong>Room Type:</strong> <?php echo $row['room_type']; ?></p>
                            <p><strong>Status:</strong> <?php echo $row['status']; ?></p>
                        </div>
                    </div>
                    <div class="booking-actions">
                        <?php if ($row['status'] == 'pending') { ?>
                            <form method="post">
                                <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                <button type="submit" name="cancel_booking">Cancel Booking</button>
                            </form>
                        <?php } ?>
                        <?php if ($row['status'] == 'cancelled') { ?>
                            Your booking has been Cancelled.
                        <?php } ?>
                        <?php if ($row['status'] == 'confirmed') { ?>
                            <?php if (isBookingPaid($conn, $row['booking_id']) || Isstripepaid($conn, $row['booking_id'])) { ?>
                                <button type="button" disabled>Paid</button>
                            <?php } else { ?>
                                <a href="payment.php?booking_id=<?php echo $row['booking_id']; ?>" class="btn-pay">
                                    <button type="button">Pay Now</button>
                                </a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No bookings found.</p>
        <?php } ?>
    </div>

    <?php include 'partials/footer.php'; ?>
</body>
</html>


