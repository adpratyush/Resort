<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Include database connection
include 'Database/db_connection.php';

// Retrieve username from session
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        $username = 'Unknown'; // If username is not set in session, set it to a default value
    }

// Include Stripe PHP library
require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51PPm9DErcQnR5DbvJgNPg9myNtjmk3NBuxttNqH2MufsXfeF6PtoQzhiixvFJurEGB41U3PCb5y6Twv41Rctdz3d00vE1kuxYC'); // Replace with your actual Stripe secret key

// Retrieve booking ID from URL parameter or session
if (isset($_GET['booking_id'])) {
    $bookingId = $_GET['booking_id'];
    $_SESSION['booking_id'] = $bookingId;
} elseif (isset($_SESSION['booking_id'])) {
    $bookingId = $_SESSION['booking_id'];
} else {
    $error_message = "Error: Booking ID not provided.";
}

// Fetch booking details from the database
if (isset($bookingId)) {
    $sql = "SELECT bookings.booking_id, Rooms.room_type, Rooms.cost, bookings.room_count, bookings.no_of_days, Customers.username 
            FROM bookings 
            INNER JOIN Rooms ON bookings.room_id = Rooms.room_id 
            INNER JOIN Customers ON bookings.customer_id = Customers.customer_id
            WHERE bookings.booking_id = ? AND bookings.status = 'confirmed'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bookingData = $result->fetch_assoc();
        $roomType = $bookingData['room_type'];
        $cost = $bookingData['cost'];
        $roomCount = $bookingData['room_count'];
        $noOfDays = $bookingData['no_of_days'];
        $username = $bookingData['username'];

        // Calculate total cost
        $totalCost = $roomCount * $cost * $noOfDays;

        // Store room_type, cost, total cost, room_count, and no_of_days in session
        $_SESSION['room_type'] = $roomType;
        $_SESSION['cost'] = $cost;
        $_SESSION['total_cost'] = $totalCost;
        $_SESSION['username'] = $username;
        $_SESSION['room_count'] = $roomCount;
        $_SESSION['no_of_days'] = $noOfDays;
        
    } else {
        $error_message = "Error: Booking not found.";
    }
    $stmt->close();
}

