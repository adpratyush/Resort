<?php
session_start();

// Include database connection
include 'Database/db_connection.php';

$message = '';
$error_message = '';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: customerLogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $checkin_date = $_POST['checkin_date'];
    $checkin_time = $_POST['checkin_time'];
    $checkout_date = $_POST['checkout_date'];
    $checkout_time = $_POST['checkout_time'];

    // Update data in the checkinout table
    $sql_update = "UPDATE checkinout 
                   SET checkin_date = '$checkin_date', checkin_time = '$checkin_time', checkout_date = '$checkout_date', checkout_time = '$checkout_time' 
                   WHERE booking_id = $booking_id";
    
    if ($conn->query($sql_update) === TRUE) {
        $message = "Check-in and check-out details updated successfully!";
    } else {
        $error_message = "Error updating check-in and check-out details: " . $conn->error;
    }
}

// Redirect back to inout.php with a message
header("Location: inout.php?message=$message&error_message=$error_message");
exit();
?>
