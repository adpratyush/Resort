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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if booking ID is set in POST
    if (isset($_POST['update_booking'])) {
        // Get the booking ID from the POST data
        $booking_id = $_POST['update_booking'];
        
        // Get the check-in and check-out datetime from the POST data
        $checkin_datetime = $_POST['checkin_time'][$booking_id];
        $checkout_datetime = $_POST['checkout_datetime'][$booking_id];
        $roomnumber = $_POST['roomnumber'][$booking_id];

        // Calculate the number of days between check-in and check-out
        $checkin_date = new DateTime($checkin_datetime);
        $checkout_date = new DateTime($checkout_datetime);
        $interval = $checkin_date->diff($checkout_date);
        $no_of_days = $interval->days;

        // Update data in the bookings table
        $sql_update = "UPDATE bookings 
                       SET checkin_time = '$checkin_datetime', checkout_datetime = '$checkout_datetime', roomnumber = '$roomnumber', no_of_days = $no_of_days
                       WHERE booking_id = $booking_id";
        
        if ($conn->query($sql_update) === TRUE) {
            $message = "Check-in and check-out details updated successfully!";
        } else {
            $error_message = "Error updating check-in and check-out details: " . $conn->error;
        }
    }
}

// Fetch bookings with status 'confirmed'
$sql_select = "SELECT * FROM bookings WHERE status = 'confirmed'";
$result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings - Admin Panel</title>
    <style>
        /* Styles remain the same */
        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
        .main{
            margin-top:5em;
            max-width:1243px;
        }
        .container {
            margin: 20px auto;
            width: 100%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color:#fff;
            border-radius:30px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        input[type="datetime-local"], input[type="text"] {
            width: 180px;
            padding: 5px;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            color: green;
        }
        .error {
            color: red;
        }
        /* Custom Modal CSS */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    padding-top: 60px;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    animation: slideIn 0.3s;
}

@keyframes slideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-header, .modal-body, .modal-footer {
    padding: 10px 20px;
}

.modal-header {
    background-color: #4CAF50;
    color: white;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
}

.modal-header .close {
    font-size: 28px;
    font-weight: bold;
    color: white;
    cursor: pointer;
}

.modal-header .close:hover {
    color: #ccc;
}

.modal-body p {
    margin: 20px 0;
    font-size: 16px;
    color: #333;
}

.modal-footer {
    text-align: right;
}

.modal-footer button {
    margin-left: 10px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.modal-footer button.cancel {
    background-color: #f44336;
    color: white;
}

.modal-footer button.cancel:hover {
    background-color: #e53935;
}

.modal-footer button.confirm {
    background-color: #4CAF50;
    color: white;
}

.modal-footer button.confirm:hover {
    background-color: #45a049;
}

    </style>
    <script>
        function showModal(bookingId) {
            document.getElementById('update_booking_id').value = bookingId;
            document.getElementById('confirmationModal').style.display = "block";
        }

        function hideModal() {
            document.getElementById('confirmationModal').style.display = "none";
        }

        function confirmUpdate() {
            hideModal();
            document.getElementById('updateForm').submit();
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('button[name="update_booking"]').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    showModal(this.value);
                });
            });
        });
    </script>
</head>
<body>
<?php include 'partials/adminHeader.php';?>

    <section class="home">
    <div class="container">
        <h2>Confirmed Bookings</h2>
        
        <?php if (!empty($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>
        <?php if (!empty($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>

        <!-- Form for submitting updates -->
        <form id="updateForm" method="post">
            <!-- Bookings table -->
            <table>
                <tr>
                    <th>Customer ID</th>
                    <th>Username</th>
                    <th>Room Type</th>
                    <th>Room Count</th>
                    <th>Booking ID</th>
                    <th>Status</th>
                    <th>Room Number</th>
                    <th>Check-in Date & Time</th>
                    <th>Checkout Date & Time</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['customer_id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['room_type']; ?></td>
                        <td><?php echo $row['room_count']; ?></td>
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <input type="text" name="roomnumber[<?php echo $row['booking_id']; ?>]" value="<?php echo $row['roomnumber']; ?>">
                        </td>
                        <td>
                            <input type="datetime-local" name="checkin_time[<?php echo $row['booking_id']; ?>]" value="<?php echo date('Y-m-d\TH:i', strtotime($row['checkin_time'])); ?>" required>
                        </td>
                        <td>
                            <input type="datetime-local" name="checkout_datetime[<?php echo $row['booking_id']; ?>]" value="<?php echo date('Y-m-d\TH:i', strtotime($row['checkout_datetime'])); ?>">
                        </td>
                        <td>
                            <button type="button" name="update_booking" value="<?php echo $row['booking_id']; ?>">Update</button>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <input type="hidden" id="update_booking_id" name="update_booking" value="">
        </form>
    </div>
    </section>

    <!-- Custom Modal -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Confirmation</h2>
            <span class="close" onclick="hideModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to update the booking details?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="cancel" onclick="hideModal()">Cancel</button>
            <button type="button" class="confirm" onclick="confirmUpdate()">OK</button>
        </div>
    </div>
</div>
</body>
</html>