// Process payment action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_method'])) {
    $selectedPayment = $_POST['payment_method'];
    $amount = $_POST['total_cost'];

    if ($selectedPayment === "eSewa") {
        $esewaRedirectUrl = "https://uat.esewa.com.np/epay/main";
        $esewaParams = array(
            'amt' => $amount,
            'txAmt' => 0,
            'psc' => 0,
            'pdc' => 0,
            'tAmt' => $amount,
            'scd' => 'EPAYTEST',
            'pid' => "Booking_" . $bookingId,
            'su' => 'https://localhost/resort/esewa_success.php',
            'fu' => 'https://localhost/resort/failure'
        );

        header("Location: $esewaRedirectUrl?" . http_build_query($esewaParams));
        exit();
    } elseif ($selectedPayment === "Direct Bank Transfer") {
        $cardholderName = $_POST['cardholder_name'];
        $token = $_POST['stripeToken'];

        try {
            $charge = \Stripe\Charge::create([
                'amount' => $amount * 100, // Amount in cents
                'currency' => 'usd',
                'description' => "Payment for booking ID: $bookingId",
                'source' => $token,
                'metadata' => [
                    'booking_id' => $bookingId,
                    'cardholder_name' => $cardholderName
                ],
            ]);

            // Save payment details to the database
            $last4 = substr($charge->payment_method_details->card->last4, -4);
            $stmt = $conn->prepare("INSERT INTO stripepayments (booking_id, amount, cardholder_name, last4, username) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisss", $bookingId, $amount, $cardholderName, $last4, $username);

            $stmt->execute();
            $stmt->close();

            $_SESSION['payment_method'] = $selectedPayment;
            header("Location: bill.php");
            exit();
        } catch (\Stripe\Exception\CardException $e) {
            $error_message = "Error: " . $e->getError()->message;
        }
    } elseif ($selectedPayment === "On Arrival") {
        $_SESSION['payment_method'] = $selectedPayment;
        header("Location: paymentsuccess.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://source.unsplash.com/1920x1080/?payment');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }

        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 15px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        input[type="number"], select, button, input[type="file"], input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
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

        option {
            background-color: #fff;
            color: #333;
        }

        a button {
            width: auto;
            margin-top: 2em;
        }
    </style>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
<div class="container">
    <h2>Payment</h2>
    <?php if (!empty($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>

    <?php if (!empty($bookingData)) { ?>
        <h3>Booking Details</h3>
        <p><strong>Booking ID:</strong> <?php echo $bookingData['booking_id']; ?></p>
        <p><strong>Room Type:</strong> <?php echo $bookingData['room_type']; ?></p>
        <p><strong>Cost per Room per Night:</strong> <?php echo $bookingData['cost']; ?></p>
        <p><strong>Room Count:</strong> <?php echo $roomCount; ?></p>
        <p><strong>Number of Days:</strong> <?php echo $noOfDays; ?></p>
        <p><strong>Total Cost:</strong> <?php echo $totalCost; ?></p>

        <h3>Payment</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="payment-form">
            <input type="hidden" name="booking_id" value="<?php echo $bookingData['booking_id']; ?>">
            <input type="hidden" name="room_type" value="<?php echo $bookingData['room_type']; ?>">
            <input type="hidden" name="customer_id" value="<?php echo $_SESSION['customer_id']; ?>">
            <input type="hidden" name="cost" value="<?php echo $bookingData['cost']; ?>">
            <input type="hidden" name="total_cost" value="<?php echo $totalCost; ?>">

            <label for="payment_amount">Payment Amount:</label>
            <input type="number" id="payment_amount" name="payment_amount" value="<?php echo $totalCost; ?>" readonly><br><br>

            <label for="payment_method">Select Payment Method:</label>
            <select id="payment_method" name="payment_method">
                <option value="eSewa">eSewa</option>
                <option value="Direct Bank Transfer">Direct Bank Transfer</option>
                <option value="On Arrival">On Arrival</option>
            </select><br><br>

            <div id="card-details" style="display: none;">
                <label for="cardholder_name">Cardholder Name:</label>
                <input type="text" id="cardholder_name" name="cardholder_name"><br><br>
                <div id="card-element"></div>
                <div id="card-errors" role="alert"></div>
            </div>

            <button type="submit">Pay</button>
        </form>
        <center><a href="bookings.php"><button>Cancel Payment</button></a></center>
    <?php } ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var stripe = Stripe('pk_test_51PPm9DErcQnR5DbvaedEPkmM1cyK3rNGXNv9mUMttMP2vG8Lbb5W6EgiVa4GXV5awaDYDqkKqpQ73SIf9DVgT5xo00ymJu0bmg'); // Replace with your actual Stripe publishable key
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var card = elements.create('card', {style: style});
    card.mount('#card-element');

    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        var paymentMethod = document.getElementById('payment_method').value;
        if (paymentMethod === 'Direct Bank Transfer') {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);

                    form.submit();
                }
            });
        }
    });
});

function toggleCardDetails(paymentMethod) {
    var cardDetails = document.getElementById('card-details');
    if (paymentMethod === 'Direct Bank Transfer') {
        cardDetails.style.display = 'block';
        document.getElementById('cardholder_name').setAttribute('required', 'required');
    } else {
        cardDetails.style.display = 'none';
        document.getElementById('cardholder_name').removeAttribute('required');
    }
}

document.addEventListener("DOMContentLoaded", function () {
    var paymentMethodSelect = document.getElementById('payment_method');

    // Initial check when page loads
    toggleCardDetails(paymentMethodSelect.value);

    // Listen for changes in the payment method select field
    paymentMethodSelect.addEventListener('change', function () {
        toggleCardDetails(this.value);
    });
});
</script>

</body>
</html>
