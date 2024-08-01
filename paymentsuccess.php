<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'Database/db_connection.php';

// Retrieve payment method and related details from session
$paymentMethod = isset($_SESSION['payment_method']) ? $_SESSION['payment_method'] : '';
$bankAccountNumber = isset($_SESSION['bank_account_number']) ? $_SESSION['bank_account_number'] : '';
$branch = isset($_SESSION['branch']) ? $_SESSION['branch'] : '';
$accountName = isset($_SESSION['account_name']) ? $_SESSION['account_name'] : '';
$bankName = isset($_SESSION['bank_name']) ? $_SESSION['bank_name'] : '';
$esewaId = isset($_SESSION['esewa_id']) ? $_SESSION['esewa_id'] : '';
$cost = isset($_SESSION['cost']) ? $_SESSION['cost'] : '';
$customerId = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : '';
$roomType = isset($_SESSION['room_type']) ? $_SESSION['room_type'] : '';
$bookingId = isset($_SESSION['booking_id']) ? $_SESSION['booking_id'] : '';

// Include database connection
include 'Database/db_connection.php';

// Fetch username from Customers table using customer_id
$username = '';
if (!empty($customerId)) {
    $sql = "SELECT username FROM Customers WHERE customer_id = '$customerId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_payment"])) {
    // Check if file was uploaded without errors
    if (isset($_FILES["receipt_file"]) && $_FILES["receipt_file"]["error"] == UPLOAD_ERR_OK) {
        $targetDir = "images/";
        $fileName = basename($_FILES["receipt_file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow only certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["receipt_file"]["tmp_name"], $targetFilePath)) {
                // Insert payment details into database
                $sql = "INSERT INTO Payments (customer_username, room_type, booking_id, cost, payment_method, receipt_image)
                        VALUES ('$username','$roomType', '$bookingId', '$cost', '$paymentMethod', '$targetFilePath')";
                if ($conn->query($sql) === TRUE) {
                    // Payment successfully confirmed, redirect to bill.php with booking_id and payment_method parameters
                    header("Location: bill.php?booking_id=$bookingId&payment_method=$paymentMethod");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error uploading file: " . $_FILES["receipt_file"]["error"];
            }
        } else {
            echo "Invalid file format. Please upload a JPG, JPEG, PNG, or GIF file.";
        }
    } else {
        // No file uploaded or an error occurred while uploading, insert NULL into database
        $sql = "INSERT INTO Payments (customer_username, room_type, booking_id, cost, payment_method, receipt_image)
                VALUES ('$username','$roomType', '$bookingId', '$cost', '$paymentMethod', NULL)";
        if ($conn->query($sql) === TRUE) {
            // Payment successfully confirmed, redirect to bill.php with booking_id and payment_method parameters
            header("Location: bill.php?booking_id=$bookingId&payment_method=$paymentMethod");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('your-background-image.jpg'); /* Replace 'your-background-image.jpg' with your actual image file */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container {
    width: 90%;
    max-width: 500px; /* Adjust the maximum width as needed */
    margin: 20px;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

p {
    margin-bottom: 10px;
}

form {
    margin-top: 20px;
}

input[type="number"],
select,
button[type="submit"],
input[type="file"] {
    width: 100%;
    margin-bottom: 20px;
    padding: 12px;
    border: 1px solid #007bff;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 16px;
    background-color: #fff;
    color: #007bff;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s;
}

button[type="submit"],
input[type="file"] {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

button[type="submit"]:hover,
input[type="file"]:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

img {
    display: block;
    margin: 0 auto;
    max-width: 100%;
    height: auto;
    margin-top: 20px;
}

a button {
    width: 100%;
    margin-top: 2em;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

/* Responsive Styles */
@media only screen and (max-width: 600px) {
    .container {
        padding: 20px;
    }

    h2 {
        font-size: 1.8rem;
    }

    input[type="number"],
    select,
    button[type="submit"],
    input[type="file"] {
        font-size: 14px;
    }
}

@media only screen and (max-width: 400px) {
    .container {
        margin: 10px;
    }
}

    </style>
</head>
<body>

    <div class="container">
        <h2>Payment Success</h2>

        <h3>Booking Details</h3>
        <p><strong>Customer Username:</strong> <?php echo $username; ?></p>
        <p><strong>Room Type:</strong> <?php echo $roomType; ?></p>
        <p><strong>Booking ID:</strong> <?php echo $bookingId; ?></p>
        <p><strong>Cost:</strong> <?php echo $cost; ?></p>

        <?php if ($paymentMethod === "Direct Bank Transfer") { ?>
            <h3>Bank Transfer Details</h3>
            <p>Bank Account Number: <?php echo $bankAccountNumber; ?></p>
            <p>Branch: <?php echo $branch; ?></p>
            <p>Account Name: <?php echo $accountName; ?></p>
            <p>Bank Name: <?php echo $bankName; ?></p>
            <img src="images/scanner.jpeg" alt="Scanner Photo">
        <?php } elseif ($paymentMethod === "eSewa") { ?>
            <h3>eSewa ID</h3>
            <p>eSewa ID: <?php echo $esewaId; ?></p>
            <img src="images/scanner.jpeg" alt="Scanner Photo">
        <?php } elseif ($paymentMethod === "On Arrival") { ?>
            <h3>On Arrival Payment</h3>
            <p>Please note that a surcharge of 3% will be applied to the total cost for paying on arrival.</p>
            <p>Total Cost (including surcharge): Rs.<?php echo $cost+($cost*3)/100; ?></p>
        <?php } ?>

        <!-- File Upload Section (only shown if payment method is not On Arrival) -->
        <?php if ($paymentMethod !== "On Arrival") { ?>
            <h3>Upload Payment Receipt</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="customer_id" value="<?php echo $customerId; ?>">
                <input type="hidden" name="room_type" value="<?php echo $roomType; ?>">
                <input type="hidden" name="booking_id" value="<?php echo $bookingId; ?>">
                <input type="file" name="receipt_file" accept="image/jpg, image/png, image/jpeg" id="receipt_file">
                <button type="submit" name="confirm_payment">Confirm Payment</button>
            </form>
        <?php } else { ?>
            <!-- Confirm Payment Button -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="customer_id" value="<?php echo $customerId; ?>">
                <input type="hidden" name="room_type" value="<?php echo $roomType; ?>">
                <input type="hidden" name="booking_id" value="<?php echo $bookingId; ?>">
                <button type="submit" name="confirm_payment">Confirm Payment</button>
                
            </form>

        <?php } ?>
        <a href="bookings.php"><button>Cancel Payment</button></a>

    </div>

</body>
</html>
