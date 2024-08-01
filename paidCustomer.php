<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paid Customers</title>
    <!-- Add your CSS styles here -->
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;

        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f2f2f2;
        }
        /* Image zoom styles */
        .zoom-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .zoom-img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }
        .main{
            margin-top:5em;

        }
    </style>
</head>
<body>
<?php include 'partials/adminHeader.php'; ?>
<section class="home">
<div class="container">
    <h2>Paid Customers</h2>

    <!-- Add search input field -->
    <input type="text" id="searchInput" placeholder="Search for customer..." style="margin-bottom: 10px;">

    <table id="paidCustomersTable">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Customer Username</th>
                <th>Room Type</th>
                <th>Booking ID</th>
                <th>Cost</th>
                <th>Payment Method</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            // Include database connection
            include 'Database/db_connection.php';

            // Fetch data from Payments table
            $sql = "SELECT * FROM view_payment";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['pid'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['room_type'] . "</td>";
                    echo "<td>" . $row['booking_id'] . "</td>";
                    echo "<td>" . $row['cost'] . "</td>";
                    echo "<td>" . $row['payment_method'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Zoom Overlay for Image -->
<div class="zoom-overlay">
    <img class="zoom-img" src="" alt="Zoomed Image">
</div>
        </section>

<!-- Add your JavaScript here -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const zoomTrigger = document.querySelectorAll('.zoom-trigger');
        const zoomOverlay = document.querySelector('.zoom-overlay');
        const zoomImg = document.querySelector('.zoom-img');
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('paidCustomersTable');

        zoomTrigger.forEach(function(trigger) {
            trigger.addEventListener('click', function() {
                const imgSrc = this.getAttribute('src');
                zoomImg.setAttribute('src', imgSrc);
                zoomOverlay.style.display = 'flex';
            });
        });

        zoomOverlay.addEventListener('click', function() {
            this.style.display = 'none';
        });

        // Real-time search functionality
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim().toLowerCase();
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let found = false;
                const cells = rows[i].getElementsByTagName('td');
                for (let j = 0; j < cells.length; j++) {
                    const cellContent = cells[j].textContent.trim().toLowerCase();
                    if (cellContent.includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }
                if (found) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    });
</script>
</body>
</html>
