<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: customerLogin.php");
    exit();
}

// Include database connection
include 'Database/db_connection.php';

// Fetch all bookings along with customer details
$sql = "SELECT bookings.booking_id, Customers.name AS customer_name, Rooms.room_type, bookings.status, bookings.checkin_time 
        FROM bookings 
        INNER JOIN Customers ON bookings.customer_id = Customers.customer_id
        INNER JOIN Rooms ON bookings.room_id = Rooms.room_id";
$result = $conn->query($sql);

// Process change status action
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['change_status'])) {
        $bookingId = $_POST['booking_id'];
        $newStatus = $_POST['new_status'];
        
        // Update booking status
        $sql_update = "UPDATE bookings SET status = '$newStatus' WHERE booking_id = '$bookingId'";
        if ($conn->query($sql_update) === TRUE) {
            // Redirect to the same page to refresh the bookings list
            header("Location: viewBooking.php");
            exit();
        } else {
            $error_message = "Error updating status: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/demo.css">
    <title>View Bookings</title>
    <style>

        .container {
            margin-left:2em;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        select {
            padding: 8px;
            border-radius: 4px;
        }

        button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        p.error {
            color: #f44336;
        }
    </style>
</head>
<body>
    <?php include 'partials/adminHeader.php'; ?>
    <section class="home">
    <div class="container">
        <h2>View Bookings</h2>
        <input type="text" id="searchInput" placeholder="Search...">
        <?php if ($result->num_rows > 0) { ?>
            <table id="bookingsTable">
                <tr>
                    <th>Booking ID</th>
                    <th>Customer Name</th>
                    <th>Room Type</th>
                    <th>Expected Check-in Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['room_type']; ?></td>
                        <td><?php echo $row['checkin_time']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                <select name="new_status">
                                    <option value="confirmed">Confirmed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <button type="submit" name="change_status">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No bookings found.</p>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
    </div>
    </section>

    <script>
        // Real-time search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("bookingsTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                // Loop through all table cells in the current row
                for (j = 0; j < tr[i].cells.length; j++) {
                    td = tr[i].cells[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break; // Break loop if match found in current row
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>