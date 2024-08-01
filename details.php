<?php
// Include database connection
include 'Database/db_connection.php';

// Fetch history records excluding those with NULL roomnumber
$sql = "SELECT * FROM ActiveBookings";
$result = $conn->query($sql);

// Initialize an empty array to hold history records
$historyRecords = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $historyRecords[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Details</title>
    <style>

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
<?php include 'partials/adminHeader.php'; ?>
<section class="home" style="margin-left:2em;">
    <h2>History Details</h2>

    <!-- Real-time Search Input -->
    <input type="text" id="searchInput" placeholder="Search by Username" onkeyup="filterTable()">

    <!-- Table to Display History Records -->
    <table id="historyTable">
        <tr>
            <th>Username</th>
            <th>Booking ID</th>
            <th>Room Number</th>
            <th>Checked In</th>
            <th>Checked Out</th>
            <th>Payment Method</th>




        </tr>
        <?php foreach ($historyRecords as $record) { ?>
            <tr>
                <td><?php echo $record['username']; ?></td>
                <td><?php echo $record['booking_id']; ?></td>
                <td><?php echo $record['roomnumber']; ?></td>
                <td><?php echo $record['checkin_time']; ?></td>
                <td><?php echo $record['checkout_datetime']; ?></td>
                <td><?php echo $record['payment_method']; ?></td>



            </tr>
        <?php } ?>
    </table>
    </section>

    <script>
        // Function to filter table rows based on search input
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("historyTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, hide those that don't match the search query
            for (i = 1; i < tr.length; i++) { // Start from index 1 to skip table header row
                td = tr[i].getElementsByTagName("td")[0]; // Filter by the first column (Username)
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>
