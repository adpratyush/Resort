<?php
session_start();

if (!isset($_SESSION['booking_id'], $_SESSION['room_type'], $_SESSION['cost'], $_SESSION['total_cost'], $_SESSION['payment_method'], $_SESSION['username'], $_SESSION['room_count'], $_SESSION['no_of_days'])) {
    header("Location: payment.php");
    exit();
}

$bookingId = $_SESSION['booking_id'];
$room = $_SESSION['room_type'];
$amt = $_SESSION['cost'];
$amount = $_SESSION['total_cost'];
$transactionId = isset($_SESSION['transaction_id']) ? $_SESSION['transaction_id'] : '';
$paymentMethod = $_SESSION['payment_method'];
$username = $_SESSION['username'];
$roomCount = $_SESSION['room_count'];
$noOfDays = $_SESSION['no_of_days'];

// Redirect back to bookings.php after download
$redirectUrl = 'bookings.php';

// Generate PDF and redirect script
$pdfScriptUrl = 'download.php'; // Adjust based on your download.php script location

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .invoice-box {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        .invoice-box h1, .invoice-box h2, .invoice-box h3, .invoice-box p {
            margin: 0;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-header h1 {
            font-size: 36px;
            color: #333;
        }
        .invoice-header img {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .invoice-info {
            margin-bottom: 40px;
        }
        .invoice-info div {
            margin-bottom: 10px;
        }
        .invoice-info div span {
            display: inline-block;
            min-width: 150px;
            font-weight: bold;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-table th, .invoice-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        .invoice-table th {
            background-color: #f7f7f7;
            font-weight: bold;
        }
        .invoice-footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 30px;
        }
        .invoice-footer .signature {
            display: inline-block;
            margin-top: 30px;
            width: 200px;
            border-top: 1px solid #ddd;
        }
        .invoice-footer p {
            margin: 5px 0;
        }
        .download-button {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .download-button:hover {
            background-color: #45a049;
        }
        @media (max-width: 600px) {
            .invoice-box {
                padding: 20px;
            }
            .invoice-header h1 {
                font-size: 24px;
            }
            .invoice-header img {
                max-width: 80px;
            }

            .invoice-info div span {
                min-width: 80px;
            }
            .invoice-table th, .invoice-table td {
                padding: 3px;
            }
            .download-button {
                width: 50%;
            }
        }
    </style>

</head>
<body>
    <div class="invoice-box">
        <div class="invoice-header">
            <img src="logo.png" alt="Company Logo">
            <h1>INVOICE</h1>
        </div>
        <div class="invoice-info">
            <div>
                <span>BILL TO:</span> <?php echo htmlspecialchars($username); ?>
            </div>
            <div>
                <span>Booking ID:</span> <?php echo htmlspecialchars($bookingId); ?>
            </div>
            <div>
                <span>FROM:</span> Aranya Soukhya<br>
            </div>
            <div>
                <span>Date:</span> <?php echo date("d/m/Y"); ?>
            </div>
            <div>
                <span>Invoice No:</span> <?php echo htmlspecialchars($bookingId); ?>
            </div>
        </div>
        <table class="invoice-table">
            <tr>
                <th>Rooms</th>
                <th>Room Count</th>
                <th>Number of Days</th>
                <th>Cost Per Night</th>
                <th>Payment Method</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($room); ?></td>
                <td><?php echo htmlspecialchars($roomCount); ?></td>
                <td><?php echo htmlspecialchars($noOfDays); ?></td>
                <td><?php echo htmlspecialchars($amt); ?></td>
                <td><?php echo htmlspecialchars($paymentMethod); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right;">Total amount</td>
                <td><?php echo htmlspecialchars($amount); ?></td>
            </tr>
        </table>
        <div class="invoice-footer">
            <div class="signature">
                <img src="images/snowpal.png" style="width:80px;height:80px;">
            </div>
            <p>Signature</p>
            <p>Thank you!</p>
            <p>www.aranyasoukhya.com</p>
        </div>
    </div>
    <a href="<?php echo $pdfScriptUrl; ?>" id="download-button" class="download-button" onclick="downloadPdf()">Download PDF</a>

    <script>
        function downloadPdf() {
            // Redirect to bookings.php after download
            setTimeout(function() {
                window.location.href = "<?php echo $redirectUrl; ?>";
            }, 1000); // 1000 milliseconds = 1 second
        }
    </script>
</body>
</html>

