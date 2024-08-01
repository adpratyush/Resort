<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'Database/db_connection.php';

// Log incoming GET request for debugging
file_put_contents('esewa_success_log.txt', "GET request: " . print_r($_GET, true) . "\n", FILE_APPEND);

// Ensure all required parameters are present in the GET request
if (isset($_GET['amt']) && isset($_GET['oid']) && isset($_GET['refId'])) {
    $amount = $_GET['amt'];
    $oid = $_GET['oid']; // Order ID
    $refId = $_GET['refId']; // Reference ID

    // Extract booking ID from oid
    $bookingId = str_replace("Booking_", "", $oid);

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        $username = 'Unknown'; // If username is not set in session, set it to a default value
    }

    // Insert payment details into the database
    $stmt = $conn->prepare("INSERT INTO esewapayments (booking_id, amount, transaction_id, username) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $bookingId, $amount, $refId, $username);

    
    if ($stmt->execute()) {
        // Redirect to bill.php after successful insertion
        $_SESSION['payment_method'] = "eSewa";
        $_SESSION['booking_id'] = $bookingId;
        $_SESSION['amount'] = $amount;
        $_SESSION['transaction_id'] = $refId;
        header("Location: bill.php");
        exit();
    } else {
        // Log and display error if insertion fails
        $error_message = "Error: " . mysqli_error($conn);
        file_put_contents('esewa_success_log.txt', "Database Error: " . $error_message . "\n", FILE_APPEND);
        echo $error_message;
    }
    $stmt->close();
} else {
    // Log and display error if required parameters are missing
    file_put_contents('esewa_success_log.txt', "Invalid request: Missing required parameters.\n", FILE_APPEND);
    echo "Invalid request.";
}
?>
